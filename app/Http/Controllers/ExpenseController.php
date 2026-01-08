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

    public function create()
    {
        $user = Auth::user();
        $categories = Category::where('type', 'expense')->get();
        $paymentMethods = PaymentMethod::where('user_id', $user->id)->get();
        return view('expenses.create', compact('categories', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id', // Validated against DB
            'payment_method_id' => 'required|exists:payment_methods,id',
            'is_deductible' => 'boolean',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240|mimes:jpeg,png,pdf,jpg',
        ]);

        try {
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            }

            // Handle checkbox boolean which might be missing in some setups, strictly cast it
            $isDeductible = $request->has('is_deductible') ? true : false;

            Expense::create([
                'user_id' => Auth::id(),
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'date' => $validated['date'],
                'category_id' => $validated['category_id'] ?? null,
                'status' => 'completed',
                'payment_method_id' => $validated['payment_method_id'],
                'is_deductible' => $isDeductible,
                'notes' => $validated['notes'] ?? null,
                'attachment_path' => $attachmentPath,
            ]);

            return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
        } catch (\Exception $e) {
            Log::error('Expense save error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to save expense: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $expense = Expense::where('user_id', $user->id)->findOrFail($id);
        $categories = Category::where('type', 'expense')->get();
        $paymentMethods = PaymentMethod::where('user_id', $user->id)->get();
        return view('expenses.create', compact('expense', 'categories', 'paymentMethods'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'is_deductible' => 'boolean',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240|mimes:jpeg,png,pdf,jpg',
        ]);

        try {
            if ($request->hasFile('attachment')) {
                $validated['attachment_path'] = $request->file('attachment')->store('attachments', 'public');
            }

            $validated['is_deductible'] = $request->has('is_deductible');

            $expense->update($validated);

            return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
        } catch (\Exception $e) {
            Log::error('Expense update error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update expense.'])->withInput();
        }
    }

    public function destroy($id)
    {
        $expense = Expense::where('user_id', Auth::id())->findOrFail($id);
        $expense->delete();

        return redirect()->back()->with('success', 'Expense deleted successfully.');
    }
}
