@extends('layouts.app')

@section('title', 'MyTaxM - Tax Summary')

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
                        "primary-dark": "#0eb561",
                        "background-light": "#f6f8f7",
                        "background-dark": "#102219",
                        "card-light": "#ffffff",
                        "card-dark": "#162e24",
                        "text-main": "#111814",
                        "text-muted": "#618975",
                        "border-light": "#dbe6e0",
                        "border-dark": "#2a4034"
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    &lt;/script&gt;
&lt;style&gt;
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for better look */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #dbe6e0;
            border-radius: 20px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background-color: #2a4034;
        }
    &lt;/style&gt;

&lt;div class="flex flex-col min-h-screen"&gt;
&lt;!-- Top Navigation --&gt;
&lt;header class="sticky top-0 z-50 flex items-center justify-between whitespace-nowrap border-b border-solid border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark px-4 sm:px-10 py-3 shadow-sm"&gt;
&lt;div class="flex items-center gap-4"&gt;
&lt;div class="size-8 text-primary flex items-center justify-center rounded bg-primary/10"&gt;
&lt;span class="material-symbols-outlined text-2xl"&gt;account_balance&lt;/span&gt;
&lt;/div&gt;
&lt;h2 class="text-text-main dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]"&gt;MyTaxM&lt;/h2&gt;
&lt;/div&gt;
&lt;!-- Desktop Menu --&gt;
&lt;div class="hidden md:flex flex-1 justify-end gap-8 items-center"&gt;
&lt;nav class="flex items-center gap-6"&gt;
&lt;a class="text-text-main dark:text-gray-300 hover:text-primary text-sm font-medium leading-normal transition-colors" href="#"&gt;Dashboard&lt;/a&gt;
&lt;a class="text-text-main dark:text-gray-300 hover:text-primary text-sm font-medium leading-normal transition-colors" href="#"&gt;Invoices&lt;/a&gt;
&lt;a class="text-text-main dark:text-gray-300 hover:text-primary text-sm font-medium leading-normal transition-colors" href="#"&gt;Expenses&lt;/a&gt;
&lt;a class="text-primary text-sm font-bold leading-normal relative after:content-[''] after:absolute after:-bottom-5 after:left-0 after:w-full after:h-0.5 after:bg-primary" href="#"&gt;Tax Summary&lt;/a&gt;
&lt;a class="text-text-main dark:text-gray-300 hover:text-primary text-sm font-medium leading-normal transition-colors" href="#"&gt;Settings&lt;/a&gt;
&lt;/nav&gt;
&lt;div class="h-6 w-px bg-border-light dark:bg-border-dark"&gt;&lt;/div&gt;
&lt;div class="flex items-center gap-4"&gt;
&lt;button class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-9 px-4 bg-transparent border border-border-light dark:border-border-dark hover:bg-gray-50 dark:hover:bg-gray-800 text-text-main dark:text-white text-sm font-medium"&gt;
&lt;span class="truncate"&gt;Log Out&lt;/span&gt;
&lt;/button&gt;
&lt;div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-9 border-2 border-primary/20" data-alt="User profile picture showing a professional headshot" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAvEpFmnqm1HTWaN6uY1f6SiBrdrTxDU97kUOSICo2BIPFBeZ9-tvipWtvagmfr-l9D3OC9CtzhuzT_8iApKr6PRin1hewQ8CL3hOa1xsGyB2ilZH2U5tkhGy8BmqPTMFS8rlO5N66bJxjxYkBk-GnQE53zqYtsbjp8UboBQzFSFGQOTRoM5hrtvVlVzsNT3ZNC58oXa0pvfy1T-QJpEOoaAtx-FROuN4cNQl6mZgcNIK-5iw7uew9oXNWq_2OLbpJs9n93QGsSFxo");'&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Mobile Menu Icon --&gt;
&lt;button class="md:hidden text-text-main dark:text-white"&gt;
&lt;span class="material-symbols-outlined"&gt;menu&lt;/span&gt;
&lt;/button&gt;
&lt;/header&gt;
&lt;main class="layout-container flex h-full grow flex-col w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"&gt;
&lt;!-- Page Header &amp; Actions --&gt;
&lt;div class="flex flex-col md:flex-row flex-wrap justify-between gap-6 mb-8 items-end md:items-center"&gt;
&lt;div class="flex flex-col gap-2"&gt;
&lt;div class="flex items-center gap-2"&gt;
&lt;h1 class="text-text-main dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]"&gt;Tax Summary&lt;/h1&gt;
&lt;span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20"&gt;YA 2023&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex items-center gap-2 text-text-muted dark:text-gray-400"&gt;
&lt;span&gt;Year of Assessment: &lt;/span&gt;
&lt;select class="bg-transparent border-none py-0 pl-0 pr-8 text-base font-semibold text-primary focus:ring-0 cursor-pointer"&gt;
&lt;option&gt;2023&lt;/option&gt;
&lt;option&gt;2022&lt;/option&gt;
&lt;option&gt;2021&lt;/option&gt;
&lt;/select&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="flex gap-3"&gt;
&lt;button class="flex items-center justify-center gap-2 rounded-lg h-10 px-4 bg-white dark:bg-card-dark border border-border-light dark:border-border-dark text-text-main dark:text-white text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors shadow-sm"&gt;
&lt;span class="material-symbols-outlined text-lg"&gt;print&lt;/span&gt;
&lt;span class="truncate hidden sm:inline"&gt;Print&lt;/span&gt;
&lt;/button&gt;
&lt;button class="flex items-center justify-center gap-2 rounded-lg h-10 px-5 bg-primary hover:bg-primary-dark text-text-main text-sm font-bold transition-colors shadow-lg shadow-primary/20"&gt;
&lt;span class="material-symbols-outlined text-lg"&gt;table_view&lt;/span&gt;
&lt;span class="truncate"&gt;Export to Excel&lt;/span&gt;
&lt;/button&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Stats Overview Cards --&gt;
&lt;div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8"&gt;
&lt;!-- Card 1 --&gt;
&lt;div class="flex flex-col gap-1 rounded-xl p-5 border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm"&gt;
&lt;div class="flex items-center gap-2 mb-2"&gt;
&lt;div class="p-1.5 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400"&gt;
&lt;span class="material-symbols-outlined text-xl"&gt;payments&lt;/span&gt;
&lt;/div&gt;
&lt;p class="text-text-muted dark:text-gray-400 text-sm font-medium"&gt;Total Gross Income&lt;/p&gt;
&lt;/div&gt;
&lt;p class="text-text-main dark:text-white text-2xl font-bold tracking-tight"&gt;RM 124,500.00&lt;/p&gt;
&lt;div class="flex items-center text-xs text-green-600 dark:text-green-400 mt-1"&gt;
&lt;span class="material-symbols-outlined text-sm mr-0.5"&gt;trending_up&lt;/span&gt;
&lt;span&gt;+12% from 2022&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Card 2 --&gt;
&lt;div class="flex flex-col gap-1 rounded-xl p-5 border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm"&gt;
&lt;div class="flex items-center gap-2 mb-2"&gt;
&lt;div class="p-1.5 rounded-md bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400"&gt;
&lt;span class="material-symbols-outlined text-xl"&gt;verified&lt;/span&gt;
&lt;/div&gt;
&lt;p class="text-text-muted dark:text-gray-400 text-sm font-medium"&gt;Approved Reliefs&lt;/p&gt;
&lt;/div&gt;
&lt;p class="text-text-main dark:text-white text-2xl font-bold tracking-tight"&gt;RM 21,400.00&lt;/p&gt;
&lt;div class="flex items-center text-xs text-text-muted dark:text-gray-500 mt-1"&gt;
&lt;span&gt;17.1% of Gross Income&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Card 3 --&gt;
&lt;div class="flex flex-col gap-1 rounded-xl p-5 border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm"&gt;
&lt;div class="flex items-center gap-2 mb-2"&gt;
&lt;div class="p-1.5 rounded-md bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400"&gt;
&lt;span class="material-symbols-outlined text-xl"&gt;account_balance_wallet&lt;/span&gt;
&lt;/div&gt;
&lt;p class="text-text-muted dark:text-gray-400 text-sm font-medium"&gt;Chargeable Income&lt;/p&gt;
&lt;/div&gt;
&lt;p class="text-text-main dark:text-white text-2xl font-bold tracking-tight"&gt;RM 103,100.00&lt;/p&gt;
&lt;div class="flex items-center text-xs text-orange-600 dark:text-orange-400 mt-1"&gt;
&lt;span&gt;Tax Bracket E (19-24%)&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Card 4 (Highlighted) --&gt;
&lt;div class="flex flex-col gap-1 rounded-xl p-5 border border-primary/50 bg-primary/5 dark:bg-primary/10 shadow-sm relative overflow-hidden group"&gt;
&lt;div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity"&gt;
&lt;span class="material-symbols-outlined text-6xl text-primary"&gt;gavel&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex items-center gap-2 mb-2 relative z-10"&gt;
&lt;div class="p-1.5 rounded-md bg-primary text-text-main"&gt;
&lt;span class="material-symbols-outlined text-xl"&gt;gavel&lt;/span&gt;
&lt;/div&gt;
&lt;p class="text-text-main dark:text-white text-sm font-bold"&gt;Net Tax Payable&lt;/p&gt;
&lt;/div&gt;
&lt;p class="text-text-main dark:text-white text-2xl font-black tracking-tight relative z-10"&gt;RM 4,250.00&lt;/p&gt;
&lt;div class="flex items-center text-xs text-text-muted dark:text-gray-400 mt-1 relative z-10"&gt;
&lt;span&gt;Before PCB deduction&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="grid grid-cols-1 lg:grid-cols-3 gap-8"&gt;
&lt;!-- Left Column: Detailed Breakdown --&gt;
&lt;div class="lg:col-span-2 flex flex-col gap-6"&gt;
&lt;h3 class="text-text-main dark:text-white tracking-tight text-xl font-bold leading-tight"&gt;Tax Calculation Breakdown&lt;/h3&gt;
&lt;div class="flex flex-col gap-4"&gt;
&lt;!-- Section A --&gt;
&lt;details class="group flex flex-col rounded-xl border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark overflow-hidden transition-all duration-300"&gt;
&lt;summary class="flex cursor-pointer items-center justify-between gap-4 p-5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"&gt;
&lt;div class="flex items-center gap-3"&gt;
&lt;div class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 rounded-full p-1"&gt;
&lt;span class="material-symbols-outlined text-lg"&gt;work&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;p class="text-text-main dark:text-white text-sm font-bold"&gt;Section A: Statutory Income&lt;/p&gt;
&lt;p class="text-text-muted dark:text-gray-400 text-xs"&gt;Employment, Business, Dividends, Rents&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="flex items-center gap-3"&gt;
&lt;span class="text-text-main dark:text-white font-bold"&gt;RM 124,500.00&lt;/span&gt;
&lt;span class="material-symbols-outlined text-text-muted transition-transform group-open:rotate-180"&gt;expand_more&lt;/span&gt;
&lt;/div&gt;
&lt;/summary&gt;
&lt;div class="border-t border-border-light dark:border-border-dark p-5 bg-gray-50/50 dark:bg-gray-900/20"&gt;
&lt;div class="flex flex-col gap-3"&gt;
&lt;div class="flex justify-between items-center text-sm"&gt;
&lt;span class="text-text-muted dark:text-gray-400"&gt;Employment Income (Salary, Bonus)&lt;/span&gt;
&lt;span class="font-medium text-text-main dark:text-white"&gt;RM 118,000.00&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex justify-between items-center text-sm"&gt;
&lt;span class="text-text-muted dark:text-gray-400"&gt;Allowances &amp;amp; Perquisites&lt;/span&gt;
&lt;span class="font-medium text-text-main dark:text-white"&gt;RM 4,500.00&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex justify-between items-center text-sm"&gt;
&lt;span class="text-text-muted dark:text-gray-400"&gt;Rental Income (Net)&lt;/span&gt;
&lt;span class="font-medium text-text-main dark:text-white"&gt;RM 2,000.00&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex justify-between items-center text-sm pt-2 border-t border-dashed border-gray-200 dark:border-gray-700"&gt;
&lt;span class="text-text-main dark:text-white font-semibold"&gt;Total Aggregated Income&lt;/span&gt;
&lt;span class="font-bold text-text-main dark:text-white"&gt;RM 124,500.00&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/details&gt;
&lt;!-- Section B --&gt;
&lt;details class="group flex flex-col rounded-xl border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark overflow-hidden transition-all duration-300"&gt;
&lt;summary class="flex cursor-pointer items-center justify-between gap-4 p-5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"&gt;
&lt;div class="flex items-center gap-3"&gt;
&lt;div class="bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 rounded-full p-1"&gt;
&lt;span class="material-symbols-outlined text-lg"&gt;volunteer_activism&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;p class="text-text-main dark:text-white text-sm font-bold"&gt;Section B: Donations &amp;amp; Zakat&lt;/p&gt;
&lt;p class="text-text-muted dark:text-gray-400 text-xs"&gt;Approved Donations, Gifts, Zakat Fitrah&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="flex items-center gap-3"&gt;
&lt;span class="text-text-main dark:text-white font-bold"&gt;- RM 500.00&lt;/span&gt;
&lt;span class="material-symbols-outlined text-text-muted transition-transform group-open:rotate-180"&gt;expand_more&lt;/span&gt;
&lt;/div&gt;
&lt;/summary&gt;
&lt;div class="border-t border-border-light dark:border-border-dark p-5 bg-gray-50/50 dark:bg-gray-900/20"&gt;
&lt;div class="flex flex-col gap-3"&gt;
&lt;div class="flex justify-between items-center text-sm"&gt;
&lt;span class="text-text-muted dark:text-gray-400"&gt;Gift of Money to Government / Approved Institutions&lt;/span&gt;
&lt;span class="font-medium text-text-main dark:text-white"&gt;RM 0.00&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex justify-between items-center text-sm"&gt;
&lt;span class="text-text-muted dark:text-gray-400"&gt;Zakat &amp;amp; Fitrah (Rebate deduction applied later)&lt;/span&gt;
&lt;span class="font-medium text-text-main dark:text-white"&gt;RM 500.00&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/details&gt;
&lt;!-- Section C --&gt;
&lt;details class="group flex flex-col rounded-xl border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark overflow-hidden transition-all duration-300" open=""&gt;
&lt;summary class="flex cursor-pointer items-center justify-between gap-4 p-5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"&gt;
&lt;div class="flex items-center gap-3"&gt;
&lt;div class="bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 rounded-full p-1"&gt;
&lt;span class="material-symbols-outlined text-lg"&gt;medical_services&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;p class="text-text-main dark:text-white text-sm font-bold"&gt;Section C: Tax Reliefs&lt;/p&gt;
&lt;p class="text-text-muted dark:text-gray-400 text-xs"&gt;Lifestyle, Insurance, EPF, Parenthood&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="flex items-center gap-3"&gt;
&lt;span class="text-text-main dark:text-white font-bold text-green-600 dark:text-green-400"&gt;- RM 21,400.00&lt;/span&gt;
&lt;span class="material-symbols-outlined text-text-muted transition-transform group-open:rotate-180"&gt;expand_more&lt;/span&gt;
&lt;/div&gt;
&lt;/summary&gt;
&lt;div class="border-t border-border-light dark:border-border-dark p-5 bg-gray-50/50 dark:bg-gray-900/20 flex flex-col gap-6"&gt;
&lt;!-- Relief Item 1 --&gt;
&lt;div class="flex flex-col gap-2"&gt;
&lt;div class="flex justify-between items-end"&gt;
&lt;div class="flex flex-col"&gt;
&lt;span class="text-sm font-semibold text-text-main dark:text-white"&gt;Individual Relief&lt;/span&gt;
&lt;span class="text-xs text-text-muted dark:text-gray-400"&gt;Automatic deduction for self&lt;/span&gt;
&lt;/div&gt;
&lt;div class="text-right"&gt;
&lt;span class="text-sm font-bold text-text-main dark:text-white"&gt;RM 9,000.00&lt;/span&gt;
&lt;span class="text-xs text-text-muted block"&gt;Max: RM 9,000&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="h-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden"&gt;
&lt;div class="h-full bg-primary w-full rounded-full"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Relief Item 2 --&gt;
&lt;div class="flex flex-col gap-2"&gt;
&lt;div class="flex justify-between items-end"&gt;
&lt;div class="flex flex-col"&gt;
&lt;span class="text-sm font-semibold text-text-main dark:text-white"&gt;Lifestyle&lt;/span&gt;
&lt;span class="text-xs text-text-muted dark:text-gray-400"&gt;Books, Internet, Sports, Devices&lt;/span&gt;
&lt;/div&gt;
&lt;div class="text-right"&gt;
&lt;span class="text-sm font-bold text-text-main dark:text-white"&gt;RM 2,250.00&lt;/span&gt;
&lt;span class="text-xs text-text-muted block"&gt;Max: RM 2,500&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="h-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden"&gt;
&lt;div class="h-full bg-primary w-[90%] rounded-full"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;div class="text-xs text-primary font-medium text-right"&gt;RM 250.00 quota remaining&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Relief Item 3 --&gt;
&lt;div class="flex flex-col gap-2"&gt;
&lt;div class="flex justify-between items-end"&gt;
&lt;div class="flex flex-col"&gt;
&lt;span class="text-sm font-semibold text-text-main dark:text-white"&gt;Life Insurance &amp;amp; EPF&lt;/span&gt;
&lt;span class="text-xs text-text-muted dark:text-gray-400"&gt;Restricted to RM4k EPF + RM3k Life Ins.&lt;/span&gt;
&lt;/div&gt;
&lt;div class="text-right"&gt;
&lt;span class="text-sm font-bold text-text-main dark:text-white"&gt;RM 7,000.00&lt;/span&gt;
&lt;span class="text-xs text-text-muted block"&gt;Max: RM 7,000&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="h-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden"&gt;
&lt;div class="h-full bg-primary w-full rounded-full"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Relief Item 4 --&gt;
&lt;div class="flex flex-col gap-2"&gt;
&lt;div class="flex justify-between items-end"&gt;
&lt;div class="flex flex-col"&gt;
&lt;span class="text-sm font-semibold text-text-main dark:text-white"&gt;Medical Expenses&lt;/span&gt;
&lt;span class="text-xs text-text-muted dark:text-gray-400"&gt;Serious diseases, fertility treatment&lt;/span&gt;
&lt;/div&gt;
&lt;div class="text-right"&gt;
&lt;span class="text-sm font-bold text-text-main dark:text-white"&gt;RM 3,150.00&lt;/span&gt;
&lt;span class="text-xs text-text-muted block"&gt;Max: RM 10,000&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="h-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden"&gt;
&lt;div class="h-full bg-primary w-[31%] rounded-full"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;div class="text-xs text-primary font-medium text-right"&gt;RM 6,850.00 quota remaining&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/details&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Right Column: Visualizations &amp; Summary --&gt;
&lt;div class="flex flex-col gap-6"&gt;
&lt;!-- PCB Comparison Widget --&gt;
&lt;div class="rounded-xl border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-lg overflow-hidden"&gt;
&lt;div class="bg-background-light dark:bg-gray-800 p-4 border-b border-border-light dark:border-border-dark flex justify-between items-center"&gt;
&lt;h4 class="font-bold text-text-main dark:text-white"&gt;Tax Balance&lt;/h4&gt;
&lt;span class="material-symbols-outlined text-text-muted"&gt;account_balance_wallet&lt;/span&gt;
&lt;/div&gt;
&lt;div class="p-5 flex flex-col gap-4"&gt;
&lt;div class="flex justify-between items-center"&gt;
&lt;span class="text-sm text-text-muted dark:text-gray-400"&gt;Net Tax Payable&lt;/span&gt;
&lt;span class="font-bold text-text-main dark:text-white"&gt;RM 4,250.00&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex justify-between items-center"&gt;
&lt;div class="flex items-center gap-1"&gt;
&lt;span class="text-sm text-text-muted dark:text-gray-400"&gt;Less: Zakat Rebate&lt;/span&gt;
&lt;/div&gt;
&lt;span class="font-medium text-green-600 dark:text-green-400"&gt;- RM 500.00&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex justify-between items-center"&gt;
&lt;div class="flex items-center gap-1"&gt;
&lt;span class="text-sm text-text-muted dark:text-gray-400"&gt;Less: PCB Paid (MTD)&lt;/span&gt;
&lt;span class="material-symbols-outlined text-[16px] text-text-muted cursor-help" title="Potongan Cukai Berjadual deducted from your monthly salary"&gt;help&lt;/span&gt;
&lt;/div&gt;
&lt;span class="font-medium text-green-600 dark:text-green-400"&gt;- RM 3,800.00&lt;/span&gt;
&lt;/div&gt;
&lt;div class="h-px bg-border-light dark:bg-border-dark my-1"&gt;&lt;/div&gt;
&lt;div class="flex justify-between items-end"&gt;
&lt;span class="text-sm font-bold text-text-main dark:text-white"&gt;Balance to Pay&lt;/span&gt;
&lt;span class="text-2xl font-black text-red-600 dark:text-red-400"&gt;RM -50.00&lt;/span&gt;
&lt;/div&gt;
&lt;div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3 flex items-start gap-2"&gt;
&lt;span class="material-symbols-outlined text-green-600 dark:text-green-400 mt-0.5"&gt;check_circle&lt;/span&gt;
&lt;p class="text-xs text-green-800 dark:text-green-200 font-medium leading-relaxed"&gt;
                                 Great news! You have overpaid your taxes by &lt;strong&gt;RM 50.00&lt;/strong&gt;. This amount is refundable by LHDN.
                             &lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Tax Bracket Widget --&gt;
