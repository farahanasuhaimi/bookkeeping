@extends('layouts.app')

@section('title', 'Add Income - TaxKeep')

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
              "primary-dark": "#0ea659", // Darker shade for better contrast on white text if needed
              "background-light": "#f6f8f7",
              "background-dark": "#102219",
              "card-light": "#ffffff",
              "card-dark": "#162e22",
              "text-primary-light": "#111814",
              "text-secondary-light": "#618975",
              "text-primary-dark": "#e0e7e3",
              "text-secondary-dark": "#8fa899",
              "border-light": "#e5e7eb",
              "border-dark": "#2a4034",
            },
            fontFamily: {
              "display": ["Inter", "sans-serif"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "2xl": "1rem", "full": "9999px"},
          },
        },
      }
    &lt;/script&gt;
&lt;style&gt;
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    &lt;/style&gt;

&lt;div class="flex h-screen w-full overflow-hidden"&gt;
&lt;!-- SideNavBar --&gt;
&lt;div class="hidden md:flex flex-col w-64 border-r border-border-light dark:border-border-dark bg-card-light dark:bg-card-dark transition-colors duration-200"&gt;
&lt;div class="p-6"&gt;
&lt;div class="flex items-center gap-3 mb-8"&gt;
&lt;div class="bg-primary/20 flex items-center justify-center rounded-xl size-10 text-primary"&gt;
&lt;span class="material-symbols-outlined"&gt;account_balance_wallet&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;h1 class="text-text-primary-light dark:text-text-primary-dark font-bold text-lg"&gt;TaxKeep&lt;/h1&gt;
&lt;p class="text-text-secondary-light dark:text-text-secondary-dark text-xs"&gt;My Business&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;nav class="flex flex-col gap-2"&gt;
&lt;a class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary-light dark:text-text-secondary-dark hover:bg-background-light dark:hover:bg-background-dark transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined text-[20px]"&gt;dashboard&lt;/span&gt;
&lt;span class="font-medium text-sm"&gt;Dashboard&lt;/span&gt;
&lt;/a&gt;
&lt;a class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary text-[#064e2a] font-semibold transition-colors shadow-sm" href="#"&gt;
&lt;span class="material-symbols-outlined text-[20px] font-semibold"&gt;payments&lt;/span&gt;
&lt;span class="text-sm"&gt;Income&lt;/span&gt;
&lt;/a&gt;
&lt;a class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary-light dark:text-text-secondary-dark hover:bg-background-light dark:hover:bg-background-dark transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined text-[20px]"&gt;receipt_long&lt;/span&gt;
&lt;span class="font-medium text-sm"&gt;Expenses&lt;/span&gt;
&lt;/a&gt;
&lt;a class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary-light dark:text-text-secondary-dark hover:bg-background-light dark:hover:bg-background-dark transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined text-[20px]"&gt;description&lt;/span&gt;
&lt;span class="font-medium text-sm"&gt;Tax Summary&lt;/span&gt;
&lt;/a&gt;
&lt;a class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-secondary-light dark:text-text-secondary-dark hover:bg-background-light dark:hover:bg-background-dark transition-colors" href="#"&gt;
&lt;span class="material-symbols-outlined text-[20px]"&gt;settings&lt;/span&gt;
&lt;span class="font-medium text-sm"&gt;Settings&lt;/span&gt;
&lt;/a&gt;
&lt;/nav&gt;
&lt;/div&gt;
&lt;div class="mt-auto p-6 border-t border-border-light dark:border-border-dark"&gt;
&lt;div class="flex items-center gap-3"&gt;
&lt;div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" data-alt="User profile picture showing a professional headshot" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBeOab8NTBJiFQTopW5G3MhAJH_KSizYLdznt2mLOg0dW0FmRp9WJKMrNeUUbEPAQxorEy7i46IbH507picgTdFYRIjAtKW41-7U5cGRdizXb5HOhO8tUzlo1Otjl0_ucTijToFhYBGdon3kAhup0nSjLCm9EOmragL6YTrnBDURbaLIDzs2uL46dP3LyBMFwXk497x-g114z4lFv4oYyl9jZ31b9oHr10-wVBOajp_CoB4tTp9RN_5vRpvfyUiFa8Nqx2cgsBp1SA");'&gt;&lt;/div&gt;
&lt;div class="flex flex-col"&gt;
&lt;p class="text-text-primary-light dark:text-text-primary-dark text-sm font-medium"&gt;Alex Tan&lt;/p&gt;
&lt;p class="text-text-secondary-light dark:text-text-secondary-dark text-xs"&gt;alex@tan.com&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Main Content --&gt;
&lt;div class="flex flex-col flex-1 h-full overflow-hidden bg-background-light dark:bg-background-dark relative"&gt;
&lt;!-- TopNavBar (Mobile only mostly, or global actions) --&gt;
&lt;header class="flex items-center justify-between px-6 py-4 bg-card-light dark:bg-card-dark border-b border-border-light dark:border-border-dark lg:hidden"&gt;
&lt;div class="flex items-center gap-3"&gt;
&lt;span class="material-symbols-outlined text-text-primary-light dark:text-text-primary-dark"&gt;menu&lt;/span&gt;
&lt;h2 class="text-text-primary-light dark:text-text-primary-dark font-bold text-lg"&gt;TaxKeep&lt;/h2&gt;
&lt;/div&gt;
&lt;div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-8" data-alt="User profile picture" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDygF0JKzRyA3puJZ--Z1uEmzkdUwW1Opwjni1mqy26ahEEvFa-IIWpZ_hLZwkuS8n3Lj_KGNmDK14mrfIwujDZ43bV9laESarrnPmdSxpZA9hsnthGBbqski6W5kvyJA-ynj2iRWt5AvNXWcb3lBQoY7_059e070Ou4ayh4uyfjhmguLmb_WI3lnyUy4ohhDc_NnPrfaKdbZeE03dpHOz3Dm6XQcGiDSL6CHG0eKCHTi6nkh5J_VJxDbdG1872CehUL14hPoTi-jw");'&gt;&lt;/div&gt;
&lt;/header&gt;
&lt;!-- Main Scrollable Area --&gt;
&lt;main class="flex-1 overflow-y-auto no-scrollbar p-4 md:p-8 lg:px-12 xl:px-24"&gt;
&lt;div class="max-w-4xl mx-auto flex flex-col gap-6"&gt;
&lt;!-- PageHeading --&gt;
&lt;div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4"&gt;
&lt;div class="flex flex-col gap-2"&gt;
&lt;div class="flex items-center gap-2 text-text-secondary-light dark:text-text-secondary-dark text-sm"&gt;
&lt;span class="material-symbols-outlined text-sm"&gt;arrow_back&lt;/span&gt;
&lt;span&gt;Back to Income List&lt;/span&gt;
&lt;/div&gt;
&lt;h1 class="text-text-primary-light dark:text-text-primary-dark text-3xl md:text-4xl font-black tracking-tight"&gt;Add New Income&lt;/h1&gt;
&lt;p class="text-text-secondary-light dark:text-text-secondary-dark text-base"&gt;Record your earnings for accurate Malaysian tax reporting.&lt;/p&gt;
&lt;/div&gt;
&lt;div class="flex gap-3"&gt;
&lt;button class="px-4 py-2 rounded-lg border border-border-light dark:border-border-dark text-text-primary-light dark:text-text-primary-dark font-medium hover:bg-background-light dark:hover:bg-background-dark transition-colors"&gt;Cancel&lt;/button&gt;
&lt;button class="px-6 py-2 rounded-lg bg-primary text-[#064e2a] font-bold shadow-lg shadow-primary/20 hover:bg-primary-dark hover:text-white transition-all transform hover:-translate-y-0.5"&gt;Save Record&lt;/button&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Form Container --&gt;
&lt;div class="bg-card-light dark:bg-card-dark rounded-2xl shadow-sm border border-border-light dark:border-border-dark p-6 md:p-8"&gt;
&lt;!-- SegmentedButtons --&gt;
&lt;div class="mb-8"&gt;
&lt;label class="text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-3 block"&gt;Income Category&lt;/label&gt;
&lt;div class="grid grid-cols-1 sm:grid-cols-2 gap-4"&gt;
&lt;!-- Option 1 --&gt;
&lt;label class="relative flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all border-primary bg-primary/5 dark:bg-primary/10"&gt;
&lt;input checked="" class="peer sr-only" name="income_type" type="radio" value="employment"/&gt;
&lt;div class="mt-1 size-5 rounded-full border border-primary flex items-center justify-center peer-checked:bg-primary"&gt;
&lt;div class="size-2.5 rounded-full bg-white"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;div class="flex flex-col"&gt;
&lt;span class="text-text-primary-light dark:text-text-primary-dark font-bold text-base mb-1"&gt;Official Employment&lt;/span&gt;
&lt;span class="text-text-secondary-light dark:text-text-secondary-dark text-sm"&gt;Form BE (Gaji, Bonus, Allowance)&lt;/span&gt;
&lt;/div&gt;
&lt;span class="material-symbols-outlined absolute top-4 right-4 text-primary"&gt;badge&lt;/span&gt;
&lt;/label&gt;
&lt;!-- Option 2 --&gt;
&lt;label class="relative flex items-start gap-4 p-4 rounded-xl border border-border-light dark:border-border-dark hover:bg-background-light dark:hover:bg-background-dark/50 cursor-pointer transition-all"&gt;
&lt;input class="peer sr-only" name="income_type" type="radio" value="business"/&gt;
&lt;div class="mt-1 size-5 rounded-full border border-gray-300 dark:border-gray-600 flex items-center justify-center"&gt;&lt;/div&gt;
&lt;div class="flex flex-col"&gt;
&lt;span class="text-text-primary-light dark:text-text-primary-dark font-medium text-base mb-1"&gt;Part-time / Business&lt;/span&gt;
&lt;span class="text-text-secondary-light dark:text-text-secondary-dark text-sm"&gt;Form B (Freelance, Side Hustle)&lt;/span&gt;
&lt;/div&gt;
&lt;span class="material-symbols-outlined absolute top-4 right-4 text-text-secondary-light dark:text-text-secondary-dark"&gt;storefront&lt;/span&gt;
&lt;/label&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8"&gt;
&lt;!-- Amount Field --&gt;
&lt;div class="col-span-1 md:col-span-2"&gt;
&lt;label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2"&gt;Total Amount (MYR)&lt;/label&gt;
&lt;div class="relative"&gt;
&lt;span class="absolute left-4 top-1/2 -translate-y-1/2 text-text-secondary-light dark:text-text-secondary-dark font-bold text-lg"&gt;RM&lt;/span&gt;
&lt;input class="w-full pl-12 pr-4 py-4 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-3xl font-bold text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-gray-300 dark:placeholder:text-gray-700" placeholder="0.00" type="text"/&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Date Field --&gt;
&lt;div class="col-span-1"&gt;
&lt;label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2"&gt;Date Received&lt;/label&gt;
&lt;div class="relative"&gt;
&lt;input class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" type="date"/&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Source Field --&gt;
&lt;div class="col-span-1"&gt;
&lt;label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2"&gt;Payer / Employer&lt;/label&gt;
&lt;input class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-text-secondary-light dark:placeholder:text-text-secondary-dark" placeholder="e.g. Acme Corp Sdn Bhd" type="text"/&gt;
&lt;/div&gt;
&lt;!-- Description Field --&gt;
&lt;div class="col-span-1 md:col-span-2"&gt;
&lt;label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2"&gt;Description / Reference&lt;/label&gt;
&lt;textarea class="w-full px-4 py-3 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-xl text-text-primary-light dark:text-text-primary-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-text-secondary-light dark:placeholder:text-text-secondary-dark min-h-[100px] resize-none" placeholder="e.g. Monthly Salary for March 2024, Project Alpha completion fee"&gt;&lt;/textarea&gt;
&lt;/div&gt;
&lt;!-- Tax Deduction (PCB) Section - Conditional Style --&gt;
&lt;div class="col-span-1 md:col-span-2 p-5 bg-background-light dark:bg-background-dark rounded-xl border border-border-light dark:border-border-dark border-dashed"&gt;
&lt;div class="flex items-start gap-4"&gt;
&lt;div class="mt-1 text-primary"&gt;
&lt;span class="material-symbols-outlined"&gt;account_balance&lt;/span&gt;
&lt;/div&gt;
&lt;div class="flex-1"&gt;
&lt;h3 class="text-text-primary-light dark:text-text-primary-dark font-semibold text-sm"&gt;Monthly Tax Deduction (PCB)&lt;/h3&gt;
&lt;p class="text-text-secondary-light dark:text-text-secondary-dark text-xs mt-1 mb-3"&gt;If this income has already been taxed via PCB, enter the amount here.&lt;/p&gt;
&lt;div class="flex items-center max-w-[200px] relative"&gt;
&lt;span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary-light dark:text-text-secondary-dark text-sm"&gt;RM&lt;/span&gt;
&lt;input class="w-full pl-10 pr-3 py-2 bg-white dark:bg-[#1f362a] border border-border-light dark:border-border-dark rounded-lg text-sm text-text-primary-light dark:text-text-primary-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="0.00" type="text"/&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Attachment Upload --&gt;
&lt;div class="col-span-1 md:col-span-2"&gt;
&lt;label class="block text-text-primary-light dark:text-text-primary-dark text-sm font-semibold mb-2"&gt;Supporting Documents&lt;/label&gt;
&lt;div class="border-2 border-dashed border-border-light dark:border-border-dark hover:border-primary dark:hover:border-primary rounded-xl p-8 flex flex-col items-center justify-center text-center cursor-pointer transition-colors bg-background-light/50 dark:bg-background-dark/50 group"&gt;
&lt;div class="size-12 rounded-full bg-primary/10 flex items-center justify-center mb-3 group-hover:bg-primary/20 transition-colors"&gt;
&lt;span class="material-symbols-outlined text-primary text-2xl"&gt;upload_file&lt;/span&gt;
&lt;/div&gt;
&lt;p class="text-text-primary-light dark:text-text-primary-dark font-medium text-sm"&gt;Click to upload or drag and drop&lt;/p&gt;
&lt;p class="text-text-secondary-light dark:text-text-secondary-dark text-xs mt-1"&gt;Payslips, Invoices, Bank Statements (PDF, JPG, PNG)&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;!-- Footer Note --&gt;
&lt;div class="flex items-start gap-3 p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-sm"&gt;
&lt;span class="material-symbols-outlined text-lg mt-0.5"&gt;info&lt;/span&gt;
&lt;p&gt;
                        This income will be added to your &lt;strong&gt;Year of Assessment 2024&lt;/strong&gt; calculations. Please ensure the category matches your LHDN filing type (Form B or BE).
                    &lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/main&gt;
&lt;/div&gt;
&lt;/div&gt;
@endsection
