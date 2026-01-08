@extends('layouts.main')

@section('dashboard-content')
<div class="container mx-auto max-w-2xl px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex flex-col">
            <h1 class="text-3xl font-black tracking-tight text-text-primary-light dark:text-text-primary-dark">
                {{ isset($income) ? 'Edit Income' : 'Add New Income' }}
            </h1>
            <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">
                {{ isset($income) ? 'Update your income details' : 'Record a new income entry' }}
            </p>
        </div>
        <a href="{{ route('incomes.index') }}" class="rounded-lg border border-border-light px-4 py-2 text-sm font-medium text-text-muted hover:bg-background-light dark:border-border-dark dark:text-gray-400 dark:hover:bg-white/5 transition-colors">
            Cancel
        </a>
    </div>

    <div class="rounded-2xl bg-card-light dark:bg-card-dark p-6 shadow-sm border border-border-light dark:border-border-dark">
        <form action="{{ isset($income) ? route('incomes.update', $income->id) : route('incomes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if(isset($income))
                @method('PUT')
            @endif

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-text-main dark:text-white mb-2">Description / Source</label>
                <input type="text" id="description" name="description" value="{{ old('description', $income->description ?? '') }}" placeholder="e.g., Monthly Salary, Freelance Project" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
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
                        <input type="number" id="amount" name="amount" value="{{ old('amount', $income->amount ?? '') }}" placeholder="0.00" step="0.01" min="0" required class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                    </div>
                    @error('amount')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-text-main dark:text-white mb-2">Date received</label>
                    <input type="date" id="date" name="date" value="{{ old('date', isset($income) ? $income->date->format('Y-m-d') : date('Y-m-d')) }}" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                    @error('date')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-text-main dark:text-white mb-2">Category</label>
                <select id="category" name="category_id" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                    <option value="">Select a category (Optional)</option>
                    <option value="1" {{ old('category_id', $income->category_id ?? '') == 1 ? 'selected' : '' }}>Official Employment</option>
                    <option value="2" {{ old('category_id', $income->category_id ?? '') == 2 ? 'selected' : '' }}>Part-time / Business</option>
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
                        <option value="{{ $method->id }}" {{ old('payment_method_id', $income->payment_method_id ?? '') == $method->id ? 'selected' : '' }}>
                            {{ $method->name }}
                        </option>
                    @endforeach
                </select>
                @error('payment_method_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-text-main dark:text-white mb-2">Notes (Optional)</label>
                <textarea id="notes" name="notes" rows="3" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50 resize-none">{{ old('notes', $income->notes ?? '') }}</textarea>
            </div>

            <!-- Attachment -->
            <div>
                <label for="attachment" class="block text-sm font-medium text-text-main dark:text-white mb-2">Attachment (Optional)</label>
                <input type="file" id="attachment" name="attachment" accept="image/*,.pdf" class="block w-full text-sm text-text-muted dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                <p class="mt-1 text-xs text-text-muted dark:text-gray-500">Max 10MB. Images or PDF.</p>
                @if(isset($income) && $income->attachment_path)
                    <p class="mt-2 text-xs text-green-600 dark:text-green-400 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">attachment</span>
                        Current file available
                    </p>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full rounded-lg bg-primary px-4 py-3 text-base font-bold text-[#111814] shadow-lg shadow-primary/20 hover:bg-primary-dark hover:text-white transition-all transform hover:-translate-y-0.5">
                    {{ isset($income) ? 'Update Income' : 'Save Income Record' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
