<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class SavingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentYear = date('Y');

        // Define Category IDs (based on Seeder)
        $catIds = [
            'epf' => 12,
            'zakat' => 13,
            'life_insurance' => 14,
            'medical_insurance' => 15,
            'sspn' => 16,
            'prs' => 17
        ];

        // Fetch YTD Totals
        $ytdEpf = Expense::where('user_id', $user->id)
            ->where('category_id', $catIds['epf'])
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $ytdZakat = Expense::where('user_id', $user->id)
            ->where('category_id', $catIds['zakat'])
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $ytdSspn = Expense::where('user_id', $user->id)
            ->where('category_id', $catIds['sspn'])
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $ytdLifeIns = Expense::where('user_id', $user->id)
            ->where('category_id', $catIds['life_insurance'])
            ->whereYear('date', $currentYear)
            ->sum('amount');    

        // Total "Savings" Balance (Sum of all accumulation types over all time)
        // For simplicity, we assume these expenses are actually transfers to savings/investments
        $totalSavings = Expense::where('user_id', $user->id)
            ->whereIn('category_id', array_values($catIds))
            ->sum('amount');

        // Recent Transactions for the Table
        $contributions = Expense::where('user_id', $user->id)
            ->whereIn('category_id', array_values($catIds))
            ->with('category')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        return view('saving_tracking', compact(
            'ytdEpf', 'ytdZakat', 'ytdSspn', 'ytdLifeIns', 'totalSavings', 'contributions'
        ));
    }
}
