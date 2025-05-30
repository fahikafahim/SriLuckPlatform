<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_id' => Order::factory(),
            'payment_method' => $this->faker->randomElement(['credit_card', 'cod']),
            'amount' => $this->faker->randomFloat(2, 20, 1000),
            'status' => $this->faker->randomElement(['paid', 'pending', 'failed']),
            'payment_date' => now(),
            'card_number' => $this->faker->creditCardNumber,
            'card_name' => $this->faker->name,
            'expiry_date' => $this->faker->creditCardExpirationDateString,
            'cvv' => $this->faker->numerify('###'),
        ];
    }
}
