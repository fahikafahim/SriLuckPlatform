<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductShowPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
   public function test_it_shows_a_product_successfully()
{
    // Create and authenticate a user
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $this->actingAs($user);

    // Create a product
    $product = Product::create([
        'name' => 'Men Hiking Boots',
        'description' => 'Rugged boots with high grip soles for mountain adventures.',
        'image_url' => '/storage/products/men_hiking_boots.png',
        'color' => 'Black',
        'size' => '10',
        'price' => 3999.00,
    ]);

    $response = $this->get(route('customer.product_show', $product->id));

    $response->assertStatus(200);
    $response->assertSee('Men Hiking Boots');
    $response->assertSee('Rs.3,999.00');
    $response->assertSee('Rugged boots with high grip');
    $response->assertSee('Black');
    $response->assertSee('10');
}


    /** @test */
    public function it_returns_404_if_product_does_not_exist()
    {
        $response = $this->get(route('customer.product_show', 9999));
        $response->assertStatus(404);
    }
}
