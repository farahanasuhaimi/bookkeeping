@extends('layouts.app')

@section('title', 'TaxKeep - Register')

@section('content')
<div class="flex h-screen w-full overflow-hidden">
    <!-- Left Section: Visual/Marketing (Hidden on mobile, visible on lg screens) -->
    <div class="hidden lg:flex w-1/2 relative flex-col justify-between p-12 bg-background-dark">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0 opacity-40">
            <img class="w-full h-full object-cover" src="{{ asset('images/background.png') }}" alt="Modern office desk with financial documents and calculator"/>
            <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-background-dark/80 to-transparent"></div>
        </div>
        <!-- Logo Area -->
        <div class="relative z-10 flex items-center gap-3">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary text-background-dark">
                <span class="material-symbols-outlined text-2xl">account_balance_wallet</span>
            </div>
            <span class="text-white text-xl font-bold tracking-tight">TaxKeep</span>
        </div>
        <!-- Quote Area -->
        <div class="relative z-10 max-w-md">
            <blockquote class="text-2xl font-medium text-white leading-relaxed mb-6">
                "TaxKeep has revolutionized how we handle our annual LHDN filings. It's compliant, secure, and incredibly user-friendly."
            </blockquote>
            <div class="flex items-center gap-4">
                <img class="w-12 h-12 rounded-full border-2 border-primary object-cover" src="{{ asset('images/portrait.png') }}" alt="Portrait of Sarah Lim, Financial Director"/>
                <div>
                    <p class="text-white font-bold text-sm">Sarah Lim</p>
                    <p class="text-primary text-xs font-medium">Financial Director at KL Tech</p>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="relative z-10 text-xs text-white/40 flex gap-6">
            <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
            <a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
            <span>© 2024 TaxKeep Malaysia</span>
        </div>
    </div>
    <!-- Right Section: Form -->
    <div class="w-full lg:w-1/2 flex flex-col h-full overflow-y-auto bg-white dark:bg-gray-900">
        <div class="flex-1 flex flex-col justify-center px-6 sm:px-12 xl:px-32 py-12">
            <!-- Mobile Logo (Visible only on small screens) -->
            <div class="lg:hidden flex items-center gap-2 mb-8">
                <div class="flex items-center justify-center w-8 h-8 rounded bg-primary text-background-dark">
                    <span class="material-symbols-outlined text-xl">account_balance_wallet</span>
                </div>
                <span class="text-text-main dark:text-white text-lg font-bold">TaxKeep</span>
            </div>
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-text-main dark:text-white text-3xl sm:text-4xl font-black leading-tight tracking-[-0.033em] mb-2">Create your Account</h1>
                <p class="text-text-muted dark:text-gray-400 text-base font-normal">Start your journey with TaxKeep today.</p>
            </div>
            <!-- Tabs -->
            <div class="mb-8 border-b border-border-color dark:border-gray-700">
                <div class="flex gap-8">
                    <a href="{{ route('login') }}" class="group flex flex-col items-center justify-center border-b-[3px] border-b-transparent pb-[13px] pt-4 px-2 outline-none focus:outline-none hover:border-b-border-color">
                        <p class="text-text-muted dark:text-gray-400 group-hover:text-text-main dark:group-hover:text-white transition-colors text-sm font-bold leading-normal tracking-[0.015em]">Log In</p>
                    </a>
                    <a href="{{ route('register') }}" class="group flex flex-col items-center justify-center border-b-[3px] border-b-text-main dark:border-b-primary pb-[13px] pt-4 px-2 outline-none focus:outline-none">
                        <p class="text-text-main dark:text-white group-hover:text-primary transition-colors text-sm font-bold leading-normal tracking-[0.015em]">Create Account</p>
                    </a>
                </div>
            </div>
            <!-- Form -->
            <form action="{{ route('register.store') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                <!-- Name Field -->
                <div class="flex flex-col gap-2">
                    <label class="text-text-main dark:text-gray-200 text-sm font-medium leading-normal">Full Name</label>
                    <input class="form-input w-full rounded-lg border border-border-color dark:border-gray-600 bg-white dark:bg-gray-800 text-text-main dark:text-white h-12 px-4 placeholder:text-text-muted dark:placeholder:text-gray-500 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all" placeholder="John Doe" type="text" name="name"/>
                </div>
                <!-- Email Field -->
                <div class="flex flex-col gap-2">
                    <label class="text-text-main dark:text-gray-200 text-sm font-medium leading-normal">Email Address</label>
                    <input class="form-input w-full rounded-lg border border-border-color dark:border-gray-600 bg-white dark:bg-gray-800 text-text-main dark:text-white h-12 px-4 placeholder:text-text-muted dark:placeholder:text-gray-500 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all" placeholder="name@company.com" type="email" name="email"/>
                </div>
                <!-- Password Field -->
                <div class="flex flex-col gap-2">
                    <label class="text-text-main dark:text-gray-200 text-sm font-medium leading-normal">Password</label>
                    <div class="relative w-full">
                        <input class="form-input w-full rounded-lg border border-border-color dark:border-gray-600 bg-white dark:bg-gray-800 text-text-main dark:text-white h-12 pl-4 pr-12 placeholder:text-text-muted dark:placeholder:text-gray-500 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all" placeholder="Enter your password" type="password" name="password"/>
                        <button class="absolute right-0 top-0 bottom-0 px-3 flex items-center text-text-muted hover:text-text-main dark:text-gray-400 dark:hover:text-white transition-colors" type="button">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                </div>
                <!-- Submit Button -->
                <button class="mt-2 w-full h-12 rounded-lg bg-primary hover:bg-[#0fd671] active:scale-[0.99] transition-all text-background-dark font-bold text-base shadow-sm flex items-center justify-center gap-2" type="submit">
                    Create Account
                </button>
                <!-- Divider -->
                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-border-color dark:border-gray-700"></div>
                    <span class="flex-shrink-0 mx-4 text-text-muted dark:text-gray-500 text-xs uppercase tracking-wider font-semibold">Or continue with</span>
                    <div class="flex-grow border-t border-border-color dark:border-gray-700"></div>
                </div>
                <!-- Social Login -->
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-center gap-2 h-11 rounded-lg border border-border-color dark:border-gray-600 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" type="button">
                        <svg class="h-5 w-5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                        </svg>
                        <span class="text-text-main dark:text-white text-sm font-medium">Google</span>
                    </button>
                    <button class="flex items-center justify-center gap-2 h-11 rounded-lg border border-border-color dark:border-gray-600 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" type="button">
                        <svg class="h-5 w-5" viewbox="0 0 23 23" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h23v23H0z" fill="#f3f3f3"></path>
                            <path d="M1 1h10v10H1z" fill="#f35325"></path>
                            <path d="M12 1h10v10H12z" fill="#81bc06"></path>
                            <path d="M1 12h10v10H1z" fill="#05a6f0"></path>
                            <path d="M12 12h10v10H12z" fill="#ffba08"></path>
                        </svg>
                        <span class="text-text-main dark:text-white text-sm font-medium">Microsoft</span>
                    </button>
                </div>
            </form>
            <div class="mt-8 text-center">
                <p class="text-text-muted dark:text-gray-500 text-sm">
                    Already have an account?
                    <a class="text-primary font-semibold hover:underline" href="{{ route('login') }}">Log In</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
