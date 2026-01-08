@extends('layouts.app')

@section('title', 'Savings Tracking - MyTaxBook')

@section('content')
<!-- Tailwind Config for this page's custom colors -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#13ec80",
                    "background-light": "#f6f8f7",
                    "background-dark": "#102219",
                    "card-light": "#ffffff",
                    "card-dark": "#1c2e24",
                    "text-main": "#111814",
                    "text-muted": "#618975",
                },
                fontFamily: {
                    "display": ["Inter", "sans-serif"]
                },
                borderRadius: {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
                },
            },
        },
    }
</script>
<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    /* Custom scrollbar for better aesthetic */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<div class="relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden bg-background-light dark:bg-background-dark">
    <!-- Navbar (Reuse Dashboard layout or simplified) -->
    @include('layouts.app')

    <!-- Main Content -->
    <div class="layout-container flex h-full grow flex-col">
        <div class="px-4 md:px-10 lg:px-40 flex flex-1 justify-center py-8">
            <div class="layout-content-container flex flex-col max-w-[1200px] flex-1 w-full gap-8">
                <!-- Page Heading -->
                <div class="flex flex-wrap justify-between items-end gap-4 p-4 -mx-4">
                    <div class="flex min-w-72 flex-col gap-2">
                        <div class="flex items-center gap-2 mb-2">
                             <a href="{{ route('dashboard') }}" class="text-text-muted hover:text-primary transition-colors flex items-center gap-1 text-sm">
                                <span class="material-symbols-outlined text-[16px]">arrow_back</span> Back
                             </a>
                        </div>
                        <h1 class="text-[#111814] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Savings Overview</h1>
                        <p class="text-[#618975] dark:text-gray-400 text-base font-normal leading-normal">Track your EPF, Zakat, and personal savings progress for tax optimization.</p>
                    </div>
                </div>
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Savings -->
                    <div class="flex flex-col gap-4 rounded-xl p-6 bg-white dark:bg-card-dark border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <span class="material-symbols-outlined text-6xl text-primary">account_balance</span>
                        </div>
                        <div class="flex justify-between items-start z-10">
                            <p class="text-[#618975] dark:text-gray-400 text-sm font-bold uppercase tracking-wider">Total Accumulated</p>
                        </div>
                        <div class="z-10">
                            <p class="text-[#111814] dark:text-white text-3xl font-bold leading-tight">RM {{ number_format($taxSavingsTotal + $totalGoalSavings, 2) }}</p>
                            <div class="flex items-center gap-1 mt-2">
                                <span class="text-sm text-[#618975] dark:text-gray-500">Combined Financial Safety Net</span>
                            </div>
                        </div>
                    </div>
                    <!-- EPF Contributions -->
                    <div class="flex flex-col gap-4 rounded-xl p-6 bg-white dark:bg-card-dark border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <span class="material-symbols-outlined text-6xl text-blue-500">work_history</span>
                        </div>
                        <div class="flex justify-between items-start z-10">
                            <p class="text-[#618975] dark:text-gray-400 text-sm font-bold uppercase tracking-wider">YTD EPF (KWSP)</p>
                        </div>
                        <div class="z-10">
                            <p class="text-[#111814] dark:text-white text-3xl font-bold leading-tight">RM {{ number_format($ytdEpf, 2) }}</p>
                            <div class="flex items-center gap-1 mt-2">
                                <span class="bg-[#e6fdec] text-[#07882c] text-xs font-bold px-2 py-1 rounded-full flex items-center">
                                    <span class="material-symbols-outlined text-[14px] mr-1">trending_up</span>
                                    {{ date('Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Zakat -->
                    <div class="flex flex-col gap-4 rounded-xl p-6 bg-white dark:bg-card-dark border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <span class="material-symbols-outlined text-6xl text-purple-500">volunteer_activism</span>
                        </div>
                        <div class="flex justify-between items-start z-10">
                            <p class="text-[#618975] dark:text-gray-400 text-sm font-bold uppercase tracking-wider">YTD Zakat Paid</p>
                        </div>
                        <div class="z-10">
                            <p class="text-[#111814] dark:text-white text-3xl font-bold leading-tight">RM {{ number_format($ytdZakat, 2) }}</p>
                            <div class="flex items-center gap-1 mt-2">
                                <span class="bg-[#e6fdec] text-[#07882c] text-xs font-bold px-2 py-1 rounded-full flex items-center">
                                    <span class="material-symbols-outlined text-[14px] mr-1">check_circle</span>
                                    Tax Rebate
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Breakdown Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Tax Relief & Goals Card -->
                    <div class="bg-white dark:bg-card-dark rounded-xl border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-[#111814] dark:text-white text-lg font-bold">Tax Relief Tracker (YA {{ date('Y') }})</h3>
                            <a href="{{ route('tax-summary') }}" class="text-primary text-sm font-semibold hover:underline">Full Report</a>
                        </div>
                        <div class="flex flex-col gap-6">
                            <!-- Life Insurance / EPF -->
                            @php
                                $limitLifeEpf = 7000; // Combined limit example, or 4000+3000
                                $totalLifeEpf = $ytdEpf + $ytdLifeIns;
                                $widthLifeEpf = min(($totalLifeEpf / $limitLifeEpf) * 100, 100);
                            @endphp
                            <div class="relative">
                                <div class="flex justify-between items-end mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-text-muted">shield</span>
                                        <span class="text-sm font-medium text-text-main dark:text-white">Life Insurance & EPF</span>
                                    </div>
                                    <span class="text-sm font-bold text-text-main dark:text-white">RM {{ number_format($totalLifeEpf) }} / RM {{ number_format($limitLifeEpf) }}</span>
                                </div>
                                <div class="h-3 w-full bg-[#f0f4f2] dark:bg-[#333] rounded-full overflow-hidden">
                                    <div class="h-full bg-primary rounded-full" style="width: {{ $widthLifeEpf }}%"></div>
                                </div>
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-text-muted">{{ number_format($widthLifeEpf, 1) }}% Utilized</span>
                                </div>
                            </div>
                            
                            <!-- SSPN -->
                            @php
                                $limitSSPN = 8000; 
                                $widthSSPN = min(($ytdSspn / $limitSSPN) * 100, 100);
                            @endphp
                            <div class="relative">
                                <div class="flex justify-between items-end mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-text-muted">school</span>
                                        <span class="text-sm font-medium text-text-main dark:text-white">SSPN Savings</span>
                                    </div>
                                    <span class="text-sm font-bold text-text-main dark:text-white">RM {{ number_format($ytdSspn) }} / RM {{ number_format($limitSSPN) }}</span>
                                </div>
                                <div class="h-3 w-full bg-[#f0f4f2] dark:bg-[#333] rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $widthSSPN }}%"></div>
                                </div>
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-text-muted">{{ number_format($widthSSPN, 1) }}% Utilized</span>
                                </div>
                            </div>
                        </div>
                        
                        </div>
                        
                        <!-- Personal Goals (New) -->
                        <div class="mt-8 flex flex-col gap-4">
                            <div class="flex justify-between items-center">
                                <h3 class="text-[#111814] dark:text-white text-lg font-bold">Personal Savings Goals</h3>
                                <button onclick="document.getElementById('addGoalModal').classList.remove('hidden')" class="text-primary text-sm font-bold flex items-center gap-1 hover:bg-primary/10 px-2 py-1 rounded transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">add</span> New Goal
                                </button>
                            </div>

                            <div class="flex flex-col gap-4">
                                @forelse($goals as $goal)
                                    @php
                                        $widthGoal = min(($goal->current_amount / $goal->target_amount) * 100, 100);
                                    @endphp
                                    <div class="group relative rounded-xl border border-border-light dark:border-border-dark p-4 hover:border-primary/50 transition-all">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="text-sm font-bold text-text-main dark:text-white">{{ $goal->name }}</p>
                                                <p class="text-[10px] text-text-muted mt-0.5">Target: RM {{ number_format($goal->target_amount) }} {{ $goal->due_date ? '• Due ' . $goal->due_date->format('M Y') : '' }}</p>
                                            </div>
                                            <div class="flex gap-2">
                                                <form action="{{ route('savings-goals.update', $goal->id) }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="current_amount" value="{{ (int)$goal->current_amount }}" step="0.01" class="w-20 text-xs px-2 py-1 rounded border border-border-light dark:bg-card-dark dark:border-border-dark text-text-main dark:text-white focus:ring-1 focus:ring-primary outline-none">
                                                    <input type="hidden" name="status" value="{{ $goal->status }}">
                                                    <button type="submit" class="text-primary opacity-0 group-hover:opacity-100 transition-opacity" title="Save Progress">
                                                        <span class="material-symbols-outlined text-[18px]">save</span>
                                                    </button>
                                                </form>
                                                <form action="{{ route('savings-goals.destroy', $goal->id) }}" method="POST" onsubmit="return confirm('Delete this goal?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 opacity-0 group-hover:opacity-100 transition-opacity" title="Delete">
                                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="h-2 w-full bg-[#f0f4f2] dark:bg-[#333] rounded-full overflow-hidden">
                                            <div class="h-full {{ $goal->status == 'completed' ? 'bg-green-500' : 'bg-primary' }} rounded-full" style="width: {{ $widthGoal }}%"></div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 border-2 border-dashed border-border-light dark:border-border-dark rounded-xl">
                                        <p class="text-xs text-text-muted">No specific goals set yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Promo/Alert -->
                        <div class="mt-6 p-4 bg-primary/5 dark:bg-primary/10 rounded-xl border border-primary/20 flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary mt-0.5">tips_and_updates</span>
                            <div>
                                <p class="text-sm font-bold text-text-main dark:text-white">Tax Optimization Tip</p>
                                <p class="text-xs text-text-muted leading-relaxed">Consider shifting RM 250/month to your SSPN goal to max out the RM 8,000 annual relief.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Transactions Section -->
                    <div class="bg-white dark:bg-card-dark rounded-xl border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm p-6 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-[#111814] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Recent Contributions</h2>
                        </div>
                        <div class="overflow-hidden rounded-xl border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm bg-white dark:bg-card-dark">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-background-light dark:bg-[#23332a] text-[#111814] dark:text-white border-b border-[#e5e7eb] dark:border-[#2a3c32]">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Date</th>
                                        <th class="px-6 py-4 font-semibold">Type</th>
                                        <th class="px-6 py-4 font-semibold text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#e5e7eb] dark:divide-[#2a3c32]">
                                    @forelse($contributions as $contribution)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-[#23332a] transition-colors">
                                        <td class="px-6 py-4 text-[#111814] dark:text-white whitespace-nowrap">{{ $contribution->date->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <span class="font-medium text-[#111814] dark:text-white">{{ $contribution->category->name }}</span>
                                            </div>
                                            <p class="text-xs text-text-muted truncate max-w-[150px]">{{ $contribution->description }}</p>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-[#111814] dark:text-white text-right font-mono">+ RM {{ number_format($contribution->amount, 2) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-text-muted">No recent contributions found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    <!-- Add Goal Modal -->
    <div id="addGoalModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-black/50 transition-opacity" aria-hidden="true" onclick="document.getElementById('addGoalModal').classList.add('hidden')"></div>
            <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-card-dark text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                <form action="{{ route('savings-goals.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-text-main dark:text-white">New Savings Goal</h3>
                        <button type="button" onclick="document.getElementById('addGoalModal').classList.add('hidden')" class="text-text-muted hover:text-text-main dark:text-gray-400 dark:hover:text-white">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    
                    <div class="flex flex-col gap-4">
                        <div>
                            <label class="block text-xs font-bold text-text-muted dark:text-gray-400 uppercase tracking-wider mb-1">Goal Name</label>
                            <input type="text" name="name" placeholder="e.g. Emergency Fund" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark px-4 py-2 text-sm text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-text-muted dark:text-gray-400 uppercase tracking-wider mb-1">Target (RM)</label>
                                <input type="number" name="target_amount" placeholder="5000" required step="0.01" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark px-4 py-2 text-sm text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-text-muted dark:text-gray-400 uppercase tracking-wider mb-1">Current (RM)</label>
                                <input type="number" name="current_amount" value="0" step="0.01" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark px-4 py-2 text-sm text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-text-muted dark:text-gray-400 uppercase tracking-wider mb-1">Target Date (Optional)</label>
                            <input type="date" name="due_date" class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark px-4 py-2 text-sm text-text-main dark:text-white focus:ring-2 focus:ring-primary outline-none">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('addGoalModal').classList.add('hidden')" class="rounded-lg px-4 py-2 text-sm font-bold text-text-muted hover:bg-gray-100 dark:hover:bg-white/5">Cancel</button>
                        <button type="submit" class="rounded-lg bg-primary px-6 py-2 text-sm font-black text-white shadow-lg shadow-primary/20 hover:opacity-90 transition-opacity">Create Goal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
