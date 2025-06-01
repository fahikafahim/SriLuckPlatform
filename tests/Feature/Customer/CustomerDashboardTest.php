<?php

namespace Tests\Feature\Customer;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_dashboard()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }
     /** @test */
    public function homepage_shows_featured_collections()
    {
        $response = $this->get('/');

        $response->assertSee('Urban Walkers');
        $response->assertSee('Evening Elegance');
        $response->assertSee('Timeless Classics');
    }
}
