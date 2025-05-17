<?php

namespace App\Models;

use App\Models\InventoryAction;
use App\Models\InventoryAdjustment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price_php',
        'category',
        'unit_type',
        'units_per_package',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2', // Cast the price to a decimal with 2 decimal places
        'quantity' => 'integer', // Cast quantity to an integer
    ];
    
      /**
     * Relationship with InventoryAdjustment
     */
    public function adjustments()
    {
        return $this->hasMany(InventoryAdjustment::class);
    }

     /**
     * Safely decrement the stock quantity without going negative.
     *
     * @param string $column
     * @param int $amount
     * @return void
     */
    public function safeDecrement(string $column, int $amount = 1): void
    {
        if ($this->$column >= $amount) {
            $this->decrement($column, $amount);
        } else {
            $this->$column = 0;
            $this->save();
        }
    }

     /**
     * Adjust stock based on quantity, type, and price.
     *
     * @param  int  $quantity
     * @param  string  $type
     * @param  float  $price
     * @param  string|null  $reason
     * @return void
     */
        public function adjustStock(int $quantity, string $type, float $price_php)
        {
            // Create the adjustment record
            $adjustment = $this->adjustments()->create([
                'quantity' => $quantity,
                'price_php' => $price_php,
                'type' => $type, // 'restock', 'deduct', or 'damage-return'
            ]);

            // Adjust the inventory quantity based on the adjustment type
            if ($type === 'restock') {
                $this->increment('quantity', $quantity);
            } elseif ($type === 'deduct') {
                $this->safeDecrement('quantity', $quantity);
            } elseif ($type === 'damage-return') {
                // Mark the item as damaged
                $this->status = 'damaged';
                $this->save();

                // Deduct the quantity of damaged stock
                $this->safeDecrement('quantity', $quantity);
            }
        }

        public function inventoryActions()
{
    return $this->hasMany(InventoryAction::class);
}



}