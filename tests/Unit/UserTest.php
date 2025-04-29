<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_user()
    {
        $user = User::create([
            'name' => 'Admin Tester',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('admin@example.com', $user->email);
        $this->assertTrue(password_verify('password123', $user->password));
    }

    #[Test]
    public function it_does_not_allow_duplicate_emails()
    {
        User::factory()->create(['email' => 'unique@example.com']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        User::create([
            'name' => 'Dup User',
            'email' => 'unique@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    #[Test]
    public function it_can_create_a_user_with_any_valid_email_string()
    {
        $user = User::create([
            'name' => 'Free Format',
            'email' => 'not-an-email',
            'password' => bcrypt('password123'),
        ]);
    
        $this->assertEquals('not-an-email', $user->email);
    }
    
}
