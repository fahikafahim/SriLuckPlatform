<?php

namespace Tests\Feature\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CartPageTest extends TestCase
{
    use RefreshDatabase;

    private function createTestUser()
    {
        return User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    /** @test */
    public function cart_page_loads_for_authenticated_user()
    {
        $user = $this->createTestUser();

        $response = $this->actingAs($user)->get(route('customer.cart'));
        $response->assertSee('Your Shopping Cart');
        $response->assertSee('Order Summary');
        $response->assertSee('Proceed to Checkout');
    }


    /** @test */
    public function cart_page_shows_empty_state_when_no_items()
    {
        $user = $this->createTestUser();

        $response = $this->actingAs($user)->get(route('customer.cart'));
        $response->assertSee('Your cart is empty');
        $response->assertSee('Start Shopping');
    }

    /** @test */
    public function checkout_button_is_disabled_when_cart_is_empty()
    {
        $user = $this->createTestUser();

        $response = $this->actingAs($user)->get(route('customer.cart'));

        $response->assertSee('disabled');
    }

    /** @test */
    public function continue_shopping_link_works()
    {
        $user = $this->createTestUser();
        $response = $this->actingAs($user)->get(route('customer.cart'));
        $response->assertSee('Continue Shopping');
        $response->assertSee('href="' . route('customer.product') . '"', false);
        $response->assertSee('href="/"', false); 
    }
}
