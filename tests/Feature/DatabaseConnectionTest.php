<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;

class DatabaseConnectionTest extends TestCase
{
    #[Test]
    public function database_connection_is_working()
    {
        try {
            DB::connection()->getPdo();
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail("Could not connect to the database. Error: " . $e->getMessage());
        }
    }
}
