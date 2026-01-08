@extends('layouts.app')

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
                <h1 class="text-text-main dark:text-white text-lg font-bold leading-normal tracking-tight">RezTax</h1>
                <p class="text-text-muted dark:text-gray-400 text-xs font-normal">Professional Plan</p>
            </div>
        </div>
        <div class="flex flex-1 flex-col gap-2 overflow-y-auto px-4 py-4">
            <nav class="flex flex-col gap-1">
                <a class="group flex items-center gap-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-background-light dark:bg-white/5 text-text-main dark:text-white' : 'text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white' }} px-3 py-2.5 transition-colors" href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'text-primary' : '' }}" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a class="group flex items-center gap-3 rounded-lg {{ request()->routeIs('incomes.*') ? 'bg-background-light dark:bg-white/5 text-text-main dark:text-white' : 'text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white' }} px-3 py-2.5 transition-colors" href="{{ route('incomes.index') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('incomes.*') ? 'text-primary' : '' }}">payments</span>
                    <span class="text-sm font-medium">Income</span>
                </a>
                <a class="group flex items-center gap-3 rounded-lg {{ request()->routeIs('expenses.*') ? 'bg-background-light dark:bg-white/5 text-text-main dark:text-white' : 'text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white' }} px-3 py-2.5 transition-colors" href="{{ route('expenses.index') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('expenses.*') ? 'text-primary' : '' }}">receipt_long</span>
                    <span class="text-sm font-medium">Expenses</span>
                </a>
                <a class="group flex items-center gap-3 rounded-lg {{ request()->routeIs('tax-summary') ? 'bg-background-light dark:bg-white/5 text-text-main dark:text-white' : 'text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white' }} px-3 py-2.5 transition-colors" href="{{ route('tax-summary') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('tax-summary') ? 'text-primary' : '' }}">description</span>
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
        @if(session('success'))
            <div class="m-4 mb-0 rounded-lg bg-green-50 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                <div class="flex">
                    <span class="material-symbols-outlined mr-2">check_circle</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="m-4 mb-0 rounded-lg bg-red-50 p-4 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                <div class="flex">
                    <span class="material-symbols-outlined mr-2">error</span>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif
        @yield('dashboard-content')
    </main>
</div>
@endsection
