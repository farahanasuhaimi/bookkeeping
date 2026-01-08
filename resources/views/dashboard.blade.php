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

    <!-- Charts & Breakdown Section -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <!-- Main Chart -->
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-6 shadow-sm lg:col-span-2">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-text-main dark:text-white">Income vs Expenses</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400">Daily trend for {{ $startOfMonth->format('F') }}</p>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-full bg-primary"></span>
                        <span class="text-text-muted dark:text-gray-400">Income</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-full bg-border-light dark:bg-gray-600"></span>
                        <span class="text-text-muted dark:text-gray-400">Expenses</span>
                    </span>
                </div>
            </div>
            
            <!-- Dynamic SVG Chart -->
            <div class="relative h-[250px] w-full flex items-end gap-1">
                @php
                    $maxVal = max(collect($chartData)->max('income'), collect($chartData)->max('expense'), 100); // Avoid div/0
                @endphp
                @foreach($chartData as $data)
                    <div class="flex-1 flex flex-col justify-end items-center group relative h-full">
                        <div class="w-full flex gap-0.5 items-end justify-center h-full pb-6">
                            <!-- Income Bar -->
                            <div style="height: {{ ($data['income'] / $maxVal) * 80 }}%" class="w-1.5 bg-primary/80 rounded-t-sm hover:bg-primary transition-all relative"></div>
                            <!-- Expense Bar -->
                            <div style="height: {{ ($data['expense'] / $maxVal) * 80 }}%" class="w-1.5 bg-gray-300 dark:bg-gray-600 rounded-t-sm hover:bg-gray-400 transition-all relative"></div>
                        </div>
                        <!-- Tooltip -->
                        <div class="absolute bottom-10 opacity-0 group-hover:opacity-100 bg-black text-white text-[10px] p-2 rounded pointer-events-none z-10 w-24 text-center transition-opacity">
                            <p class="font-bold">{{ $data['date'] }}</p>
                            <p class="text-primary">Inc: {{ $data['income'] }}</p>
                            <p class="text-gray-400">Exp: {{ $data['expense'] }}</p>
                        </div>
                        <!-- X-Axis Label (Show every 5th day) -->
                        @if($loop->iteration % 5 == 1 || $loop->last)
                            <span class="absolute bottom-0 text-[10px] text-text-muted dark:text-gray-500 whitespace-nowrap">{{ $data['date'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Expense Categories -->
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-6 shadow-sm flex flex-col">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4">Top Spending</h3>
            <div class="flex flex-col gap-4 flex-1">
                @forelse($expensesByCategory as $catName => $data)
                <div class="flex items-center gap-4 rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 p-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined text-[20px]">
                             {{ match(strtolower($catName)) {
                                'housing' => 'home',
                                'transport' => 'directions_car',
                                'utilities' => 'bolt',
                                'food & dining' => 'restaurant',
                                'entertainment' => 'confirmation_number',
                                default => 'category'
                            } }}
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between">
                            <p class="text-sm font-bold text-text-main dark:text-white">{{ $catName }}</p>
                            <p class="text-xs text-text-muted dark:text-gray-400">{{ $data['percentage'] }}%</p>
                        </div>
                        <p class="text-xs text-text-muted dark:text-gray-400">RM {{ number_format($data['amount']) }}</p>
                         <div class="h-1.5 w-full bg-white dark:bg-black/20 rounded-full mt-1.5 overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex-1 flex flex-col items-center justify-center text-text-muted py-8">
                    <span class="material-symbols-outlined text-4xl mb-2 opacity-50">pie_chart</span>
                    <p>No expenses yet</p>
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
@endsection
