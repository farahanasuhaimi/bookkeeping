<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\PaymentMethod;

class IncomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $incomes = Income::where('user_id', $user->id)
            ->with(['category', 'paymentMethod'])
            ->orderBy('date', 'desc')
            ->paginate(10);
            
        $paymentMethods = PaymentMethod::where('user_id', $user->id)->get();

        return view('income', compact('incomes', 'paymentMethods'));
    }

    public function create()
    {
        $user = Auth::user();
        $paymentMethods = PaymentMethod::where('user_id', $user->id)->get();
        return view('income.create', compact('paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category_id' => 'nullable|integer',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240|mimes:jpeg,png,pdf,jpg',
        ]);

        try {
            $attachmentPath = null;
            if ($request->hasFile('attachment') && auth()->user()->plan == 'pro') {
                $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            }

            Income::create([
                'user_id' => Auth::id(),
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'date' => $validated['date'],
                'source' => $validated['description'],
                'status' => 'confirmed',
                'category_id' => $validated['category_id'] ?? null,
                'payment_method_id' => $validated['payment_method_id'],
                'notes' => $validated['notes'] ?? null,
                'attachment_path' => $attachmentPath,
            ]);

            return redirect()->route('incomes.index')->with('success', 'Income added successfully.');
        } catch (\Exception $e) {
            Log::error('Income save error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to save income: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $income = Income::where('user_id', $user->id)->findOrFail($id);
        $paymentMethods = PaymentMethod::where('user_id', $user->id)->get();
        return view('income.create', compact('income', 'paymentMethods'));
    }

    public function update(Request $request, $id)
    {
        $income = Income::where('user_id', Auth::id())->findOrFail($id);
        
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category_id' => 'nullable|integer',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240|mimes:jpeg,png,pdf,jpg',
        ]);

        try {
            if ($request->hasFile('attachment') && auth()->user()->plan == 'pro') {
                $validated['attachment_path'] = $request->file('attachment')->store('attachments', 'public');
            }

            $income->update(array_merge($validated, [
                'source' => $validated['description'] // Keep source synced with description
            ]));

            return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
        } catch (\Exception $e) {
            Log::error('Income update error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update income.'])->withInput();
        }
    }

    public function destroy($id)
    {
        $income = Income::where('user_id', Auth::id())->findOrFail($id);
        $income->delete();

        return redirect()->back()->with('success', 'Income deleted successfully.');
    }
}
