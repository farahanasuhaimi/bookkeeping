<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\PaymentMethod;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $paymentMethods = PaymentMethod::where('user_id', $user->id)->get();

        // 1. Determine Month to View
        $selectedMonth = $request->input('month', date('Y-m'));
        $startOfMonth = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $selectedMonth)->endOfMonth();

        // 2. High Level Stats
        $totalIncome = Income::where('user_id', $user->id)
            ->whereYear('date', $startOfMonth->year)
            ->whereMonth('date', $startOfMonth->month)
            ->where('status', 'confirmed')
            ->sum('amount');

        $totalExpenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $startOfMonth->year)
            ->whereMonth('date', $startOfMonth->month)
            ->where('status', 'completed')
            ->sum('amount');

        $netBalance = $totalIncome - $totalExpenses;

        // 3. Chart Data (Daily for the selected month)
        $chartData = [];
        $daysInMonth = $startOfMonth->daysInMonth;
        
        $dailyIncomes = Income::where('user_id', $user->id)
            ->whereYear('date', $startOfMonth->year)
            ->whereMonth('date', $startOfMonth->month)
            ->where('status', 'confirmed')
            ->selectRaw('DATE(date) as day, SUM(amount) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $dailyExpenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $startOfMonth->year)
            ->whereMonth('date', $startOfMonth->month)
            ->where('status', 'completed')
            ->selectRaw('DATE(date) as day, SUM(amount) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $startOfMonth->copy()->day($i)->format('Y-m-d');
            $chartData[] = [
                'date' => $startOfMonth->copy()->day($i)->format('d M'),
                'income' => $dailyIncomes[$date] ?? 0,
                'expense' => $dailyExpenses[$date] ?? 0
            ];
        }

        // 3b. Yearly Trending (Last 12 Months)
        $yearlyTrending = [];
        for ($i = 11; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $monthIncome = Income::where('user_id', $user->id)
                ->whereYear('date', $monthDate->year)
                ->whereMonth('date', $monthDate->month)
                ->where('status', 'confirmed')
                ->sum('amount');
            $monthExpense = Expense::where('user_id', $user->id)
                ->whereYear('date', $monthDate->year)
                ->whereMonth('date', $monthDate->month)
                ->where('status', 'completed')
                ->sum('amount');
            
            $yearlyTrending[] = [
                'month' => $monthDate->format('M Y'),
                'income' => $monthIncome,
                'expense' => $monthExpense
            ];
        }

        // 4. Expense Categories Breakdown
        $expensesByCategory = Expense::where('user_id', $user->id)
            ->whereYear('date', $startOfMonth->year)
            ->whereMonth('date', $startOfMonth->month)
            ->where('status', 'completed')
            ->with('category')
            ->get()
            ->groupBy(fn($item) => $item->category->name ?? 'Uncategorized')
            ->map(function ($group) use ($totalExpenses) {
                $sum = $group->sum('amount');
                return [
                    'amount' => $sum,
                    'percentage' => $totalExpenses > 0 ? round(($sum / $totalExpenses) * 100) : 0,
                    'count' => $group->count(),
                    'color' => $group->first()->category->color ?? '#64748b' // Default gray for uncategorized
                ];
            })->sortByDesc('amount');

        // 4b. Income Categories Breakdown
        $incomeByCategory = Income::where('user_id', $user->id)
            ->whereYear('date', $startOfMonth->year)
            ->whereMonth('date', $startOfMonth->month)
            ->where('status', 'confirmed')
            ->with('category')
            ->get()
            ->groupBy(fn($item) => $item->category->name ?? 'Uncategorized')
            ->map(function ($group) use ($totalIncome) {
                $sum = $group->sum('amount');
                return [
                    'amount' => $sum,
                    'percentage' => $totalIncome > 0 ? round(($sum / $totalIncome) * 100) : 0,
                    'count' => $group->count(),
                    'color' => $group->first()->category->color ?? '#64748b'
                ];
            })->sortByDesc('amount');

        // 5. Recent/All Transactions
        $incomes = Income::where('user_id', $user->id)
            ->whereYear('date', $startOfMonth->year)
            ->whereMonth('date', $startOfMonth->month)
            ->with(['category', 'paymentMethod'])
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($item) {
                $item->type = 'income';
                return $item;
            });

        $expenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $startOfMonth->year)
            ->whereMonth('date', $startOfMonth->month)
            ->with(['category', 'paymentMethod'])
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($item) {
                $item->type = 'expense';
                return $item;
            });

        $transactions = $incomes->concat($expenses)->sortByDesc('date');

        // 6. Refined Tax Savings Estimate (Monthly)
        // Calculate tax savings based on deductible expenses in this month
        $deductibleTotal = Expense::where('user_id', $user->id)
            ->whereYear('date', $startOfMonth->year)
            ->whereMonth('date', $startOfMonth->month)
            ->where('status', 'completed')
            ->where('is_deductible', true)
            ->sum('amount');

        $estTaxSavings = $deductibleTotal * 0.15; // Conservative average relief impact estimate

        // 7. Active Savings Goals
        $activeGoals = \App\Models\SavingsGoal::where('user_id', $user->id)
            ->where('status', 'active')
            ->orderBy('due_date', 'asc')
            ->get();

        return view('dashboard', compact(
            'selectedMonth',
            'startOfMonth',
            'totalIncome', 
            'totalExpenses', 
            'netBalance', 
            'chartData', 
            'yearlyTrending',
            'expensesByCategory', 
            'incomeByCategory',
            'transactions',
            'estTaxSavings',
            'paymentMethods',
            'activeGoals'
        ));
    }
}