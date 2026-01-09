@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full overflow-hidden">
    <!-- Side Navigation -->
    <aside class="hidden w-64 flex-col border-r border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark lg:flex">
        <div class="flex h-16 items-center px-6">
            <div class="flex flex-col">
                <h1 class="text-text-main dark:text-white text-lg font-bold leading-normal tracking-tight">RezTax</h1>
                <p class="text-text-muted dark:text-gray-400 text-xs font-bold uppercase tracking-wider">{{ auth()->user()->plan }} Account</p>
            </div>
        </div>
        <div class="flex flex-1 flex-col gap-2 overflow-y-auto px-4 py-4">
            <nav class="flex flex-col gap-1">
                @if(auth()->user()->is_admin)
                <div class="px-3 py-2 mb-1">
                    <p class="text-[10px] font-black uppercase tracking-widest text-primary">Administration</p>
                </div>
                <a class="group flex items-center gap-3 rounded-lg {{ request()->routeIs('admin.*') ? 'bg-primary/10 text-primary' : 'text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white' }} px-3 py-2.5 transition-colors mb-4" href="{{ route('admin.dashboard') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.*') ? 'text-primary' : '' }}" style="font-variation-settings: 'FILL' 1;">admin_panel_settings</span>
                    <span class="text-sm font-bold">Admin Controls</span>
                </a>
                <div class="border-t border-border-light dark:border-border-dark my-2"></div>
                @endif
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
                <a href="{{ route('saving-tracking') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('saving-tracking') ? 'bg-primary/10 text-primary' : 'text-text-muted dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5' }} transition-colors">
                    <span class="material-symbols-outlined text-[22px]">savings</span>
                    <span class="text-sm font-semibold">Savings Tracker</span>
                </a>
                <a class="group flex items-center gap-3 rounded-lg {{ request()->routeIs('import.*') ? 'bg-background-light dark:bg-white/5 text-text-main dark:text-white' : 'text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white' }} px-3 py-2.5 transition-colors" href="{{ route('import.index') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('import.*') ? 'text-primary' : '' }}">upload_file</span>
                    <span class="text-sm font-medium">Import Statement</span>
                </a>
                <a class="group flex items-center gap-3 rounded-lg {{ request()->routeIs('settings.*') ? 'bg-background-light dark:bg-white/5 text-text-main dark:text-white' : 'text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white' }} px-3 py-2.5 transition-colors" href="{{ route('settings.index') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('settings.*') ? 'text-primary' : '' }}">settings</span>
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
        @if(auth()->user()->plan == 'free')
        <div class="p-4 px-6">
            <div class="rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-900/50 p-4">
                <p class="text-xs font-bold text-amber-800 dark:text-amber-400 mb-2 italic">Unlock Pro Features</p>
                <a href="{{ route('pricing') }}" class="block w-full text-center bg-amber-400 hover:bg-amber-500 text-text-main text-[11px] font-black py-2 rounded-lg transition-colors italic">
                    UPGRADE NOW
                </a>
            </div>
        </div>
        @endif
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

<!-- Upgrade Modal -->
<div id="upgradeModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="w-full max-w-md bg-surface-light dark:bg-surface-dark rounded-2xl shadow-2xl overflow-hidden border border-border-light dark:border-border-dark animate-in fade-in zoom-in duration-200">
        <div class="relative p-8 text-center">
            <button onclick="closeUpgradeModal()" class="absolute top-4 right-4 text-text-muted hover:text-text-main dark:text-gray-400 dark:hover:text-white transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/30 mb-6">
                <span class="material-symbols-outlined text-3xl text-amber-500">military_tech</span>
            </div>
            <h3 class="text-2xl font-black text-text-main dark:text-white mb-2 tracking-tight">Upgrade to RezTax Pro</h3>
            <p class="text-text-muted dark:text-gray-400 mb-8 leading-relaxed">
                Unlock professional tax reporting, year-on-year analysis, and advanced income forecasting to maximize your tax savings.
            </p>
            <ul class="text-left space-y-3 mb-8 px-4">
                <li class="flex items-center gap-3 text-sm font-medium">
                    <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                    Professional PDF Export
                </li>
                <li class="flex items-center gap-3 text-sm font-medium">
                    <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                    Advanced Tax Projections
                </li>
                <li class="flex items-center gap-3 text-sm font-medium">
                    <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                    Historical Year Comparisons
                </li>
            </ul>
            <a href="{{ route('pricing') }}" class="block w-full text-center bg-primary hover:bg-primary-dark text-text-main font-black py-4 rounded-xl transition-transform hover:scale-[1.02] shadow-xl shadow-primary/20 italic">
                EXPLORE PLANS
            </a>
            <p class="mt-4 text-[10px] text-text-muted uppercase font-bold tracking-widest italic">Starting from RM 15.00 / month</p>
        </div>
    </div>
</div>

<script>
    function showUpgradeModal() {
        document.getElementById('upgradeModal').classList.remove('hidden');
    }
    function closeUpgradeModal() {
        document.getElementById('upgradeModal').classList.add('hidden');
    }
</script>
