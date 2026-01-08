@extends('layouts.main')

@section('dashboard-content')
<div class="container mx-auto max-w-[1200px] px-4 py-8 md:px-8">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-text-main dark:text-white sm:text-4xl">User Directory</h2>
            <p class="mt-1 text-base text-text-muted dark:text-gray-400">Manage user accounts and subscription tiers.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-primary hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Admin
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-background-light dark:bg-white/5 text-xs uppercase text-text-muted dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 font-semibold">User</th>
                    <th class="px-6 py-3 font-semibold">Email</th>
                    <th class="px-6 py-3 font-semibold text-center">Status</th>
                    <th class="px-6 py-3 font-semibold text-center">Plan</th>
                    <th class="px-6 py-3 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-light dark:divide-border-dark">
                @foreach($users as $user)
                    <tr class="group hover:bg-background-light dark:hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center text-white font-bold text-xs">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-text-main dark:text-white">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-text-muted dark:text-gray-400">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($user->is_admin)
                                <span class="inline-flex items-center rounded-md bg-purple-50 dark:bg-purple-900/30 px-2 py-1 text-xs font-medium text-purple-700 dark:text-purple-400 ring-1 ring-inset ring-purple-600/20">Admin</span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center rounded-md {{ $user->plan == 'pro' ? 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 ring-amber-600/20' : 'bg-gray-50 dark:bg-white/10 text-gray-600 dark:text-gray-400 ring-gray-600/20' }} px-2 py-1 text-xs font-bold ring-1 ring-inset uppercase">
                                {{ $user->plan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.users.update-plan', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="plan" onchange="this.form.submit()" class="text-xs bg-transparent border border-border-light dark:border-border-dark rounded px-2 py-1 cursor-pointer">
                                    <option value="free" {{ $user->plan == 'free' ? 'selected' : '' }}>Switch to Free</option>
                                    <option value="pro" {{ $user->plan == 'pro' ? 'selected' : '' }}>Switch to Pro</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-border-light dark:border-border-dark">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
