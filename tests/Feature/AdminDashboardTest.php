<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_dashboard()
    {
        // Explicitly create a single admin user
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create([
            'user_type' => 'admin' // Make sure this matches your actual column name
        ]);

        $response = $this->actingAs($admin)
                         ->get('/dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_redirected_to_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }
}
