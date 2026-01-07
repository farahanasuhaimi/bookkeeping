<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IncomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $incomes = Income::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('income', compact('incomes'));
    }

    public function create()
    {
        return view('income.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            Income::create([
                'user_id' => Auth::id(),
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'date' => $validated['date'],
                'source' => $validated['description'],
                'status' => 'confirmed',
                'notes' => $validated['notes'] ?? null,
            ]);

            return redirect()->route('income')->with('success', 'Income added successfully.');
        } catch (\Exception $e) {
            Log::error('Income save error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to save income.'])->withInput();
        }
    }

    public function destroy($id)
    {
        $income = Income::where('user_id', Auth::id())->findOrFail($id);
        $income->delete();

        return redirect()->back()->with('success', 'Income deleted successfully.');
    }
}
