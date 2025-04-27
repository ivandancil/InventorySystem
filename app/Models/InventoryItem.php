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
        'description',
        'quantity',
        'price',
        'sku',
        'category',
        'supplier',
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

}