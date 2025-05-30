<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Order;
use App\Models\User;


class PaymentTableSeeder extends Seeder
{

public function run()
{
    $user = User::inRandomOrder()->first(); 
    $orders = Order::take(5)->get();

    foreach ($orders as $order) {
        Payment::create([
            'user_id'        => $user->id,
            'order_id'       => $order->id,
            'payment_method' => 'cod',
            'amount'         => $order->total_amount,
            'status'         => 'pending',
            'payment_date'   => now(),
            'card_number'    => null,
            'card_name'      => null,
            'expiry_date'    => null,
            'cvv'            => null,
        ]);
    }
}

}
