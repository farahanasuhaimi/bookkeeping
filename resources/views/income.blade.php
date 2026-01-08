@extends('layouts.dashboard')

@section('dashboard-content')
<div class="flex h-screen w-full overflow-hidden">
    <!-- Main Content -->
    <div class="flex flex-col flex-1 h-full overflow-hidden bg-background-light dark:bg-background-dark relative">
        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-y-auto no-scrollbar p-4 md:p-8 lg:px-12 xl:px-24">
            <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl mx-auto flex flex-col gap-6">
                @csrf
                <input type="hidden" name="type" value="income">
                <!-- PageHeading -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-text-secondary-light dark:text-text-secondary-dark text-sm hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-sm">arrow_back</span>
                            <span>Back to Income List</span>
                        </a>
                        <h1 class="text-text-primary-light dark:text-text-primary-dark text-3xl md:text-4xl font-black tracking-tight">Add New Income</h1>
                        <p class="text-text-secondary-light dark:text-text-secondary-dark text-base">Record your earnings for accurate Malaysian tax reporting.</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg border border-border-light dark:border-border-dark text-text-primary-light dark:text-text-primary-dark font-medium hover:bg-background-light dark:hover:bg-background-dark transition-colors text-center">Cancel</a>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-primary text-[#064e2a] font-bold shadow-lg shadow-primary/20 hover:bg-primary-dark hover:text-white transition-all transform hover:-translate-y-0.5">Save Record</button>
                    </div>
                </div>
                <!-- Form Container -->
                <div class="bg-card-light dark:bg-card-dark rounded-2xl shadow-sm border border-border-light dark:border-border-dark p-6 md:p-8">
                    <!-- SegmentedButtons -->
                    <div class="mb-8">
                        <label class="text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-3 block">Income Category</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Option 1 -->
                            <label class="relative flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all border-primary bg-primary/5 dark:bg-primary/10">
                                <input checked="" class="peer sr-only" name="category_id" type="radio" value="1"/>
                                <div class="mt-1 size-5 rounded-full border border-primary flex items-center justify-center peer-checked:bg-primary">
                                    <div class="size-2.5 rounded-full bg-white"></div>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-text-primary-light dark:text-text-primary-dark font-bold text-base mb-1">Official Employment</span>
                                    <span class="text-text-secondary-light dark:text-text-secondary-dark text-sm">Form BE (Gaji, Bonus, Allowance)</span>
                                </div>
                                <span class="material-symbols-outlined absolute top-4 right-4 text-primary">badge</span>
                            </label>
                            <!-- Option 2 -->
                            <label class="relative flex items-start gap-4 p-4 rounded-xl border border-border-light dark:border-border-dark hover:bg-background-light dark:hover:bg-background-dark/50 cursor-pointer transition-all">
                                <input class="peer sr-only" name="category_id" type="radio" value="2"/>
                                <div class="mt-1 size-5 rounded-full border border-gray-300 dark:border-gray-600 flex items-center justify-center peer-checked:bg-primary peer-checked:border-primary">
                                    <div class="size-2.5 rounded-full bg-white hidden peer-checked:block"></div>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-text-primary-light dark:text-text-primary-dark font-medium text-base mb-1">Part-time / Business</span>
                                    <span class="text-text-secondary-light dark:text-text-secondary-dark text-sm">Form B (Freelance, Side Hustle)</span>
                                </div>
                                <span class="material-symbols-outlined absolute top-4 right-4 text-text-secondary-light dark:text-text-secondary-dark">storefront</span>
                            </label>
                        </div>
                        @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                        <!-- Amount Field -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2">Total Amount (MYR)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-text-secondary-light dark:text-text-secondary-dark font-bold text-lg">RM</span>
                                <input name="amount" value="{{ old('amount') }}" class="w-full pl-12 pr-4 py-4 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-3xl font-bold text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-gray-300 dark:placeholder:text-gray-700" placeholder="0.00" type="number" step="0.01" required/>
                            </div>
                            @error('amount') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Date Field -->
                        <div class="col-span-1">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2">Date Received</label>
                            <div class="relative">
                                <input name="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" type="date" required/>
                            </div>
                            @error('date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Source Field -->
                        <div class="col-span-1">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2">Payer / Employer</label>
                            <input name="description" value="{{ old('description') }}" class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-text-secondary-light dark:placeholder:text-text-secondary-dark" placeholder="e.g. Acme Corp Sdn Bhd" type="text" required/>
                            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Description Field -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2">Description / Reference</label>
                            <textarea name="notes" class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-text-secondary-light dark:placeholder:text-text-secondary-dark min-h-[100px] resize-none" placeholder="e.g. Monthly Salary for March 2024, Project Alpha completion fee">{{ old('notes') }}</textarea>
                            @error('notes') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Tax Deduction (PCB) Section - Conditional Style -->
                        <div class="col-span-1 md:col-span-2 p-5 bg-background-light dark:bg-background-dark rounded-xl border border-border-light dark:border-border-dark border-dashed">
                            <div class="flex items-start gap-4">
                                <div class="mt-1 text-primary">
                                    <span class="material-symbols-outlined">account_balance</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-text-primary-light dark:text-text-primary-dark font-semibold text-sm">Monthly Tax Deduction (PCB)</h3>
                                    <p class="text-text-secondary-light dark:text-text-secondary-dark text-xs mt-1 mb-3">If this income has already been taxed via PCB, enter the amount here.</p>
                                    <div class="flex items-center max-w-[200px] relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary-light dark:text-text-secondary-dark text-sm">RM</span>
                                        <input name="pcb_amount" value="{{ old('pcb_amount') }}" class="w-full pl-10 pr-3 py-2 bg-white dark:bg-[#1f362a] border border-border-light dark:border-border-dark rounded-lg text-sm text-text-primary-light dark:text-text-primary-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="0.00" type="number" step="0.01"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Attachment Upload -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2">Supporting Documents</label>
                            <label class="border-2 border-dashed border-border-light dark:border-border-dark hover:border-primary dark:hover:border-primary rounded-xl p-8 flex flex-col items-center justify-center text-center cursor-pointer transition-colors bg-background-light/50 dark:bg-background-dark/50 group">
                                <input type="file" name="attachment" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="size-12 rounded-full bg-primary/10 flex items-center justify-center mb-3 group-hover:bg-primary/20 transition-colors">
                                    <span class="material-symbols-outlined text-primary text-2xl">upload_file</span>
                                </div>
                                <p class="text-text-primary-light dark:text-text-primary-dark font-medium text-sm">Click to upload or drag and drop</p>
                                <p class="text-text-secondary-light dark:text-text-secondary-dark text-xs mt-1">Payslips, Invoices, Bank Statements (PDF, JPG, PNG)</p>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Footer Note -->
                <div class="flex items-start gap-3 p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-sm">
                    <span class="material-symbols-outlined text-lg mt-0.5">info</span>
                    <p>
                        This income will be added to your <strong>Year of Assessment 2024</strong> calculations. Please ensure the category matches your LHDN filing type (Form B or BE).
                    </p>
                </div>
            </form>
        </main>
    </div>
</div>
@endsection
