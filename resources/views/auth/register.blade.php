@extends('layouts.app')

@section('title', 'RezTax - Register')

@section('content')
<body class="font-display bg-background-light dark:bg-background-dark text-text-main dark:text-white transition-colors duration-200">
<div class="flex h-screen w-full overflow-hidden">
    <!-- Left Section: Visual/Marketing (Hidden on mobile, visible on lg screens) -->
    <div class="hidden lg:flex w-1/2 relative flex-col justify-between p-12 bg-background-dark">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0 opacity-40">
            <img class="w-full h-full object-cover"
                alt="Modern office desk with financial documents and calculator"
                src="{{ asset('images/background.png') }}" />
            <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-background-dark/80 to-transparent">
            </div>
        </div>
        <!-- Logo Area -->
        <div class="relative z-10 flex items-center gap-3">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary text-background-dark">
                <span class="material-symbols-outlined text-2xl">account_balance_wallet</span>
            </div>
            <span class="text-white text-xl font-bold tracking-tight">RezTax</span>
        </div>
        <!-- Quote Area -->
        <div class="relative z-10 max-w-md">
            <blockquote class="text-2xl font-medium text-white leading-relaxed mb-6 italic">
                "RezTax has revolutionized how we handle our annual LHDN filings. It's compliant, secure, and
                incredibly user-friendly."
            </blockquote>
            <div class="flex items-center gap-4">
                <img class="w-12 h-12 rounded-full border-2 border-primary object-cover"
                    alt="Portrait of Sarah Lim, Financial Director"
                    src="{{ asset('images/sarah-lim.png') }}" />
                <div>
                    <p class="text-white font-bold text-sm">Sarah Lim</p>
                    <p class="text-primary text-xs font-medium italic">Financial Director at KL Tech</p>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="relative z-10 text-xs text-white/40 flex gap-6">
            <a class="hover:text-primary transition-colors italic" href="#">Privacy Policy</a>
            <a class="hover:text-primary transition-colors italic" href="#">Terms of Service</a>
            <span>© 2026 RezTax Malaysia</span>
        </div>
    </div>
    <!-- Right Section: Form -->
    <div class="w-full lg:w-1/2 flex flex-col h-full overflow-y-auto bg-surface-light dark:bg-surface-dark">
        <div class="flex-1 flex flex-col justify-center px-6 sm:px-12 xl:px-32 py-12">
            <!-- Mobile Logo (Visible only on small screens) -->
            <div class="lg:hidden flex items-center gap-2 mb-8">
                <div class="flex items-center justify-center w-8 h-8 rounded bg-primary text-background-dark">
                    <span class="material-symbols-outlined text-xl">account_balance_wallet</span>
                </div>
                <span class="text-text-main dark:text-white text-lg font-bold">RezTax</span>
            </div>
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-text-main dark:text-white text-3xl sm:text-4xl font-black leading-tight tracking-[-0.033em] mb-2 italic">
                    Create your Account</h1>
                <p class="text-text-muted dark:text-gray-400 text-base font-normal">Simplify your Malaysian Tax
                    Filing & Bookkeeping.</p>
            </div>
            <!-- Tabs -->
            <div class="mb-8 border-b border-border-light dark:border-border-dark">
                <div class="flex gap-8">
                    <a href="{{ route('login') }}"
                        class="group flex flex-col items-center justify-center border-b-[3px] border-b-transparent pb-[13px] pt-4 px-2 outline-none focus:outline-none hover:border-b-border-light">
                        <p
                            class="text-text-muted dark:text-gray-400 group-hover:text-text-main dark:group-hover:text-white transition-colors text-sm font-bold leading-normal tracking-[0.015em]">
                            Log In</p>
                    </a>
                    <a href="{{ route('register') }}"
                        class="group flex flex-col items-center justify-center border-b-[3px] border-b-primary pb-[13px] pt-4 px-2 outline-none focus:outline-none">
                        <p
                            class="text-text-main dark:text-white group-hover:text-primary transition-colors text-sm font-bold leading-normal tracking-[0.015em]">
                            Create Account</p>
                    </a>
                </div>
            </div>
            <!-- Form -->
            <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5">
                @csrf
                <!-- Name Field -->
                <div class="flex flex-col gap-2">
                    <label class="text-text-main dark:text-gray-200 text-sm font-medium leading-normal">Full Name</label>
                    <input
                        class="form-input w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main dark:text-white h-12 px-4 placeholder:text-text-muted dark:placeholder:text-gray-500 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all"
                        placeholder="Enter your full name" type="text" name="name" value="{{ old('name') }}" required
                        autofocus />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Email Field -->
                <div class="flex flex-col gap-2">
                    <label class="text-text-main dark:text-gray-200 text-sm font-medium leading-normal">Email
                        Address</label>
                    <input
                        class="form-input w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main dark:text-white h-12 px-4 placeholder:text-text-muted dark:placeholder:text-gray-500 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all"
                        placeholder="name@company.com" type="email" name="email" value="{{ old('email') }}" required />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Password Field -->
                <div class="flex flex-col gap-2">
                    <label
                            class="text-text-main dark:text-gray-200 text-sm font-medium leading-normal">Password</label>
                    <div class="relative w-full">
                        <input
                            class="form-input w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main dark:text-white h-12 pl-4 pr-12 placeholder:text-text-muted dark:placeholder:text-gray-500 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all"
                            placeholder="Enter your password" type="password" name="password" required />
                        <button
                            class="absolute right-0 top-0 bottom-0 px-3 flex items-center text-text-muted hover:text-text-main dark:text-gray-400 dark:hover:text-white transition-colors"
                            type="button" onclick="const input = this.previousElementSibling; input.type = input.type === 'password' ? 'text' : 'password';">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                    @error('password')
                         <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                 <!-- Confirm Password Field -->
                 <div class="flex flex-col gap-2">
                    <label
                            class="text-text-main dark:text-gray-200 text-sm font-medium leading-normal">Confirm Password</label>
                    <div class="relative w-full">
                        <input
                            class="form-input w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main dark:text-white h-12 pl-4 pr-12 placeholder:text-text-muted dark:placeholder:text-gray-500 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all"
                            placeholder="Confirm your password" type="password" name="password_confirmation" required />
                        <button
                            class="absolute right-0 top-0 bottom-0 px-3 flex items-center text-text-muted hover:text-text-main dark:text-gray-400 dark:hover:text-white transition-colors"
                            type="button" onclick="const input = this.previousElementSibling; input.type = input.type === 'password' ? 'text' : 'password';">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                </div>
                <!-- Submit Button -->
                <button
                    class="mt-2 w-full h-12 rounded-lg bg-primary hover:bg-[#0fd671] active:scale-[0.99] transition-all text-background-dark font-bold text-base shadow-sm flex items-center justify-center gap-2 italic"
                    type="submit">
                    Create Account
                </button>
            </form>
            <div class="mt-8 text-center">
                <p class="text-text-muted dark:text-gray-500 text-sm">
                    Already have an account?
                    <a class="text-primary font-semibold hover:underline italic" href="{{ route('login') }}">Log In</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