&lt;div class="rounded-xl border border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark shadow-sm p-5"&gt;
&lt;h4 class="font-bold text-text-main dark:text-white mb-4"&gt;Tax Bracket (Category E)&lt;/h4&gt;
&lt;div class="flex flex-col gap-4"&gt;
&lt;div class="flex justify-between text-xs text-text-muted dark:text-gray-400"&gt;
&lt;span&gt;0%&lt;/span&gt;
&lt;span&gt;Current: 21%&lt;/span&gt;
&lt;span&gt;Max: 30%&lt;/span&gt;
&lt;/div&gt;
&lt;!-- Visual Steps --&gt;
&lt;div class="flex w-full gap-1 h-3"&gt;
&lt;div class="flex-1 bg-primary rounded-l-sm opacity-30" title="0-5k"&gt;&lt;/div&gt;
&lt;div class="flex-1 bg-primary opacity-40" title="5k-20k"&gt;&lt;/div&gt;
&lt;div class="flex-1 bg-primary opacity-50" title="20k-35k"&gt;&lt;/div&gt;
&lt;div class="flex-1 bg-primary opacity-60" title="35k-50k"&gt;&lt;/div&gt;
&lt;div class="flex-1 bg-primary opacity-80" title="50k-70k"&gt;&lt;/div&gt;
&lt;div class="flex-1 bg-primary rounded-r-sm relative overflow-visible" title="70k-100k"&gt;
&lt;div class="absolute -top-1.5 left-1/2 -translate-x-1/2 w-0.5 h-6 bg-text-main dark:bg-white z-10"&gt;&lt;/div&gt;
&lt;div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-text-main dark:bg-white text-white dark:text-black text-[10px] font-bold px-1.5 py-0.5 rounded whitespace-nowrap"&gt;You&lt;/div&gt;
&lt;/div&gt;
&lt;div class="flex-1 bg-gray-200 dark:bg-gray-700" title="100k+"&gt;&lt;/div&gt;
&lt;div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-r-sm" title="400k+"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;p class="text-xs text-text-muted dark:text-gray-400 leading-relaxed"&gt;
                            Your chargeable income of &lt;strong&gt;RM 103,100&lt;/strong&gt; places you in the 21% tax bracket. The next bracket starts at RM 250,000.
                        &lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Helper / Promo --&gt;
