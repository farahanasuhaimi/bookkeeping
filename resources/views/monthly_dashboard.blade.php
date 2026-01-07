@extends('layouts.app')

@section('title', 'MyTaxBook Dashboard')

@section('content')
&lt;!-- Tailwind Config for this page's custom colors --&gt;
&lt;script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"&gt;&lt;/script&gt;
&lt;script id="tailwind-config"&gt;
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec80",
                        "background-light": "#f6f8f7",
                        "background-dark": "#102219",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1A2C23",
                        "text-main": "#111814",
                        "text-muted": "#618975",
                        "border-light": "#dbe6e0",
                        "border-dark": "#2A4034",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.375rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    &lt;/script&gt;

&lt;div class="flex h-screen w-full overflow-hidden"&gt;
&lt;!-- Side Navigation --&gt;
&lt;aside class="hidden w-64 flex-col border-r border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark lg:flex"&gt;
&lt;div class="flex h-16 items-center px-6"&gt;
&lt;div class="flex flex-col"&gt;
&lt;h1 class="text-text-main dark:text-white text-lg font-bold leading-normal tracking-tight"&gt;MyTaxBook&lt;/h1&gt;
&lt;p class="text-text-muted dark:text-gray-400 text-xs font-normal"&gt;Professional Plan&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="flex flex-1 flex-col gap-2 overflow-y-auto px-4 py-4"&gt;
&lt;nav class="flex flex-col gap-1"&gt;
&lt;a class="group flex items-center gap-3 rounded-lg bg-background-light dark:bg-white/5 px-3 py-2.5 text-text-main dark:text-white transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;"&gt;dashboard&lt;/span&gt;
&lt;span class="text-sm font-medium"&gt;Dashboard&lt;/span&gt;
&lt;/a&gt;
&lt;a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined"&gt;payments&lt;/span&gt;
&lt;span class="text-sm font-medium"&gt;Income&lt;/span&gt;
&lt;/a&gt;
&lt;a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined"&gt;receipt_long&lt;/span&gt;
&lt;span class="text-sm font-medium"&gt;Expenses&lt;/span&gt;
&lt;/a&gt;
&lt;a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined"&gt;description&lt;/span&gt;
&lt;span class="text-sm font-medium"&gt;Tax Filing&lt;/span&gt;
&lt;/a&gt;
&lt;a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-muted hover:bg-background-light hover:text-text-main dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined"&gt;settings&lt;/span&gt;
&lt;span class="text-sm font-medium"&gt;Settings&lt;/span&gt;
&lt;/a&gt;
&lt;/nav&gt;
&lt;/div&gt;
&lt;div class="p-4 border-t border-border-light dark:border-border-dark"&gt;
&lt;button class="flex w-full cursor-pointer items-center justify-center rounded-lg bg-primary py-2.5 text-[#111814] text-sm font-bold shadow-sm transition-transform hover:scale-[1.02] active:scale-[0.98]"&gt;
&lt;span class="material-symbols-outlined mr-2 text-[20px]"&gt;add_circle&lt;/span&gt;
&lt;span&gt;Add Transaction&lt;/span&gt;
&lt;/button&gt;
&lt;/div&gt;
&lt;/aside&gt;
&lt;!-- Main Content --&gt;
&lt;main class="flex-1 overflow-y-auto"&gt;
&lt;div class="container mx-auto max-w-[1200px] px-4 py-8 md:px-8"&gt;
&lt;!-- Page Header --&gt;
&lt;div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"&gt;
&lt;div&gt;
&lt;h2 class="text-3xl font-black tracking-tight text-text-main dark:text-white sm:text-4xl"&gt;October 2023 Overview&lt;/h2&gt;
&lt;p class="mt-1 text-base text-text-muted dark:text-gray-400"&gt;Monthly financial snapshot &amp;amp; tax readiness&lt;/p&gt;
&lt;/div&gt;
&lt;div class="flex items-center gap-3"&gt;
&lt;div class="relative"&gt;
&lt;button class="flex items-center gap-2 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark px-4 py-2 text-sm font-medium text-text-main dark:text-white shadow-sm hover:bg-gray-50 dark:hover:bg-white/5"&gt;
&lt;span class="material-symbols-outlined text-[20px]"&gt;calendar_month&lt;/span&gt;
&lt;span&gt;Oct 2023&lt;/span&gt;
&lt;span class="material-symbols-outlined text-[16px]"&gt;expand_more&lt;/span&gt;
&lt;/button&gt;
&lt;/div&gt;
&lt;button class="flex items-center gap-2 rounded-lg bg-text-main dark:bg-white px-4 py-2 text-sm font-bold text-white dark:text-text-main shadow-sm hover:opacity-90"&gt;
&lt;span class="material-symbols-outlined text-[20px]"&gt;download&lt;/span&gt;
&lt;span class="hidden sm:inline"&gt;Report&lt;/span&gt;
&lt;/button&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Stats Grid --&gt;
&lt;div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6"&gt;
&lt;!-- Income Card --&gt;
&lt;div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md"&gt;
&lt;div class="mb-2 flex items-center justify-between"&gt;
&lt;p class="text-sm font-medium text-text-muted dark:text-gray-400"&gt;Total Income&lt;/p&gt;
&lt;span class="material-symbols-outlined text-primary bg-primary/10 rounded-full p-1 text-[20px]"&gt;trending_up&lt;/span&gt;
&lt;/div&gt;
&lt;p class="text-2xl font-bold tracking-tight text-text-main dark:text-white"&gt;RM 12,500.00&lt;/p&gt;
&lt;div class="mt-2 flex items-center gap-2 text-xs"&gt;
&lt;span class="font-medium text-green-600 dark:text-green-400"&gt;+12%&lt;/span&gt;
&lt;span class="text-text-muted dark:text-gray-500"&gt;vs last month&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Expenses Card --&gt;
&lt;div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md"&gt;
&lt;div class="mb-2 flex items-center justify-between"&gt;
&lt;p class="text-sm font-medium text-text-muted dark:text-gray-400"&gt;Total Expenses&lt;/p&gt;
&lt;span class="material-symbols-outlined text-red-500 bg-red-500/10 rounded-full p-1 text-[20px]"&gt;trending_down&lt;/span&gt;
&lt;/div&gt;
&lt;p class="text-2xl font-bold tracking-tight text-text-main dark:text-white"&gt;RM 4,200.00&lt;/p&gt;
&lt;div class="mt-2 flex items-center gap-2 text-xs"&gt;
&lt;span class="inline-flex items-center gap-1 rounded-full bg-green-100 dark:bg-green-900/30 px-2 py-0.5 font-medium text-green-700 dark:text-green-400"&gt;
&lt;span class="material-symbols-outlined text-[14px]"&gt;verified&lt;/span&gt;
                                RM 1,200 Deductible
                            &lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Balance Card --&gt;
