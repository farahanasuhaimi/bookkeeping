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

        // 4. Expense Categories Breakdown
        $expensesByCategory = Expense::where('user_id', $user->id)
            ->whereYear('date', $startOfMonth->year)
            ->whereMonth('date', $startOfMonth->month)
            ->where('status', 'completed')
            ->with('category')
            ->get()
            ->groupBy('category.name')
            ->map(function ($group) use ($totalExpenses) {
                $sum = $group->sum('amount');
                return [
                    'amount' => $sum,
                    'percentage' => $totalExpenses > 0 ? round(($sum / $totalExpenses) * 100) : 0,
                    'count' => $group->count()
                ];
            })->sortByDesc('amount')->take(4);

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
            'expensesByCategory', 
            'transactions',
            'estTaxSavings',
            'paymentMethods',
            'activeGoals'
        ));
    }
}