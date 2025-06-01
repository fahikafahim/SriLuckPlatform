<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
   public function product_page_loads_successfully()
{
    $response = $this->get(route('customer.product'));
    $response->assertSee('Our Products');
}


    // /** @test */
    public function product_page_shows_no_products_message_when_empty()
    {
        $response = $this->get(route('customer.product'));
        $response->assertSee('No products available at the moment.');
    }

    /** @test */
    public function product_page_displays_product_names()
    {
        Product::create([
            'name' => 'Manual Product',
            'description' => 'Test product description',
            'price' => 499.99,
            'size' => 'L',
            'color' => 'Red',
            'image_url' => 'https://via.placeholder.com/300',
        ]);

        $response = $this->get(route('customer.product'));

        $response->assertSee('Manual Product');
        $response->assertSee('Test product description');
    }
}
