@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full overflow-hidden relative">
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 z-40 hidden bg-black/50 backdrop-blur-sm lg:hidden transition-opacity"></div>

    <!-- Side Navigation -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-border-light bg-surface-light transition-transform duration-300 dark:border-border-dark dark:bg-surface-dark lg:static lg:flex -translate-x-full lg:translate-x-0">
        <div class="flex h-16 items-center justify-between px-6">
            <div class="flex flex-col">
                <h1 class="text-lg font-bold leading-normal tracking-tight text-text-main dark:text-white">RezTax</h1>
                <p class="text-xs font-bold uppercase tracking-wider text-text-muted dark:text-gray-400">{{ auth()->user()->plan }} Account</p>
            </div>
            <!-- Close Button (Mobile Only) -->
            <button onclick="toggleSidebar()" class="lg:hidden text-text-muted hover:text-text-main dark:text-gray-400 dark:hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="flex flex-1 flex-col gap-2 overflow-y-auto px-4 py-4">
            <!-- Desktop "New Transaction" Button -->
            <button onclick="openTransactionModal('income')" class="hidden lg:flex mb-4 w-full cursor-pointer items-center justify-center rounded-xl bg-primary py-3 text-[#111814] text-sm font-black shadow-lg shadow-primary/20 transition-all hover:scale-[1.02] hover:shadow-primary/30 active:scale-[0.98]">
                <span class="material-symbols-outlined mr-2 text-[22px]">add_circle</span>
                <span>NEW TRANSACTION</span>
            </button>

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
        <!-- Removed Bottom Buttons -->
    </aside>
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Mobile Header -->
        <div class="sticky top-0 z-30 flex h-16 items-center border-b border-border-light bg-surface-light px-4 dark:border-border-dark dark:bg-surface-dark lg:hidden">
            <button onclick="toggleSidebar()" class="mr-4 text-text-muted hover:text-text-main dark:text-gray-400 dark:hover:text-white">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <h1 class="text-lg font-bold text-text-main dark:text-white">RezTax</h1>
        </div>

        <!-- Mobile FAB -->
        <button onclick="openTransactionModal('income')" class="fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-primary text-[#111814] shadow-lg shadow-primary/40 transition-transform hover:scale-110 active:scale-95 lg:hidden animate-in fade-in zoom-in duration-300">
            <span class="material-symbols-outlined text-[32px]">add</span>
        </button>

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

    // Mobile Sidebar Toggle
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    // Transaction Modal Logic
    function openTransactionModal(defaultType = 'income') {
        const modal = document.getElementById('transactionModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        switchTransactionType(defaultType);
        
        // Set today's date if empty
        const dateInput = document.getElementById('transactionDate');
        if (!dateInput.value) {
            dateInput.valueAsDate = new Date();
        }
    }

    function closeTransactionModal() {
        const modal = document.getElementById('transactionModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function switchTransactionType(type) {
        const form = document.getElementById('transactionForm');
        const incomeBtn = document.getElementById('tab-income');
        const expenseBtn = document.getElementById('tab-expense');
        const incomeCats = document.getElementById('categories-income');
        const expenseCats = document.getElementById('categories-expense');
        const modalTitle = document.getElementById('modal-title');

        if (type === 'income') {
            form.action = "{{ route('incomes.store') }}";
            modalTitle.innerText = "New Income";
            
            incomeBtn.classList.replace('text-text-muted', 'bg-white');
            incomeBtn.classList.replace('hover:text-text-main', 'text-primary');
            incomeBtn.classList.add('shadow-sm', 'dark:bg-white/10', 'dark:text-white');
            
            expenseBtn.classList.remove('bg-white', 'text-red-500', 'shadow-sm', 'dark:bg-white/10', 'dark:text-white');
            expenseBtn.classList.add('text-text-muted', 'hover:text-text-main');

            incomeCats.classList.remove('hidden');
            incomeCats.required = true;
            expenseCats.classList.add('hidden');
            expenseCats.required = false;
        } else {
            form.action = "{{ route('expenses.store') }}";
            modalTitle.innerText = "New Expense";
            
            expenseBtn.classList.replace('text-text-muted', 'bg-white');
            expenseBtn.classList.replace('hover:text-text-main', 'text-red-500');
            expenseBtn.classList.add('shadow-sm', 'dark:bg-white/10', 'dark:text-white');
            
            incomeBtn.classList.remove('bg-white', 'text-primary', 'shadow-sm', 'dark:bg-white/10', 'dark:text-white');
            incomeBtn.classList.add('text-text-muted', 'hover:text-text-main');

            expenseCats.classList.remove('hidden');
            expenseCats.required = true;
            incomeCats.classList.add('hidden');
            incomeCats.required = false;
        }
    }
</script>

<!-- Transaction Modal -->
<div id="transactionModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeTransactionModal()"></div>
    
    <div class="flex min-h-screen items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-surface-light dark:bg-surface-dark text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-border-light dark:border-border-dark">
             <div class="px-6 py-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-text-main dark:text-white tracking-tight" id="modal-title">New Transaction</h3>
                    <button onclick="closeTransactionModal()" class="text-text-muted hover:text-text-main dark:text-gray-400 dark:hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                
                <!-- Tabs -->
                <div class="grid grid-cols-2 gap-1 mb-6 p-1 bg-background-light dark:bg-white/5 rounded-xl border border-border-light dark:border-border-dark">
                    <button type="button" onclick="switchTransactionType('income')" id="tab-income" class="py-2.5 text-sm font-bold rounded-lg transition-all text-text-muted hover:text-text-main">Income</button>
                    <button type="button" onclick="switchTransactionType('expense')" id="tab-expense" class="py-2.5 text-sm font-bold rounded-lg transition-all text-text-muted hover:text-text-main">Expense</button>
                </div>

                <form id="transactionForm" method="POST" action="">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-text-muted dark:text-gray-400 mb-1">Amount</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-text-muted font-bold">RM</span>
                                <input type="number" step="0.01" name="amount" required class="w-full pl-10 rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 text-text-main dark:text-white font-bold focus:ring-primary focus:border-primary" placeholder="0.00">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-text-muted dark:text-gray-400 mb-1">Date</label>
                            <input type="date" id="transactionDate" name="date" required class="w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 text-text-main dark:text-white font-medium focus:ring-primary focus:border-primary">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-text-muted dark:text-gray-400 mb-1">Category</label>
                            <select name="category_id" id="categories-income" class="w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 text-text-main dark:text-white font-medium focus:ring-primary focus:border-primary">
                                <option value="" disabled selected>Select Category</option>
                                @foreach($sharedIncomeCategories ?? [] as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <select name="category_id" id="categories-expense" class="hidden w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 text-text-main dark:text-white font-medium focus:ring-primary focus:border-primary">
                                <option value="" disabled selected>Select Category</option>
                                @foreach($sharedExpenseCategories ?? [] as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-text-muted dark:text-gray-400 mb-1">Payment Method</label>
                            <select name="payment_method_id" required class="w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 text-text-main dark:text-white font-medium focus:ring-primary focus:border-primary">
                                @foreach($sharedPaymentMethods ?? [] as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-text-muted dark:text-gray-400 mb-1">Description</label>
                            <input type="text" name="description" required class="w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 text-text-main dark:text-white font-medium focus:ring-primary focus:border-primary" placeholder="What is this for?">
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full rounded-xl bg-primary py-3.5 text-sm font-black text-[#111814] shadow-lg shadow-primary/20 hover:bg-primary-dark hover:shadow-primary/30 transition-all active:scale-[0.98]">
                            SAVE TRANSACTION
                        </button>
                    </div>
                </form>
             </div>
        </div>
    </div>
</div>
