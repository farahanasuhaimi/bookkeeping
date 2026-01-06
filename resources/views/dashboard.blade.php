@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
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
            </nav>
        </div>
        <div class="p-4 border-t border-border-light dark:border-border-dark">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex w-full cursor-pointer items-center justify-center rounded-lg bg-red-500 py-2.5 text-white text-sm font-bold shadow-sm transition-transform hover:scale-[1.02] active:scale-[0.98]">
                    <span class="material-symbols-outlined mr-2 text-[20px]">logout</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <div class="container mx-auto max-w-[1200px] px-4 py-8 md:px-8">
            <!-- Page Header -->
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-text-main dark:text-white sm:text-4xl">Welcome, {{ Auth::user()->name }}</h2>
                    <p class="mt-1 text-base text-text-muted dark:text-gray-400">Here's your financial snapshot</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <button class="flex items-center gap-2 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark px-4 py-2 text-sm font-medium text-text-main dark:text-white shadow-sm hover:bg-gray-50 dark:hover:bg-white/5">
                            <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                            <span>Oct 2023</span>
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
                    <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white">RM 12,500.00</p>
                    <div class="mt-2 flex items-center gap-2 text-xs">
                        <span class="font-medium text-green-600 dark:text-green-400">+12%</span>
                        <span class="text-text-muted dark:text-gray-500">vs last month</span>
                    </div>
                </div>
                <!-- Expenses Card -->
                <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-sm font-medium text-text-muted dark:text-gray-400">Total Expenses</p>
                        <span class="material-symbols-outlined text-red-500 bg-red-500/10 rounded-full p-1 text-[20px]">trending_down</span>
                    </div>
                    <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white">RM 4,200.00</p>
                    <div class="mt-2 flex items-center gap-2 text-xs">
                        <span class="inline-flex items-center gap-1 rounded-full bg-green-100 dark:bg-green-900/30 px-2 py-0.5 font-medium text-green-700 dark:text-green-400">
                            <span class="material-symbols-outlined text-[14px]">verified</span>
                            RM 1,200 Deductible
                        </span>
                    </div>
                </div>
                <!-- Balance Card -->
                <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-sm font-medium text-text-muted dark:text-gray-400">Net Balance</p>
                        <span class="material-symbols-outlined text-text-main dark:text-white bg-gray-100 dark:bg-white/10 rounded-full p-1 text-[20px]">account_balance_wallet</span>
                    </div>
                    <p class="text-2xl font-bold tracking-tight text-text-main dark:text-white">RM 8,300.00</p>
                    <div class="mt-2 flex items-center gap-2 text-xs">
                        <span class="font-medium text-green-600 dark:text-green-400">+8%</span>
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
                    <div class="mt-2 flex items-center gap-2 text-xs">
                        <span class="font-medium text-green-600 dark:text-green-400">+2%</span>
                        <span class="text-text-muted dark:text-gray-500">optimization</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
