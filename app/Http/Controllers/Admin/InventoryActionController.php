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

    public function clearFlag($itemId, $type)
    {
        $item = InventoryItem::findOrFail($itemId);

        if ($type === 'restocked') {
            $item->restocked = false;
        } elseif ($type === 'request_update') {
            $item->needs_update = false;
        }

        $item->save();

        return redirect()->back()->with('success', 'Flag cleared successfully.');
    }
}
