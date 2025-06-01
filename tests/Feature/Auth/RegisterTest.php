<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase; // Resets database before each test

    public function test_user_can_register_successfully()
    {
        // Generate unique test email using Str helper
        $uniqueEmail = strtolower('user_' . Str::random(5)) . '@example.com';

        // POST request to registration endpoint with user data
        $response = $this->post('/register', [
            'name' => 'Ahsan Test',
            'email' => $uniqueEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123', // Matching confirmation
        ]);

        // Assertions:
        $response->assertRedirect('/dashboard'); // Check redirect after registration
        $this->assertDatabaseHas('users', [    // Verify user exists in database
            'email' => $uniqueEmail,
        ]);
    }

    public function test_register_validation_errors()
    {
        // POST empty request to trigger validation errors
        $response = $this->post('/register', []);

        // Assertions:
        $response->assertSessionHasErrors([  // Check for validation errors
            'name',    // Name field required error
            'email',   // Email field required error
            'password', // Password field required error
        ]);
    }
}
