<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryAdjustmentController extends Controller
{
    /**
     * Show the adjustment form.
     */
    public function create(InventoryItem $inventoryItem)
    {
        return view('admin.inventory.adjust', compact('inventoryItem'));
    }

    /**
     * Handle inventory adjustment submission.
     */
    public function store(Request $request, InventoryItem $inventoryItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:restock,deduct',
            'price_php' => 'required|numeric',
        ]);

        // Ensure the model has this method!
        $inventoryItem->adjustStock($validated['quantity'], $validated['type'], $validated['price_php']);

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory adjusted successfully.');
    }
}
