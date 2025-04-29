<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_can_login_successfully()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertTrue(
            Auth::attempt([
                'email' => 'admin@example.com',
                'password' => 'password',
            ])
        );

        $this->assertEquals('admin@example.com', Auth::user()->email);
    }

    #[Test]
    public function login_fails_with_wrong_credentials()
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertFalse(
            Auth::attempt([
                'email' => 'admin@example.com',
                'password' => 'wrongpassword',
            ])
        );
    }

    #[Test]
    public function admin_can_access_dashboard()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200); // Assuming the route exists and doesn't require a role check
    }

    #[Test]
    public function guest_cannot_access_admin_dashboard()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login')); // Adjust based on your auth redirection
    }

    #[Test]
    public function user_can_logout_successfully()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Auth::logout();

        $this->assertGuest(); // Assert user is logged out
    }
}
