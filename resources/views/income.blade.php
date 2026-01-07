@extends('layouts.dashboard')

@section('dashboard-content')
<div class="flex h-screen w-full overflow-hidden">
    <!-- Main Content -->
    <div class="flex flex-col flex-1 h-full overflow-hidden bg-background-light dark:bg-background-dark relative">
        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-y-auto no-scrollbar p-4 md:p-8 lg:px-12 xl:px-24">
            <div class="max-w-7xl mx-auto flex flex-col gap-6">
                <!-- PageHeading -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex flex-col gap-2">
                        <h1 class="text-text-primary-light dark:text-text-primary-dark text-3xl md:text-4xl font-black tracking-tight">Income Records</h1>
                        <p class="text-text-secondary-light dark:text-text-secondary-dark text-base">Track all your earnings and income sources.</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('income.create') }}" class="px-6 py-2 rounded-lg bg-primary text-[#064e2a] font-bold shadow-lg shadow-primary/20 hover:bg-primary-dark hover:text-white transition-all transform hover:-translate-y-0.5">Add New Income</a>
                    </div>
                </div>

                <!-- Income Table -->
                <div class="bg-card-light dark:bg-card-dark rounded-2xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden">
                    <table class="min-w-full divide-y divide-border-light dark:divide-border-dark">
                        <thead class="bg-background-light dark:bg-background-dark">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-secondary-light dark:text-text-secondary-dark uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-secondary-light dark:text-text-secondary-dark uppercase tracking-wider">Description</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-text-secondary-light dark:text-text-secondary-dark uppercase tracking-wider">Amount (MYR)</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-light dark:divide-border-dark">
                            @forelse ($incomes as $income)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-text-primary-light dark:text-text-primary-dark">{{ $income->date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-text-primary-light dark:text-text-primary-dark">{{ $income->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-green-600 dark:text-green-400">
                                        {{ number_format($income->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('income.destroy', $income->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-400">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-center text-text-secondary-light dark:text-text-secondary-dark">No income records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-background-light dark:bg-background-dark">
                            <tr>
                                <th colspan="2" scope="row" class="px-6 py-3 text-right text-sm font-semibold text-text-primary-light dark:text-text-primary-dark">Total Income</th>
                                <td class="px-6 py-3 text-right text-sm font-bold text-text-primary-light dark:text-text-primary-dark">
                                    {{ number_format($incomes->sum('amount'), 2) }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                 <!-- Pagination -->
                <div class="mt-4">
                    {{ $incomes->links() }}
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
