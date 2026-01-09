@extends('layouts.main')

@section('dashboard-content')
<div class="container mx-auto max-w-[1200px] px-4 py-8 md:px-8">
    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-text-main dark:text-white sm:text-4xl">{{ $startOfMonth->format('F Y') }} Overview</h2>
            <p class="mt-1 text-base text-text-muted dark:text-gray-400">Monthly financial snapshot & tax readiness.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <form id="monthForm" action="{{ route('dashboard') }}" method="GET">
                    <input type="month" name="month" value="{{ $selectedMonth }}" onchange="this.form.submit()" class="flex items-center gap-2 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark px-4 py-2 text-sm font-medium text-text-main dark:text-white shadow-sm hover:bg-gray-50 dark:hover:bg-white/5 cursor-pointer outline-none focus:ring-2 focus:ring-primary/50">
                </form>
            </div>
            <button onclick="window.print()" class="flex items-center gap-2 rounded-lg bg-text-main dark:bg-white px-4 py-2 text-sm font-bold text-white dark:text-text-main shadow-sm hover:opacity-90">
                <span class="material-symbols-outlined text-[20px]">print</span>
                <span class="hidden sm:inline">Print Report</span>
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        <!-- Income Card -->
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md">
            <div class="mb-2 flex items-center justify-between">
                <p class="text-sm font-medium text-text-muted dark:text-gray-400">Total Income</p>
                <span class="material-symbols-outlined text-primary bg-primary/10 rounded-full p-1 text-[20px]">trending_up</span>
            </div>
            <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white">RM {{ number_format($totalIncome, 2) }}</p>
            <div class="mt-2 flex items-center gap-2 text-xs">
                <span class="text-text-muted dark:text-gray-500">Inflows for {{ $startOfMonth->format('M') }}</span>
            </div>
        </div>
        <!-- Expenses Card -->
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md">
            <div class="mb-2 flex items-center justify-between">
                <p class="text-sm font-medium text-text-muted dark:text-gray-400">Total Expenses</p>
                <span class="material-symbols-outlined text-red-500 bg-red-500/10 rounded-full p-1 text-[20px]">trending_down</span>
            </div>
            <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white">RM {{ number_format($totalExpenses, 2) }}</p>
             <div class="mt-2 flex items-center gap-2 text-xs">
                <span class="text-text-muted dark:text-gray-500">Outflows for {{ $startOfMonth->format('M') }}</span>
            </div>
        </div>
        <!-- Balance Card -->
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md">
            <div class="mb-2 flex items-center justify-between">
                <p class="text-sm font-medium text-text-muted dark:text-gray-400">Net Balance</p>
                <span class="material-symbols-outlined text-text-main dark:text-white bg-gray-100 dark:bg-white/10 rounded-full p-1 text-[20px]">account_balance_wallet</span>
            </div>
            <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white {{ $netBalance < 0 ? 'text-red-500' : '' }}">RM {{ number_format($netBalance, 2) }}</p>
             <div class="mt-2 flex items-center gap-2 text-xs">
                <span class="text-text-muted dark:text-gray-500">Income - Expenses</span>
            </div>
        </div>
        <!-- Est Tax Card (Placeholder logic) -->
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md ring-1 ring-primary/20">
            <div class="mb-2 flex items-center justify-between">
                <p class="text-sm font-medium text-text-muted dark:text-gray-400">Est. Tax Impact</p>
                <span class="material-symbols-outlined text-primary bg-primary/10 rounded-full p-1 text-[20px]">savings</span>
            </div>
            <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white">RM {{ number_format($estTaxSavings, 2) }}</p>
            <div class="mt-2 flex items-center gap-2 text-xs">
                <span class="text-text-muted dark:text-gray-500">Approx. Reduction</span>
            </div>
        </div>
    </div>

    <!-- Analytics Hub Section -->
    <div class="mb-8 overflow-hidden rounded-[2rem] border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm">
        <div class="border-b border-border-light dark:border-border-dark p-6 sm:px-8">
            <h3 class="text-xl font-black text-text-main dark:text-white italic flex items-center gap-3">
                <span class="material-symbols-outlined text-primary font-bold">analytics</span>
                Analytics Hub
            </h3>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 divide-y lg:divide-y-0 lg:divide-x divide-border-light dark:divide-border-dark">
            <!-- Yearly Trending Chart -->
            <div class="p-6 sm:p-8 lg:col-span-2">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-black uppercase tracking-widest text-text-muted italic">Monthly Performance</h4>
                        <p class="text-xs text-text-muted">Income vs Expenses (Last 12 Months)</p>
                    </div>
                </div>
                <div class="h-[300px] w-full lowercase">
                    <canvas id="yearlyTrendChart"></canvas>
                </div>
            </div>

            <!-- Distribution Charts (Carousel-like or Stacked) -->
            <div class="p-6 sm:p-8 flex flex-col gap-8">
                <div>
                    <h4 class="text-sm font-black uppercase tracking-widest text-text-muted italic mb-4">Expense Distribution</h4>
                    <div class="h-[180px] w-full">
                        <canvas id="expenseDistChart"></canvas>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-black uppercase tracking-widest text-text-muted italic mb-4">Income Breakdown</h4>
                    <div class="h-[180px] w-full">
                        <canvas id="incomeDistChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats & Goals Row -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-8">
        <!-- Saving Goals -->
        <div class="rounded-3xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-8 shadow-sm">
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-lg font-black text-text-main dark:text-white italic">Active Savings Goals</h3>
                <a href="{{ route('saving-tracking') }}" class="bg-primary/10 text-primary px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary/20 transition-all">MANAGE</a>
            </div>
            <div class="space-y-6">
                @forelse($activeGoals as $goal)
                    @php
                        $perc = $goal->target_amount > 0 ? min(($goal->current_amount / $goal->target_amount) * 100, 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-text-main dark:text-white">{{ $goal->name }}</span>
                            <span class="text-[10px] font-black text-text-muted italic">RM {{ number_format($goal->current_amount) }} / {{ number_format($goal->target_amount) }}</span>
                        </div>
                        <div class="h-2 w-full bg-background-light dark:bg-background-dark rounded-full overflow-hidden p-0.5 border border-border-light dark:border-border-dark shadow-inner">
                            <div class="h-full bg-primary rounded-full transition-all duration-1000" style="width: {{ $perc }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center text-text-muted py-8 opacity-50">
                        <span class="material-symbols-outlined text-4xl mb-2">savings</span>
                        <p class="text-xs font-black uppercase italic tracking-widest">No active goals</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Top Categories List -->
        <div class="rounded-3xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-8 shadow-sm">
             <h3 class="text-lg font-black text-text-main dark:text-white mb-6 italic">Top Spending Categories</h3>
             <div class="grid grid-cols-1 gap-4">
                @forelse($expensesByCategory->take(3) as $catName => $data)
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark group hover:border-primary/50 transition-all">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl font-black italic text-lg shadow-sm" style="background-color: {{ $data['color'] }}20; color: {{ $data['color'] }}">
                         {{ substr($catName, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-baseline mb-1">
                            <p class="text-sm font-bold text-text-main dark:text-white">{{ $catName }}</p>
                            <p class="text-[10px] font-black text-primary italic uppercase">{{ $data['percentage'] }}%</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-text-muted italic">RM {{ number_format($data['amount'], 2) }}</p>
                            <p class="text-[9px] text-text-muted font-black uppercase tracking-widest">{{ $data['count'] ?? 0 }} entries</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center text-text-muted py-8 opacity-50">
                    <span class="material-symbols-outlined text-4xl mb-2">category</span>
                    <p class="text-xs font-black uppercase italic tracking-widest">No spending recorded</p>
                </div>
                @endforelse
             </div>
        </div>
    </div>

    <!-- Bottom Section: Recent Transactions -->
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-text-main dark:text-white">Transaction History</h3>
        </div>
        <div class="overflow-hidden rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="bg-background-light dark:bg-white/5 text-xs uppercase text-text-muted dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Date</th>
                        <th class="px-6 py-3 font-semibold">Method</th>
                        <th class="px-6 py-3 font-semibold">Description</th>
                        <th class="px-6 py-3 font-semibold text-center">Category</th>
                        <th class="px-6 py-3 font-semibold text-center">Doc</th>
                        <th class="px-6 py-3 font-semibold text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @forelse($transactions as $transaction)
                        <tr class="group hover:bg-background-light dark:hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 text-text-muted dark:text-gray-400 whitespace-nowrap">
                                {{ $transaction->date->format('d M y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-white/10 text-text-muted dark:text-gray-300">
                                    {{ $transaction->paymentMethod->name ?? 'Cash' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-text-main dark:text-white">{{ $transaction->description }}</p>
                                <p class="text-xs text-text-muted dark:text-gray-500">{{ $transaction->notes ?? '' }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-100 dark:bg-white/10 text-text-muted dark:text-gray-300 text-xs font-medium">
                                    {{ $transaction->category->name ?? 'None' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($transaction->attachment_path)
                                    <a href="{{ Storage::url($transaction->attachment_path) }}" target="_blank" class="text-primary hover:text-primary-dark" title="View Attachment">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                @else
                                    <span class="text-gray-300 dark:text-gray-700">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-bold {{ $transaction->type == 'income' ? 'text-green-600 dark:text-green-400' : 'text-text-main dark:text-white' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }} RM {{ number_format($transaction->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-text-muted">
                                <span class="material-symbols-outlined text-3xl mb-2 opacity-50 block">receipt_long</span>
                                No transactions found for this month.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.03)';
        const textColor = isDark ? '#9ca3af' : '#94a3b8';
        
        // Vibrant Palette for Categories
        const colorPalette = [
            '#3b82f6', // Blue
            '#ef4444', // Red
            '#f59e0b', // Amber
            '#10b981', // Emerald
            '#8b5cf6', // Violet
            '#ec4899', // Pink
            '#06b6d4', // Cyan
            '#f97316', // Orange
        ];

        // 1. Yearly Trend Chart
        const trendCtx = document.getElementById('yearlyTrendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: @json(collect($yearlyTrending)->pluck('month')),
                datasets: [
                    {
                        label: 'Income',
                        data: @json(collect($yearlyTrending)->pluck('income')),
                        borderColor: '#13ec80',
                        backgroundColor: 'rgba(19, 236, 128, 0.05)', // Very subtle fill
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 0, // Clean look, show on hover
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#13ec80',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Expense',
                        data: @json(collect($yearlyTrending)->pluck('expense')),
                        borderColor: isDark ? '#64748b' : '#cbd5e1',
                        backgroundColor: 'transparent',
                        fill: false,
                        tension: 0.4,
                        borderWidth: 2,
                        borderDash: [6, 6],
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: isDark ? '#64748b' : '#94a3b8'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isDark ? '#1e293b' : '#ffffff',
                        titleColor: isDark ? '#ffffff' : '#0f172a',
                        bodyColor: isDark ? '#cbd5e1' : '#334155',
                        borderColor: isDark ? '#334155' : '#e2e8f0',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'RM ' + new Intl.NumberFormat('en-MY', { minimumFractionDigits: 2 }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { 
                            color: gridColor,
                            drawBorder: false,
                        },
                        border: { display: false },
                        ticks: { 
                            color: textColor, 
                            font: { size: 10, weight: '500' }, 
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: value => 'RM ' + value 
                        }
                    },
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: { 
                            color: textColor, 
                            font: { size: 10, weight: '500' },
                            maxRotation: 0
                        }
                    }
                }
            }
        });

        // 2. Expense Distribution Chart
        const expenseCtx = document.getElementById('expenseDistChart').getContext('2d');
        new Chart(expenseCtx, {
            type: 'doughnut',
            data: {
                labels: @json($expensesByCategory->keys()),
                datasets: [{
                    data: @json($expensesByCategory->pluck('amount')),
                    backgroundColor: colorPalette,
                    borderWidth: 2,
                    borderColor: isDark ? '#111827' : '#ffffff', // Match bg for gap effect
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: textColor,
                            font: { size: 11, weight: '500' },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            boxWidth: 8
                        }
                    }
                }
            }
        });

        // 3. Income Breakdown Chart
        const incomeCtx = document.getElementById('incomeDistChart').getContext('2d');
        new Chart(incomeCtx, {
            type: 'doughnut',
            data: {
                labels: @json($incomeByCategory->keys()),
                datasets: [{
                    data: @json($incomeByCategory->pluck('amount')),
                    backgroundColor: colorPalette, // Reusing palette
                    borderWidth: 2,
                    borderColor: isDark ? '#111827' : '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'left',
                        labels: {
                            color: textColor,
                            font: { size: 11, weight: '500' },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            boxWidth: 8
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
