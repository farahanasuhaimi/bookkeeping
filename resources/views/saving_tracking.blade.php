@extends('layouts.main')

@section('dashboard-content')
<div class="px-6 py-12 max-w-6xl mx-auto">
    <!-- Page Heading -->
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h2 class="text-4xl font-black text-text-main dark:text-white mb-2 italic tracking-tight">Savings & Goals</h2>
            <p class="text-text-muted dark:text-gray-400 max-w-xl">Track your EPF, Zakat, and personal savings progress for smarter tax optimization and financial freedom.</p>
        </div>
        <button onclick="document.getElementById('addGoalModal').classList.remove('hidden')" 
            class="bg-primary hover:bg-primary/90 text-text-main font-black px-6 py-3 rounded-2xl shadow-lg shadow-primary/20 transition-all hover:scale-[1.02] italic flex items-center gap-2">
            <span class="material-symbols-outlined font-bold">add_circle</span>
            NEW GOAL
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Total accumulated -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-[2.5rem] p-8 border border-border-light dark:border-border-dark shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-8xl text-primary">account_balance_wallet</span>
            </div>
            <p class="text-xs font-black uppercase tracking-widest text-text-muted mb-4 italic">Total Combined Savings</p>
            <div class="flex items-baseline gap-1">
                <span class="text-sm font-bold text-text-muted">RM</span>
                <p class="text-4xl font-black text-text-main dark:text-white">{{ number_format($taxSavingsTotal + $totalGoalSavings, 2) }}</p>
            </div>
            <p class="text-[10px] text-primary font-bold mt-4 uppercase tracking-tighter">Financial Safety Net</p>
        </div>

        <!-- YTD EPF -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-[2.5rem] p-8 border border-border-light dark:border-border-dark shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-8xl text-blue-500">work_history</span>
            </div>
            <p class="text-xs font-black uppercase tracking-widest text-text-muted mb-4 italic">YTD EPF (KWSP)</p>
            <div class="flex items-baseline gap-1">
                <span class="text-sm font-bold text-text-muted">RM</span>
                <p class="text-4xl font-black text-text-main dark:text-white">{{ number_format($ytdEpf, 2) }}</p>
            </div>
            <p class="text-[10px] text-blue-500 font-bold mt-4 uppercase tracking-tighter">Tax Relief Eligible</p>
        </div>

        <!-- YTD Zakat -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-[2.5rem] p-8 border border-border-light dark:border-border-dark shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-8xl text-amber-500">volunteer_activism</span>
            </div>
            <p class="text-xs font-black uppercase tracking-widest text-text-muted mb-4 italic">YTD Zakat Total</p>
            <div class="flex items-baseline gap-1">
                <span class="text-sm font-bold text-text-muted">RM</span>
                <p class="text-4xl font-black text-text-main dark:text-white">{{ number_format($ytdZakat, 2) }}</p>
            </div>
            <p class="text-[10px] text-amber-500 font-bold mt-4 uppercase tracking-tighter">100% Tax Rebate</p>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid lg:grid-cols-2 gap-10">
        <!-- Tax Relief Progress Section -->
        <div>
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-primary font-bold">verified_user</span>
                <h3 class="text-xl font-black text-text-main dark:text-white italic">Tax Relief Progress</h3>
            </div>
            
            <div class="space-y-8 bg-surface-light dark:bg-surface-dark rounded-[2rem] p-8 border border-border-light dark:border-border-dark shadow-sm">
                <!-- Life Insurance / EPF -->
                @php
                    $limitLifeEpf = 7000;
                    $totalLifeEpf = $ytdEpf + $ytdLifeIns;
                    $percentLifeEpf = min(($totalLifeEpf / $limitLifeEpf) * 100, 100);
                @endphp
                <div>
                    <div class="flex justify-between items-end mb-3">
                        <div>
                            <p class="text-sm font-bold text-text-main dark:text-white">Life Insurance & EPF</p>
                            <p class="text-[10px] text-text-muted uppercase tracking-widest">Limit: RM {{ number_format($limitLifeEpf) }}</p>
                        </div>
                        <span class="text-sm font-black text-text-main dark:text-white italic">RM {{ number_format($totalLifeEpf) }}</span>
                    </div>
                    <div class="h-4 w-full bg-background-light dark:bg-background-dark rounded-full overflow-hidden p-1 shadow-inner border border-border-light dark:border-border-dark">
                        <div class="h-full bg-primary rounded-full transition-all duration-1000" style="width: {{ $percentLifeEpf }}%"></div>
                    </div>
                </div>

                <!-- SSPN -->
                @php
                    $limitSSPN = 8000; 
                    $percentSSPN = min(($ytdSspn / $limitSSPN) * 100, 100);
                @endphp
                <div>
                    <div class="flex justify-between items-end mb-3">
                        <div>
                            <p class="text-sm font-bold text-text-main dark:text-white">SSPN Savings</p>
                            <p class="text-[10px] text-text-muted uppercase tracking-widest">Limit: RM {{ number_format($limitSSPN) }}</p>
                        </div>
                        <span class="text-sm font-black text-text-main dark:text-white italic">RM {{ number_format($ytdSspn) }}</span>
                    </div>
                    <div class="h-4 w-full bg-background-light dark:bg-background-dark rounded-full overflow-hidden p-1 shadow-inner border border-border-light dark:border-border-dark">
                        <div class="h-full bg-amber-400 rounded-full transition-all duration-1000" style="width: {{ $percentSSPN }}%"></div>
                    </div>
                </div>

                <div class="p-5 bg-primary/5 dark:bg-primary/10 rounded-2xl border border-primary/20 flex items-start gap-3 mt-4">
                    <span class="material-symbols-outlined text-primary text-xl">lightbulb</span>
                    <div>
                        <p class="text-xs font-bold text-text-main dark:text-white">Optimization Tip</p>
                        <p class="text-[11px] text-text-muted mt-1 leading-relaxed">You've utilized {{ number_format($percentSSPN, 1) }}% of your SSPN relief. Adding RM {{ number_format(max(0, $limitSSPN - $ytdSspn)) }} more will maximize your tax savings for YA {{ date('Y') }}.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Goals Section -->
        <div>
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-primary font-bold">flag</span>
                <h3 class="text-xl font-black text-text-main dark:text-white italic">Financial Goals</h3>
            </div>

            <div class="space-y-4">
                @forelse($goals as $goal)
                    @php
                        $percentGoal = min(($goal->current_amount / $goal->target_amount) * 100, 100);
                        $isCompleted = $goal->status === 'completed' || $percentGoal >= 100;
                    @endphp
                    <div class="group bg-surface-light dark:bg-surface-dark rounded-3xl p-6 border border-border-light dark:border-border-dark shadow-sm hover:border-primary/50 transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-bold text-text-main dark:text-white">{{ $goal->name }}</h4>
                                <p class="text-xs text-text-muted">Targeted RM {{ number_format($goal->target_amount, 2) }} {{ $goal->due_date ? '• Due ' . $goal->due_date->format('M Y') : '' }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('savings-goals.update', $goal->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="current_amount" value="{{ (float)$goal->current_amount }}" step="0.01" 
                                        class="w-24 text-xs font-bold px-3 py-1.5 rounded-lg border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-text-main dark:text-white focus:ring-1 focus:ring-primary outline-none">
                                    <input type="hidden" name="status" value="{{ $goal->status }}">
                                    <button type="submit" class="text-primary hover:scale-110 transition-transform" title="Update Balance">
                                        <span class="material-symbols-outlined text-lg">check_circle</span>
                                    </button>
                                </form>
                                <form action="{{ route('savings-goals.destroy', $goal->id) }}" method="POST" onsubmit="return confirm('Delete this goal?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-text-muted hover:text-red-500 transition-colors">
                                        <span class="material-symbols-outlined text-lg font-bold">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="h-3 w-full bg-background-light dark:bg-background-dark rounded-full overflow-hidden flex shadow-inner">
                            <div class="h-full {{ $isCompleted ? 'bg-green-500' : 'bg-primary' }} rounded-full transition-all duration-700" style="width: {{ $percentGoal }}%"></div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-[10px] font-black uppercase tracking-widest text-text-muted">{{ number_format($percentGoal, 0) }}% Achieved</span>
                            <span class="text-[10px] font-black uppercase tracking-widest {{ $isCompleted ? 'text-green-500' : 'text-primary' }}">{{ $isCompleted ? 'GOAL MET!' : 'IN PROGRESS' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-background-light/50 dark:bg-background-dark/50 rounded-3xl border-2 border-dashed border-border-light dark:border-border-dark">
                        <span class="material-symbols-outlined text-4xl text-text-muted mb-2">savings</span>
                        <p class="text-sm text-text-muted italic">No savings goals yet. Start by creating one!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Contributions Table -->
    <div class="mt-12 bg-surface-light dark:bg-surface-dark rounded-[2rem] border border-border-light dark:border-border-dark shadow-sm overflow-hidden">
        <div class="p-8 border-b border-border-light dark:border-border-dark">
            <h3 class="text-xl font-black text-text-main dark:text-white italic flex items-center gap-3">
                <span class="material-symbols-outlined text-primary font-bold">history</span>
                Recent Relief Contributions
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-background-light/50 dark:bg-background-dark/50 border-b border-border-light dark:border-border-dark">
                    <tr>
                        <th class="px-8 py-4 text-xs font-black uppercase tracking-widest text-text-muted">Date</th>
                        <th class="px-8 py-4 text-xs font-black uppercase tracking-widest text-text-muted">Type</th>
                        <th class="px-8 py-4 text-xs font-black uppercase tracking-widest text-text-muted">Description</th>
                        <th class="px-8 py-4 text-xs font-black uppercase tracking-widest text-text-muted text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @forelse($contributions as $contribution)
                    <tr class="hover:bg-background-light/30 dark:hover:bg-white/5 transition-colors">
                        <td class="px-8 py-5 text-sm font-medium text-text-main dark:text-white whitespace-nowrap">{{ $contribution->date->format('d M Y') }}</td>
                        <td class="px-8 py-5 text-sm font-bold text-text-main dark:text-white uppercase tracking-tighter">{{ $contribution->category->name }}</td>
                        <td class="px-8 py-5 text-sm text-text-muted italic">{{ $contribution->description }}</td>
                        <td class="px-8 py-5 text-sm font-black text-text-main dark:text-white text-right font-mono">+ RM {{ number_format($contribution->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center text-text-muted italic">No recent contributions recorded.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Goal Modal -->
<div id="addGoalModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('addGoalModal').classList.add('hidden')"></div>
        <div class="relative transform overflow-hidden rounded-[2.5rem] bg-surface-light dark:bg-surface-dark text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-border-light dark:border-border-dark">
            <form action="{{ route('savings-goals.store') }}" method="POST" class="p-8">
                @csrf
                <div class="mb-8 flex items-center justify-between">
                    <h3 class="text-2xl font-black text-text-main dark:text-white italic">New Goal</h3>
                    <button type="button" onclick="document.getElementById('addGoalModal').classList.add('hidden')" class="text-text-muted hover:text-text-main dark:hover:text-white transition-colors">
                        <span class="material-symbols-outlined font-bold">close</span>
                    </button>
                </div>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">Goal Name</label>
                        <input type="text" name="name" placeholder="e.g. Dream House, Emergency Fund" required 
                            class="w-full rounded-2xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark px-5 py-3 text-sm text-text-main dark:text-white focus:border-primary focus:ring-primary outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">Target (RM)</label>
                            <input type="number" name="target_amount" placeholder="5000" required step="0.01" 
                                class="w-full rounded-2xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark px-5 py-3 text-sm text-text-main dark:text-white focus:border-primary focus:ring-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">Starting (RM)</label>
                            <input type="number" name="current_amount" value="0" step="0.01" 
                                class="w-full rounded-2xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark px-5 py-3 text-sm text-text-main dark:text-white focus:border-primary focus:ring-primary outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">Target Date (Optional)</label>
                        <input type="date" name="due_date" 
                            class="w-full rounded-2xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark px-5 py-3 text-sm text-text-main dark:text-white focus:border-primary focus:ring-primary outline-none">
                    </div>
                </div>

                <div class="mt-10 flex flex-col gap-3">
                    <button type="submit" class="w-full rounded-2xl bg-primary px-6 py-4 text-sm font-black text-text-main shadow-lg shadow-primary/20 hover:opacity-90 transition-all hover:scale-[1.02] italic">
                        CREATE SAVINGS GOAL
                    </button>
                    <button type="button" onclick="document.getElementById('addGoalModal').classList.add('hidden')" 
                        class="w-full rounded-2xl px-6 py-4 text-sm font-black text-text-muted hover:bg-background-light dark:hover:bg-white/5 transition-all italic uppercase tracking-widest">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
