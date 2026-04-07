<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Income
            ['slug' => 'employment-income',  'name' => 'Official Employment',      'type' => 'income'],
            ['slug' => 'part-time-business', 'name' => 'Part-time / Business',     'type' => 'income'],
            ['slug' => 'rental-income',      'name' => 'Rental Income',            'type' => 'income'],
            ['slug' => 'dividends-interest', 'name' => 'Dividends / Interest',     'type' => 'income'],

            // Expense — general
            ['slug' => null, 'name' => 'Housing',              'type' => 'expense'],
            ['slug' => null, 'name' => 'Transport',            'type' => 'expense'],
            ['slug' => null, 'name' => 'Food & Dining',        'type' => 'expense'],
            ['slug' => null, 'name' => 'Utilities',            'type' => 'expense'],
            ['slug' => null, 'name' => 'Equipment',            'type' => 'expense'],
            ['slug' => null, 'name' => 'Professional Services','type' => 'expense'],
            ['slug' => null, 'name' => 'Other',                'type' => 'expense'],
            ['slug' => null, 'name' => 'Entertainment',        'type' => 'expense'],

            // Expense — tax-relevant (slugs required)
            ['slug' => 'lifestyle',          'name' => 'Lifestyle',                'type' => 'expense'],
            ['slug' => 'epf-contribution',   'name' => 'EPF Contribution',         'type' => 'expense'],
            ['slug' => 'zakat',              'name' => 'Zakat',                    'type' => 'expense'],
            ['slug' => 'life-insurance',     'name' => 'Life Insurance',           'type' => 'expense'],
            ['slug' => 'medical-insurance',  'name' => 'Medical Insurance',        'type' => 'expense'],
            ['slug' => 'sspn-savings',       'name' => 'SSPN Savings',             'type' => 'expense'],
            ['slug' => 'prs-retirement',     'name' => 'PRS (Private Retirement)', 'type' => 'expense'],
        ];

        foreach ($categories as $data) {
            if ($data['slug']) {
                Category::firstOrCreate(
                    ['slug' => $data['slug']],
                    ['name' => $data['name'], 'type' => $data['type']]
                );
            } else {
                Category::firstOrCreate(
                    ['name' => $data['name'], 'type' => $data['type'], 'user_id' => null]
                );
            }
        }
    }
}
