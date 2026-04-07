<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Collection;

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

    /**
     * Resolve category IDs from slugs once per request.
     * Returns a slug → id map for all tax-relevant categories.
     */
    private function resolveCategoryIds(): Collection
    {
        $slugs = [
            'employment-income',
            'part-time-business',
            'rental-income',
            'dividends-interest',
            'lifestyle',
            'epf-contribution',
            'zakat',
            'life-insurance',
            'medical-insurance',
        ];

        return Category::whereIn('slug', $slugs)
            ->pluck('id', 'slug');
    }

    private function getTaxSummaryData(Request $request): array
    {
        $user = auth()->user();
        $currentYear = $request->input('year', date('Y'));
        $prevYear = $currentYear - 1;

        $categoryIds = $this->resolveCategoryIds();

        // Income category IDs
        $employmentId = $categoryIds->get('employment-income');
        $partTimeId   = $categoryIds->get('part-time-business');
        $rentalId     = $categoryIds->get('rental-income');
        $dividendsId  = $categoryIds->get('dividends-interest');

        // Relief/expense category IDs
        $lifestyleId  = $categoryIds->get('lifestyle');
        $epfId        = $categoryIds->get('epf-contribution');
        $zakatId      = $categoryIds->get('zakat');
        $insuranceId  = $categoryIds->get('life-insurance');
        $medicalId    = $categoryIds->get('medical-insurance');

        // 1. Total Annual Income & PCB
        $incomeData = Income::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->where('status', 'confirmed')
            ->selectRaw('SUM(amount) as total_income, SUM(pcb_amount) as total_pcb')
            ->first();

        $totalIncome = $incomeData->total_income ?? 0;
        $pcbPaid     = $incomeData->total_pcb ?? 0;

        // Income projection
        $isHistorical = (int) $currentYear < (int) date('Y');
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

        // Income breakdown by category
        $incomeCategoryIds = array_filter([$employmentId, $partTimeId, $rentalId, $dividendsId]);

        $incomeBreakdown = Income::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->where('status', 'confirmed')
            ->whereIn('category_id', $incomeCategoryIds)
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        $employmentIncome = $incomeBreakdown[$employmentId] ?? 0;
        $rentalIncome     = $incomeBreakdown[$rentalId] ?? 0;
        $otherIncome      = ($incomeBreakdown[$partTimeId] ?? 0) + ($incomeBreakdown[$dividendsId] ?? 0);

        $projEmployment = $isHistorical ? $employmentIncome : ($employmentIncome / $monthsElapsed) * 12;
        $projRental     = $isHistorical ? $rentalIncome     : ($rentalIncome     / $monthsElapsed) * 12;
        $projOther      = $isHistorical ? $otherIncome      : ($otherIncome      / $monthsElapsed) * 12;

        // 2. Relief calculations
        $standardRelief = 9000;

        $reliefCategoryIds = array_filter([$lifestyleId, $epfId, $zakatId, $insuranceId, $medicalId]);

        $expenseReliefs = Expense::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->whereIn('category_id', $reliefCategoryIds)
            ->where('status', 'completed')
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        $lifestyleReliefLimit = 2500;
        $epfReliefLimit       = 4000;
        $insuranceReliefLimit = 3000;
        $medicalReliefLimit   = 4000;

        $lifestyleRelief = min($expenseReliefs[$lifestyleId] ?? 0, $lifestyleReliefLimit);
        $epfRelief       = min($expenseReliefs[$epfId]       ?? 0, $epfReliefLimit);
        $insuranceRelief = min($expenseReliefs[$insuranceId] ?? 0, $insuranceReliefLimit);
        $medicalRelief   = min($expenseReliefs[$medicalId]   ?? 0, $medicalReliefLimit);
        $zakatPaid       = $expenseReliefs[$zakatId]         ?? 0;

        $totalReliefs = $standardRelief + $epfRelief + $insuranceRelief + $lifestyleRelief + $medicalRelief;

        // 3. Chargeable income
        $chargeableIncome = max(0, $totalIncome - $totalReliefs);

        // 4. Tax payable
        $taxPayableBeforeRebate = $this->calculateTax($chargeableIncome);

        // 5. Zakat rebate & net tax
        $netTaxPayable = max(0, $taxPayableBeforeRebate - $zakatPaid);
        $balanceToPay  = $netTaxPayable - $pcbPaid;

        return [
            'totalIncome'          => $totalIncome,
            'projectedIncome'      => $projectedIncome,
            'currentYear'          => $currentYear,
            'prevYear'             => $prevYear,
            'employmentIncome'     => $employmentIncome,
            'rentalIncome'         => $rentalIncome,
            'otherIncome'          => $otherIncome,
            'projEmployment'       => $projEmployment,
            'projRental'           => $projRental,
            'projOther'            => $projOther,
            'totalReliefs'         => $totalReliefs,
            'chargeableIncome'     => $chargeableIncome,
            'taxPayable'           => $taxPayableBeforeRebate,
            'zakatPaid'            => $zakatPaid,
            'pcbPaid'              => $pcbPaid,
            'netTaxPayable'        => $netTaxPayable,
            'balanceToPay'         => $balanceToPay,
            'lifestyleRelief'      => $lifestyleRelief,
            'lifestyleReliefLimit' => $lifestyleReliefLimit,
            'medicalRelief'        => $medicalRelief,
            'medicalReliefLimit'   => $medicalReliefLimit,
            'epfRelief'            => $epfRelief,
            'epfReliefLimit'       => $epfReliefLimit,
            'insuranceRelief'      => $insuranceRelief,
            'insuranceReliefLimit' => $insuranceReliefLimit,
            'isHistorical'         => $isHistorical,
        ];
    }

    private function calculateTax(float $amount): float
    {
        $tax = 0;
        if ($amount > 100000) { $tax += ($amount - 100000) * 0.24; $amount = 100000; }
        if ($amount > 70000)  { $tax += ($amount - 70000)  * 0.21; $amount = 70000;  }
        if ($amount > 50000)  { $tax += ($amount - 50000)  * 0.13; $amount = 50000;  }
        if ($amount > 35000)  { $tax += ($amount - 35000)  * 0.08; $amount = 35000;  }
        if ($amount > 20000)  { $tax += ($amount - 20000)  * 0.03; $amount = 20000;  }
        if ($amount > 5000)   { $tax += ($amount - 5000)   * 0.01; }
        return $tax;
    }
}
