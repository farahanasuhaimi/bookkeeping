<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $methods = [
                ['name' => 'Cash Wallet', 'type' => 'Cash'],
                ['name' => 'Maybank', 'type' => 'Bank'],
                ['name' => 'CIMB Clicks', 'type' => 'Bank'],
                ['name' => 'Bank Islam', 'type' => 'Bank'],
                ['name' => 'Wise', 'type' => 'E-Wallet'],
                ['name' => 'GrabPay', 'type' => 'E-Wallet'],
                ['name' => 'Credit Card (Visa)', 'type' => 'Credit Card'],
            ];

            foreach ($methods as $method) {
                PaymentMethod::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'name' => $method['name']
                    ],
                    [
                        'type' => $method['type']
                    ]
                );
            }
        }
    }
}
