@extends('layouts.dashboard')

@section('dashboard-content')
<div class="flex h-screen w-full overflow-hidden">
    <!-- Main Content -->
    <div class="flex flex-col flex-1 h-full overflow-hidden bg-background-light dark:bg-background-dark relative">
        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-y-auto no-scrollbar p-4 md:p-8 lg:px-12 xl:px-24">
            <div class="max-w-4xl mx-auto flex flex-col gap-6">
                <!-- PageHeading -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('income') }}" class="flex items-center gap-2 text-text-secondary-light dark:text-text-secondary-dark text-sm">
                            <span class="material-symbols-outlined text-sm">arrow_back</span>
                            <span>Back to Income List</span>
                        </a>
                        <h1 class="text-text-primary-light dark:text-text-primary-dark text-3xl md:text-4xl font-black tracking-tight">Add New Income</h1>
                        <p class="text-text-secondary-light dark:text-text-secondary-dark text-base">Record your earnings for accurate Malaysian tax reporting.</p>
                    </div>
                </div>
                <!-- Form Container -->
                <form action="{{ route('income.store') }}" method="POST" class="bg-card-light dark:bg-card-dark rounded-2xl shadow-sm border border-border-light dark:border-border-dark p-6 md:p-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                        <!-- Amount Field -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2" for="amount">Total Amount (MYR)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-text-secondary-light dark:text-text-secondary-dark font-bold text-lg">RM</span>
                                <input id="amount" name="amount" class="w-full pl-12 pr-4 py-4 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-3xl font-bold text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-gray-300 dark:placeholder:text-gray-700" placeholder="0.00" type="text" required/>
                            </div>
                        </div>
                        <!-- Date Field -->
                        <div class="col-span-1">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2" for="date">Date Received</label>
                            <div class="relative">
                                <input id="date" name="date" class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" type="date" required/>
                            </div>
                        </div>
                        <!-- Source Field -->
                        <div class="col-span-1">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2" for="description">Payer / Employer</label>
                            <input id="description" name="description" class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-text-secondary-light dark:placeholder:text-text-secondary-dark" placeholder="e.g. Acme Corp Sdn Bhd" type="text" required/>
                        </div>
                        <!-- Description Field -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2" for="notes">Description / Reference</label>
                            <textarea id="notes" name="notes" class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-text-secondary-light dark:placeholder:text-text-secondary-dark min-h-[100px] resize-none" placeholder="e.g. Monthly Salary for March 2024, Project Alpha completion fee"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-8">
                        <a href="{{ route('income') }}" class="px-4 py-2 rounded-lg border border-border-light dark:border-border-dark text-text-primary-light dark:text-text-primary-dark font-medium hover:bg-background-light dark:hover:bg-background-dark transition-colors">Cancel</a>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-primary text-[#064e2a] font-bold shadow-lg shadow-primary/20 hover:bg-primary-dark hover:text-white transition-all transform hover:-translate-y-0.5">Save Record</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
