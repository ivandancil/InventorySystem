<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\QuantityUpdateRequest;
use Illuminate\Http\RedirectResponse;

class StaffDashboardController extends Controller
{
    /**
     * Display the staff dashboard with a list of inventory items.
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');

        $inventoryItemsQuery = InventoryItem::query();

        if ($search) {
            $inventoryItemsQuery->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('category', 'LIKE', '%' . $search . '%');
            });
        }

        $inventoryItems = $inventoryItemsQuery->paginate(10); // Paginate the results

        return view('staff.dashboard', compact('inventoryItems'));
    }

   /**
     * Filter inventory items based on the search query and return the table HTML.
     */
    public function filter(Request $request): View
    {
        $query = $request->get('query');

        $inventoryItemsQuery = InventoryItem::query();

        if ($query) {
            $inventoryItemsQuery->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                  ->orWhere('category', 'LIKE', '%' . $query . '%');
            });
        }

        $inventoryItems = $inventoryItemsQuery->paginate(10);

        return view('staff.dashboard-inventory-table', compact('inventoryItems'));
    }

    /**
     * Mark an item as restocked.
     */
    public function restock(Request $request): JsonResponse
{
    $request->validate([
        'item_id' => 'required|exists:inventory_items,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $itemId = $request->input('item_id');
    $restockQuantity = $request->input('quantity');
    $item = InventoryItem::findOrFail($itemId);

    $item->increment('quantity', $restockQuantity);
    $item->last_restocked_at = now();
    $item->save();

    // Optionally log the restock action with the quantity

    return response()->json([
        'success' => true,
        'message' => __('Item ') . $item->name . __(' restocked. Quantity increased by ') . $restockQuantity,
        'newQuantity' => $item->quantity,
    ]);
}

    /**
     * Store a request for quantity update.
     */
    public function requestUpdate(Request $request): RedirectResponse
    {
        $itemId = $request->input('item_id');
        $reason = $request->input('reason');
        $item = InventoryItem::findOrFail($itemId);

        // Create a new QuantityUpdateRequest record
        QuantityUpdateRequest::create([
            'inventory_item_id' => $itemId,
            'requested_by_user_id' => auth()->id(),
            'reason' => $reason,
            'status' => 'pending', // Default status
        ]);

        return redirect()->back()->with('success', __('Quantity update requested for: ') . $item->name);
    }
}