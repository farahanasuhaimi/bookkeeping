@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Tailwind Config for this page's custom colors -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#13ec80",
                    "background-light": "#f6f8f7",
                    "background-dark": "#102219",
                    "surface-light": "#ffffff",
                    "surface-dark": "#1A2C23",
                    "text-main": "#111814",
                    "text-muted": "#618975",
                    "border-light": "#dbe6e0",
                    "border-dark": "#2A4034",
                },
                fontFamily: {
                    "display": ["Inter", "sans-serif"]
                },
            },
        },
    }
</script>

<div class="flex h-screen w-full overflow-hidden">
    <!-- Side Navigation -->
    <aside class="hidden w-64 flex-col border-r border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark lg:flex">
        <div class="flex h-16 items-center px-6">
            <div class="flex flex-col">
                <h1 class="text-text-main dark:text-white text-lg font-bold leading-normal tracking-tight">MyTaxBook</h1>
                <p class="text-text-muted dark:text-gray-400 text-xs font-normal">Professional Plan</p>
            </div>
        </div>
        <div class="flex flex-1 flex-col gap-2 overflow-y-auto px-4 py-4">
            <nav class="flex flex-col gap-1">
                <a class="group flex items-center gap-3 rounded-lg bg-background-light dark:bg-white/5 px-3 py-2.5 text-text-main dark:text-white transition-colors" href="#">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white transition-colors" href="#">
                    <span class="material-symbols-outlined">payments</span>
                    <span class="text-sm font-medium">Income</span>
                </a>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white transition-colors" href="#">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="text-sm font-medium">Expenses</span>
                </a>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white transition-colors" href="#">
                    <span class="material-symbols-outlined">description</span>
                    <span class="text-sm font-medium">Tax Filing</span>
                </a>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white transition-colors" href="#">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="text-sm font-medium">Settings</span>
                </a>
                
                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="group flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-text-muted hover:bg-red-50 hover:text-red-600 dark:text-gray-400 dark:hover:bg-red-900/20 dark:hover:text-red-400 transition-colors">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="text-sm font-medium">Logout</span>
                    </button>
                </form>
            </nav>
        </div>
        <div class="p-4 border-t border-border-light dark:border-border-dark space-y-2">
            <button onclick="openTransactionModal('income')" class="flex w-full cursor-pointer items-center justify-center rounded-lg bg-primary py-2.5 text-[#111814] text-sm font-bold shadow-sm transition-transform hover:scale-[1.02] active:scale-[0.98]">
                <span class="material-symbols-outlined mr-2 text-[20px]">add_circle</span>
                <span>Add Transaction</span>
            </button>
            <div class="grid grid-cols-2 gap-2">
                <button onclick="openTransactionModal('income')" class="flex items-center justify-center gap-1 rounded-lg border border-primary/30 bg-primary/5 py-2 text-xs font-medium text-primary hover:bg-primary/10 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">trending_up</span>
                    <span>Income</span>
                </button>
                <button onclick="openTransactionModal('expense')" class="flex items-center justify-center gap-1 rounded-lg border border-red-300 dark:border-red-900/50 bg-red-50 dark:bg-red-900/10 py-2 text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/20 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">trending_down</span>
                    <span>Expense</span>
                </button>
            </div>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Mobile Transaction Buttons (visible only on mobile) -->
        <div class="fixed bottom-6 right-6 z-40 flex flex-col gap-3 lg:hidden">
            <button onclick="openTransactionModal('expense')" class="flex items-center justify-center gap-2 rounded-full bg-red-500 dark:bg-red-600 p-4 text-white shadow-lg hover:shadow-xl hover:scale-110 transition-all">
                <span class="material-symbols-outlined">trending_down</span>
            </button>
            <button onclick="openTransactionModal('income')" class="flex items-center justify-center gap-2 rounded-full bg-primary p-4 text-[#111814] shadow-lg hover:shadow-xl hover:scale-110 transition-all">
                <span class="material-symbols-outlined">trending_up</span>
            </button>
        </div>
        <div class="container mx-auto max-w-[1200px] px-4 py-8 md:px-8">
            <!-- Page Header -->
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-text-main dark:text-white sm:text-4xl">{{ date('F Y') }} Overview</h2>
                    <p class="mt-1 text-base text-text-muted dark:text-gray-400">Welcome back, {{ Auth::user()->name }}. Here is your financial snapshot.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <button class="flex items-center gap-2 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark px-4 py-2 text-sm font-medium text-text-main dark:text-white shadow-sm hover:bg-gray-50 dark:hover:bg-white/5">
                            <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                            <span>{{ date('M Y') }}</span>
                            <span class="material-symbols-outlined text-[16px]">expand_more</span>
                        </button>
                    </div>
                    <button class="flex items-center gap-2 rounded-lg bg-text-main dark:bg-white px-4 py-2 text-sm font-bold text-white dark:text-text-main shadow-sm hover:opacity-90">
                        <span class="material-symbols-outlined text-[20px]">download</span>
                        <span class="hidden sm:inline">Report</span>
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
                    <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white">RM {{ number_format($totalIncome ?? 0, 2) }}</p>
                    <div class="mt-2 flex items-center gap-2 text-xs">
                        <span class="font-medium text-green-600 dark:text-green-400">+12%</span>
                        <span class="font-medium text-green-600 dark:text-green-400">--</span>
                        <span class="text-text-muted dark:text-gray-500">vs last month</span>
                    </div>
                </div>
                <!-- Expenses Card -->
                <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-sm font-medium text-text-muted dark:text-gray-400">Total Expenses</p>
                        <span class="material-symbols-outlined text-red-500 bg-red-500/10 rounded-full p-1 text-[20px]">trending_down</span>
                    </div>
                    <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white">RM {{ number_format($totalExpenses ?? 0, 2) }}</p>
                    <div class="mt-2 flex items-center gap-2 text-xs">
                        <span class="inline-flex items-center gap-1 rounded-full bg-green-100 dark:bg-green-900/30 px-2 py-0.5 font-medium text-green-700 dark:text-green-400">
                            <span class="material-symbols-outlined text-[14px]">verified</span>
                            RM 1,200 Deductible
                            Tax Deductible
                        </span>
                    </div>
                </div>
                <!-- Balance Card -->
                <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-sm font-medium text-text-muted dark:text-gray-400">Net Balance</p>
                        <span class="material-symbols-outlined text-text-main dark:text-white bg-gray-100 dark:bg-white/10 rounded-full p-1 text-[20px]">account_balance_wallet</span>
                    </div>
                    <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white">RM {{ number_format($netBalance ?? 0, 2) }}</p>
                    <div class="mt-2 flex items-center gap-2 text-xs">
                        <span class="font-medium text-green-600 dark:text-green-400">+8%</span>
                        <span class="font-medium text-green-600 dark:text-green-400">--</span>
                        <span class="text-text-muted dark:text-gray-500">stable growth</span>
                    </div>
                </div>
                <!-- Savings Card -->
                <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md ring-1 ring-primary/20">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-sm font-medium text-text-muted dark:text-gray-400">Est. Tax Savings</p>
                        <span class="material-symbols-outlined text-primary bg-primary/10 rounded-full p-1 text-[20px]">savings</span>
                    </div>
                    <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white">RM 450.00</p>
                    <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white">RM {{ number_format($estTaxSavings, 2) }}</p>
                    <div class="mt-2 flex items-center gap-2 text-xs">
                        <span class="font-medium text-green-600 dark:text-green-400">+2%</span>
                        <span class="font-medium text-green-600 dark:text-green-400">--</span>
                        <span class="text-text-muted dark:text-gray-500">optimization</span>
                    </div>
                </div>
            </div>
            <!-- Charts & Relief Section -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
                <!-- Main Chart -->
                <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-6 shadow-sm lg:col-span-2">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-bold text-text-main dark:text-white">Income vs Expenses</h3>
                            <p class="text-sm text-text-muted dark:text-gray-400">Last 30 Days trend analysis</p>
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
                    <!-- SVG Chart Area -->
                    <div class="relative h-[250px] w-full">
                        <svg class="h-full w-full overflow-visible" fill="none" preserveaspectratio="none" viewbox="0 0 800 250" xmlns="http://www.w3.org/2000/svg">
                            <!-- Grid Lines -->
                            <line class="text-gray-100 dark:text-white/5" stroke="currentColor" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="200" y2="200"></line>
                            <line class="text-gray-100 dark:text-white/5" stroke="currentColor" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="150" y2="150"></line>
                            <line class="text-gray-100 dark:text-white/5" stroke="currentColor" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="100" y2="100"></line>
                            <line class="text-gray-100 dark:text-white/5" stroke="currentColor" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="50" y2="50"></line>
                            <!-- Income Path -->
                            <defs>
                                <lineargradient gradientunits="userSpaceOnUse" id="incomeGradient" x1="400" x2="400" y1="0" y2="250">
                                    <stop stop-color="#13ec80" stop-opacity="0.2"></stop>
                                    <stop offset="1" stop-color="#13ec80" stop-opacity="0"></stop>
                                </lineargradient>
                            </defs>
                            <path d="M0,200 C50,180 100,220 150,150 C200,80 250,50 300,60 C350,70 400,120 450,100 C500,80 550,20 600,30 C650,40 700,90 750,80 L800,50 V250 H0 Z" fill="url(#incomeGradient)"></path>
                            <path d="M0,200 C50,180 100,220 150,150 C200,80 250,50 300,60 C350,70 400,120 450,100 C500,80 550,20 600,30 C650,40 700,90 750,80 L800,50" stroke="#13ec80" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
                            <!-- Expense Path -->
                            <path class="text-gray-300 dark:text-gray-600" d="M0,220 C60,230 120,200 180,210 C240,220 300,180 360,190 C420,200 480,210 540,160 C600,110 660,150 720,160 L800,180" stroke="currentColor" stroke-dasharray="6 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <div class="flex justify-between mt-2 px-2 text-xs font-medium text-text-muted dark:text-gray-500">
                        <span>01 Oct</span>
                        <span>05 Oct</span>
                        <span>10 Oct</span>
                        <span>15 Oct</span>
                        <span>20 Oct</span>
                        <span>25 Oct</span>
                        <span>30 Oct</span>
                    </div>
                </div>
                <!-- Tax Relief Widget -->
                <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="mb-4 flex items-start justify-between">
                            <div>
                                <h3 class="text-base font-bold text-text-main dark:text-white">Tax Reliefs</h3>
                                <p class="text-sm text-text-muted dark:text-gray-400">Maximize your claims</p>
                            </div>
                            <div class="rounded-lg bg-background-light dark:bg-white/5 p-2">
                                <span class="material-symbols-outlined text-text-main dark:text-white">verified_user</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-6">
                            <!-- Lifestyle Relief -->
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="font-medium text-text-main dark:text-white">Lifestyle</span>
                                    <span class="text-text-muted dark:text-gray-400">RM 1,500 / 2,500</span>
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-background-light dark:bg-gray-700">
                                    <div class="h-full rounded-full bg-primary" style="width: 60%"></div>
                                </div>
                                <p class="text-xs text-text-muted dark:text-gray-500">Books, Internet, Sports equipment</p>
                            </div>
                            <!-- EPF Relief -->
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="font-medium text-text-main dark:text-white">EPF &amp; Insurance</span>
                                    <span class="text-text-muted dark:text-gray-400">RM 3,200 / 4,000</span>
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-background-light dark:bg-gray-700">
                                    <div class="h-full rounded-full bg-blue-500" style="width: 80%"></div>
                                </div>
                                <p class="text-xs text-text-muted dark:text-gray-500">Life insurance and KWSP contributions</p>
                            </div>
                        </div>
                    </div>
                    <button class="mt-6 w-full rounded-lg bg-background-light dark:bg-white/5 py-2.5 text-sm font-bold text-text-main dark:text-white transition-colors hover:bg-gray-200 dark:hover:bg-white/10">
                        View All Reliefs
                    </button>
                </div>
            </div>
            <!-- Bottom Section: Expense Categories & Recent Transactions -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Expense Categories -->
                <div class="flex flex-col gap-4">
                    <h3 class="text-lg font-bold text-text-main dark:text-white">Expense Categories</h3>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <!-- Category 1 -->
                        <div class="flex items-center gap-4 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-4 transition-all hover:bg-gray-50 dark:hover:bg-white/5">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400">
                                <span class="material-symbols-outlined">house</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-text-main dark:text-white">Housing</p>
                                <p class="text-xs text-text-muted dark:text-gray-400">40% • RM 1,680</p>
                            </div>
                        </div>
                        <!-- Category 2 -->
                        <div class="flex items-center gap-4 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-4 transition-all hover:bg-gray-50 dark:hover:bg-white/5">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400">
                                <span class="material-symbols-outlined">directions_car</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-text-main dark:text-white">Transport</p>
                                <p class="text-xs text-text-muted dark:text-gray-400">20% • RM 840</p>
                            </div>
                        </div>
                        <!-- Category 3 -->
                        <div class="flex items-center gap-4 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-4 transition-all hover:bg-gray-50 dark:hover:bg-white/5">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                                <span class="material-symbols-outlined">shopping_bag</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-text-main dark:text-white">Lifestyle</p>
                                <p class="text-xs text-text-muted dark:text-gray-400">15% • RM 630</p>
                            </div>
                        </div>
                        <!-- Category 4 -->
                        <div class="flex items-center gap-4 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-4 transition-all hover:bg-gray-50 dark:hover:bg-white/5">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                                <span class="material-symbols-outlined">more_horiz</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-text-main dark:text-white">Others</p>
                                <p class="text-xs text-text-muted dark:text-gray-400">25% • RM 1,050</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recent Transactions -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-text-main dark:text-white">Recent Activity</h3>
                        <a class="text-sm font-medium text-primary hover:underline" href="#">View All</a>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-background-light dark:bg-white/5 text-xs uppercase text-text-muted dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Transaction</th>
                                    <th class="px-6 py-3 font-semibold text-center">Status</th>
                                    <th class="px-6 py-3 font-semibold text-right">Amount</th>
                                    <th class="px-6 py-3 font-semibold text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-light dark:divide-border-dark">
                                <tr class="group hover:bg-background-light dark:hover:bg-white/5">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-text-main dark:text-white">Design Client A</p>
                                        <p class="text-xs text-text-muted dark:text-gray-400">Freelance Income • 24 Oct</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/30 px-2.5 py-0.5 text-xs font-medium text-green-700 dark:text-green-400">
                                            Completed
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-green-600 dark:text-green-400">+ RM 3,500.00</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="rounded p-1 text-text-muted hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="group hover:bg-background-light dark:hover:bg-white/5">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-text-main dark:text-white">Popular Bookstore</p>
                                        <p class="text-xs text-text-muted dark:text-gray-400">Lifestyle (Books) • 23 Oct</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center">
                                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 dark:bg-blue-900/20 px-2.5 py-0.5 text-xs font-medium text-blue-600 dark:text-blue-400" title="Tax Deductible">
                                                <span class="material-symbols-outlined text-[12px]">verified</span>
                                                Deductible
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-text-main dark:text-white">- RM 150.00</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="rounded p-1 text-text-muted hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="group hover:bg-background-light dark:hover:bg-white/5">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-text-main dark:text-white">Apple Store</p>
                                        <p class="text-xs text-text-muted dark:text-gray-400">Equipment • 21 Oct</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center">
                                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 dark:bg-blue-900/20 px-2.5 py-0.5 text-xs font-medium text-blue-600 dark:text-blue-400" title="Tax Deductible">
                                                <span class="material-symbols-outlined text-[12px]">verified</span>
                                                Deductible
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-text-main dark:text-white">- RM 4,299.00</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="rounded p-1 text-text-muted hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="group hover:bg-background-light dark:hover:bg-white/5">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-text-main dark:text-white">TNB Bill</p>
                                        <p class="text-xs text-text-muted dark:text-gray-400">Utilities • 20 Oct</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-800 px-2.5 py-0.5 text-xs font-medium text-gray-700 dark:text-gray-400">
                                            Standard
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-text-main dark:text-white">- RM 180.00</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="rounded p-1 text-text-muted hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>
                                    </td>
                                </tr>
                                @forelse($transactions as $transaction)
                                    <tr class="group hover:bg-background-light dark:hover:bg-white/5">
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-text-main dark:text-white">{{ $transaction->description }}</p>
                                            <p class="text-xs text-text-muted dark:text-gray-400">{{ $transaction->category }} • {{ $transaction->date->format('d M') }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($transaction->is_deductible)
                                            <div class="flex justify-center">
                                                <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 dark:bg-blue-900/20 px-2.5 py-0.5 text-xs font-medium text-blue-600 dark:text-blue-400" title="Tax Deductible">
                                                    <span class="material-symbols-outlined text-[12px]">verified</span>
                                                    Deductible
                                                </span>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold {{ $transaction->type == 'income' ? 'text-green-600 dark:text-green-400' : 'text-text-main dark:text-white' }}">
                                            {{ $transaction->type == 'income' ? '+' : '-' }} RM {{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button class="rounded p-1 text-text-muted hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors" title="Edit">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-text-muted">No transactions found for this month.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-text-main dark:text-white">Recent Transactions</h3>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($recentIncomes as $income)
                        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-4 shadow-sm">
                            <p class="text-sm font-medium text-text-muted dark:text-gray-400">Income: {{ $income->description }}</p>
                            <p class="text-lg font-bold text-green-600 dark:text-green-400">+RM {{ number_format($income->amount, 2) }}</p>
                            <p class="text-xs text-text-muted dark:text-gray-500">{{ $income->date }}</p>
                        </div>
                    @endforeach
                    @foreach ($recentExpenses as $expense)
                        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-4 shadow-sm">
                            <p class="text-sm font-medium text-text-muted dark:text-gray-400">Expense: {{ $expense->description }}</p>
                            <p class="text-lg font-bold text-red-500 dark:text-red-400">-RM {{ number_format($expense->amount, 2) }}</p>
                            <p class="text-xs text-text-muted dark:text-gray-500">{{ $expense->date }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tax Calculation Details -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-text-main dark:text-white">Tax Calculation</h3>
                <div class="mt-4 rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-6 shadow-sm">
                    <p class="text-sm font-medium text-text-muted dark:text-gray-400">Estimated Tax Savings</p>
                    <p class="text-2xl font-bold text-primary">RM {{ number_format($estTaxSavings, 2) }}</p>
                    <p class="mt-2 text-xs text-text-muted dark:text-gray-500">Based on 15% of total income.</p>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Add Transaction Modal -->
<div id="transactionModal" class="fixed inset-0 z-50 hidden flex items-center justify-center overflow-y-auto bg-black/50 dark:bg-black/70 p-4">
    <div class="w-full max-w-md rounded-2xl bg-surface-light dark:bg-surface-dark shadow-xl animation-fade-in">
        <!-- Modal Header -->
        <div class="border-b border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 rounded-t-2xl px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-text-main dark:text-white" id="modalTitle">Add Income</h3>
            <button onclick="closeTransactionModal()" class="rounded-lg p-1 text-text-muted hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Modal Content -->
        <form id="transactionForm" class="space-y-4 p-6">
            @csrf
            <!-- Transaction Type (hidden field) -->
            <input type="hidden" id="transactionType" name="type" value="income">

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-text-main dark:text-white mb-2">Description</label>
                <input type="text" id="description" name="description" placeholder="e.g., Freelance Project" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
            </div>

            <!-- Amount -->
            <div>
                <label for="amount" class="block text-sm font-medium text-text-main dark:text-white mb-2">Amount (RM)</label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-text-muted dark:text-gray-400">RM</span>
                    <input type="number" id="amount" name="amount" placeholder="0.00" step="0.01" min="0" required class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                </div>
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-text-main dark:text-white mb-2">Category</label>
                <select id="category" name="category_id" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                    <option value="">Select a category</option>
                    <option value="1">Housing</option>
                    <option value="2">Transport</option>
                    <option value="3">Lifestyle</option>
                    <option value="4">Food & Dining</option>
                    <option value="5">Utilities</option>
                    <option value="6">Equipment</option>
                    <option value="7">Professional Services</option>
                    <option value="8">Other</option>
                </select>
            </div>

            <!-- Date -->
            <div>
                <label for="date" class="block text-sm font-medium text-text-main dark:text-white mb-2">Date</label>
                <input type="date" id="date" name="date" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
            </div>

            <!-- Tax Deductible (Expenses only) -->
            <div id="deductibleSection" class="hidden space-y-2">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" id="isDeductible" name="is_deductible" class="w-4 h-4 rounded border-border-light dark:border-border-dark text-primary focus:ring-primary">
                    <span class="text-sm font-medium text-text-main dark:text-white">Tax Deductible</span>
                </label>
                <p class="text-xs text-text-muted dark:text-gray-400 ml-7">Mark if this expense can be claimed as a tax deduction</p>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-text-main dark:text-white mb-2">Notes (Optional)</label>
                <textarea id="notes" name="notes" rows="2" placeholder="Add any additional details..." class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50 resize-none"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeTransactionModal()" class="flex-1 rounded-lg border border-border-light dark:border-border-dark px-4 py-2.5 text-sm font-medium text-text-main dark:text-white hover:bg-background-light dark:hover:bg-white/5 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-[#111814] hover:opacity-90 transition-opacity">
                    Save Transaction
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Transaction Form Script -->
<script>
    const transactionModal = document.getElementById('transactionModal');
    const transactionForm = document.getElementById('transactionForm');
    const transactionTypeInput = document.getElementById('transactionType');
    const modalTitle = document.getElementById('modalTitle');
    const deductibleSection = document.getElementById('deductibleSection');
    const dateInput = document.getElementById('date');
    const categorySelect = document.getElementById('category');

    // Set today's date as default
    dateInput.valueAsDate = new Date();

    function openTransactionModal(type) {
        transactionTypeInput.value = type;
        modalTitle.textContent = type === 'income' ? 'Add Income' : 'Add Expense';
        deductibleSection.classList.toggle('hidden', type === 'income');
        
        // Update category options based on type
        updateCategoryOptions(type);
        
        transactionModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeTransactionModal() {
        transactionModal.classList.add('hidden');
        transactionForm.reset();
        dateInput.valueAsDate = new Date();
        document.body.style.overflow = 'auto';
    }

    function updateCategoryOptions(type) {
        const incomeOptions = [
            { value: 'salary', text: 'Salary' },
            { value: 'freelance', text: 'Freelance Work' },
            { value: 'business', text: 'Business Income' },
            { value: 'investment', text: 'Investment Returns' },
            { value: 'other', text: 'Other Income' }
        ];

        const expenseOptions = [
            { value: 'housing', text: 'Housing' },
            { value: 'transport', text: 'Transport' },
            { value: 'lifestyle', text: 'Lifestyle' },
            { value: 'food', text: 'Food & Dining' },
            { value: 'utilities', text: 'Utilities' },
            { value: 'equipment', text: 'Equipment' },
            { value: 'professional', text: 'Professional Services' },
            { value: 'other', text: 'Other' }
        ];

        const options = type === 'income' ? incomeOptions : expenseOptions;
        categorySelect.innerHTML = '<option value="">Select a category</option>' + 
            options.map(opt => `<option value="${opt.value}">${opt.text}</option>`).join('');
    }

    // Form submission
    transactionForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        // Convert string to boolean for checkbox
        data.is_deductible = formData.has('is_deductible') ? true : false;

        try {
            const response = await fetch('{{ route("transactions.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (result.success) {
                // Show success message
                showSuccessNotification(result.message);
                
                // Close modal
                closeTransactionModal();
                
                // Refresh dashboard data after a short delay
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showErrorNotification(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            showErrorNotification('Failed to save transaction. Please try again.');
        }
    });

    // Helper function to show success notification
    function showSuccessNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 z-50 bg-green-500 dark:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg animate-slide-in';
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('animate-slide-out');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Helper function to show error notification
    function showErrorNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 z-50 bg-red-500 dark:bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg animate-slide-in';
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('animate-slide-out');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Close modal when clicking outside
    transactionModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeTransactionModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !transactionModal.classList.contains('hidden')) {
            closeTransactionModal();
        }
    });
</script>

<!-- Add CSS for modal animation -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }

    .animation-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }

    .animate-slide-in {
        animation: slideIn 0.3s ease-out;
    }

    .animate-slide-out {
        animation: slideOut 0.3s ease-in;
    }
</style>