&lt;div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md"&gt;
&lt;div class="mb-2 flex items-center justify-between"&gt;
&lt;p class="text-sm font-medium text-text-muted dark:text-gray-400"&gt;Net Balance&lt;/p&gt;
&lt;span class="material-symbols-outlined text-text-main dark:text-white bg-gray-100 dark:bg-white/10 rounded-full p-1 text-[20px]"&gt;account_balance_wallet&lt;/span&gt;
&lt;/div&gt;
&lt;p class="text-2xl font-bold tracking-tight text-text-main dark:text-white"&gt;RM 8,300.00&lt;/p&gt;
&lt;div class="mt-2 flex items-center gap-2 text-xs"&gt;
&lt;span class="font-medium text-green-600 dark:text-green-400"&gt;+8%&lt;/span&gt;
&lt;span class="text-text-muted dark:text-gray-500"&gt;stable growth&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Savings Card --&gt;
&lt;div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-5 shadow-sm transition-all hover:shadow-md ring-1 ring-primary/20"&gt;
&lt;div class="mb-2 flex items-center justify-between"&gt;
&lt;p class="text-sm font-medium text-text-muted dark:text-gray-400"&gt;Est. Tax Savings&lt;/p&gt;
&lt;span class="material-symbols-outlined text-primary bg-primary/10 rounded-full p-1 text-[20px]"&gt;savings&lt;/span&gt;
&lt;/div&gt;
&lt;p class="text-2xl font-bold tracking-tight text-text-main dark:text-white"&gt;RM 450.00&lt;/p&gt;
&lt;div class="mt-2 flex items-center gap-2 text-xs"&gt;
&lt;span class="font-medium text-green-600 dark:text-green-400"&gt;+2%&lt;/span&gt;
&lt;span class="text-text-muted dark:text-gray-500"&gt;optimization&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Charts &amp; Relief Section --&gt;
&lt;div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6"&gt;
&lt;!-- Main Chart --&gt;
&lt;div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-6 shadow-sm lg:col-span-2"&gt;
&lt;div class="mb-6 flex items-center justify-between"&gt;
&lt;div&gt;
&lt;h3 class="text-base font-bold text-text-main dark:text-white"&gt;Income vs Expenses&lt;/h3&gt;
&lt;p class="text-sm text-text-muted dark:text-gray-400"&gt;Last 30 Days trend analysis&lt;/p&gt;
&lt;/div&gt;
&lt;div class="flex items-center gap-2 text-sm"&gt;
&lt;span class="flex items-center gap-1.5"&gt;
&lt;span class="h-2.5 w-2.5 rounded-full bg-primary"&gt;&lt;/span&gt;
&lt;span class="text-text-muted dark:text-gray-400"&gt;Income&lt;/span&gt;
&lt;/span&gt;
&lt;span class="flex items-center gap-1.5"&gt;
&lt;span class="h-2.5 w-2.5 rounded-full bg-border-light dark:bg-gray-600"&gt;&lt;/span&gt;
&lt;span class="text-text-muted dark:text-gray-400"&gt;Expenses&lt;/span&gt;
&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- SVG Chart Area --&gt;
&lt;div class="relative h-[250px] w-full"&gt;
&lt;svg class="h-full w-full overflow-visible" fill="none" preserveaspectratio="none" viewbox="0 0 800 250" xmlns="http://www.w3.org/2000/svg"&gt;
&lt;!-- Grid Lines --&gt;
&lt;line class="text-gray-100 dark:text-white/5" stroke="currentColor" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="200" y2="200"&gt;&lt;/line&gt;
&lt;line class="text-gray-100 dark:text-white/5" stroke="currentColor" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="150" y2="150"&gt;&lt;/line&gt;
&lt;line class="text-gray-100 dark:text-white/5" stroke="currentColor" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="100" y2="100"&gt;&lt;/line&gt;
&lt;line class="text-gray-100 dark:text-white/5" stroke="currentColor" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="800" y1="50" y2="50"&gt;&lt;/line&gt;
&lt;!-- Income Path --&gt;
&lt;defs&gt;
&lt;lineargradient gradientunits="userSpaceOnUse" id="incomeGradient" x1="400" x2="400" y1="0" y2="250"&gt;
&lt;stop stop-color="#13ec80" stop-opacity="0.2"&gt;&lt;/stop&gt;
&lt;stop offset="1" stop-color="#13ec80" stop-opacity="0"&gt;&lt;/stop&gt;
&lt;/lineargradient&gt;
&lt;/defs&gt;
&lt;path d="M0,200 C50,180 100,220 150,150 C200,80 250,50 300,60 C350,70 400,120 450,100 C500,80 550,20 600,30 C650,40 700,90 750,80 L800,50 V250 H0 Z" fill="url(#incomeGradient)"&gt;&lt;/path&gt;
&lt;path d="M0,200 C50,180 100,220 150,150 C200,80 250,50 300,60 C350,70 400,120 450,100 C500,80 550,20 600,30 C650,40 700,90 750,80 L800,50" stroke="#13ec80" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"&gt;&lt;/path&gt;
&lt;!-- Expense Path --&gt;
&lt;path class="text-gray-300 dark:text-gray-600" d="M0,220 C60,230 120,200 180,210 C240,220 300,180 360,190 C420,200 480,210 540,160 C600,110 660,150 720,160 L800,180" stroke="currentColor" stroke-dasharray="6 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"&gt;&lt;/path&gt;
&lt;/svg&gt;
&lt;/div&gt;
&lt;div class="flex justify-between mt-2 px-2 text-xs font-medium text-text-muted dark:text-gray-500"&gt;
&lt;span&gt;01 Oct&lt;/span&gt;
&lt;span&gt;05 Oct&lt;/span&gt;
&lt;span&gt;10 Oct&lt;/span&gt;
&lt;span&gt;15 Oct&lt;/span&gt;
&lt;span&gt;20 Oct&lt;/span&gt;
&lt;span&gt;25 Oct&lt;/span&gt;
&lt;span&gt;30 Oct&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Tax Relief Widget --&gt;
&lt;div class="rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-6 shadow-sm flex flex-col justify-between"&gt;
&lt;div&gt;
&lt;div class="mb-4 flex items-start justify-between"&gt;
&lt;div&gt;
&lt;h3 class="text-base font-bold text-text-main dark:text-white"&gt;Tax Reliefs&lt;/h3&gt;
&lt;p class="text-sm text-text-muted dark:text-gray-400"&gt;Maximize your claims&lt;/p&gt;
&lt;/div&gt;
&lt;div class="rounded-lg bg-background-light dark:bg-white/5 p-2"&gt;
&lt;span class="material-symbols-outlined text-text-main dark:text-white"&gt;verified_user&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="flex flex-col gap-6"&gt;
&lt;!-- Lifestyle Relief --&gt;
&lt;div class="space-y-2"&gt;
&lt;div class="flex justify-between text-sm"&gt;
&lt;span class="font-medium text-text-main dark:text-white"&gt;Lifestyle&lt;/span&gt;
&lt;span class="text-text-muted dark:text-gray-400"&gt;RM 1,500 / 2,500&lt;/span&gt;
&lt;/div&gt;
&lt;div class="h-2 w-full overflow-hidden rounded-full bg-background-light dark:bg-gray-700"&gt;
&lt;div class="h-full rounded-full bg-primary" style="width: 60%"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;p class="text-xs text-text-muted dark:text-gray-500"&gt;Books, Internet, Sports equipment&lt;/p&gt;
&lt;/div&gt;
&lt;!-- EPF Relief --&gt;
&lt;div class="space-y-2"&gt;
&lt;div class="flex justify-between text-sm"&gt;
&lt;span class="font-medium text-text-main dark:text-white"&gt;EPF &amp;amp; Insurance&lt;/span&gt;
&lt;span class="text-text-muted dark:text-gray-400"&gt;RM 3,200 / 4,000&lt;/span&gt;
&lt;/div&gt;
&lt;div class="h-2 w-full overflow-hidden rounded-full bg-background-light dark:bg-gray-700"&gt;
&lt;div class="h-full rounded-full bg-blue-500" style="width: 80%"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;p class="text-xs text-text-muted dark:text-gray-500"&gt;Life insurance and KWSP contributions&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;button class="mt-6 w-full rounded-lg bg-background-light dark:bg-white/5 py-2.5 text-sm font-bold text-text-main dark:text-white transition-colors hover:bg-gray-200 dark:hover:bg-white/10"&gt;
                            View All Reliefs
                        &lt;/button&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Bottom Section: Expense Categories &amp; Recent Transactions --&gt;