&lt;div class="rounded-xl bg-gradient-to-br from-[#102219] to-[#1e3b2e] dark:from-black dark:to-[#0a150f] p-6 text-white relative overflow-hidden"&gt;
&lt;!-- Decorative background pattern --&gt;
&lt;div class="absolute top-0 right-0 w-32 h-32 bg-primary/20 rounded-full blur-3xl -mr-10 -mt-10"&gt;&lt;/div&gt;
&lt;div class="relative z-10 flex flex-col gap-3"&gt;
&lt;div class="size-10 rounded-full bg-white/10 flex items-center justify-center backdrop-blur-sm mb-1"&gt;
&lt;span class="material-symbols-outlined text-primary"&gt;lightbulb&lt;/span&gt;
&lt;/div&gt;
&lt;h4 class="font-bold text-lg"&gt;Maximize your refund?&lt;/h4&gt;
&lt;p class="text-sm text-gray-300"&gt;You have &lt;strong&gt;RM 6,850&lt;/strong&gt; remaining in Medical relief quota. Upload receipts to claim more.&lt;/p&gt;
&lt;button class="mt-2 w-full py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg text-sm font-semibold transition-colors"&gt;
                            Upload Receipt
                        &lt;/button&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/main&gt;
&lt;!-- Footer --&gt;
&lt;footer class="bg-card-light dark:bg-card-dark border-t border-border-light dark:border-border-dark py-8 mt-auto"&gt;
&lt;div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4"&gt;
&lt;p class="text-sm text-text-muted dark:text-gray-500"&gt;© 2023 MyTaxM. All rights reserved.&lt;/p&gt;
&lt;div class="flex gap-6 text-sm font-medium text-text-muted dark:text-gray-400"&gt;
&lt;a class="hover:text-primary transition-colors" href="#"&gt;Privacy Policy&lt;/a&gt;
&lt;a class="hover:text-primary transition-colors" href="#"&gt;Terms of Service&lt;/a&gt;
&lt;a class="hover:text-primary transition-colors" href="#"&gt;Help Center&lt;/a&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/footer&gt;
&lt;/div&gt;
@endsection
