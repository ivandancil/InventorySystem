<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class StockQuantityTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_increase_stock_quantity()
    {
        $item = InventoryItem::factory()->create([
            'quantity' => 10,
        ]);

        $item->increment('quantity', 5);

        $this->assertEquals(15, $item->fresh()->quantity);
    }

    #[Test]
    public function it_can_decrease_stock_quantity()
    {
        $item = InventoryItem::factory()->create([
            'quantity' => 10,
        ]);

        $item->decrement('quantity', 3);

        $this->assertEquals(7, $item->fresh()->quantity);
    }

    #[Test]
    public function it_cannot_have_negative_stock()
    {
        $item = InventoryItem::factory()->create([
            'quantity' => 5,
        ]);

        // Try to decrement more than available
        $item->safeDecrement('quantity', 10);

        // Force quantity to not go below 0
        $item->refresh();

        $this->assertGreaterThanOrEqual(0, $item->quantity);
    }
}
