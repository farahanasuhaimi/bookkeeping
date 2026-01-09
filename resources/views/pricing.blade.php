@extends('layouts.main')

@section('dashboard-content')
<div class="px-6 py-12 max-w-6xl mx-auto">
    <div class="text-center mb-16">
        <h2 class="text-4xl font-black text-text-main dark:text-white mb-4 tracking-tight">Simple, Transparent Pricing</h2>
        <p class="text-text-muted dark:text-gray-400 text-lg max-w-2xl mx-auto">
            Choose the best plan for your tax management needs. Unlock advanced features and maximize your savings today.
        </p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <!-- Monthly Plan -->
        <div class="relative bg-surface-light dark:bg-surface-dark rounded-3xl p-8 border border-border-light dark:border-border-dark shadow-sm hover:shadow-xl transition-shadow duration-300">
            <div class="mb-8">
                <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">Pro Monthly</h3>
                <div class="flex items-baseline gap-1">
                    <span class="text-4xl font-black text-text-main dark:text-white">RM 15</span>
                    <span class="text-text-muted">/ month</span>
                </div>
                <p class="text-sm text-text-muted mt-2">Flexibility to pay as you go.</p>
            </div>

            <ul class="space-y-4 mb-8">
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <span class="text-sm font-medium text-text-main dark:text-gray-300">Unlimited File Uploads</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <span class="text-sm font-medium text-text-main dark:text-gray-300">Professional PDF Reports</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <span class="text-sm font-medium text-text-main dark:text-gray-300">Advanced Tax Projections</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <span class="text-sm font-medium text-text-main dark:text-gray-300">Priority Support</span>
                </li>
            </ul>

            <button class="w-full bg-primary hover:bg-primary/90 text-text-main font-black py-4 rounded-2xl transition-all hover:scale-[1.02]">
                UPGRADE MONTHLY
            </button>
        </div>

        <!-- Yearly Plan -->
        <div class="relative bg-surface-light dark:bg-surface-dark rounded-3xl p-8 border-2 border-primary shadow-2xl scale-105">
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-primary text-text-main text-[10px] font-black px-4 py-1.5 rounded-full tracking-widest uppercase">
                Best Value (Save RM 30)
            </div>
            
            <div class="mb-8">
                <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">Pro Yearly</h3>
                <div class="flex items-baseline gap-1">
                    <span class="text-4xl font-black text-text-main dark:text-white">RM 150</span>
                    <span class="text-text-muted">/ year</span>
                </div>
                <p class="text-sm text-text-muted mt-2">Effective RM 12.50 / month.</p>
            </div>

            <ul class="space-y-4 mb-8">
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">stars</span>
                    <span class="text-sm font-bold text-text-main dark:text-gray-300">Everything in Monthly</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <span class="text-sm font-medium text-text-main dark:text-gray-300">Historical Year Comparisons</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <span class="text-sm font-medium text-text-main dark:text-gray-300">Exclusive Forecasting Tools</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <span class="text-sm font-medium text-text-main dark:text-gray-300">Early Access to New Features</span>
                </li>
            </ul>

            <button class="w-full bg-primary hover:bg-primary/90 text-text-main font-black py-4 rounded-2xl transition-all hover:scale-[1.02] shadow-xl shadow-primary/20">
                UPGRADE YEARLY
            </button>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="mt-24 max-w-3xl mx-auto">
        <h3 class="text-2xl font-black text-text-main dark:text-white mb-8 text-center italic">Frequently Asked Questions</h3>
        <div class="space-y-6">
            <div class="p-6 bg-surface-light dark:bg-surface-dark rounded-2xl border border-border-light dark:border-border-dark">
                <h4 class="font-bold text-text-main dark:text-white mb-2 italic">Can I cancel anytime?</h4>
                <p class="text-sm text-text-muted dark:text-gray-400">Yes, you can cancel your subscription at any time. Your Pro features will remain active until the end of your current billing period.</p>
            </div>
            <div class="p-6 bg-surface-light dark:bg-surface-dark rounded-2xl border border-border-light dark:border-border-dark">
                <h4 class="font-bold text-text-main dark:text-white mb-2 italic">Is my data secure?</h4>
                <p class="text-sm text-text-muted dark:text-gray-400">Absolutely. We use industry-standard encryption and secure payment processing via CHIP.io to ensure your financial data is protected.</p>
            </div>
        </div>
    </div>
</div>
@endsection
