<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaxSummaryController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. Calculate Total Annual Income
        $totalIncome = \App\Models\Income::where('user_id', $user->id)
            ->whereYear('date', date('Y')) // Assuming current year for now
            ->where('status', 'confirmed')
            ->sum('amount');

        // 2. Calculate Total Deductions (Reliefs)
        // Hardcoded standard relief for now + basic logic
        $standardRelief = 9000;
        
        // Example dynamic relief based on expenses marked as deductible
        $deductibleExpenses = \App\Models\Expense::where('user_id', $user->id)
            ->whereYear('date', date('Y'))
            ->where('status', 'completed')
            ->where('is_deductible', true)
            ->sum('amount');

        $epfRelief = 4000; // Mock value or calculated if data available
        $insuranceRelief = 3000; // Mock value
        $lifestyleReliefLimit = 2500;
        
        // Cap deductible expenses at lifestyle limit for this example logic
        $lifestyleRelief = min($deductibleExpenses, $lifestyleReliefLimit);

        $totalReliefs = $standardRelief + $epfRelief + $insuranceRelief + $lifestyleRelief;

        // 3. Calculate Chargeable Income
        $chargeableIncome = max(0, $totalIncome - $totalReliefs);

        // 4. Calculate Tax Payable (Simplified Tiered Calculation)
        $taxPayable = $this->calculateTax($chargeableIncome);

        $zakatPaid = 500; // Mock or from DB
        $pcbPaid = \App\Models\Income::where('user_id', $user->id)
            ->whereYear('date', date('Y'))
            ->sum('pcb_amount') ?? 0;

        $netTaxPayable = max(0, $taxPayable - $zakatPaid);
        $balanceToPay = $netTaxPayable - $pcbPaid;

        return view('tax_summary', [
            'totalIncome' => $totalIncome,
            'totalReliefs' => $totalReliefs,
            'chargeableIncome' => $chargeableIncome,
            'taxPayable' => $taxPayable,
            'zakatPaid' => $zakatPaid,
            'pcbPaid' => $pcbPaid,
            'netTaxPayable' => $netTaxPayable,
            'balanceToPay' => $balanceToPay,
            'lifestyleRelief' => $lifestyleRelief,
            'lifestyleReliefLimit' => $lifestyleReliefLimit,
        ]);
    }

    private function calculateTax($amount)
    {
        // 2023 Tax Rates (Simplified for Example)
        // 0 - 5,000: 0%
        // 5,001 - 20,000: 1%
        // 20,001 - 35,000: 3%
        // 35,001 - 50,000: 8%
        // 50,001 - 70,000: 13%
        // 70,001 - 100,000: 21%
        // 100,001 - 250,000: 24%
        // 250,001 - 400,000: 24.5%
        
        $tax = 0;

        if ($amount > 100000) {
            $tax += ($amount - 100000) * 0.24;
            $amount = 100000;
        }
        if ($amount > 70000) {
            $tax += ($amount - 70000) * 0.21;
            $amount = 70000;
        }
        if ($amount > 50000) {
            $tax += ($amount - 50000) * 0.13;
            $amount = 50000;
        }
        if ($amount > 35000) {
            $tax += ($amount - 35000) * 0.08;
            $amount = 35000;
        }
        if ($amount > 20000) {
            $tax += ($amount - 20000) * 0.03;
            $amount = 20000;
        }
        if ($amount > 5000) {
            $tax += ($amount - 5000) * 0.01;
        }

        return $tax;
    }
}
