<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Category;
use App\Models\PaymentMethod;
use Carbon\Carbon;

class HistoricalDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a test user
        $user = User::first() ?: User::factory()->create([
            'name' => 'Simulated User',
            'email' => 'sim@reztax.com',
            'password' => bcrypt('password'),
        ]);

        // Get some payment methods
        $bankTransfer = PaymentMethod::where('name', 'Bank Transfer')->first();
        $creditCard = PaymentMethod::where('name', 'Credit Card')->first() ?: PaymentMethod::first();
        $cash = PaymentMethod::where('name', 'Cash')->first() ?: PaymentMethod::first();

        $this->command->info("Generating data for 2025...");

        for ($month = 1; $month <= 12; $month++) {
            $monthDate = Carbon::create(2025, $month, 25);
            
            // --- INCOME ---
            // 1. Monthly Salary (Official Employment)
            Income::create([
                'user_id' => $user->id,
                'category_id' => 1,
                'source' => 'Monthly Salary',
                'amount' => 7500.00,
                'pcb_amount' => 210.00,
                'date' => $monthDate->toDateString(),
                'status' => 'confirmed',
                'payment_method_id' => $bankTransfer->id ?? null,
                'description' => 'Salary for ' . $monthDate->format('F Y'),
            ]);

            // 2. Freelance / Part-time (Occasional)
            if ($month % 3 == 0) {
                Income::create([
                    'user_id' => $user->id,
                    'category_id' => 2,
                    'source' => 'Freelance Gig',
                    'amount' => 1200.00,
                    'date' => $monthDate->copy()->subDays(10)->toDateString(),
                    'status' => 'confirmed',
                    'description' => 'Website maintenance project',
                ]);
            }

            // --- EXPENSES (Fixed) ---
            // Housing
            Expense::create([
                'user_id' => $user->id,
                'category_id' => 3, // Housing
                'description' => 'Apartment Rent',
                'amount' => 1800.00,
                'date' => Carbon::create(2025, $month, 1)->toDateString(),
                'status' => 'completed',
                'payment_method_id' => $bankTransfer->id ?? null,
            ]);

            // Transport
            Expense::create([
                'user_id' => $user->id,
                'category_id' => 4, // Transport
                'description' => 'Car Installment',
                'amount' => 650.00,
                'date' => Carbon::create(2025, $month, 5)->toDateString(),
                'status' => 'completed',
                'payment_method_id' => $bankTransfer->id ?? null,
            ]);

            // Utilities
            Expense::create([
                'user_id' => $user->id,
                'category_id' => 7, // Utilities
                'description' => 'Electric & Water Bills',
                'amount' => 320.00,
                'date' => Carbon::create(2025, $month, 10)->toDateString(),
                'status' => 'completed',
                'payment_method_id' => $bankTransfer->id ?? null,
            ]);

            // Food & Dining
            Expense::create([
                'user_id' => $user->id,
                'category_id' => 6, // Food
                'description' => 'Monthly Groceries & Dining',
                'amount' => 950.00,
                'date' => Carbon::create(2025, $month, 15)->toDateString(),
                'status' => 'completed',
                'payment_method_id' => $creditCard->id ?? null,
            ]);

            // --- TAX RELIEFS & SAVINGS ---
            // EPF Contribution (Employee share stored as expense for tracking)
            Expense::create([
                'user_id' => $user->id,
                'category_id' => 12, // EPF
                'description' => 'EPF Contribution (11%)',
                'amount' => 825.00,
                'date' => $monthDate->toDateString(),
                'status' => 'completed',
                'is_deductible' => true,
            ]);

            // Lifestyle (Internet, Books, Tech)
            Expense::create([
                'user_id' => $user->id,
                'category_id' => 5, // Lifestyle
                'description' => 'High-speed Internet & Books',
                'amount' => 250.00,
                'date' => Carbon::create(2025, $month, 12)->toDateString(),
                'status' => 'completed',
                'is_deductible' => true,
            ]);

            // Life Insurance (Every 6 months)
            if ($month == 6 || $month == 12) {
                Expense::create([
                    'user_id' => $user->id,
                    'category_id' => 14, // Life Insurance
                    'description' => 'Semi-annual Life Insurance Premium',
                    'amount' => 1200.00,
                    'date' => Carbon::create(2025, $month, 20)->toDateString(),
                    'status' => 'completed',
                    'is_deductible' => true,
                ]);
            }

            // Medical Insurance (Every month)
            Expense::create([
                'user_id' => $user->id,
                'category_id' => 15, // Medical Insurance
                'description' => 'Medical Card Premium',
                'amount' => 220.00,
                'date' => Carbon::create(2025, $month, 22)->toDateString(),
                'status' => 'completed',
                'is_deductible' => true,
            ]);

            // SSPN Savings (Targeted savings)
            if ($month == 12) {
                Expense::create([
                    'user_id' => $user->id,
                    'category_id' => 16, // SSPN
                    'description' => 'Year-end SSPN Top-up',
                    'amount' => 3000.00,
                    'date' => Carbon::create(2025, $month, 28)->toDateString(),
                    'status' => 'completed',
                    'is_deductible' => true,
                ]);
                
                // Zakat
                Expense::create([
                    'user_id' => $user->id,
                    'category_id' => 13, // Zakat
                    'description' => 'Zakat Fitrah & Pendapatan',
                    'amount' => 450.00,
                    'date' => Carbon::create(2025, $month, 27)->toDateString(),
                    'status' => 'completed',
                ]);
            }
        }

        $this->command->info("2025 simulation data completed!");
    }
}
