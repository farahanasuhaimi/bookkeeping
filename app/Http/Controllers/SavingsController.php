<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\SavingsGoal;
use Illuminate\Support\Facades\Auth;

class SavingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentYear = date('Y');

        // 1. Fetch Tax-focused Savings (Expense Categories)
        $catIds = [
            'epf' => 12,
            'zakat' => 13,
            'life_insurance' => 14,
            'medical_insurance' => 15,
            'sspn' => 16,
            'prs' => 17
        ];

        $ytdEpf = Expense::where('user_id', $user->id)->where('category_id', $catIds['epf'])->whereYear('date', $currentYear)->sum('amount');
        $ytdZakat = Expense::where('user_id', $user->id)->where('category_id', $catIds['zakat'])->whereYear('date', $currentYear)->sum('amount');
        $ytdSspn = Expense::where('user_id', $user->id)->where('category_id', $catIds['sspn'])->whereYear('date', $currentYear)->sum('amount');
        $ytdLifeIns = Expense::where('user_id', $user->id)->where('category_id', $catIds['life_insurance'])->whereYear('date', $currentYear)->sum('amount');

        // Total "Tax Savings" Contributions
        $taxSavingsTotal = Expense::where('user_id', $user->id)->whereIn('category_id', array_values($catIds))->sum('amount');

        // 2. Fetch Personal Savings Goals
        $goals = SavingsGoal::where('user_id', $user->id)->orderBy('status', 'asc')->orderBy('due_date', 'asc')->get();
        $totalGoalSavings = $goals->sum('current_amount');

        // Recent Contributions
        $contributions = Expense::where('user_id', $user->id)
            ->whereIn('category_id', array_values($catIds))
            ->with('category')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        return view('saving_tracking', compact(
            'ytdEpf', 'ytdZakat', 'ytdSspn', 'ytdLifeIns', 
            'taxSavingsTotal', 'totalGoalSavings', 'contributions', 'goals'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'due_date' => 'nullable|date',
        ]);

        $validated['user_id'] = Auth::id();
        SavingsGoal::create($validated);

        return redirect()->back()->with('success', 'Savings goal created successfully!');
    }

    public function update(Request $request, $id)
    {
        $goal = SavingsGoal::where('user_id', Auth::id())->findOrFail($id);
        
        $validated = $request->validate([
            'current_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        if ($validated['current_amount'] >= $goal->target_amount) {
            $validated['status'] = 'completed';
        }

        $goal->update($validated);

        return redirect()->back()->with('success', 'Goal updated!');
    }

    public function destroy($id)
    {
        $goal = SavingsGoal::where('user_id', Auth::id())->findOrFail($id);
        $goal->delete();

        return redirect()->back()->with('warning', 'Goal deleted.');
    }
}
