<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Bookkeeping') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans bg-white dark:bg-gray-900 text-gray-900 dark:text-white antialiased">
        <div class="flex h-screen w-full overflow-hidden">
            <!-- Left Section: Visual/Marketing (Hidden on mobile, visible on lg screens) -->
            <div class="hidden lg:flex w-1/2 relative flex-col justify-between p-12 bg-gradient-to-br from-blue-600 to-blue-800">
                <!-- Logo Area -->
                <div class="relative z-10 flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-white text-blue-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                        </svg>
                    </div>
                    <span class="text-white text-xl font-bold">Bookkeeping</span>
                </div>

                <!-- Quote Area -->
                <div class="relative z-10 max-w-md">
                    <blockquote class="text-2xl font-medium text-white leading-relaxed mb-6">
                        "Manage your finances with confidence and ease."
                    </blockquote>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-300 flex items-center justify-center font-bold text-blue-800">JD</div>
                        <div>
                            <p class="text-white font-bold text-sm">John Developer</p>
                            <p class="text-blue-100 text-xs font-medium">Founder & CEO</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="relative z-10 text-xs text-blue-100 flex gap-6">
                    <a class="hover:text-white transition-colors" href="#">Privacy Policy</a>
                    <a class="hover:text-white transition-colors" href="#">Terms of Service</a>
                    <span>© 2024 Bookkeeping App</span>
                </div>
            </div>

            <!-- Right Section: Dashboard/Form -->
            <div class="w-full lg:w-1/2 flex flex-col h-full overflow-y-auto bg-white dark:bg-gray-900">
                <div class="flex-1 flex flex-col justify-center px-6 sm:px-12 xl:px-32 py-12">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex items-center gap-2 mb-8">
                        <div class="flex items-center justify-center w-8 h-8 rounded bg-blue-600 text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                            </svg>
                        </div>
                        <span class="text-gray-900 dark:text-white text-lg font-bold">Bookkeeping</span>
                    </div>

                    <!-- Dashboard Header -->
                    <div class="mb-8">
                        <h1 class="text-gray-900 dark:text-white text-4xl font-black leading-tight mb-3">Welcome Back</h1>
                        <p class="text-gray-600 dark:text-gray-400 text-base font-normal">Manage your income, expenses, and finances all in one place.</p>
                    </div>

                    <!-- Quick Stats -->
                    <div class="mb-8 grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                            <p class="text-gray-600 dark:text-gray-400 text-xs font-medium mb-2">Total Income</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">RM {{ number_format($totalIncome ?? 0, 2) }}</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 border border-red-200 dark:border-red-800">
                            <p class="text-gray-600 dark:text-gray-400 text-xs font-medium mb-2">Total Expenses</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">RM {{ number_format($totalExpenses ?? 0, 2) }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                            <p class="text-gray-600 dark:text-gray-400 text-xs font-medium mb-2">Net Balance</p>
                            <p class="text-xl font-bold text-green-600 dark:text-green-400">RM {{ number_format($netBalance ?? 0, 2) }}</p>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="mb-8">
                        <h2 class="text-gray-900 dark:text-white text-sm font-bold mb-4">Features</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <a href="#" class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors">
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6"/>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">Add Income</span>
                                </div>
                            </a>
                            <a href="#" class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors">
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">Manage Expenses</span>
                                </div>
                            </a>
                            <a href="#" class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors">
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">Savings Tracking</span>
                                </div>
                            </a>
                            <a href="#" class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors">
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">Monthly Dashboard</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    @if (Route::has('login'))
                        <div class="space-y-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="w-full inline-block text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-colors">
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="w-full inline-block text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-colors">
                                    Log In
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="w-full inline-block text-center px-6 py-3 border-2 border-blue-600 text-blue-600 dark:text-white dark:border-blue-400 font-bold rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                        Create Account
                                    </a>
                                @endif

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="w-full inline-block text-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors mt-2">
                                        Forgot your password?
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>

                <!-- Footer Navigation -->
                <div class="border-t border-gray-200 dark:border-gray-700 px-6 sm:px-12 xl:px-32 py-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    <p>Secure • Simple • Reliable</p>
                </div>
            </div>
        </div>
    </body>
</html>