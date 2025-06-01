<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase; // Resets the database before each test

    public function test_admin_login_screen_is_displayed()
    {
        // GET request to the admin login route
        $response = $this->get(route('admin.login'));

        // Assertions:
        $response->assertStatus(200); // Check HTTP 200 OK status
        $response->assertSee('Admin Portal'); // Check page contains text
        $response->assertSee('Admin Login');
        $response->assertSee('Customer Login');
    }

    public function test_admin_can_login_with_correct_credentials()
    {
        // Create a test admin user in database
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'), // Hash the test password
            'user_type' => 'admin',
        ]);

        // POST request to submit login form with credentials
        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
            'password' => 'adminpassword',
        ]);

        // Assertions:
        $response->assertRedirect(); // Check for successful redirect after login
        $this->assertAuthenticatedAs($admin); // Verify the admin is logged in
    }

    public function test_admin_cannot_login_with_invalid_credentials()
    {
        // Create another test user
        $admin = User::create([
            'name' => 'Wrong Admin',
            'email' => 'wrongadmin@example.com',
            'password' => Hash::make('correctpass'), // Hash the correct password
        ]);

        // POST request from login page with wrong credentials
        $response = $this->from(route('admin.login'))->post(route('admin.login'), [
            'email' => 'wrongadmin@example.com',
            'password' => 'wrongpass', // Incorrect password
        ]);

        // Assertions:
        $response->assertRedirect(route('admin.login')); // Should redirect back to login
        $response->assertSessionHasErrors('email'); // Should show error for email field
        $this->assertGuest(); // Verify no user is authenticated
    }
}
