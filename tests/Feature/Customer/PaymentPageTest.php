<?php

// namespace Tests\Feature\Customer;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Tests\TestCase;
// use App\Models\User;
// use App\Models\Order;
// use Illuminate\Support\Facades\Hash;

// class PaymentPageTest extends TestCase
// {
//     use RefreshDatabase;

//     private function createTestUser()
//     {
//         return User::create([
//             'name' => 'Test User',
//             'email' => 'testuser@example.com',
//             'password' => Hash::make('password'),
//         ]);
//     }

//     private function createTestOrder($user)
//     {
//         return Order::create([
//             'user_id' => $user->id,
//             'product_id' => 1, // Adjust if needed
//             'quantity' => 2,
//             'total_price' => 500.00,
//             'status' => 'pending',
//         ]);
//     }

//     /** @test */
//     public function authenticated_user_can_view_payment_page()
//     {
//         $user = $this->createTestUser();
//         $order = $this->createTestOrder($user);

//         $response = $this->actingAs($user)->get(route('payment.show', $order->id));

//         $response->assertStatus(200);
//         $response->assertSee('Payment');
//         $response->assertSee('Rs.500.00');
//         $response->assertSee('Confirm Payment');
//     }

//     /** @test */
//     public function unauthenticated_user_is_redirected_from_payment_page()
//     {
//         $order = Order::create([
//             'user_id' => 1,
//             'product_id' => 1,
//             'quantity' => 1,
//             'total_price' => 100,
//             'status' => 'pending',
//         ]);

//         $response = $this->get(route('payment.show', $order->id));
//         $response->assertRedirect('/login');
//     }

//     /** @test */
//     public function payment_process_redirects_on_success()
//     {
//         $user = $this->createTestUser();
//         $order = $this->createTestOrder($user);

//         $response = $this->actingAs($user)->post(route('payment.store', $order->id), [
//             'payment_method' => 'credit_card',
//             'card_number' => '4111111111111111',
//             'expiry_date' => '12/25',
//             'cvv' => '123'
//         ]);

//         $response->assertRedirect(route('orders.confirmation', $order->id));
//     }

//     /** @test */
//     public function payment_process_shows_validation_errors()
//     {
//         $user = $this->createTestUser();
//         $order = $this->createTestOrder($user);

//         $response = $this->actingAs($user)->post(route('payment.store', $order->id), [
//             // Missing payment details
//         ]);

//         $response->assertSessionHasErrors(['payment_method', 'card_number', 'expiry_date', 'cvv']);
//     }

//     /** @test */
//     public function user_cannot_pay_for_other_users_order()
//     {
//         $user = $this->createTestUser();

//         $otherUser = User::create([
//             'name' => 'Other User',
//             'email' => 'other@example.com',
//             'password' => Hash::make('password'),
//         ]);

//         $order = $this->createTestOrder($otherUser);

//         $response = $this->actingAs($user)->get(route('payment.show', $order->id));
//         $response->assertStatus(403); // Or redirect if your controller uses policies or middleware
//     }
// }
