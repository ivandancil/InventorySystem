<?php

namespace App\Models;

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
        'quantity',
        'price',
        'category',
        'restocked',
        'needs_update',
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

}