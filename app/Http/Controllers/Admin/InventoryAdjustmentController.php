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
         // Validate the input data
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:restock,deduct,damage-return',
            'price_php' => 'required|numeric',
            'damage_reason' => 'nullable|string', // Only required for damage-return
        ]);


            // Check the adjustment type
        if ($validated['type'] == 'damage-return') {
            // Handle return of damaged goods logic
            // For example, you could set the quantity back to the original state
            $inventoryItem->adjustStock($validated['quantity'], 'deduct', $validated['price_php']);
            
            // Log this adjustment for the record
            // You might want to log the reason for return in a different column or database table
        } else {
            // Handle normal restock or deduct
            $inventoryItem->adjustStock($validated['quantity'], $validated['type'], $validated['price_php']);
        }

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory adjusted successfully.');
    }
}
