@extends('layouts.dashboard')

@section('dashboard-content')
<div class="flex h-screen w-full overflow-hidden">
    <!-- Main Content -->
    <div class="flex flex-col flex-1 h-full overflow-hidden bg-background-light dark:bg-background-dark relative">
        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-y-auto no-scrollbar p-4 md:p-8 lg:px-12 xl:px-24">
            <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl mx-auto flex flex-col gap-6">
                @csrf
                <input type="hidden" name="type" value="expense">
                <!-- PageHeading -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-text-secondary-light dark:text-text-secondary-dark text-sm hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-sm">arrow_back</span>
                            <span>Back to Dashboard</span>
                        </a>
                        <h1 class="text-text-primary-light dark:text-text-primary-dark text-3xl md:text-4xl font-black tracking-tight">Add New Expense</h1>
                        <p class="text-text-secondary-light dark:text-text-secondary-dark text-base">Record your business expenses for tax deductions.</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg border border-border-light dark:border-border-dark text-text-primary-light dark:text-text-primary-dark font-medium hover:bg-background-light dark:hover:bg-background-dark transition-colors text-center">Cancel</a>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-primary text-[#064e2a] font-bold shadow-lg shadow-primary/20 hover:bg-primary-dark hover:text-white transition-all transform hover:-translate-y-0.5">Save Expense</button>
                    </div>
                </div>
                <!-- Form Container -->
                <div class="bg-card-light dark:bg-card-dark rounded-2xl shadow-sm border border-border-light dark:border-border-dark p-6 md:p-8">
                    <!-- Category Section -->
                    <div class="mb-8">
                        <label class="text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-3 block">Expense Category</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <!-- Option 1: Office -->
                            <label class="relative flex flex-col items-center gap-3 p-4 rounded-xl border border-border-light dark:border-border-dark hover:bg-background-light dark:hover:bg-background-dark/50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 dark:has-[:checked]:bg-primary/10">
                                <input class="peer sr-only" name="category_id" type="radio" value="3" required/>
                                <div class="size-10 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                                    <span class="material-symbols-outlined">desk</span>
                                </div>
                                <span class="text-text-primary-light dark:text-text-primary-dark font-medium text-sm">Office</span>
                            </label>
                            <!-- Option 2: Transport -->
                            <label class="relative flex flex-col items-center gap-3 p-4 rounded-xl border border-border-light dark:border-border-dark hover:bg-background-light dark:hover:bg-background-dark/50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 dark:has-[:checked]:bg-primary/10">
                                <input class="peer sr-only" name="category_id" type="radio" value="4"/>
                                <div class="size-10 rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 flex items-center justify-center">
                                    <span class="material-symbols-outlined">directions_car</span>
                                </div>
                                <span class="text-text-primary-light dark:text-text-primary-dark font-medium text-sm">Transport</span>
                            </label>
                            <!-- Option 3: Utilities -->
                            <label class="relative flex flex-col items-center gap-3 p-4 rounded-xl border border-border-light dark:border-border-dark hover:bg-background-light dark:hover:bg-background-dark/50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 dark:has-[:checked]:bg-primary/10">
                                <input class="peer sr-only" name="category_id" type="radio" value="5"/>
                                <div class="size-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                                    <span class="material-symbols-outlined">bolt</span>
                                </div>
                                <span class="text-text-primary-light dark:text-text-primary-dark font-medium text-sm">Utilities</span>
                            </label>
                            <!-- Option 4: Other -->
                            <label class="relative flex flex-col items-center gap-3 p-4 rounded-xl border border-border-light dark:border-border-dark hover:bg-background-light dark:hover:bg-background-dark/50 cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 dark:has-[:checked]:bg-primary/10">
                                <input class="peer sr-only" name="category_id" type="radio" value="6"/>
                                <div class="size-10 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 flex items-center justify-center">
                                    <span class="material-symbols-outlined">more_horiz</span>
                                </div>
                                <span class="text-text-primary-light dark:text-text-primary-dark font-medium text-sm">Other</span>
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
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2">Date of Transaction</label>
                            <div class="relative">
                                <input name="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" type="date" required/>
                            </div>
                            @error('date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Vendor Field -->
                        <div class="col-span-1">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2">Vendor / Payee</label>
                            <input name="description" value="{{ old('description') }}" class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-text-secondary-light dark:placeholder:text-text-secondary-dark" placeholder="e.g. TNB, Grab, Shopee" type="text" required/>
                            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <!-- Description Field -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2">Description / Notes</label>
                            <textarea name="notes" class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-text-secondary-light dark:placeholder:text-text-secondary-dark min-h-[100px] resize-none" placeholder="Enter additional details regarding this expense...">{{ old('notes') }}</textarea>
                            @error('notes') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Tax Deductible Checkbox -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="flex items-center gap-3 p-4 rounded-xl border border-border-light dark:border-border-dark bg-background-light/50 dark:bg-background-dark/50 cursor-pointer hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                                <input type="checkbox" name="is_deductible" value="1" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary" {{ old('is_deductible') ? 'checked' : '' }}>
                                <div>
                                    <span class="block text-text-primary-light dark:text-text-primary-dark font-semibold text-sm">Tax Deductible Expense</span>
                                    <span class="block text-text-secondary-light dark:text-text-secondary-dark text-xs mt-0.5">Check this if this expense qualifies for tax deduction.</span>
                                </div>
                            </label>
                        </div>

                        <!-- Attachment Upload -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2">Receipt / Invoice</label>
                            <label class="border-2 border-dashed border-border-light dark:border-border-dark hover:border-primary dark:hover:border-primary rounded-xl p-8 flex flex-col items-center justify-center text-center cursor-pointer transition-colors bg-background-light/50 dark:bg-background-dark/50 group">
                                <input type="file" name="attachment" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="size-12 rounded-full bg-primary/10 flex items-center justify-center mb-3 group-hover:bg-primary/20 transition-colors">
                                    <span class="material-symbols-outlined text-primary text-2xl">upload_file</span>
                                </div>
                                <p class="text-text-primary-light dark:text-text-primary-dark font-medium text-sm">Click to upload or drag and drop</p>
                                <p class="text-text-secondary-light dark:text-text-secondary-dark text-xs mt-1">PDF, JPG, PNG up to 2MB</p>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>
@endsection
