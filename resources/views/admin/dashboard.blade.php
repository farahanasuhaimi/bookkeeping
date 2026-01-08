@extends('layouts.main')

@section('dashboard-content')
<div class="container mx-auto max-w-[1200px] px-4 py-8 md:px-8">
    <div class="mb-8">
        <h2 class="text-3xl font-black tracking-tight text-text-main dark:text-white sm:text-4xl">Admin Control Center</h2>
        <p class="mt-1 text-base text-text-muted dark:text-gray-400">System-wide management and performance overview.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm">
            <p class="text-sm font-medium text-text-muted dark:text-gray-400">Total Users</p>
            <p class="text-2xl font-bold text-text-main dark:text-white">{{ number_format($stats['total_users']) }}</p>
        </div>
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm">
            <p class="text-sm font-medium text-text-muted dark:text-gray-400">Pro Subscriptions</p>
            <p class="text-2xl font-bold text-primary">{{ number_format($stats['pro_users']) }}</p>
        </div>
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm">
            <p class="text-sm font-medium text-text-muted dark:text-gray-400">Economic Volume (Inc)</p>
            <p class="text-2xl font-bold text-green-600">RM {{ number_format($stats['total_income'], 0) }}</p>
        </div>
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm">
            <p class="text-sm font-medium text-text-muted dark:text-gray-400">Economic Volume (Exp)</p>
            <p class="text-2xl font-bold text-red-500">RM {{ number_format($stats['total_expenses'], 0) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Quick Actions -->
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-6 shadow-sm">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4">Management Links</h3>
            <div class="flex flex-col gap-3">
                <a href="{{ route('admin.users') }}" class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-white/5 hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">group</span>
                        <span class="font-bold">User Directory</span>
                    </div>
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
                <a href="{{ route('admin.categories') }}" class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-white/5 hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">category</span>
                        <span class="font-bold">Global Categories</span>
                    </div>
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            </div>
        </div>

        <!-- System Status -->
        <div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-6 shadow-sm">
            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4">System Health</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-text-muted dark:text-gray-400">Platform Version</span>
                    <span class="font-mono bg-gray-100 dark:bg-white/10 px-2 py-0.5 rounded">vYA-2026.1.1</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-text-muted dark:text-gray-400">Security Middleware</span>
                    <span class="text-green-600 font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">verified</span> Active
                    </span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-text-muted dark:text-gray-400">Environment</span>
                    <span class="text-text-main dark:text-white">Production</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
