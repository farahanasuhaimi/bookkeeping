<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Savings;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create categories
        $categories = [
            ['name' => 'Salary', 'description' => 'Monthly salary', 'color' => '#10b981'],
            ['name' => 'Freelance', 'description' => 'Freelance work', 'color' => '#3b82f6'],
            ['name' => 'Groceries', 'description' => 'Food and groceries', 'color' => '#f59e0b'],
            ['name' => 'Utilities', 'description' => 'Bills and utilities', 'color' => '#ef4444'],
            ['name' => 'Entertainment', 'description' => 'Entertainment expenses', 'color' => '#8b5cf6'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'user_id' => $user->id,
                ...$category,
            ]);
        }

        // Create incomes
        Income::create([
            'user_id' => $user->id,
            'source' => 'Salary',
            'amount' => 5000,
            'description' => 'Monthly salary',
            'date' => now()->subDays(5),
            'status' => 'confirmed',
        ]);

        Income::create([
            'user_id' => $user->id,
            'source' => 'Freelance Project',
            'amount' => 1500,
            'description' => 'Web development project',
            'date' => now()->subDays(10),
            'status' => 'confirmed',
        ]);

        // Create expenses
        $groceriesCategory = Category::where('user_id', $user->id)->where('name', 'Groceries')->first();
        $utilitiesCategory = Category::where('user_id', $user->id)->where('name', 'Utilities')->first();
        $entertainmentCategory = Category::where('user_id', $user->id)->where('name', 'Entertainment')->first();

        Expense::create([
            'user_id' => $user->id,
            'category_id' => $groceriesCategory->id,
            'description' => 'Weekly groceries shopping',
            'amount' => 150,
            'date' => now()->subDays(2),
            'payment_method' => 'Credit Card',
            'status' => 'completed',
        ]);

        Expense::create([
            'user_id' => $user->id,
            'category_id' => $utilitiesCategory->id,
            'description' => 'Electricity bill',
            'amount' => 120,
            'date' => now()->subDays(1),
            'payment_method' => 'Bank Transfer',
            'status' => 'completed',
        ]);

        Expense::create([
            'user_id' => $user->id,
            'category_id' => $entertainmentCategory->id,
            'description' => 'Movie tickets',
            'amount' => 50,
            'date' => now(),
            'payment_method' => 'Cash',
            'status' => 'completed',
        ]);

        // Create savings goals
        Savings::create([
            'user_id' => $user->id,
            'goal_name' => 'Emergency Fund',
            'target_amount' => 10000,
            'current_amount' => 3500,
            'description' => 'Building emergency fund',
            'target_date' => now()->addMonths(6),
            'status' => 'active',
        ]);

        Savings::create([
            'user_id' => $user->id,
            'goal_name' => 'Vacation',
            'target_amount' => 5000,
            'current_amount' => 1200,
            'description' => 'Saving for summer vacation',
            'target_date' => now()->addMonths(4),
            'status' => 'active',
        ]);
    }
}
