@extends('layouts.main')

@section('dashboard-content')
<div class="px-6 py-12 max-w-5xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-text-main dark:text-white mb-2 italic">Settings</h2>
        <p class="text-text-muted dark:text-gray-400">Manage your payment methods and wallets.</p>
    </div>

    @include('settings.nav')

    <!-- Quick Add Section -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-3xl p-6 border border-border-light dark:border-border-dark shadow-sm mb-8">
        <h3 class="text-sm font-black text-text-main dark:text-white mb-4 uppercase tracking-widest italic flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-sm">add_circle</span>
            Add New Payment Method
        </h3>
        <form action="{{ route('settings.payment-methods.store') }}" method="POST" class="flex flex-wrap gap-4 items-end">
            @csrf
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] font-black uppercase tracking-widest text-text-muted mb-1">Method Name</label>
                <input type="text" name="name" placeholder="e.g. Maybank, GrabPay" required
                    class="w-full rounded-xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-sm px-4 py-2.5 focus:border-primary focus:ring-primary">
            </div>
            <div class="w-40">
                <label class="block text-[10px] font-black uppercase tracking-widest text-text-muted mb-1">Type</label>
                <select name="type" class="w-full rounded-xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-sm px-4 py-2.5 focus:border-primary focus:ring-primary">
                    <option value="Bank">Bank</option>
                    <option value="E-Wallet">E-Wallet</option>
                    <option value="Cash">Cash</option>
                    <option value="Credit Card">Credit Card</option>
                </select>
            </div>
            <button type="submit" class="bg-primary hover:bg-primary/90 text-text-main font-black px-6 py-2.5 rounded-xl transition-all hover:scale-[1.02] text-xs italic">
                ADD METHOD
            </button>
        </form>
    </div>

    <div class="bg-surface-light dark:bg-surface-dark rounded-3xl border border-border-light dark:border-border-dark shadow-sm overflow-hidden text-sm">
        <div class="p-6 border-b border-border-light dark:border-border-dark">
            <h3 class="text-lg font-bold text-text-main dark:text-white italic">Your Payment Methods</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-background-light/50 dark:bg-background-dark/50 border-b border-border-light dark:border-border-dark">
                    <tr>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-text-muted">Name</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-text-muted">Type</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-text-muted text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                    @forelse($paymentMethods as $method)
                    <tr class="hover:bg-background-light/30 dark:hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-text-main dark:text-white">{{ $method->name }}</span>
                            @if(!$method->user_id) <span class="ml-2 text-[9px] font-black text-text-muted italic uppercase">(Default)</span> @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-[10px] font-black uppercase tracking-wider bg-primary/10 text-primary">{{ $method->type ?? 'Other' }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($method->user_id)
                            <form action="{{ route('settings.payment-methods.destroy', $method->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this payment method?')" class="text-text-muted hover:text-red-500 transition-colors">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </form>
                            @else
                            <span class="text-text-muted italic text-[10px]">Read-only</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-text-muted italic">No payment methods found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
