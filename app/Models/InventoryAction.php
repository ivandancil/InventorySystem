<?php

namespace App\Models;

use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryAction extends Model
{
    use HasFactory;

    protected $fillable = [
       'inventory_item_id',
        'user_id',
        'action_type',
        'status',
        'notes',
        'quantity',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
