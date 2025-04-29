<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_update_user_profile()
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
        ]);

        $user->update([
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $this->assertEquals('Updated Name', $user->fresh()->name);
        $this->assertEquals('updated@example.com', $user->fresh()->email);
    }

    #[Test]
    public function it_can_delete_user_profile()
    {
        $user = User::factory()->create();

        $userId = $user->id;

        $user->delete();

        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }

    #[Test]
    public function it_requires_unique_email_on_update()
    {
        $user1 = User::factory()->create([
            'email' => 'user1@example.com',
        ]);
    
        $user2 = User::factory()->create([
            'email' => 'user2@example.com',
        ]);
    
        $this->expectException(\Illuminate\Database\QueryException::class);
    
        $user2->update([
            'email' => 'user1@example.com', // Duplicate email
        ]);
    }
    
}
