<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Store a new transaction (income or expense)
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'nullable|sometimes',
            'date' => 'required|date',
            'is_deductible' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        try {
            if ($validated['type'] === 'income') {
                $transaction = Income::create([
                    'user_id' => $user->id,
                    'description' => $validated['description'],
                    'amount' => $validated['amount'],
                    'date' => $validated['date'],
                    'source' => $validated['description'], // Use description as source
                    'status' => 'confirmed',
                    'notes' => $validated['notes'] ?? null,
                ]);
            } else {
                $transaction = Expense::create([
                    'user_id' => $user->id,
                    'description' => $validated['description'],
                    'amount' => $validated['amount'],
                    'category_id' => $validated['category_id'] ?? null,
                    'date' => $validated['date'],
                    'status' => 'completed',
                    'payment_method' => 'other', // Default payment method
                    'is_deductible' => $validated['is_deductible'] ?? false,
                    'notes' => $validated['notes'] ?? null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => ucfirst($validated['type']) . ' recorded successfully!',
                'transaction' => $transaction,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Transaction save error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save transaction: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all transactions for the current user (combined income & expenses)
     */
    public function getCombined()
    {
        $user = Auth::user();

        $incomes = Income::where('user_id', $user->id)
            ->select('id', 'description', 'amount', 'date', 'status')
            ->get()
            ->map(function ($income) {
                $income->type = 'income';
                $income->category = null;
                $income->is_deductible = false;
                return $income;
            });

        $expenses = Expense::where('user_id', $user->id)
            ->with('category')
            ->select('id', 'description', 'amount', 'date', 'status', 'category_id')
            ->get()
            ->map(function ($expense) {
                $expense->type = 'expense';
                $expense->category = $expense->category?->name;
                $expense->is_deductible = false; // Add this field if needed in model
                return $expense;
            });

        $transactions = $incomes->concat($expenses)->sortByDesc('date')->values();

        return response()->json([
            'success' => true,
            'transactions' => $transactions,
        ]);
    }

    /**
     * Get transactions for current month
     */
    public function getMonthly()
    {
        $user = Auth::user();
        $now = now();

        $incomes = Income::where('user_id', $user->id)
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->select('id', 'description', 'amount', 'date', 'status')
            ->get()
            ->map(function ($income) {
                $income->type = 'income';
                return $income;
            });

        $expenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->with('category')
            ->select('id', 'description', 'amount', 'date', 'status', 'category_id')
            ->get()
            ->map(function ($expense) {
                $expense->type = 'expense';
                $expense->category = $expense->category?->name;
                return $expense;
            });

        $transactions = $incomes->concat($expenses)->sortByDesc('date')->values();

        return response()->json([
            'success' => true,
            'transactions' => $transactions,
        ]);
    }
}
