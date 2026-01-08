<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Income;
use App\Models\Expense;

class TaxSummaryController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getTaxSummaryData($request);
        return view('tax_summary', $data);
    }

    public function exportPDF(Request $request)
    {
        $data = $this->getTaxSummaryData($request);
        
        $pdf = Pdf::loadView('tax_summary_pdf', $data);
        
        $filename = 'RezTax_Report_' . $data['currentYear'] . '_' . now()->format('YmdHis') . '.pdf';
        
        return $pdf->download($filename);
    }

    private function getTaxSummaryData(Request $request)
    {
        $user = auth()->user();

        // 1. Calculate Total Annual Income & PCB Paid
        $currentYear = $request->input('year', date('Y'));
        $prevYear = $currentYear - 1;
        $incomeData = Income::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->where('status', 'confirmed')
            ->selectRaw('SUM(amount) as total_income, SUM(pcb_amount) as total_pcb')
            ->first();

        $totalIncome = $incomeData->total_income ?? 0;
        $pcbPaid = $incomeData->total_pcb ?? 0;

        // --- Income Projection Logic ---
        $isHistorical = (int)$currentYear < (int)date('Y');
        $monthsElapsed = 12;
        
        if (!$isHistorical) {
            $monthsWithIncome = Income::where('user_id', $user->id)
                ->whereYear('date', $currentYear)
                ->where('status', 'confirmed')
                ->selectRaw('COUNT(DISTINCT MONTH(date)) as count')
                ->value('count') ?: 1;
            
            $monthsElapsed = $monthsWithIncome;
        }

        $projectedIncome = $isHistorical ? $totalIncome : ($totalIncome / $monthsElapsed) * 12;

        // Breakdown income by category
        $incomeBreakdown = Income::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->where('status', 'confirmed')
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        $employmentIncome = $incomeBreakdown[1] ?? 0;
        $rentalIncome = $incomeBreakdown[18] ?? 0;
        $otherIncome = ($incomeBreakdown[2] ?? 0) + ($incomeBreakdown[19] ?? 0);

        $projEmployment = $isHistorical ? $employmentIncome : ($employmentIncome / $monthsElapsed) * 12;
        $projRental = $isHistorical ? $rentalIncome : ($rentalIncome / $monthsElapsed) * 12;
        $projOther = $isHistorical ? $otherIncome : ($otherIncome / $monthsElapsed) * 12;

        // 2. Calculate Reliefs
        $standardRelief = 9000;
        $reliefCategories = [5, 12, 13, 14, 15];
        $expenseReliefs = Expense::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->whereIn('category_id', $reliefCategories)
            ->where('status', 'completed')
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        $epfReliefRaw = $expenseReliefs[12] ?? 0;
        $insuranceReliefRaw = $expenseReliefs[14] ?? 0;
        $epfRelief = min($epfReliefRaw, 4000);
        $insuranceRelief = min($insuranceReliefRaw, 3000);
        
        $lifestyleReliefLimit = 2500;
        $lifestyleRelief = min($expenseReliefs[5] ?? 0, $lifestyleReliefLimit);

        $medicalReliefLimit = 4000;
        $medicalRelief = min($expenseReliefs[15] ?? 0, $medicalReliefLimit);

        $totalReliefs = $standardRelief + $epfRelief + $insuranceRelief + $lifestyleRelief + $medicalRelief;

        // 3. Chargeable Income
        $chargeableIncome = max(0, $totalIncome - $totalReliefs);

        // 4. Tax Payable
        $taxPayableBeforeRebate = $this->calculateTax($chargeableIncome);

        // 5. Rebates
        $zakatPaid = $expenseReliefs[13] ?? 0;
        $netTaxPayable = max(0, $taxPayableBeforeRebate - $zakatPaid);
        $balanceToPay = $netTaxPayable - $pcbPaid;

        return [
            'totalIncome' => $totalIncome,
            'projectedIncome' => $projectedIncome,
            'currentYear' => $currentYear,
            'prevYear' => $prevYear,
            'employmentIncome' => $employmentIncome,
            'rentalIncome' => $rentalIncome,
            'otherIncome' => $otherIncome,
            'projEmployment' => $projEmployment,
            'projRental' => $projRental,
            'projOther' => $projOther,
            'totalReliefs' => $totalReliefs,
            'chargeableIncome' => $chargeableIncome,
            'taxPayable' => $taxPayableBeforeRebate,
            'zakatPaid' => $zakatPaid,
            'pcbPaid' => $pcbPaid,
            'netTaxPayable' => $netTaxPayable,
            'balanceToPay' => $balanceToPay,
            'lifestyleRelief' => $lifestyleRelief,
            'lifestyleReliefLimit' => $lifestyleReliefLimit,
            'medicalRelief' => $medicalRelief,
            'medicalReliefLimit' => $medicalReliefLimit,
            'epfRelief' => $epfRelief,
            'epfReliefLimit' => 4000,
            'insuranceRelief' => $insuranceRelief,
            'insuranceReliefLimit' => 3000,
            'isHistorical' => $isHistorical,
        ];
    }

    private function calculateTax($amount)
    {
        $tax = 0;
        if ($amount > 100000) { $tax += ($amount - 100000) * 0.24; $amount = 100000; }
        if ($amount > 70000) { $tax += ($amount - 70000) * 0.21; $amount = 70000; }
        if ($amount > 50000) { $tax += ($amount - 50000) * 0.13; $amount = 50000; }
        if ($amount > 35000) { $tax += ($amount - 35000) * 0.08; $amount = 35000; }
        if ($amount > 20000) { $tax += ($amount - 20000) * 0.03; $amount = 20000; }
        if ($amount > 5000) { $tax += ($amount - 5000) * 0.01; }
        return $tax;
    }
}
