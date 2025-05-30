<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Order::create([
                'user_id' => 1, // Assumes user with ID 1 exists
                'full_name' => "Customer $i",
                'email' => "customer{$i}@example.com",
                'phone_number' => '07' . rand(00000000, 99999999),
                'address' => "123 Example Street",
                'city' => "City $i",
                'province' => "Province $i",
                'postal_code' => "1000$i",
                'status' => 'pending',
                'total_amount' => rand(1000, 10000),
                'cart_items' => json_encode([
                    [
                        'product_id' => rand(1, 5),
                        'product_name' => 'Sample Product ' . rand(1, 5),
                        'price' => rand(100, 1000),
                        'quantity' => rand(1, 5)
                    ],
                    [
                        'product_id' => rand(6, 10),
                        'product_name' => 'Sample Product ' . rand(6, 10),
                        'price' => rand(100, 1000),
                        'quantity' => rand(1, 3)
                    ]
                ]),
            ]);
        }
    }
}
