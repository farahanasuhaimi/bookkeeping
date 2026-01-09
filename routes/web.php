<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\TaxSummaryController;
use App\Http\Controllers\SavingsController;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.store');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.store');

Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->middleware('guest')->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pricing', function () {
        return view('pricing');
    })->name('pricing');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Income Resource Routes
    Route::resource('incomes', IncomeController::class);

    // Expense Resource Routes
    Route::resource('expenses', ExpenseController::class);

    Route::get('/tax-summary', [TaxSummaryController::class, 'index'])->name('tax-summary');
    Route::get('/tax-summary/export', [TaxSummaryController::class, 'exportPDF'])->name('tax-summary.export');

    // Savings Route
    Route::get('/saving-tracking', [SavingsController::class, 'index'])->name('saving-tracking');
    Route::resource('savings-goals', SavingsController::class)->except(['index', 'show', 'create', 'edit']);

    // Import Routes
    Route::get('/import', [\App\Http\Controllers\ImportController::class, 'index'])->name('import.index');
    Route::post('/import/preview', [\App\Http\Controllers\ImportController::class, 'preview'])->name('import.preview');
    Route::post('/import/store', [\App\Http\Controllers\ImportController::class, 'store'])->name('import.store');

    // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SettingsController::class, 'index'])->name('index');
        Route::get('/profile', [\App\Http\Controllers\SettingsController::class, 'profile'])->name('profile');
        Route::patch('/profile', [\App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('profile.update');
        Route::patch('/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('password.update');
        Route::get('/payment-methods', [\App\Http\Controllers\SettingsController::class, 'paymentMethods'])->name('payment-methods');
        Route::post('/payment-methods', [\App\Http\Controllers\SettingsController::class, 'storePaymentMethod'])->name('payment-methods.store');
        Route::delete('/payment-methods/{id}', [\App\Http\Controllers\SettingsController::class, 'destroyPaymentMethod'])->name('payment-methods.destroy');
        Route::get('/categories', [\App\Http\Controllers\SettingsController::class, 'categories'])->name('categories');
        Route::post('/categories', [\App\Http\Controllers\SettingsController::class, 'storeCategory'])->name('categories.store');
        Route::delete('/categories/{id}', [\App\Http\Controllers\SettingsController::class, 'destroyCategory'])->name('categories.destroy');
    });

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
        Route::patch('/users/{id}/plan', [\App\Http\Controllers\AdminController::class, 'updatePlan'])->name('users.update-plan');
        Route::get('/categories', [\App\Http\Controllers\AdminController::class, 'categories'])->name('categories');
        Route::post('/categories', [\App\Http\Controllers\AdminController::class, 'storeCategory'])->name('categories.store');
    });
});
