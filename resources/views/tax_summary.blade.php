@extends('layouts.dashboard')

@section('dashboard-content')
<div class="flex flex-col min-h-screen">
    <main class="layout-container flex h-full grow flex-col w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header & Actions -->
        <div class="flex flex-col md:flex-row flex-wrap justify-between gap-6 mb-8 items-end md:items-center">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <h1 class="text-text-main dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">Tax Summary</h1>
                    <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">YA 2023</span>
                </div>
                <div class="flex items-center gap-2 text-text-muted dark:text-gray-400">
                    <span>Year of Assessment: </span>
                    <select class="bg-transparent border-none py-0 pl-0 pr-8 text-base font-semibold text-primary focus:ring-0 cursor-pointer">
                        <option>2023</option>
                        <option>2022</option>
                        <option>2021</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-3">
                <button class="flex items-center justify-center gap-2 rounded-lg h-10 px-4 bg-white dark:bg-card-dark border border-border-light dark:border-border-dark text-text-main dark:text-white text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-lg">print</span>
                    <span class="truncate hidden sm:inline">Print</span>
                </button>
                <button class="flex items-center justify-center gap-2 rounded-lg h-10 px-5 bg-primary hover:bg-primary-dark text-text-main text-sm font-bold transition-colors shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-lg">table_view</span>
                    <span class="truncate">Export to Excel</span>
                </button>
            </div>
        </div>
        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Card 1 -->
            <div class="flex flex-col gap-1 rounded-xl p-5 border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="p-1.5 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined text-xl">payments</span>
                    </div>
                    <p class="text-text-muted dark:text-gray-400 text-sm font-medium">Total Gross Income</p>
                </div>
                <p class="text-text-main dark:text-white text-2xl font-bold tracking-tight">RM {{ number_format($totalIncome, 2) }}</p>
                <div class="flex items-center text-xs text-green-600 dark:text-green-400 mt-1">
                    <span class="material-symbols-outlined text-sm mr-0.5">trending_up</span>
                    <span>+12% from 2022</span>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="flex flex-col gap-1 rounded-xl p-5 border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="p-1.5 rounded-md bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                        <span class="material-symbols-outlined text-xl">verified</span>
                    </div>
                    <p class="text-text-muted dark:text-gray-400 text-sm font-medium">Approved Reliefs</p>
                </div>
                <p class="text-text-main dark:text-white text-2xl font-bold tracking-tight">RM {{ number_format($totalReliefs, 2) }}</p>
                <div class="flex items-center text-xs text-text-muted dark:text-gray-500 mt-1">
                    <span>{{ $totalIncome > 0 ? number_format(($totalReliefs / $totalIncome) * 100, 1) : 0 }}% of Gross Income</span>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="flex flex-col gap-1 rounded-xl p-5 border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="p-1.5 rounded-md bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400">
                        <span class="material-symbols-outlined text-xl">account_balance_wallet</span>
                    </div>
                    <p class="text-text-muted dark:text-gray-400 text-sm font-medium">Chargeable Income</p>
                </div>
                <p class="text-text-main dark:text-white text-2xl font-bold tracking-tight">RM {{ number_format($chargeableIncome, 2) }}</p>
                <div class="flex items-center text-xs text-orange-600 dark:text-orange-400 mt-1">
                    <span>Tax Bracket E (19-24%)</span>
                </div>
            </div>
            <!-- Card 4 (Highlighted) -->
            <div class="flex flex-col gap-1 rounded-xl p-5 border border-primary/50 bg-primary/5 dark:bg-primary/10 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl text-primary">gavel</span>
                </div>
                <div class="flex items-center gap-2 mb-2 relative z-10">
                    <div class="p-1.5 rounded-md bg-primary text-text-main">
                        <span class="material-symbols-outlined text-xl">gavel</span>
                    </div>
                    <p class="text-text-main dark:text-white text-sm font-bold">Net Tax Payable</p>
                </div>
                <p class="text-text-main dark:text-white text-2xl font-black tracking-tight relative z-10">RM {{ number_format($netTaxPayable, 2) }}</p>
                <div class="flex items-center text-xs text-text-muted dark:text-gray-400 mt-1 relative z-10">
                    <span>Before PCB deduction</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Detailed Breakdown -->
            <div class="lg:col-span-2 flex flex-col gap-6">
                <h3 class="text-text-main dark:text-white tracking-tight text-xl font-bold leading-tight">Tax Calculation Breakdown</h3>
                <div class="flex flex-col gap-4">
                    <!-- Section A -->
                    <details class="group flex flex-col rounded-xl border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark overflow-hidden transition-all duration-300">
                        <summary class="flex cursor-pointer items-center justify-between gap-4 p-5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 rounded-full p-1">
                                    <span class="material-symbols-outlined text-lg">work</span>
                                </div>
                                <div>
                                    <p class="text-text-main dark:text-white text-sm font-bold">Section A: Statutory Income</p>
                                    <p class="text-text-muted dark:text-gray-400 text-xs">Employment, Business, Dividends, Rents</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-text-main dark:text-white font-bold">RM {{ number_format($totalIncome, 2) }}</span>
                                <span class="material-symbols-outlined text-text-muted transition-transform group-open:rotate-180">expand_more</span>
                            </div>
                        </summary>
                        <div class="border-t border-border-light dark:border-border-dark p-5 bg-gray-50/50 dark:bg-gray-900/20">
                            <div class="flex flex-col gap-3">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-text-muted dark:text-gray-400">Employment Income (Salary, Bonus)</span>
                                    <span class="font-medium text-text-main dark:text-white">RM {{ number_format($totalIncome, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-text-muted dark:text-gray-400">Allowances &amp; Perquisites</span>
                                    <span class="font-medium text-text-main dark:text-white">RM 4,500.00</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-text-muted dark:text-gray-400">Rental Income (Net)</span>
                                    <span class="font-medium text-text-main dark:text-white">RM 2,000.00</span>
                                </div>
                                <div class="flex justify-between items-center text-sm pt-2 border-t border-dashed border-gray-200 dark:border-gray-700">
                                    <span class="text-text-main dark:text-white font-semibold">Total Aggregated Income</span>
                                    <span class="font-bold text-text-main dark:text-white">RM {{ number_format($totalIncome, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </details>
                    <!-- Section B -->
                    <details class="group flex flex-col rounded-xl border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark overflow-hidden transition-all duration-300">
                        <summary class="flex cursor-pointer items-center justify-between gap-4 p-5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 rounded-full p-1">
                                    <span class="material-symbols-outlined text-lg">volunteer_activism</span>
                                </div>
                                <div>
                                    <p class="text-text-main dark:text-white text-sm font-bold">Section B: Donations &amp; Zakat</p>
                                    <p class="text-text-muted dark:text-gray-400 text-xs">Approved Donations, Gifts, Zakat Fitrah</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-text-main dark:text-white font-bold">- RM {{ number_format($zakatPaid, 2) }}</span>
                                <span class="material-symbols-outlined text-text-muted transition-transform group-open:rotate-180">expand_more</span>
                            </div>
                        </summary>
                        <div class="border-t border-border-light dark:border-border-dark p-5 bg-gray-50/50 dark:bg-gray-900/20">
                            <div class="flex flex-col gap-3">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-text-muted dark:text-gray-400">Gift of Money to Government / Approved Institutions</span>
                                    <span class="font-medium text-text-main dark:text-white">RM 0.00</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-text-muted dark:text-gray-400">Zakat &amp; Fitrah (Rebate deduction applied later)</span>
                                    <span class="font-medium text-text-main dark:text-white">RM {{ number_format($zakatPaid, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </details>
                    <!-- Section C -->
                    <details class="group flex flex-col rounded-xl border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark overflow-hidden transition-all duration-300" open="">
                        <summary class="flex cursor-pointer items-center justify-between gap-4 p-5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 rounded-full p-1">
                                    <span class="material-symbols-outlined text-lg">medical_services</span>
                                </div>
                                <div>
                                    <p class="text-text-main dark:text-white text-sm font-bold">Section C: Tax Reliefs</p>
                                    <p class="text-text-muted dark:text-gray-400 text-xs">Lifestyle, Insurance, EPF, Parenthood</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-text-main dark:text-white font-bold text-green-600 dark:text-green-400">- RM {{ number_format($totalReliefs, 2) }}</span>
                                <span class="material-symbols-outlined text-text-muted transition-transform group-open:rotate-180">expand_more</span>
                            </div>
                        </summary>
                        <div class="border-t border-border-light dark:border-border-dark p-5 bg-gray-50/50 dark:bg-gray-900/20 flex flex-col gap-6">
                            <!-- Relief Item 1 -->
                            <div class="flex flex-col gap-2">
                                <div class="flex justify-between items-end">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-text-main dark:text-white">Individual Relief</span>
                                        <span class="text-xs text-text-muted dark:text-gray-400">Automatic deduction for self</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-bold text-text-main dark:text-white">RM 9,000.00</span>
                                        <span class="text-xs text-text-muted block">Max: RM 9,000</span>
                                    </div>
                                </div>
                                <div class="h-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary w-full rounded-full"></div>
                                </div>
                            </div>
                            <!-- Relief Item 2 -->
                            <div class="flex flex-col gap-2">
                                <div class="flex justify-between items-end">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-text-main dark:text-white">Lifestyle</span>
                                        <span class="text-xs text-text-muted dark:text-gray-400">Books, Internet, Sports, Devices</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-bold text-text-main dark:text-white">RM {{ number_format($lifestyleRelief, 2) }}</span>
                                        <span class="text-xs text-text-muted block">Max: RM 2,500</span>
                                    </div>
                                </div>
                                <div class="h-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary w-[90%] rounded-full"></div>
                                </div>
                                <div class="text-xs text-primary font-medium text-right">RM 250.00 quota remaining</div>
                            </div>
                            <!-- Relief Item 3 -->
                            <div class="flex flex-col gap-2">
                                <div class="flex justify-between items-end">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-text-main dark:text-white">Life Insurance &amp; EPF</span>
                                        <span class="text-xs text-text-muted dark:text-gray-400">Restricted to RM4k EPF + RM3k Life Ins.</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-bold text-text-main dark:text-white">RM 7,000.00</span>
                                        <span class="text-xs text-text-muted block">Max: RM 7,000</span>
                                    </div>
                                </div>
                                <div class="h-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary w-full rounded-full"></div>
                                </div>
                            </div>
                            <!-- Relief Item 4 -->
                            <div class="flex flex-col gap-2">
                                <div class="flex justify-between items-end">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-text-main dark:text-white">Medical Expenses</span>
                                        <span class="text-xs text-text-muted dark:text-gray-400">Serious diseases, fertility treatment</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-bold text-text-main dark:text-white">RM 3,150.00</span>
                                        <span class="text-xs text-text-muted block">Max: RM 10,000</span>
                                    </div>
                                </div>
                                <div class="h-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary w-[31%] rounded-full"></div>
                                </div>
                                <div class="text-xs text-primary font-medium text-right">RM 6,850.00 quota remaining</div>
                            </div>
                        </div>
                    </details>
                </div>
            </div>
            <!-- Right Column: Visualizations & Summary -->
            <div class="flex flex-col gap-6">
                <!-- PCB Comparison Widget -->
                <div class="rounded-xl border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-lg overflow-hidden">
                    <div class="bg-background-light dark:bg-gray-800 p-4 border-b border-border-light dark:border-border-dark flex justify-between items-center">
                        <h4 class="font-bold text-text-main dark:text-white">Tax Balance</h4>
                        <span class="material-symbols-outlined text-text-muted">account_balance_wallet</span>
                    </div>
                    <div class="p-5 flex flex-col gap-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-text-muted dark:text-gray-400">Net Tax Payable</span>
                            <span class="font-bold text-text-main dark:text-white">RM {{ number_format($netTaxPayable, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-1">
                                <span class="text-sm text-text-muted dark:text-gray-400">Less: Zakat Rebate</span>
                            </div>
                            <span class="font-medium text-green-600 dark:text-green-400">- RM {{ number_format($zakatPaid, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-1">
                                <span class="text-sm text-text-muted dark:text-gray-400">Less: PCB Paid (MTD)</span>
                                <span class="material-symbols-outlined text-[16px] text-text-muted cursor-help" title="Potongan Cukai Berjadual deducted from your monthly salary">help</span>
                            </div>
                            <span class="font-medium text-green-600 dark:text-green-400">- RM {{ number_format($pcbPaid, 2) }}</span>
                        </div>
                        <div class="h-px bg-border-light dark:bg-border-dark my-1"></div>
                        <div class="flex justify-between items-end">
                            <span class="text-sm font-bold text-text-main dark:text-white">Balance to Pay</span>
                            <span class="text-2xl font-black {{ $balanceToPay > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">RM {{ number_format($balanceToPay, 2) }}</span>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3 flex items-start gap-2">
                            <span class="material-symbols-outlined text-green-600 dark:text-green-400 mt-0.5">check_circle</span>
                            <p class="text-xs text-green-800 dark:text-green-200 font-medium leading-relaxed">
                                Great news! You have overpaid your taxes by <strong>RM 50.00</strong>. This amount is refundable by LHDN.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Tax Bracket Widget -->
                <div class="rounded-xl border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm p-5">
                    <h4 class="font-bold text-text-main dark:text-white mb-4">Tax Bracket (Category E)</h4>
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between text-xs text-text-muted dark:text-gray-400">
                            <span>0%</span>
                            <span>Current: 21%</span>
                            <span>Max: 30%</span>
                        </div>
                        <!-- Visual Steps -->
                        <div class="flex w-full gap-1 h-3">
                            <div class="flex-1 bg-primary rounded-l-sm opacity-30" title="0-5k"></div>
                            <div class="flex-1 bg-primary opacity-40" title="5k-20k"></div>
                            <div class="flex-1 bg-primary opacity-50" title="20k-35k"></div>
                            <div class="flex-1 bg-primary opacity-60" title="35k-50k"></div>
                            <div class="flex-1 bg-primary opacity-80" title="50k-70k"></div>
                            <div class="flex-1 bg-primary rounded-r-sm relative overflow-visible" title="70k-100k">
                                <div class="absolute -top-1.5 left-1/2 -translate-x-1/2 w-0.5 h-6 bg-text-main dark:bg-white z-10"></div>
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-text-main dark:bg-white text-white dark:text-black text-[10px] font-bold px-1.5 py-0.5 rounded whitespace-nowrap">You</div>
                            </div>
                            <div class="flex-1 bg-gray-200 dark:bg-gray-700" title="100k+"></div>
                            <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-r-sm" title="400k+"></div>
                        </div>
                        <p class="text-xs text-text-muted dark:text-gray-400 leading-relaxed">
                            Your chargeable income of <strong>RM 103,100</strong> places you in the 21% tax bracket. The next bracket starts at RM 250,000.
                        </p>
                    </div>
                </div>
                <!-- Helper / Promo -->
                <div class="rounded-xl bg-gradient-to-br from-[#102219] to-[#1e3b2e] dark:from-black dark:to-[#0a150f] p-6 text-white relative overflow-hidden">
                    <!-- Decorative background pattern -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/20 rounded-full blur-3xl -mr-10 -mt-10"></div>
                    <div class="relative z-10 flex flex-col gap-3">
                        <div class="size-10 rounded-full bg-white/10 flex items-center justify-center backdrop-blur-sm mb-1">
                            <span class="material-symbols-outlined text-primary">lightbulb</span>
                        </div>
                        <h4 class="font-bold text-lg">Maximize your refund?</h4>
                        <p class="text-sm text-gray-300">You have <strong>RM 6,850</strong> remaining in Medical relief quota. Upload receipts to claim more.</p>
                        <button class="mt-2 w-full py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg text-sm font-semibold transition-colors">
                            Upload Receipt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
