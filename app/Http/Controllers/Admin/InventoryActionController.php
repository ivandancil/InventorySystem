<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\InventoryAction;
use App\Http\Controllers\Controller;

class InventoryActionController extends Controller
{
    public function index()
    {
        $actions = InventoryAction::with('inventoryItem')->latest()->paginate(10);

        return view('admin.inventory.actions.index', compact('actions'));
    }
}
