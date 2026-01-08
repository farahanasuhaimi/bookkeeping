@extends('layouts.main')

@section('dashboard-content')
<div class="flex h-screen w-full overflow-hidden">
    <!-- Main Content -->
    <div class="flex flex-col flex-1 h-full overflow-hidden bg-background-light dark:bg-background-dark relative">
        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-y-auto no-scrollbar p-4 md:p-8 lg:px-12 xl:px-24">
            <div class="max-w-6xl mx-auto flex flex-col gap-6">
                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex flex-col gap-2">
                        <h1 class="text-text-primary-light dark:text-text-primary-dark text-3xl md:text-4xl font-black tracking-tight">Expenses</h1>
                        <p class="text-text-secondary-light dark:text-text-secondary-dark text-base">Manage your spending and tax deductions.</p>
                    </div>
                    <a href="{{ route('expenses.create') }}" class="flex items-center gap-2 px-6 py-2.5 rounded-lg bg-primary text-[#064e2a] font-bold shadow-lg shadow-primary/20 hover:bg-primary-dark hover:text-white transition-all transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-[20px]">add_circle</span>
                        <span>Add New Expense</span>
                    </a>
                </div>

                <!-- Data Table -->
                <div class="bg-card-light dark:bg-card-dark rounded-2xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-background-light dark:bg-white/5 border-b border-border-light dark:border-border-dark text-text-muted dark:text-gray-400 uppercase text-xs font-semibold">
                                <tr>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Vendor / Description</th>
                                    <th class="px-6 py-4">Category</th>
                                    <th class="px-6 py-4">Method</th>
                                    <th class="px-6 py-4 text-center">Receipt</th>
                                    <th class="px-6 py-4 text-right">Amount (RM)</th>
                                    <th class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-light dark:divide-border-dark text-text-primary-light dark:text-text-primary-dark">
                                @forelse($expenses as $expense)
                                <tr class="hover:bg-background-light dark:hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">{{ $expense->date->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold truncate max-w-[200px]">{{ $expense->description }}</p>
                                        <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark truncate max-w-[200px]">{{ $expense->notes ?? 'No notes' }}</p>
                                        @if($expense->is_deductible)
                                        <span class="inline-flex items-center gap-1 mt-1 text-[10px] bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 px-1.5 py-0.5 rounded">
                                            <span class="material-symbols-outlined text-[10px]">verified</span> Tax Deductible
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="size-6 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs">
                                                <span class="material-symbols-outlined text-[14px]">
                                                    {{ match(strtolower($expense->category->name ?? 'other')) {
                                                        'housing' => 'home',
                                                        'transport' => 'directions_car',
                                                        'utilities' => 'bolt',
                                                        'food & dining' => 'restaurant',
                                                        'entertainment' => 'confirmation_number',
                                                        'lifestyle' => 'fitness_center',
                                                        'equipment' => 'computer',
                                                        'professional services' => 'work',
                                                        default => 'category'
                                                    } }}
                                                </span>
                                            </div>
                                            <span>{{ $expense->category->name ?? 'Uncategorized' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm border border-border-light dark:border-border-dark px-2 py-1 rounded text-text-muted">
                                            {{ $expense->paymentMethod->name ?? 'Other' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($expense->attachment_path)
                                        <a href="{{ Storage::url($expense->attachment_path) }}" target="_blank" class="text-primary hover:underline text-xs flex items-center justify-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">visibility</span> View
                                        </a>
                                        @elseif($expense->receipt_url)
                                         <a href="{{ Storage::url($expense->receipt_url) }}" target="_blank" class="text-primary hover:underline text-xs flex items-center justify-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">visibility</span> View
                                        </a>
                                        @else
                                        <span class="text-text-muted dark:text-gray-600 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold font-mono text-text-main dark:text-white">
                                        {{ number_format($expense->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('expenses.edit', $expense->id) }}" class="p-1 rounded text-text-muted hover:bg-gray-100 dark:hover:bg-white/10 transition-colors" title="Edit">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                            </a>
                                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 rounded text-text-muted hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Delete">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-text-secondary-light dark:text-text-secondary-dark">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="size-16 rounded-full bg-background-light dark:bg-white/5 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-3xl text-text-muted">receipt_long</span>
                                            </div>
                                            <p class="text-base font-medium">No expenses found</p>
                                            <p class="text-sm max-w-md mx-auto">Start tracking your tax-deductible expenses by adding a new record.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $expenses->links() }}
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
