<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\PaymentMethod;

class ExpenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $expenses = Expense::where('user_id', $user->id)
            ->with(['category', 'paymentMethod'])
            ->orderBy('date', 'desc')
            ->paginate(10);
            
        $categories = Category::where('type', 'expense')->get();
        $paymentMethods = PaymentMethod::where('user_id', $user->id)->get();

        return view('expense', compact('expenses', 'categories', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category_id' => 'nullable|integer',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240',
        ]);

        try {
            $expense = Expense::create([
                'user_id' => Auth::id(),
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'date' => $validated['date'],
                'category_id' => $validated['category_id'] ?? null,
                'status' => 'completed',
                'payment_method' => 'other',
                'notes' => $validated['notes'] ?? null,
            ]);

            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('attachments', 'public');
                $expense->update(['receipt_url' => $path]);
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Expense added successfully.',
                    'data' => $expense,
                ]);
            }

            return redirect()->back()->with('success', 'Expense added successfully.');
        } catch (\Exception $e) {
            Log::error('Expense save error: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save expense: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Failed to save expense.'])->withInput();
        }
    }

    public function destroy($id)
    {
        $expense = Expense::where('user_id', Auth::id())->findOrFail($id);
        $expense->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Expense deleted successfully.',
            ]);
        }

        return redirect()->back()->with('success', 'Expense deleted successfully.');
    }
}
