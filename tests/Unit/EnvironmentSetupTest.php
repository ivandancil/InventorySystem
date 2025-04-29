<?php

namespace Tests\Unit;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnvironmentSetupTest extends TestCase
{
    #[Test]
    public function app_boots_successfully()
        {
            $response = $this->get('/');
            $response->assertStatus(200); // Home page should load
        }
}