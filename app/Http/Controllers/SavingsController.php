<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\SavingsGoal;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class SavingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentYear = date('Y');

        // Look up categories by name instead of hardcoded IDs
        $categories = Category::whereIn('name', ['EPF', 'Zakat', 'SSPN', 'Life Insurance', 'Medical Insurance', 'PRS'])
                              ->get()
                              ->pluck('id', 'name');

        $ytdEpf = 0;
        $ytdZakat = 0;
        $ytdSspn = 0;
        $ytdLifeIns = 0;

        if (isset($categories['EPF'])) {
            $ytdEpf = Expense::where('user_id', $user->id)->where('category_id', $categories['EPF'])->whereYear('date', $currentYear)->sum('amount');
        }
        if (isset($categories['Zakat'])) {
            $ytdZakat = Expense::where('user_id', $user->id)->where('category_id', $categories['Zakat'])->whereYear('date', $currentYear)->sum('amount');
        }
        if (isset($categories['SSPN'])) {
            $ytdSspn = Expense::where('user_id', $user->id)->where('category_id', $categories['SSPN'])->whereYear('date', $currentYear)->sum('amount');
        }
        if (isset($categories['Life Insurance'])) {
            $ytdLifeIns = Expense::where('user_id', $user->id)->where('category_id', $categories['Life Insurance'])->whereYear('date', $currentYear)->sum('amount');
        }

        // Total "Tax Savings" Contributions
        $taxSavingsTotal = Expense::where('user_id', $user->id)->whereIn('category_id', $categories->values())->sum('amount');

        // 2. Fetch Personal Savings Goals
        $goals = SavingsGoal::where('user_id', $user->id)->orderBy('status', 'asc')->orderBy('due_date', 'asc')->get();
        $totalGoalSavings = $goals->sum('current_amount');

        // Recent Contributions
        $contributions = Expense::where('user_id', $user->id)
            ->whereIn('category_id', $categories->values())
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
