@extends('layouts.dashboard')

@section('dashboard-content')
<div class="flex h-screen w-full overflow-hidden">
    <!-- Main Content Wrapper -->
    <div class="flex flex-1 flex-col h-full overflow-hidden relative">
        <!-- Scrollable Page Content -->
        <main class="flex-1 overflow-y-auto p-4 lg:p-10 scroll-smooth">
            <div class="max-w-5xl mx-auto space-y-6">
                <!-- Breadcrumbs -->
                <div class="flex items-center gap-2 text-sm">
                    <a class="text-[#618975] dark:text-slate-400 hover:text-primary font-medium transition-colors" href="#">Home</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <a class="text-[#618975] dark:text-slate-400 hover:text-primary font-medium transition-colors" href="#">Expenses</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="text-[#111814] dark:text-white font-medium">Add New</span>
                </div>
                <!-- Page Heading -->
                <div class="flex flex-col gap-2">
                    <h1 class="text-3xl lg:text-4xl font-black tracking-tight text-[#111814] dark:text-white">Record New Expense</h1>
                    <p class="text-[#618975] dark:text-slate-400 text-base max-w-2xl">
                        Enter details for your business expenditure. Ensure tax details are accurate for LHDN reporting.
                    </p>
                </div>
                <!-- Form Card -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden">
                    <!-- Form Header (Optional) -->
                    <div class="px-6 py-4 border-b border-border-light dark:border-border-dark bg-slate-50/50 dark:bg-white/5 flex justify-between items-center">
                        <h3 class="font-semibold text-lg">Expense Details</h3>
                        <span class="text-xs font-medium px-2 py-1 rounded bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200">Draft</span>
                    </div>
                    <div class="p-6 lg:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <!-- Amount -->
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-[#111814] dark:text-slate-200">Amount (MYR) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 font-medium">RM</span>
                                </div>
                                <input class="w-full pl-10 pr-4 py-3 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-[#111814] dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" placeholder="0.00" step="0.01" type="number"/>
                            </div>
                        </div>
                        <!-- Date -->
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-[#111814] dark:text-slate-200">Date of Transaction <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input class="w-full pl-4 pr-10 py-3 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-[#111814] dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all [color-scheme:light] dark:[color-scheme:dark]" type="date"/>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-slate-400">calendar_today</span>
                                </div>
                            </div>
                        </div>
                        <!-- Category -->
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-[#111814] dark:text-slate-200">Expense Category <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select class="w-full pl-4 pr-10 py-3 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-[#111814] dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none transition-all">
                                    <option disabled="" selected="" value="">Select a category</option>
                                    <option value="office">Office Supplies</option>
                                    <option value="travel">Travel &amp; Transport</option>
                                    <option value="meals">Meals &amp; Entertainment</option>
                                    <option value="utilities">Utilities</option>
                                    <option value="rent">Rent</option>
                                    <option value="marketing">Marketing</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-slate-400">expand_more</span>
                                </div>
                            </div>
                        </div>
                        <!-- Vendor -->
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-[#111814] dark:text-slate-200">Vendor / Payee</label>
                            <div class="relative">
                                <input class="w-full pl-4 pr-4 py-3 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-[#111814] dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" placeholder="e.g. TNB, Grab, Shopee" type="text"/>
                            </div>
                        </div>
                        <!-- Description (Full width) -->
                        <div class="flex flex-col gap-2 md:col-span-2">
                            <label class="text-sm font-semibold text-[#111814] dark:text-slate-200">Description</label>
                            <textarea class="w-full p-4 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-[#111814] dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none transition-all" placeholder="Enter additional details regarding this expense..." rows="3"></textarea>
                        </div>
                        <!-- Tax Compliance Section (Full width) -->
                        <div class="md:col-span-2 mt-2">
                            <div class="rounded-xl border border-primary/30 bg-primary/5 dark:bg-primary/10 p-5 flex flex-col sm:flex-row gap-4 items-start sm:items-center transition-colors">
                                <div class="relative flex items-center">
                                    <input class="peer h-6 w-6 cursor-pointer appearance-none rounded border border-primary text-primary focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-all checked:bg-primary checked:border-transparent" id="tax-deductible" type="checkbox"/>
                                    <span class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 peer-checked:opacity-100 material-symbols-outlined text-lg font-bold">check</span>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-base font-bold text-[#111814] dark:text-white cursor-pointer" for="tax-deductible">
                                        Tax-Deductible Expense (Qualifying Expenditure)
                                    </label>
                                    <p class="text-sm text-[#618975] dark:text-slate-400 mt-1">
                                        Check this if this expense qualifies for tax deduction under <span class="font-medium text-slate-800 dark:text-slate-200">Income Tax Act 1967</span>.
                                    </p>
                                </div>
                                <div class="hidden sm:block">
                                    <span class="material-symbols-outlined text-primary text-4xl opacity-50">verified_user</span>
                                </div>
                            </div>
                        </div>
                        <!-- Receipt Upload (Full width) -->
                        <div class="md:col-span-2">
                            <label class="text-sm font-semibold text-[#111814] dark:text-slate-200 mb-2 block">Receipt / Invoice</label>
                            <div class="border-2 border-dashed border-border-light dark:border-border-dark hover:border-primary dark:hover:border-primary rounded-xl p-8 flex flex-col items-center justify-center text-center cursor-pointer bg-slate-50 dark:bg-slate-900/50 hover:bg-white dark:hover:bg-slate-900 transition-all group">
                                <div class="bg-white dark:bg-slate-800 p-3 rounded-full shadow-sm mb-3 group-hover:scale-110 transition-transform duration-200">
                                    <span class="material-symbols-outlined text-3xl text-primary">cloud_upload</span>
                                </div>
                                <p class="text-sm font-medium text-[#111814] dark:text-white">Click to upload or drag and drop</p>
                                <p class="text-xs text-[#618975] dark:text-slate-500 mt-1">PDF, PNG, JPG up to 10MB</p>
                            </div>
                        </div>
                    </div>
                    <!-- Action Bar -->
                    <div class="px-6 py-5 bg-slate-50 dark:bg-slate-900 border-t border-border-light dark:border-border-dark flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                        <button class="px-6 py-2.5 rounded-lg text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors">
                            Cancel
                        </button>
                        <button class="px-6 py-2.5 rounded-lg text-sm font-bold text-primary border border-primary hover:bg-primary/10 transition-colors">
                            Save &amp; Add Another
                        </button>
                        <button class="px-6 py-2.5 rounded-lg text-sm font-bold bg-primary text-[#111814] hover:bg-primary-hover shadow-sm hover:shadow transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-lg">save</span>
                            Save Expense
                        </button>
                    </div>
                </div>
                <!-- Helper Links -->
                <div class="flex justify-center gap-6 pt-4 pb-8">
                    <a class="text-xs text-[#618975] dark:text-slate-500 hover:text-primary underline" href="#">LHDN Tax Guidelines</a>
                    <a class="text-xs text-[#618975] dark:text-slate-500 hover:text-primary underline" href="#">Expense Categories Help</a>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
