<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsToAlias;

class QuantityUpdateRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_item_id',
        'requested_by_user_id',
        'reason',
        'status',
    ];

    /**
     * Get the inventory item that the request belongs to.
     */
    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    /**
     * Get the user who requested the quantity update.
     */
    public function requestedBy(): BelongsToAlias
    {
        return $this->belongsTo(User::class, 'requested_by_user_id');
    }
}