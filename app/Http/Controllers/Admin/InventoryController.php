<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Illuminate\Validation\Rule;
use App\Models\InventoryAdjustment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class InventoryController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventoryItems = InventoryItem::all(); // Retrieve all inventory items
        return view('admin.inventory.index', compact('inventoryItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'category' => ['nullable', 'string', 'max:255'],
        ]);

        InventoryItem::create($request->all());

        return Redirect::route('admin.inventory.index')->with('success', 'Inventory item created successfully.');
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        return view('admin.inventory.edit', compact('inventoryItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'category' => ['nullable', 'string', 'max:255'],
        ]);

        $inventoryItem->update($request->all());

        return Redirect::route('admin.inventory.index')->with('success', 'Inventory item updated successfully.');
    }

     /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();
        return Redirect::route('admin.inventory.index')->with('success', 'Inventory item deleted successfully.');
    }
}