<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase; // Resets the database before each test

    public function test_login_screen_is_displayed()
    {
        // GET request to the login route
        $response = $this->get(route('login'));

        // Assertions:
        $response->assertStatus(200); // Check HTTP 200 OK status
        $response->assertSee('Sign in to access your exclusive collection'); // Check page contains text
    }

    public function test_user_can_login_with_correct_credentials()
    {
        // Create a test user in database
        $user = User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password123'), // Hash the test password
        ]);

        // POST request to submit login form with credentials
        $response = $this->post(route('login'), [
            'email' => 'testuser@example.com',
            'password' => 'password123',
        ]);

        // Assertions:
        $response->assertRedirect(); // Check for successful redirect after login
        $this->assertAuthenticatedAs($user); // Verify the user is logged in
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        // Create another test user
        $user = User::create([
            'name' => 'Wrong User',
            'email' => 'wrong@example.com',
            'password' => bcrypt('correctpass'), // Hash the correct password
        ]);

        // POST request from login page with wrong credentials
        $response = $this->from(route('login'))->post(route('login'), [
            'email' => 'wrong@example.com',
            'password' => 'wrongpass', // Incorrect password
        ]);

        // Assertions:
        $response->assertRedirect(route('login')); // Should redirect back to login
        $response->assertSessionHasErrors('email'); // Should show error for email field
        $this->assertGuest(); // Verify no user is authenticated
    }
}
