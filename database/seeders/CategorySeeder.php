<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Income Categories (IDs 1-2 based on view hardcoding)
        Category::firstOrCreate(['id' => 1], ['name' => 'Official Employment', 'type' => 'income']);
        Category::firstOrCreate(['id' => 2], ['name' => 'Part-time / Business', 'type' => 'income']);
        Category::firstOrCreate(['id' => 18], ['name' => 'Rental Income', 'type' => 'income']);
        Category::firstOrCreate(['id' => 19], ['name' => 'Dividends / Interest', 'type' => 'income']);

        // Expense Categories (General)
        $expenses = [
            3 => 'Housing',
            4 => 'Transport',
            5 => 'Lifestyle',
            6 => 'Food & Dining',
            7 => 'Utilities',
            8 => 'Equipment',
            9 => 'Professional Services',
            10 => 'Other',
            11 => 'Entertainment',
            12 => 'EPF Contribution',
            13 => 'Zakat',
            14 => 'Life Insurance',
            15 => 'Medical Insurance',
            16 => 'SSPN Savings',
            17 => 'PRS (Private Retirement)'
        ];

        foreach ($expenses as $id => $name) {
            Category::firstOrCreate(['id' => $id], ['name' => $name, 'type' => 'expense']);
        }
    }
}
