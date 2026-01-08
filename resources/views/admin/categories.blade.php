@extends('layouts.main')

@section('dashboard-content')
<div class="container mx-auto max-w-[1200px] px-4 py-8 md:px-8">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-text-main dark:text-white sm:text-4xl">Global Categories</h2>
            <p class="mt-1 text-base text-text-muted dark:text-gray-400">Control system-wide income and expense categories.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-primary hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Admin
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- New Category Form -->
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-6 shadow-sm h-fit">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4">Add New Category</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-1 text-text-main dark:text-white">Category Name</label>
                    <input type="text" name="name" required placeholder="e.g. Dividend" class="w-full px-4 py-2 rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 focus:ring-2 focus:ring-primary/50 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1 text-text-main dark:text-white">Type</label>
                    <select name="type" required class="w-full px-4 py-2 rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 focus:ring-2 focus:ring-primary/50 outline-none">
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-text-main py-2 rounded-lg font-bold transition-colors shadow-lg shadow-primary/20">
                    Create Global Category
                </button>
            </form>
        </div>

        <!-- Category List -->
        <div class="lg:col-span-2 rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="bg-background-light dark:bg-white/5 text-xs uppercase text-text-muted dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-center">ID</th>
                        <th class="px-6 py-3 font-semibold">Name</th>
                        <th class="px-6 py-3 font-semibold">Type</th>
                        <th class="px-6 py-3 font-semibold text-center">Visibility</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @foreach($categories as $category)
                        <tr class="hover:bg-background-light dark:hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 text-center font-mono text-xs text-text-muted">{{ $category->id }}</td>
                            <td class="px-6 py-4 font-bold text-text-main dark:text-white">{{ $category->name }}</td>
                            <td class="px-6 py-4">
                                <span class="capitalize px-2 py-0.5 rounded text-xs {{ $category->type == 'income' ? 'bg-green-100 dark:bg-green-900/30 text-green-700' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-700' }}">
                                    {{ $category->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs font-medium text-text-muted dark:text-gray-400">Global</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
