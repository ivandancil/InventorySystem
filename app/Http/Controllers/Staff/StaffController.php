<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\InventoryAction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
        public function index(Request $request)
        {
            $query = InventoryItem::query();

            // Search by name or category
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

            $products = $query->paginate(10);
            return view('staff.dashboard', compact('products'));
        }

        public function markRestocked(Request $request, $id)
        {
            // Find the product
            $product = InventoryItem::findOrFail($id);
            
            // Update the product's status
            $product->restocked = true;  // Set as restocked
            $product->save();

            // Log the action
            InventoryAction::create([
                'inventory_item_id' => $id,
                'user_id' => Auth::id(),
                'action_type' => 'restocked',
                'notes' => $request->notes,
            ]);
            
            return redirect()->route('staff.dashboard')->with('success', 'Product marked as restocked.');
        }


        public function requestUpdate(Request $request, $id)
        {
            // Find the product
            $product = InventoryItem::findOrFail($id);
            
            // Update the product's status
            $product->needs_update = true;  // Mark as needing update
            $product->save();

            // Log the action
            InventoryAction::create([
                'inventory_item_id' => $id,
                'user_id' => Auth::id(),
                'action_type' => 'request_update',
                'notes' => $request->notes,
            ]);

            return redirect()->route('staff.dashboard')->with('success', 'Update request submitted.');
        }

        
        public function showRestockForm($id)
        {
            $product = InventoryItem::findOrFail($id);
            return view('staff.restock', compact('product'));
        }
        
        public function showUpdateForm($id)
        {
            $product = InventoryItem::findOrFail($id);
            return view('staff.update', compact('product'));
        }


                public function liveSearch(Request $request)
        {
            $search = $request->input('search');

            // Fetch inventory items matching the search query (you can also add more conditions for filtering)
            $inventoryItems = InventoryItem::where('name', 'like', '%' . $search . '%')
                ->orWhere('category', 'like', '%' . $search . '%') // You can add more columns if necessary
                ->get();

            // Return a view or JSON with the filtered items
            return response()->json($inventoryItems); // You can send data to be used on the frontend
        }


}
