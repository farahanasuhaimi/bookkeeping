@extends('layouts.main')

@section('dashboard-content')
<div class="container mx-auto max-w-2xl px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex flex-col">
            <h1 class="text-3xl font-black tracking-tight text-text-primary-light dark:text-text-primary-dark">
                {{ isset($expense) ? 'Edit Expense' : 'Add New Expense' }}
            </h1>
            <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">
                {{ isset($expense) ? 'Update expense details' : 'Log a new startup expense' }}
            </p>
        </div>
        <a href="{{ route('expenses.index') }}" class="rounded-lg border border-border-light px-4 py-2 text-sm font-medium text-text-muted hover:bg-background-light dark:border-border-dark dark:text-gray-400 dark:hover:bg-white/5 transition-colors">
            Cancel
        </a>
    </div>

    <div class="rounded-2xl bg-card-light dark:bg-card-dark p-6 shadow-sm border border-border-light dark:border-border-dark">
        <form action="{{ isset($expense) ? route('expenses.update', $expense->id) : route('expenses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if(isset($expense))
                @method('PUT')
            @endif

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-text-main dark:text-white mb-2">Description / Vendor</label>
                <input type="text" id="description" name="description" value="{{ old('description', $expense->description ?? '') }}" placeholder="e.g., Office Rent, Server Cost" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                @error('description')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount & Date Row -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-text-main dark:text-white mb-2">Amount (RM)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-2.5 text-text-muted dark:text-gray-400">RM</span>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', $expense->amount ?? '') }}" placeholder="0.00" step="0.01" min="0" required class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                    </div>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-text-main dark:text-white mb-2">Date</label>
                    <input type="date" id="date" name="date" value="{{ old('date', isset($expense) ? $expense->date->format('Y-m-d') : date('Y-m-d')) }}" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                </div>
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-text-main dark:text-white mb-2">Category</label>
                <select id="category" name="category_id" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $expense->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Payment Method -->
            <div>
                <label for="payment_method" class="block text-sm font-medium text-text-main dark:text-white mb-2">Payment Method</label>
                <select id="payment_method" name="payment_method_id" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                    <option value="">Select Method</option>
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->id }}" {{ old('payment_method_id', $expense->payment_method_id ?? '') == $method->id ? 'selected' : '' }}>
                            {{ $method->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tax Deductible (Expenses only) -->
            <div>
                <label class="flex items-center gap-3 cursor-pointer py-2 px-1">
                    <input type="checkbox" name="is_deductible" value="1" {{ old('is_deductible', $expense->is_deductible ?? false) ? 'checked' : '' }} class="w-5 h-5 rounded border-border-light dark:border-border-dark text-primary focus:ring-primary">
                    <div>
                        <span class="block text-sm font-medium text-text-main dark:text-white">Tax Deductible</span>
                        <span class="block text-xs text-text-muted dark:text-gray-400">Mark if this expense can be claimed as a tax deduction</span>
                    </div>
                </label>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-text-main dark:text-white mb-2">Notes (Optional)</label>
                <textarea id="notes" name="notes" rows="3" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50 resize-none">{{ old('notes', $expense->notes ?? '') }}</textarea>
            </div>

            <!-- Attachment -->
            <div>
                <label for="attachment" class="block text-sm font-medium text-text-main dark:text-white mb-2 flex items-center gap-2">
                    Receipt / Attachment (Optional)
                    @if(auth()->user()->plan != 'pro')
                        <span class="inline-flex items-center rounded-md bg-amber-50 dark:bg-amber-900/30 px-2 py-0.5 text-[10px] font-bold text-amber-700 dark:text-amber-400 ring-1 ring-inset ring-amber-600/20">PRO</span>
                    @endif
                </label>
                
                @if(auth()->user()->plan == 'pro')
                    <input type="file" id="attachment" name="attachment" accept="image/*,.pdf" class="block w-full text-sm text-text-muted dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    <p class="mt-1 text-xs text-text-muted dark:text-gray-500">Max 10MB. Images or PDF.</p>
                @else
                    <div class="relative group cursor-pointer" onclick="showUpgradeModal()">
                        <div class="absolute inset-0 bg-gray-100/50 dark:bg-card-dark/50 backdrop-blur-[2px] rounded-lg flex items-center justify-center z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-xs font-black text-amber-500 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">lock</span> UNLOCK ATTACHMENTS
                            </span>
                        </div>
                        <input type="file" disabled class="block w-full text-xs text-text-muted dark:text-gray-400 border border-dashed border-border-light dark:border-border-dark rounded-lg p-4 cursor-not-allowed" placeholder="Upgrade to Pro to upload receipts">
                    </div>
                    <p class="mt-1 text-[10px] text-amber-600 dark:text-amber-400 font-bold">File attachments are available for Pro users only.</p>
                @endif

                @if(isset($expense) && $expense->attachment_path)
                     <p class="mt-2 text-xs text-green-600 dark:text-green-400 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">attachment</span>
                        Current file available
                    </p>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full rounded-lg bg-primary px-4 py-3 text-base font-bold text-[#111814] shadow-lg shadow-primary/20 hover:bg-primary-dark hover:text-white transition-all transform hover:-translate-y-0.5">
                    {{ isset($expense) ? 'Update Expense' : 'Save Expense Record' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