&lt;div class="grid grid-cols-1 gap-6 lg:grid-cols-2"&gt;
&lt;!-- Expense Categories --&gt;
&lt;div class="flex flex-col gap-4"&gt;
&lt;h3 class="text-lg font-bold text-text-main dark:text-white"&gt;Expense Categories&lt;/h3&gt;
&lt;div class="grid grid-cols-1 gap-3 sm:grid-cols-2"&gt;
&lt;!-- Category 1 --&gt;
&lt;div class="flex items-center gap-4 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-4 transition-all hover:bg-gray-50 dark:hover:bg-white/5"&gt;
&lt;div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400"&gt;
&lt;span class="material-symbols-outlined"&gt;house&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;p class="text-sm font-bold text-text-main dark:text-white"&gt;Housing&lt;/p&gt;
&lt;p class="text-xs text-text-muted dark:text-gray-400"&gt;40% • RM 1,680&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Category 2 --&gt;
&lt;div class="flex items-center gap-4 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-4 transition-all hover:bg-gray-50 dark:hover:bg-white/5"&gt;
&lt;div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400"&gt;
&lt;span class="material-symbols-outlined"&gt;directions_car&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;p class="text-sm font-bold text-text-main dark:text-white"&gt;Transport&lt;/p&gt;
&lt;p class="text-xs text-text-muted dark:text-gray-400"&gt;20% • RM 840&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Category 3 --&gt;
&lt;div class="flex items-center gap-4 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-4 transition-all hover:bg-gray-50 dark:hover:bg-white/5"&gt;
&lt;div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400"&gt;
&lt;span class="material-symbols-outlined"&gt;shopping_bag&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;p class="text-sm font-bold text-text-main dark:text-white"&gt;Lifestyle&lt;/p&gt;
&lt;p class="text-xs text-text-muted dark:text-gray-400"&gt;15% • RM 630&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Category 4 --&gt;
&lt;div class="flex items-center gap-4 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-4 transition-all hover:bg-gray-50 dark:hover:bg-white/5"&gt;
&lt;div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400"&gt;
&lt;span class="material-symbols-outlined"&gt;more_horiz&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;p class="text-sm font-bold text-text-main dark:text-white"&gt;Others&lt;/p&gt;
&lt;p class="text-xs text-text-muted dark:text-gray-400"&gt;25% • RM 1,050&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Recent Transactions --&gt;
&lt;div class="flex flex-col gap-4"&gt;
&lt;div class="flex items-center justify-between"&gt;
&lt;h3 class="text-lg font-bold text-text-main dark:text-white"&gt;Recent Activity&lt;/h3&gt;
&lt;a class="text-sm font-medium text-primary hover:underline" href="#"&gt;View All&lt;/a&gt;
&lt;/div&gt;
&lt;div class="overflow-hidden rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark shadow-sm"&gt;
&lt;table class="w-full text-left text-sm"&gt;
&lt;thead class="bg-background-light dark:bg-white/5 text-xs uppercase text-text-muted dark:text-gray-400"&gt;
&lt;tr&gt;
&lt;th class="px-6 py-3 font-semibold"&gt;Transaction&lt;/th&gt;
&lt;th class="px-6 py-3 font-semibold text-center"&gt;Status&lt;/th&gt;
&lt;th class="px-6 py-3 font-semibold text-right"&gt;Amount&lt;/th&gt;
&lt;/tr&gt;
&lt;/thead&gt;
&lt;tbody class="divide-y divide-border-light dark:divide-border-dark"&gt;
&lt;tr class="group hover:bg-background-light dark:hover:bg-white/5"&gt;
&lt;td class="px-6 py-4"&gt;
&lt;p class="font-bold text-text-main dark:text-white"&gt;Design Client A&lt;/p&gt;
&lt;p class="text-xs text-text-muted dark:text-gray-400"&gt;Freelance Income • 24 Oct&lt;/p&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-center"&gt;
&lt;span class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/30 px-2.5 py-0.5 text-xs font-medium text-green-700 dark:text-green-400"&gt;
                                                Completed
                                            &lt;/span&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-right font-bold text-green-600 dark:text-green-400"&gt;+ RM 3,500.00&lt;/td&gt;
