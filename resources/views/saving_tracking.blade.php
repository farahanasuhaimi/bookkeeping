@extends('layouts.app')

@section('title', 'Savings Tracking - MyTaxBook')

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
    &lt;/script&gt;
&lt;style&gt;
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
    &lt;/style&gt;

&lt;div class="relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden"&gt;
&lt;!-- Navigation --&gt;
&lt;div class="layout-container flex w-full flex-col"&gt;
&lt;header class="sticky top-0 z-50 flex items-center justify-between whitespace-nowrap border-b border-solid border-[#e5e7eb] dark:border-[#2a3c32] bg-white dark:bg-card-dark px-10 py-3 shadow-sm"&gt;
&lt;div class="flex items-center gap-8"&gt;
&lt;div class="flex items-center gap-4 text-[#111814] dark:text-white"&gt;
&lt;div class="size-8 flex items-center justify-center text-primary"&gt;
&lt;span class="material-symbols-outlined text-3xl"&gt;account_balance_wallet&lt;/span&gt;
&lt;/div&gt;
&lt;h2 class="text-[#111814] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]"&gt;MyTaxBook&lt;/h2&gt;
&lt;/div&gt;
&lt;label class="flex flex-col min-w-40 !h-10 max-w-64 hidden md:flex"&gt;
&lt;div class="flex w-full flex-1 items-stretch rounded-lg h-full"&gt;
&lt;div class="text-[#618975] flex border-none bg-[#f0f4f2] dark:bg-[#2a3c32] items-center justify-center pl-4 rounded-l-lg border-r-0"&gt;
&lt;span class="material-symbols-outlined text-[20px]"&gt;search&lt;/span&gt;
&lt;/div&gt;
&lt;input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111814] dark:text-white focus:outline-0 focus:ring-0 border-none bg-[#f0f4f2] dark:bg-[#2a3c32] focus:border-none h-full placeholder:text-[#618975] px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal leading-normal" placeholder="Search transactions..." value=""/&gt;
&lt;/div&gt;
&lt;/label&gt;
&lt;/div&gt;
&lt;div class="flex flex-1 justify-end gap-8 items-center"&gt;
&lt;nav class="hidden lg:flex items-center gap-6"&gt;
&lt;a class="text-[#111814] dark:text-white hover:text-primary text-sm font-medium leading-normal transition-colors" href="#"&gt;Dashboard&lt;/a&gt;
&lt;a class="text-[#111814] dark:text-white hover:text-primary text-sm font-medium leading-normal transition-colors" href="#"&gt;Invoices&lt;/a&gt;
&lt;a class="text-[#111814] dark:text-white hover:text-primary text-sm font-medium leading-normal transition-colors" href="#"&gt;Expenses&lt;/a&gt;
&lt;a class="text-primary text-sm font-bold leading-normal relative after:content-[''] after:absolute after:-bottom-5 after:left-0 after:w-full after:h-0.5 after:bg-primary" href="#"&gt;Savings&lt;/a&gt;
&lt;a class="text-[#111814] dark:text-white hover:text-primary text-sm font-medium leading-normal transition-colors" href="#"&gt;Tax Reports&lt;/a&gt;
&lt;/nav&gt;
&lt;button class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-9 px-4 bg-primary hover:bg-opacity-90 transition-all text-[#111814] text-sm font-bold leading-normal shadow-sm"&gt;
&lt;span class="truncate flex items-center gap-2"&gt;
&lt;span class="material-symbols-outlined text-[18px]"&gt;add&lt;/span&gt;
                            Quick Add
                        &lt;/span&gt;
&lt;/button&gt;
&lt;div class="bg-center bg-no-repeat bg-cover rounded-full size-10 border-2 border-primary cursor-pointer" data-alt="User profile picture showing a professional headshot" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCVaTnlo3GEyy4tRjJ12gTnCuCOuQq1sWhvm1EVxotH_ar0bPXFLKq0qlmgLKI_IhRkLWWh7-vAbd7PVgyjZBY0TbBmfP7HhK2ww6nLqQSsvCt0FZ1fF4A-2VhrUQhnIDWdLF7gUVVGT9gh7bX-6_b4gDpEOHuuTFBeT1AwAD0HEamZ6uAjwj5ZaLOuKu0T-ORABgZiew85XpbRtB8a_TzGihgX29sA4EAdnbdafExLWKsP-aZhZrOvyhO79CYEvJj37rRJpwX7rkw");'&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;/header&gt;
&lt;/div&gt;
&lt;!-- Main Content --&gt;
&lt;div class="layout-container flex h-full grow flex-col"&gt;
&lt;div class="px-4 md:px-10 lg:px-40 flex flex-1 justify-center py-8"&gt;
&lt;div class="layout-content-container flex flex-col max-w-[1200px] flex-1 w-full gap-8"&gt;
&lt;!-- Page Heading --&gt;
&lt;div class="flex flex-wrap justify-between items-end gap-4 p-4 -mx-4"&gt;
&lt;div class="flex min-w-72 flex-col gap-2"&gt;
&lt;h1 class="text-[#111814] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]"&gt;Savings Overview&lt;/h1&gt;
&lt;p class="text-[#618975] dark:text-gray-400 text-base font-normal leading-normal"&gt;Track your EPF, Zakat, and personal savings progress for tax optimization.&lt;/p&gt;
&lt;/div&gt;
&lt;div class="flex items-center gap-3"&gt;
&lt;span class="text-sm text-text-muted dark:text-gray-500 font-medium"&gt;Last updated: Today, 10:42 AM&lt;/span&gt;
&lt;button class="flex cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-white dark:bg-card-dark border border-[#dbe6e0] dark:border-[#333] text-[#111814] dark:text-white hover:bg-gray-50 dark:hover:bg-[#2a3c32] text-sm font-bold leading-normal transition-colors"&gt;
&lt;span class="truncate flex items-center gap-2"&gt;
&lt;span class="material-symbols-outlined text-[18px]"&gt;download&lt;/span&gt;
                                    Export Report
                                &lt;/span&gt;
&lt;/button&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Stats Cards --&gt;
&lt;div class="grid grid-cols-1 md:grid-cols-3 gap-6"&gt;
&lt;!-- Total Savings --&gt;
&lt;div class="flex flex-col gap-4 rounded-xl p-6 bg-white dark:bg-card-dark border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm relative overflow-hidden group"&gt;
&lt;div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity"&gt;
&lt;span class="material-symbols-outlined text-6xl text-primary"&gt;account_balance&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex justify-between items-start z-10"&gt;
&lt;p class="text-[#618975] dark:text-gray-400 text-sm font-bold uppercase tracking-wider"&gt;Total Savings Balance&lt;/p&gt;
&lt;span class="material-symbols-outlined text-[#618975] cursor-pointer hover:text-primary"&gt;visibility&lt;/span&gt;
&lt;/div&gt;
&lt;div class="z-10"&gt;
&lt;p class="text-[#111814] dark:text-white text-3xl font-bold leading-tight"&gt;RM 142,500.00&lt;/p&gt;
&lt;div class="flex items-center gap-1 mt-2"&gt;
&lt;span class="bg-[#e6fdec] text-[#07882c] text-xs font-bold px-2 py-1 rounded-full flex items-center"&gt;
&lt;span class="material-symbols-outlined text-[14px] mr-1"&gt;trending_up&lt;/span&gt;
                                        +5.2%
                                    &lt;/span&gt;
&lt;span class="text-sm text-[#618975] dark:text-gray-500 ml-2"&gt;vs last month&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- EPF Contributions --&gt;
&lt;div class="flex flex-col gap-4 rounded-xl p-6 bg-white dark:bg-card-dark border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm relative overflow-hidden group"&gt;
&lt;div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity"&gt;
&lt;span class="material-symbols-outlined text-6xl text-blue-500"&gt;work_history&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex justify-between items-start z-10"&gt;
&lt;p class="text-[#618975] dark:text-gray-400 text-sm font-bold uppercase tracking-wider"&gt;YTD EPF (KWSP)&lt;/p&gt;
&lt;/div&gt;
&lt;div class="z-10"&gt;
&lt;p class="text-[#111814] dark:text-white text-3xl font-bold leading-tight"&gt;RM 12,400.00&lt;/p&gt;
&lt;div class="flex items-center gap-1 mt-2"&gt;
&lt;span class="bg-[#e6fdec] text-[#07882c] text-xs font-bold px-2 py-1 rounded-full flex items-center"&gt;
&lt;span class="material-symbols-outlined text-[14px] mr-1"&gt;trending_up&lt;/span&gt;
                                        +8.1%
                                    &lt;/span&gt;
&lt;span class="text-sm text-[#618975] dark:text-gray-500 ml-2"&gt;Consistent&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Zakat --&gt;
&lt;div class="flex flex-col gap-4 rounded-xl p-6 bg-white dark:bg-card-dark border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm relative overflow-hidden group"&gt;
&lt;div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity"&gt;
&lt;span class="material-symbols-outlined text-6xl text-purple-500"&gt;volunteer_activism&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex justify-between items-start z-10"&gt;
&lt;p class="text-[#618975] dark:text-gray-400 text-sm font-bold uppercase tracking-wider"&gt;YTD Zakat Paid&lt;/p&gt;
&lt;/div&gt;
&lt;div class="z-10"&gt;
&lt;p class="text-[#111814] dark:text-white text-3xl font-bold leading-tight"&gt;RM 1,200.00&lt;/p&gt;
&lt;div class="flex items-center gap-1 mt-2"&gt;
&lt;span class="bg-[#e6fdec] text-[#07882c] text-xs font-bold px-2 py-1 rounded-full flex items-center"&gt;
&lt;span class="material-symbols-outlined text-[14px] mr-1"&gt;check_circle&lt;/span&gt;
                                        Eligible
                                    &lt;/span&gt;
&lt;span class="text-sm text-[#618975] dark:text-gray-500 ml-2"&gt;for Tax Rebate&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Detailed Breakdown Grid --&gt;
&lt;div class="grid grid-cols-1 lg:grid-cols-2 gap-8"&gt;
&lt;!-- EPF Breakdown Card --&gt;
&lt;div class="bg-white dark:bg-card-dark rounded-xl border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm p-6"&gt;
&lt;div class="flex justify-between items-center mb-6"&gt;
&lt;h3 class="text-[#111814] dark:text-white text-lg font-bold"&gt;EPF Account Distribution&lt;/h3&gt;
&lt;button class="text-primary text-sm font-semibold hover:underline"&gt;View Statement&lt;/button&gt;
&lt;/div&gt;
&lt;div class="flex flex-col gap-6"&gt;
&lt;!-- Acct 1 --&gt;
&lt;div&gt;
&lt;div class="flex justify-between items-end mb-2"&gt;
&lt;span class="text-sm font-medium text-text-main dark:text-white"&gt;Account 1 (70%)&lt;/span&gt;
&lt;span class="text-sm font-bold text-text-main dark:text-white"&gt;RM 8,680.00&lt;/span&gt;
&lt;/div&gt;
&lt;div class="h-3 w-full bg-[#f0f4f2] dark:bg-[#333] rounded-full overflow-hidden"&gt;
&lt;div class="h-full bg-blue-600 rounded-full" style="width: 70%"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;p class="text-xs text-text-muted mt-1"&gt;Retirement specific savings&lt;/p&gt;
&lt;/div&gt;
&lt;!-- Acct 2 --&gt;
&lt;div&gt;
&lt;div class="flex justify-between items-end mb-2"&gt;
&lt;span class="text-sm font-medium text-text-main dark:text-white"&gt;Account 2 (30%)&lt;/span&gt;
&lt;span class="text-sm font-bold text-text-main dark:text-white"&gt;RM 3,720.00&lt;/span&gt;
&lt;/div&gt;
&lt;div class="h-3 w-full bg-[#f0f4f2] dark:bg-[#333] rounded-full overflow-hidden"&gt;
&lt;div class="h-full bg-blue-400 rounded-full" style="width: 30%"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;p class="text-xs text-text-muted mt-1"&gt;Available for housing, education, medical&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="mt-6 pt-6 border-t border-[#f0f4f2] dark:border-[#333] grid grid-cols-2 gap-4"&gt;
&lt;div&gt;
&lt;p class="text-xs text-text-muted"&gt;Employer Share (13%)&lt;/p&gt;
&lt;p class="font-bold text-text-main dark:text-white"&gt;RM 1,612.00&lt;/p&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;p class="text-xs text-text-muted"&gt;Employee Share (11%)&lt;/p&gt;
&lt;p class="font-bold text-text-main dark:text-white"&gt;RM 1,364.00&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Tax Relief &amp; Goals Card --&gt;
&lt;div class="bg-white dark:bg-card-dark rounded-xl border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm p-6"&gt;
&lt;div class="flex justify-between items-center mb-6"&gt;
&lt;h3 class="text-[#111814] dark:text-white text-lg font-bold"&gt;Tax Relief Tracker (YA 2024)&lt;/h3&gt;
&lt;button class="text-primary text-sm font-semibold hover:underline"&gt;Settings&lt;/button&gt;
&lt;/div&gt;
&lt;div class="flex flex-col gap-6"&gt;
&lt;!-- Life Insurance / EPF --&gt;
&lt;div class="relative"&gt;
&lt;div class="flex justify-between items-end mb-2"&gt;
&lt;div class="flex items-center gap-2"&gt;
&lt;span class="material-symbols-outlined text-sm text-text-muted"&gt;shield&lt;/span&gt;
&lt;span class="text-sm font-medium text-text-main dark:text-white"&gt;Life Insurance &amp;amp; EPF&lt;/span&gt;
&lt;/div&gt;
&lt;span class="text-sm font-bold text-text-main dark:text-white"&gt;RM 3,500 / RM 4,000&lt;/span&gt;
&lt;/div&gt;
&lt;div class="h-3 w-full bg-[#f0f4f2] dark:bg-[#333] rounded-full overflow-hidden"&gt;
&lt;div class="h-full bg-primary rounded-full" style="width: 87.5%"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;div class="flex justify-between mt-1"&gt;
&lt;span class="text-xs text-text-muted"&gt;87.5% Utilized&lt;/span&gt;
&lt;span class="text-xs text-primary font-medium"&gt;RM 500 left to max&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- SSPN --&gt;
&lt;div class="relative"&gt;
&lt;div class="flex justify-between items-end mb-2"&gt;
&lt;div class="flex items-center gap-2"&gt;
&lt;span class="material-symbols-outlined text-sm text-text-muted"&gt;school&lt;/span&gt;
&lt;span class="text-sm font-medium text-text-main dark:text-white"&gt;SSPN Savings&lt;/span&gt;
&lt;/div&gt;
&lt;span class="text-sm font-bold text-text-main dark:text-white"&gt;RM 2,000 / RM 8,000&lt;/span&gt;
&lt;/div&gt;
&lt;div class="h-3 w-full bg-[#f0f4f2] dark:bg-[#333] rounded-full overflow-hidden"&gt;
&lt;div class="h-full bg-yellow-400 rounded-full" style="width: 25%"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;div class="flex justify-between mt-1"&gt;
&lt;span class="text-xs text-text-muted"&gt;25% Utilized&lt;/span&gt;
&lt;span class="text-xs text-text-muted font-medium"&gt;RM 6,000 left to max&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Promo/Alert --&gt;
&lt;div class="mt-6 p-3 bg-background-light dark:bg-[#15221d] rounded-lg border border-dashed border-primary/30 flex items-start gap-3"&gt;
&lt;span class="material-symbols-outlined text-primary mt-0.5"&gt;info&lt;/span&gt;
&lt;div&gt;
&lt;p class="text-sm font-semibold text-text-main dark:text-white"&gt;Maximize your relief!&lt;/p&gt;
&lt;p class="text-xs text-text-muted"&gt;You can save RM 1,200 more in PRS to reach the RM 3,000 limit.&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Recent Transactions Section --&gt;
&lt;div class="flex flex-col gap-4"&gt;
&lt;div class="flex items-center justify-between px-2"&gt;
&lt;h2 class="text-[#111814] dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em]"&gt;Recent Contributions&lt;/h2&gt;
&lt;a class="text-primary text-sm font-bold hover:underline" href="#"&gt;View All&lt;/a&gt;
&lt;/div&gt;
&lt;div class="overflow-hidden rounded-xl border border-[#e5e7eb] dark:border-[#2a3c32] shadow-sm bg-white dark:bg-card-dark"&gt;
&lt;table class="w-full text-left text-sm"&gt;
&lt;thead class="bg-background-light dark:bg-[#23332a] text-[#111814] dark:text-white border-b border-[#e5e7eb] dark:border-[#2a3c32]"&gt;
&lt;tr&gt;
&lt;th class="px-6 py-4 font-semibold"&gt;Date&lt;/th&gt;
&lt;th class="px-6 py-4 font-semibold"&gt;Type&lt;/th&gt;
&lt;th class="px-6 py-4 font-semibold hidden md:table-cell"&gt;Reference / Description&lt;/th&gt;
&lt;th class="px-6 py-4 font-semibold"&gt;Status&lt;/th&gt;
&lt;th class="px-6 py-4 font-semibold text-right"&gt;Amount&lt;/th&gt;
&lt;/tr&gt;
&lt;/thead&gt;
&lt;tbody class="divide-y divide-[#e5e7eb] dark:divide-[#2a3c32]"&gt;
&lt;tr class="hover:bg-gray-50 dark:hover:bg-[#23332a] transition-colors"&gt;
&lt;td class="px-6 py-4 text-[#111814] dark:text-white whitespace-nowrap"&gt;Oct 24, 2023&lt;/td&gt;
&lt;td class="px-6 py-4"&gt;
&lt;div class="flex items-center gap-2"&gt;
&lt;div class="size-2 rounded-full bg-blue-500"&gt;&lt;/div&gt;
&lt;span class="font-medium text-[#111814] dark:text-white"&gt;EPF Contribution&lt;/span&gt;
&lt;/div&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-[#618975] hidden md:table-cell"&gt;Monthly Salary Deduction (Oct)&lt;/td&gt;
&lt;td class="px-6 py-4"&gt;
&lt;span class="inline-flex items-center rounded-md bg-[#e6fdec] dark:bg-[#103020] px-2 py-1 text-xs font-medium text-[#07882c] dark:text-[#13ec80] ring-1 ring-inset ring-green-600/20"&gt;Cleared&lt;/span&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 font-bold text-[#111814] dark:text-white text-right font-mono"&gt;+ RM 1,120.00&lt;/td&gt;
&lt;/tr&gt;
&lt;tr class="hover:bg-gray-50 dark:hover:bg-[#23332a] transition-colors"&gt;
&lt;td class="px-6 py-4 text-[#111814] dark:text-white whitespace-nowrap"&gt;Oct 15, 2023&lt;/td&gt;
&lt;td class="px-6 py-4"&gt;
&lt;div class="flex items-center gap-2"&gt;
&lt;div class="size-2 rounded-full bg-purple-500"&gt;&lt;/div&gt;
&lt;span class="font-medium text-[#111814] dark:text-white"&gt;Zakat Pendapatan&lt;/span&gt;
&lt;/div&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-[#618975] hidden md:table-cell"&gt;PPZ Online Payment #88291&lt;/td&gt;
&lt;td class="px-6 py-4"&gt;
&lt;span class="inline-flex items-center rounded-md bg-[#e6fdec] dark:bg-[#103020] px-2 py-1 text-xs font-medium text-[#07882c] dark:text-[#13ec80] ring-1 ring-inset ring-green-600/20"&gt;Cleared&lt;/span&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 font-bold text-[#111814] dark:text-white text-right font-mono"&gt;+ RM 250.00&lt;/td&gt;
&lt;/tr&gt;
&lt;tr class="hover:bg-gray-50 dark:hover:bg-[#23332a] transition-colors"&gt;
&lt;td class="px-6 py-4 text-[#111814] dark:text-white whitespace-nowrap"&gt;Oct 01, 2023&lt;/td&gt;
&lt;td class="px-6 py-4"&gt;
&lt;div class="flex items-center gap-2"&gt;
&lt;div class="size-2 rounded-full bg-yellow-500"&gt;&lt;/div&gt;
&lt;span class="font-medium text-[#111814] dark:text-white"&gt;ASB Saving&lt;/span&gt;
&lt;/div&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-[#618975] hidden md:table-cell"&gt;Recurring Transfer - Maybank&lt;/td&gt;
&lt;td class="px-6 py-4"&gt;
&lt;span class="inline-flex items-center rounded-md bg-[#e6fdec] dark:bg-[#103020] px-2 py-1 text-xs font-medium text-[#07882c] dark:text-[#13ec80] ring-1 ring-inset ring-green-600/20"&gt;Cleared&lt;/span&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 font-bold text-[#111814] dark:text-white text-right font-mono"&gt;+ RM 500.00&lt;/td&gt;
&lt;/tr&gt;
&lt;tr class="hover:bg-gray-50 dark:hover:bg-[#23332a] transition-colors"&gt;
&lt;td class="px-6 py-4 text-[#111814] dark:text-white whitespace-nowrap"&gt;Sep 24, 2023&lt;/td&gt;
&lt;td class="px-6 py-4"&gt;
&lt;div class="flex items-center gap-2"&gt;
&lt;div class="size-2 rounded-full bg-blue-500"&gt;&lt;/div&gt;
&lt;span class="font-medium text-[#111814] dark:text-white"&gt;EPF Contribution&lt;/span&gt;
&lt;/div&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 text-[#618975] hidden md:table-cell"&gt;Monthly Salary Deduction (Sep)&lt;/td&gt;
&lt;td class="px-6 py-4"&gt;
&lt;span class="inline-flex items-center rounded-md bg-[#e6fdec] dark:bg-[#103020] px-2 py-1 text-xs font-medium text-[#07882c] dark:text-[#13ec80] ring-1 ring-inset ring-green-600/20"&gt;Cleared&lt;/span&gt;
&lt;/td&gt;
&lt;td class="px-6 py-4 font-bold text-[#111814] dark:text-white text-right font-mono"&gt;+ RM 1,120.00&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Quick Actions Grid --&gt;
&lt;div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"&gt;
&lt;div class="bg-primary/10 dark:bg-primary/20 rounded-lg p-4 flex flex-col items-center justify-center gap-2 cursor-pointer hover:bg-primary/20 transition-colors border border-primary/20"&gt;
&lt;span class="material-symbols-outlined text-primary text-3xl"&gt;savings&lt;/span&gt;
&lt;span class="text-sm font-bold text-[#111814] dark:text-white"&gt;Add Savings&lt;/span&gt;
&lt;/div&gt;
&lt;div class="bg-white dark:bg-card-dark rounded-lg p-4 flex flex-col items-center justify-center gap-2 cursor-pointer hover:bg-gray-50 dark:hover:bg-[#2a3c32] transition-colors border border-[#e5e7eb] dark:border-[#2a3c32] group"&gt;
&lt;span class="material-symbols-outlined text-gray-400 group-hover:text-primary transition-colors text-3xl"&gt;calculate&lt;/span&gt;
&lt;span class="text-sm font-medium text-[#111814] dark:text-white"&gt;Tax Calculator&lt;/span&gt;
&lt;/div&gt;
&lt;div class="bg-white dark:bg-card-dark rounded-lg p-4 flex flex-col items-center justify-center gap-2 cursor-pointer hover:bg-gray-50 dark:hover:bg-[#2a3c32] transition-colors border border-[#e5e7eb] dark:border-[#2a3c32] group"&gt;
&lt;span class="material-symbols-outlined text-gray-400 group-hover:text-primary transition-colors text-3xl"&gt;account_balance&lt;/span&gt;
&lt;span class="text-sm font-medium text-[#111814] dark:text-white"&gt;Link Bank&lt;/span&gt;
&lt;/div&gt;
&lt;div class="bg-white dark:bg-card-dark rounded-lg p-4 flex flex-col items-center justify-center gap-2 cursor-pointer hover:bg-gray-50 dark:hover:bg-[#2a3c32] transition-colors border border-[#e5e7eb] dark:border-[#2a3c32] group"&gt;
&lt;span class="material-symbols-outlined text-gray-400 group-hover:text-primary transition-colors text-3xl"&gt;description&lt;/span&gt;
&lt;span class="text-sm font-medium text-[#111814] dark:text-white"&gt;Download EA Form&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
@endsection
