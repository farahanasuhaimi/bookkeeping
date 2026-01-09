@extends('layouts.main')

@section('dashboard-content')
<div class="px-6 py-12 max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-text-main dark:text-white mb-2 italic">Import Bank Statement</h2>
        <p class="text-text-muted dark:text-gray-400">Upload your CSV file to automatically populate your records.</p>
    </div>

    <div class="bg-surface-light dark:bg-surface-dark rounded-3xl p-8 border border-border-light dark:border-border-dark shadow-sm">
        <form action="{{ route('import.preview') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-8">
                <label class="block text-sm font-bold text-text-main dark:text-white mb-4">Select CSV File</label>
                <div class="relative group">
                    <input type="file" name="csv_file" accept=".csv,.txt" required
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="border-2 border-dashed border-border-light dark:border-border-dark rounded-2xl p-12 text-center group-hover:border-primary transition-colors">
                        <span class="material-symbols-outlined text-4xl text-text-muted group-hover:text-primary mb-2">upload_file</span>
                        <p class="text-sm text-text-muted dark:text-gray-400">Click to browse or drag and drop your bank export</p>
                        <p class="text-xs text-text-muted/60 mt-1">Maximum size: 2MB</p>
                    </div>
                </div>
                @error('csv_file')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-text-main font-black py-4 rounded-xl transition-all hover:scale-[1.01] flex items-center justify-center gap-2 italic">
                <span>PREVIEW IMPORT</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </form>
    </div>

    <div class="mt-12 p-6 bg-amber-50 dark:bg-amber-900/20 rounded-2xl border border-amber-200 dark:border-amber-900/50">
        <h4 class="flex items-center gap-2 text-amber-800 dark:text-amber-400 font-bold mb-2">
            <span class="material-symbols-outlined">info</span>
            How it works
        </h4>
        <ul class="text-sm text-amber-800/80 dark:text-amber-400/80 space-y-2">
            <li>• You will be able to map your columns (Date, Description, Amount) in the next step.</li>
            <li>• The system automatically separates Incomes and Expenses based on the amount sign.</li>
            <li>• No data is permanently stored until you confirm the mapping.</li>
        </ul>
    </div>
</div>
@endsection
