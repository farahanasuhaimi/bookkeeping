@extends('layouts.app')

@section('title', 'TaxWise - Add New Expense')

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
                        "primary-hover": "#0fd671",
                        "background-light": "#f6f8f7",
                        "background-dark": "#102219",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1A2E24",
                        "border-light": "#dbe6e0",
                        "border-dark": "#2A4536",
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        /* Custom scrollbar for sidebar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.1);
            border-radius: 20px;
        }
    &lt;/style&gt;

&lt;div class="flex h-screen w-full overflow-hidden"&gt;
&lt;!-- Side Navigation --&gt;
&lt;aside class="hidden w-64 flex-col border-r border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark lg:flex transition-colors duration-200"&gt;
&lt;div class="flex h-16 items-center px-6 border-b border-border-light dark:border-border-dark"&gt;
&lt;div class="flex flex-col"&gt;
&lt;h1 class="text-[#111814] dark:text-white text-lg font-bold leading-normal"&gt;TaxWise&lt;/h1&gt;
&lt;p class="text-[#618975] dark:text-primary/80 text-xs font-normal leading-normal"&gt;MY Edition&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;nav class="flex-1 overflow-y-auto px-4 py-6 gap-2 flex flex-col"&gt;
&lt;a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-background-light dark:hover:bg-background-dark/50 transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined"&gt;pie_chart&lt;/span&gt;
&lt;span class="text-sm font-medium"&gt;Dashboard&lt;/span&gt;
&lt;/a&gt;
&lt;a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/10 text-slate-900 dark:text-primary font-semibold" href="#"&gt;
&lt;span class="material-symbols-outlined icon-filled text-primary"&gt;attach_money&lt;/span&gt;
&lt;span class="text-sm"&gt;Expenses&lt;/span&gt;
&lt;/a&gt;
&lt;a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-background-light dark:hover:bg-background-dark/50 transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined"&gt;description&lt;/span&gt;
&lt;span class="text-sm font-medium"&gt;Invoices&lt;/span&gt;
&lt;/a&gt;
&lt;a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-background-light dark:hover:bg-background-dark/50 transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined"&gt;bar_chart&lt;/span&gt;
&lt;span class="text-sm font-medium"&gt;Reports&lt;/span&gt;
&lt;/a&gt;
&lt;div class="pt-4 mt-auto border-t border-border-light dark:border-border-dark"&gt;
&lt;a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-background-light dark:hover:bg-background-dark/50 transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined"&gt;settings&lt;/span&gt;
&lt;span class="text-sm font-medium"&gt;Settings&lt;/span&gt;
&lt;/a&gt;
&lt;/div&gt;
&lt;/nav&gt;
&lt;/aside&gt;
&lt;!-- Main Content Wrapper --&gt;
&lt;div class="flex flex-1 flex-col h-full overflow-hidden relative"&gt;
&lt;!-- Top Header --&gt;
&lt;header class="h-16 flex items-center justify-between border-b border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark px-6 lg:px-10 shrink-0 z-10"&gt;
&lt;div class="flex items-center gap-4 lg:hidden"&gt;
&lt;button class="text-slate-500 hover:text-primary"&gt;
&lt;span class="material-symbols-outlined"&gt;menu&lt;/span&gt;
&lt;/button&gt;
&lt;h2 class="text-lg font-bold"&gt;TaxWise&lt;/h2&gt;
&lt;/div&gt;
&lt;!-- Breadcrumbs (Desktop only in header, or separate) --&gt;
&lt;div class="hidden lg:flex items-center text-sm"&gt;
&lt;!-- Placeholder for left header content if needed --&gt;
&lt;/div&gt;
&lt;div class="flex flex-1 justify-end gap-6 items-center"&gt;
&lt;button class="relative flex h-10 w-10 items-center justify-center rounded-full hover:bg-background-light dark:hover:bg-background-dark/50 text-slate-600 dark:text-slate-300 transition-colors"&gt;
&lt;span class="material-symbols-outlined"&gt;notifications&lt;/span&gt;
&lt;span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 border-2 border-white dark:border-surface-dark"&gt;&lt;/span&gt;
&lt;/button&gt;
&lt;div class="h-8 w-8 rounded-full bg-cover bg-center border border-border-light dark:border-border-dark" data-alt="User profile photo showing a smiling professional" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCIRSIeIRm80xgyRY-5xjc8d1hqOQCmA0ckmLkCWniR79z8TrXHo1wj--tJQ3dDdBXi2AY6lBwZCHH49V-XkvzPXbDJ1Nb9Lz8cKnElrhRwXFQ6UXBluzsDZtkRa5kWeClYs5wBY18lgMeAj5MkFBTUKgqy500BvlEjvhdHKPLm2lweupSLc8JljfVAmdvFuIXHJ4NFX6iDCJdpDOKgj0Z6vSHSt96cV3qzXDom52VlyKCZA9FTJXe1RJPdnBynD-wLqVeTszBzuF4");'&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/header&gt;
&lt;!-- Scrollable Page Content --&gt;
&lt;main class="flex-1 overflow-y-auto p-4 lg:p-10 scroll-smooth"&gt;
&lt;div class="max-w-5xl mx-auto space-y-6"&gt;
&lt;!-- Breadcrumbs --&gt;
&lt;div class="flex items-center gap-2 text-sm"&gt;
&lt;a class="text-[#618975] dark:text-slate-400 hover:text-primary font-medium transition-colors" href="#"&gt;Home&lt;/a&gt;
&lt;span class="text-slate-300 dark:text-slate-600"&gt;/&lt;/span&gt;
&lt;a class="text-[#618975] dark:text-slate-400 hover:text-primary font-medium transition-colors" href="#"&gt;Expenses&lt;/a&gt;
&lt;span class="text-slate-300 dark:text-slate-600"&gt;/&lt;/span&gt;
&lt;span class="text-[#111814] dark:text-white font-medium"&gt;Add New&lt;/span&gt;
&lt;/div&gt;
&lt;!-- Page Heading --&gt;
&lt;div class="flex flex-col gap-2"&gt;
&lt;h1 class="text-3xl lg:text-4xl font-black tracking-tight text-[#111814] dark:text-white"&gt;Record New Expense&lt;/h1&gt;
&lt;p class="text-[#618975] dark:text-slate-400 text-base max-w-2xl"&gt;
                            Enter details for your business expenditure. Ensure tax details are accurate for LHDN reporting.
                        &lt;/p&gt;
&lt;/div&gt;
&lt;!-- Form Card --&gt;
&lt;div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-border-light dark:border-border-dark overflow-hidden"&gt;
&lt;!-- Form Header (Optional) --&gt;
&lt;div class="px-6 py-4 border-b border-border-light dark:border-border-dark bg-slate-50/50 dark:bg-white/5 flex justify-between items-center"&gt;
&lt;h3 class="font-semibold text-lg"&gt;Expense Details&lt;/h3&gt;
&lt;span class="text-xs font-medium px-2 py-1 rounded bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200"&gt;Draft&lt;/span&gt;
&lt;/div&gt;
&lt;div class="p-6 lg:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6"&gt;
&lt;!-- Amount --&gt;
&lt;div class="flex flex-col gap-2"&gt;
&lt;label class="text-sm font-semibold text-[#111814] dark:text-slate-200"&gt;Amount (MYR) &lt;span class="text-red-500"&gt;*&lt;/span&gt;&lt;/label&gt;
&lt;div class="relative"&gt;
&lt;div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"&gt;
&lt;span class="text-slate-500 font-medium"&gt;RM&lt;/span&gt;
&lt;/div&gt;
&lt;input class="w-full pl-10 pr-4 py-3 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-[#111814] dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" placeholder="0.00" step="0.01" type="number"/&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Date --&gt;
&lt;div class="flex flex-col gap-2"&gt;
&lt;label class="text-sm font-semibold text-[#111814] dark:text-slate-200"&gt;Date of Transaction &lt;span class="text-red-500"&gt;*&lt;/span&gt;&lt;/label&gt;
&lt;div class="relative"&gt;
&lt;input class="w-full pl-4 pr-10 py-3 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-[#111814] dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all [color-scheme:light] dark:[color-scheme:dark]" type="date"/&gt;
&lt;div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"&gt;
&lt;span class="material-symbols-outlined text-slate-400"&gt;calendar_today&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Category --&gt;
&lt;div class="flex flex-col gap-2"&gt;
&lt;label class="text-sm font-semibold text-[#111814] dark:text-slate-200"&gt;Expense Category &lt;span class="text-red-500"&gt;*&lt;/span&gt;&lt;/label&gt;
&lt;div class="relative"&gt;
&lt;select class="w-full pl-4 pr-10 py-3 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-[#111814] dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none transition-all"&gt;
&lt;option disabled="" selected="" value=""&gt;Select a category&lt;/option&gt;
&lt;option value="office"&gt;Office Supplies&lt;/option&gt;
&lt;option value="travel"&gt;Travel &amp;amp; Transport&lt;/option&gt;
&lt;option value="meals"&gt;Meals &amp;amp; Entertainment&lt;/option&gt;
&lt;option value="utilities"&gt;Utilities&lt;/option&gt;
&lt;option value="rent"&gt;Rent&lt;/option&gt;
&lt;option value="marketing"&gt;Marketing&lt;/option&gt;
&lt;/select&gt;
&lt;div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"&gt;
&lt;span class="material-symbols-outlined text-slate-400"&gt;expand_more&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Vendor --&gt;
&lt;div class="flex flex-col gap-2"&gt;
&lt;label class="text-sm font-semibold text-[#111814] dark:text-slate-200"&gt;Vendor / Payee&lt;/label&gt;
&lt;div class="relative"&gt;
&lt;input class="w-full pl-4 pr-4 py-3 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-[#111814] dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" placeholder="e.g. TNB, Grab, Shopee" type="text"/&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Description (Full width) --&gt;
&lt;div class="flex flex-col gap-2 md:col-span-2"&gt;
&lt;label class="text-sm font-semibold text-[#111814] dark:text-slate-200"&gt;Description&lt;/label&gt;
&lt;textarea class="w-full p-4 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-slate-900 text-[#111814] dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none transition-all" placeholder="Enter additional details regarding this expense..." rows="3"&gt;&lt;/textarea&gt;
&lt;/div&gt;
&lt;!-- Tax Compliance Section (Full width) --&gt;
&lt;div class="md:col-span-2 mt-2"&gt;
&lt;div class="rounded-xl border border-primary/30 bg-primary/5 dark:bg-primary/10 p-5 flex flex-col sm:flex-row gap-4 items-start sm:items-center transition-colors"&gt;
&lt;div class="relative flex items-center"&gt;
&lt;input class="peer h-6 w-6 cursor-pointer appearance-none rounded border border-primary text-primary focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-all checked:bg-primary checked:border-transparent" id="tax-deductible" type="checkbox"/&gt;
&lt;span class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 peer-checked:opacity-100 material-symbols-outlined text-lg font-bold"&gt;check&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex-1"&gt;
&lt;label class="block text-base font-bold text-[#111814] dark:text-white cursor-pointer" for="tax-deductible"&gt;
                                            Tax-Deductible Expense (Qualifying Expenditure)
                                        &lt;/label&gt;
&lt;p class="text-sm text-[#618975] dark:text-slate-400 mt-1"&gt;
                                            Check this if this expense qualifies for tax deduction under &lt;span class="font-medium text-slate-800 dark:text-slate-200"&gt;Income Tax Act 1967&lt;/span&gt;.
                                        &lt;/p&gt;
&lt;/div&gt;
&lt;div class="hidden sm:block"&gt;
&lt;span class="material-symbols-outlined text-primary text-4xl opacity-50"&gt;verified_user&lt;/span&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Receipt Upload (Full width) --&gt;
&lt;div class="md:col-span-2"&gt;
&lt;label class="text-sm font-semibold text-[#111814] dark:text-slate-200 mb-2 block"&gt;Receipt / Invoice&lt;/label&gt;
&lt;div class="border-2 border-dashed border-border-light dark:border-border-dark hover:border-primary dark:hover:border-primary rounded-xl p-8 flex flex-col items-center justify-center text-center cursor-pointer bg-slate-50 dark:bg-slate-900/50 hover:bg-white dark:hover:bg-slate-900 transition-all group"&gt;
&lt;div class="bg-white dark:bg-slate-800 p-3 rounded-full shadow-sm mb-3 group-hover:scale-110 transition-transform duration-200"&gt;
&lt;span class="material-symbols-outlined text-3xl text-primary"&gt;cloud_upload&lt;/span&gt;
&lt;/div&gt;
&lt;p class="text-sm font-medium text-[#111814] dark:text-white"&gt;Click to upload or drag and drop&lt;/p&gt;
&lt;p class="text-xs text-[#618975] dark:text-slate-500 mt-1"&gt;PDF, PNG, JPG up to 10MB&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Action Bar --&gt;
&lt;div class="px-6 py-5 bg-slate-50 dark:bg-slate-900 border-t border-border-light dark:border-border-dark flex flex-col-reverse sm:flex-row sm:justify-end gap-3"&gt;
&lt;button class="px-6 py-2.5 rounded-lg text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors"&gt;
                                Cancel
                            &lt;/button&gt;
&lt;button class="px-6 py-2.5 rounded-lg text-sm font-bold text-primary border border-primary hover:bg-primary/10 transition-colors"&gt;
                                Save &amp;amp; Add Another
                            &lt;/button&gt;
&lt;button class="px-6 py-2.5 rounded-lg text-sm font-bold bg-primary text-[#111814] hover:bg-primary-hover shadow-sm hover:shadow transition-all flex items-center justify-center gap-2"&gt;
&lt;span class="material-symbols-outlined text-lg"&gt;save&lt;/span&gt;
                                Save Expense
                            &lt;/button&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Helper Links --&gt;
&lt;div class="flex justify-center gap-6 pt-4 pb-8"&gt;
&lt;a class="text-xs text-[#618975] dark:text-slate-500 hover:text-primary underline" href="#"&gt;LHDN Tax Guidelines&lt;/a&gt;
&lt;a class="text-xs text-[#618975] dark:text-slate-500 hover:text-primary underline" href="#"&gt;Expense Categories Help&lt;/a&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/main&gt;
&lt;/div&gt;
&lt;/div&gt;
@endsection
