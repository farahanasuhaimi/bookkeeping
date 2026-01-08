<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>RezTax Report YA {{ $currentYear }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 13px; color: #333; line-height: 1.5; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #13ec80; padding-bottom: 20px; }
        .logo { font-size: 28px; font-weight: 900; color: #111814; letter-spacing: -1px; }
        .logo span { color: #13ec80; }
        .report-title { font-size: 18px; font-weight: bold; margin-top: 5px; color: #666; }
        
        .section { margin-bottom: 25px; }
        .section-title { font-size: 14px; font-bold: bold; background: #f6f8f7; padding: 8px 12px; border-left: 4px solid #13ec80; margin-bottom: 15px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { font-size: 11px; text-transform: uppercase; color: #777; letter-spacing: 0.5px; }
        
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .primary-text { color: #13ec80; }
        
        .summary-box { background: #111814; color: white; padding: 20px; border-radius: 8px; margin-top: 30px; }
        .summary-row { display: table; width: 100%; margin-bottom: 8px; }
        .summary-label { display: table-cell; font-size: 14px; }
        .summary-value { display: table-cell; text-align: right; font-size: 18px; font-weight: bold; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #999; padding: 20px 0; }
        .highlight { background: #e6fdec; color: #07882c; padding: 2px 6px; border-radius: 4px; font-size: 11px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Rez<span>Tax</span></div>
        <div class="report-title">Tax Readiness Individual Summary (YA {{ $currentYear }})</div>
        <div style="font-size: 11px; color: #999;">Generated on: {{ now()->format('d M Y, h:i A') }}</div>
    </div>

    <div class="section">
        <div class="section-title">SECTION A: STATUTORY INCOME</div>
        <table>
            <thead>
                <tr>
                    <th>Source of Income</th>
                    <th class="text-right">YTD Actual (RM)</th>
                    <th class="text-right">Projected Annual (RM)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Employment Income (EA Form)</td>
                    <td class="text-right">{{ number_format($employmentIncome, 2) }}</td>
                    <td class="text-right">{{ number_format($projEmployment, 2) }}</td>
                </tr>
                <tr>
                    <td>Rental Income (Net)</td>
                    <td class="text-right">{{ number_format($rentalIncome, 2) }}</td>
                    <td class="text-right">{{ number_format($projRental, 2) }}</td>
                </tr>
                <tr>
                    <td>Other (Part-time, Business, etc.)</td>
                    <td class="text-right">{{ number_format($otherIncome, 2) }}</td>
                    <td class="text-right">{{ number_format($projOther, 2) }}</td>
                </tr>
                <tr class="font-bold">
                    <td>TOTAL AGGREGATED INCOME</td>
                    <td class="text-right">{{ number_format($totalIncome, 2) }}</td>
                    <td class="text-right" style="color: #13ec80; font-size: 16px;">{{ number_format($projectedIncome, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">SECTION B: TAX RELIEFS & DEDUCTIONS</div>
        <table>
            <thead>
                <tr>
                    <th>Deduction / Relief Type</th>
                    <th class="text-right">Max Limit (RM)</th>
                    <th class="text-right">Utilized (RM)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Individual & Dependent Relief</td>
                    <td class="text-right">9,000.00</td>
                    <td class="text-right">9,000.00</td>
                </tr>
                <tr>
                    <td>Life Insurance Premium</td>
                    <td class="text-right">{{ number_format($insuranceReliefLimit, 2) }}</td>
                    <td class="text-right">{{ number_format($insuranceRelief, 2) }}</td>
                </tr>
                <tr>
                    <td>EPF Contribution</td>
                    <td class="text-right">{{ number_format($epfReliefLimit, 2) }}</td>
                    <td class="text-right">{{ number_format($epfRelief, 2) }}</td>
                </tr>
                <tr>
                    <td>Lifestyle (Internet, Books, Tech)</td>
                    <td class="text-right">{{ number_format($lifestyleReliefLimit, 2) }}</td>
                    <td class="text-right">{{ number_format($lifestyleRelief, 2) }}</td>
                </tr>
                <tr>
                    <td>Medical & Education Insurance</td>
                    <td class="text-right">{{ number_format($medicalReliefLimit, 2) }}</td>
                    <td class="text-right">{{ number_format($medicalRelief, 2) }}</td>
                </tr>
                <tr class="font-bold">
                    <td colspan="2">TOTAL RELIEFS APPLIED</td>
                    <td class="text-right">{{ number_format($totalReliefs, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="summary-box">
        <div class="summary-row">
            <span class="summary-label">Chargeable Income (A - B)</span>
            <span class="summary-value">RM {{ number_format($chargeableIncome, 2) }}</span>
        </div>
        <div class="summary-row" style="margin-top: 15px; border-top: 1px solid #444; padding-top: 15px;">
            <span class="summary-label">Estimated Tax Payable</span>
            <span class="summary-value">RM {{ number_format($taxPayable, 2) }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Tax Rebates (Zakat/Fitrah)</span>
            <span class="summary-value">- RM {{ number_format($zakatPaid, 2) }}</span>
        </div>
        <div class="summary-row" style="margin-top: 10px; color: #13ec80;">
            <span class="summary-label">NET TAX PAYABLE</span>
            <span class="summary-value">RM {{ number_format($netTaxPayable, 2) }}</span>
        </div>
    </div>

    <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 6px; font-size: 11px; color: #666;">
        <strong>Disclaimer:</strong> This report is for planning purposes only and is based on self-reported data in RezTax. Final tax liability should be verified against official LHDN e-Filing systems.
    </div>

    <div class="footer">
        RezTax Malaysia • Secure • Simple • Reliable • Generated by User: {{ auth()->user()->name }}
    </div>
</body>
</html>
