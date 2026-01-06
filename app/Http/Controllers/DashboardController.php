<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Savings;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            // Return home page for non-authenticated users
            return view('welcome', [
                'totalIncome' => 0,
                'totalExpenses' => 0,
                'netBalance' => 0,
                'recentIncomes' => [],
                'recentExpenses' => [],
                'activeSavings' => [],
                'expensesByCategory' => [],
            ]);
        }

        // Get current user's financial data
        $totalIncome = Income::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->sum('amount');

        $totalExpenses = Expense::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');

        $netBalance = $totalIncome - $totalExpenses;

        // Get recent transactions
        $recentIncomes = Income::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        $recentExpenses = Expense::where('user_id', $user->id)
            ->with('category')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        // Get savings data
        $activeSavings = Savings::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        // Get expense breakdown by category
        $expensesByCategory = Expense::where('user_id', $user->id)
            ->where('status', 'completed')
            ->with('category')
            ->get()
            ->groupBy('category.name')
            ->map(function ($group) {
                return $group->sum('amount');
            });

        return view('welcome', [
            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'netBalance' => $netBalance,
            'recentIncomes' => $recentIncomes,
            'recentExpenses' => $recentExpenses,
            'activeSavings' => $activeSavings,
            'expensesByCategory' => $expensesByCategory,
        ]);
    }
}
