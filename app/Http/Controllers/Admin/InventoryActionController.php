<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\InventoryAction;
use App\Http\Controllers\Controller;

class InventoryActionController extends Controller
{
    public function index()
    {
        $actions = InventoryAction::with('inventoryItem')->latest()->paginate(10);

        return view('admin.inventory.actions.index', compact('actions'));
    }

    public function approved($itemId, $type)
    {
        $item = InventoryItem::findOrFail($itemId);

        // Find the latest pending action of that type for the item
        $action = InventoryAction::where('inventory_item_id', $itemId)
            ->where('action_type', $type)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$action) {
            return redirect()->back()->with('error', 'No pending action found to confirm.');
        }

        if ($type === 'restocked') {
            // Check if admin has enough stock to fulfill the request
            if ($item->quantity < $action->quantity) {
                return redirect()->back()->with('error', 'Not enough stock to approve this request.');
            }

            // Deduct from admin stock
            $item->quantity -= $action->quantity;
            $item->save();
        }

        if ($type === 'request_update') {
            $item->needs_update = false;
            $item->save();
        }

        $action->status = 'approved';
        $action->save();

        return redirect()->back()->with('success', 'Action confirmed and inventory updated.');
    }
}
