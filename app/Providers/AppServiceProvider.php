<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.main', function ($view) {
            if (auth()->check()) {
                $view->with('sharedPaymentMethods', \App\Models\PaymentMethod::where('user_id', auth()->id())->get());
                $view->with('sharedIncomeCategories', \App\Models\Category::where('type', 'income')->get());
                $view->with('sharedExpenseCategories', \App\Models\Category::where('type', 'expense')->get());
            }
        });
    }
}