&lt;/tr&gt;
&lt;tr class="group hover:bg-background-light dark:hover:bg-white/5"&gt;
&lt;td class="px-6 py-4"&gt;
&lt;p class="font-bold text-text-main dark:text-white"&gt;Popular Bookstore&lt;/p&gt;
&lt;p class="text-xs text-text-muted dark:text-gray-400"&gt;Lifestyle (Books) • 23 Oct&lt;/p&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-center"&gt;
&lt;div class="flex justify-center"&gt;
&lt;span class="inline-flex items-center gap-1 rounded-full bg-blue-50 dark:bg-blue-900/20 px-2.5 py-0.5 text-xs font-medium text-blue-600 dark:text-blue-400" title="Tax Deductible"&gt;
&lt;span class="material-symbols-outlined text-[12px]"&gt;verified&lt;/span&gt;
                                                    Deductible
                                                &lt;/span&gt;
&lt;/div&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-right font-bold text-text-main dark:text-white"&gt;- RM 150.00&lt;/td&gt;
&lt;/tr&gt;
&lt;tr class="group hover:bg-background-light dark:hover:bg-white/5"&gt;
&lt;td class="px-6 py-4"&gt;
&lt;p class="font-bold text-text-main dark:text-white"&gt;Apple Store&lt;/p&gt;
&lt;p class="text-xs text-text-muted dark:text-gray-400"&gt;Equipment • 21 Oct&lt;/p&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-center"&gt;
&lt;div class="flex justify-center"&gt;
&lt;span class="inline-flex items-center gap-1 rounded-full bg-blue-50 dark:bg-blue-900/20 px-2.5 py-0.5 text-xs font-medium text-blue-600 dark:text-blue-400" title="Tax Deductible"&gt;
&lt;span class="material-symbols-outlined text-[12px]"&gt;verified&lt;/span&gt;
                                                    Deductible
                                                &lt;/span&gt;
&lt;/div&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-right font-bold text-text-main dark:text-white"&gt;- RM 4,299.00&lt;/td&gt;
&lt;/tr&gt;
&lt;tr class="group hover:bg-background-light dark:hover:bg-white/5"&gt;
&lt;td class="px-6 py-4"&gt;
&lt;p class="font-bold text-text-main dark:text-white"&gt;TNB Bill&lt;/p&gt;
&lt;p class="text-xs text-text-muted dark:text-gray-400"&gt;Utilities • 20 Oct&lt;/p&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-center"&gt;
&lt;span class="inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-800 px-2.5 py-0.5 text-xs font-medium text-gray-700 dark:text-gray-400"&gt;
                                                Standard
                                            &lt;/span&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-right font-bold text-text-main dark:text-white"&gt;- RM 180.00&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/main&gt;
&lt;/div&gt;
@endsection
