<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class InventoryItemTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_inventory_item()
    {
        $item = InventoryItem::create([
            'name' => 'Test Product',
            'quantity' => 10,
            'price' => 99.99,
            'category' => 'Electronics',
        ]);

        $this->assertDatabaseHas('inventory_items', ['name' => 'Test Product']);
        $this->assertEquals(10, $item->quantity);
        $this->assertEquals(99.99, $item->price);
    }

    #[Test]
    public function it_can_view_all_inventory_items()
    {
        InventoryItem::factory()->count(3)->create();

        $items = InventoryItem::all();

        $this->assertCount(3, $items);
    }


    #[Test]
    public function it_requires_name_category_quantity_and_price()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        InventoryItem::create([]); // missing all required fields
    }

    #[Test]
    public function it_can_update_inventory_item()
    {
        $item = InventoryItem::factory()->create([
            'name' => 'Old Name',
            'quantity' => 5,
            'price' => 10.00,
        ]);

        $item->update([
            'name' => 'Updated Name',
            'quantity' => 20,
            'price' => 15.50,
        ]);

        $this->assertEquals('Updated Name', $item->fresh()->name);
        $this->assertEquals(20, $item->fresh()->quantity);
        $this->assertEquals(15.50, $item->fresh()->price);
    }

    #[Test]
    public function it_calculates_total_stock_quantity_and_product_count()
    {
        InventoryItem::factory()->create(['quantity' => 10]);
        InventoryItem::factory()->create(['quantity' => 20]);

        $totalQuantity = InventoryItem::sum('quantity');
        $productCount = InventoryItem::count();

        $this->assertEquals(30, $totalQuantity);
        $this->assertEquals(2, $productCount);
    }

    #[Test]
    public function it_can_delete_inventory_item()
    {
        $item = InventoryItem::factory()->create();

        $item->delete();

        $this->assertModelMissing($item);
    }
}
