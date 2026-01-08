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
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $totalExpenses = Expense::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            // Do we exclude Savings/Tax Relief from "Total Expenses"?
            // Usually yes if we want "Burn Rate", but for simplicity let's keep all.
            // Or better: Exclude "Savings/Investments" category types if they exist?
            // For now, simple sum.
            ->sum('amount');

        $netBalance = $totalIncome - $totalExpenses;

        // 3. Chart Data (Daily for the selected month)
        // We need an array of [Day => [Income, Expense]]
        $chartData = [];
        $daysInMonth = $startOfMonth->daysInMonth;
        
        $dailyIncomes = Income::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->selectRaw('DATE(date) as day, SUM(amount) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $dailyExpenses = Expense::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
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
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
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
            })->sortByDesc('amount')->take(4); // Top 4 categories

        // 5. Recent/All Transactions for the list
        $incomes = Income::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->with(['category', 'paymentMethod'])
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($item) {
                $item->type = 'income';
                return $item;
            });

        $expenses = Expense::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->with(['category', 'paymentMethod'])
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($item) {
                $item->type = 'expense';
                return $item;
            });

        $transactions = $incomes->concat($expenses)->sortByDesc('date');

        // 6. Tax Savings (Dummy calculation or based on dedicated view)
        // Let's just pass a rough estimate
        $estTaxSavings = $totalExpenses * 0.24; // Avg tax rate assumption

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
            'paymentMethods'
        ));
    }
}