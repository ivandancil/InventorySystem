<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAccountTest extends TestCase
{
    use RefreshDatabase;

        #[Test]
        public function admin_can_register_successfully()
        {
            $response = $this->post('/register', [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

            $response->assertStatus(302); // Assuming it redirects after successful registration
            $this->assertDatabaseHas('users', [
                'email' => 'admin@example.com',
            ]);
        }

        #[Test]
        public function admin_can_login_successfully()
        {
            // First, create a user in the database
            $user = \App\Models\User::factory()->create([
                'email' => 'admin@example.com',
                'password' => bcrypt('password'), // encrypt password
            ]);

            // Attempt to login with correct credentials
            $response = $this->post('/login', [
                'email' => 'admin@example.com',
                'password' => 'password',
            ]);

            $response->assertStatus(302); // Laravel redirects on success
            $this->assertAuthenticatedAs($user);
        }

        #[Test]
        public function admin_cannot_login_with_wrong_password()
        {
            // Create a user
            $user = \App\Models\User::factory()->create([
                'email' => 'wrongpass@example.com',
                'password' => bcrypt('correctpassword'),
            ]);

            // Attempt login with wrong password
            $response = $this->post('/login', [
                'email' => 'wrongpass@example.com',
                'password' => 'wrongpassword',
            ]);

            // It should redirect back and not authenticate
            $response->assertStatus(302);
            $this->assertGuest(); // User should NOT be logged in
        }


        #[Test]
        public function admin_cannot_login_with_unregistered_email()
        {
            // Try to login with an email that doesn't exist
            $response = $this->post('/login', [
                'email' => 'nonexistent@example.com',
                'password' => 'password123',
            ]);

            $response->assertStatus(302);
            $this->assertGuest(); // Still not authenticated
        }

}
