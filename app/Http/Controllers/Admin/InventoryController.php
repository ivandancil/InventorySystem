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
   public function index(Request $request)
{
    $search = $request->input('search');

    $inventoryItems = InventoryItem::query()
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%');
        })
        ->withCount(['pendingRestockRequests', 'pendingUpdateRequests'])// 👈 Add this
        ->get();

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
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50', // Limit the length to 100 characters (can adjust as needed)
                'regex:/^[a-zA-Z0-9\s]+$/', // Allow only letters, numbers, and spaces (no special characters)
                'not_regex:/([a-zA-Z])\1{2,}/', // Prevent excessive repetition of the same character (e.g., "aaa")
            ],
            'description' => 'required|string|max:1000|not_regex:/([a-zA-Z])\1{2,}/', // Prevent excessive repetition of the same character (e.g., "aaa")
            'quantity' => 'required|integer|min:0|max:500', // Limit the quantity to a maximum of 500
            'price_php' => 'required|numeric|min:0|max:100000', // Price between 0 and 100,000 PHP
            'category' => 'nullable|string|max:100|',
            'unit_type' => 'required|string|in:each,box,dozen',
            'units_per_package' => 'required|integer|min:1|max:100',
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
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50', // Limit the length to 50 characters (same as store method)
                'regex:/^[a-zA-Z0-9\s]+$/', // Only letters, numbers, and spaces allowed
                'not_regex:/([a-zA-Z])\1{2,}/', // Prevent excessive repetition of the same character
            ],
            'description' => 'required|string|max:1000|not_regex:/([a-zA-Z])\1{2,}/', // Prevent excessive repetition in descriptions
            'quantity' => 'required|integer|min:0|max:500', // Limit quantity to 500
            'price_php' => 'required|numeric|min:0|max:100000', // Price limited to between 0 and 100,000 PHP
            'category' => 'nullable|string|max:100', // Limit category to 100 characters
            'unit_type' => 'required|string|in:each,box,dozen', // Restrict unit type
            'units_per_package' => 'required|integer|min:1|max:100', // Limit units per package to a max of 100
        ]);

        $inventoryItem->update($validated); // Directly update with validated data

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


        public function liveSearch(Request $request)
        {
            $query = $request->input('query');

            $results = InventoryItem::where('name', 'like', '%' . $query . '%')
                ->orWhere('category', 'like', '%' . $query . '%')
                ->get();

            return response()->json($results);
        }

        

}