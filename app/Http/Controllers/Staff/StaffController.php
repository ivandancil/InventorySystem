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

         $products = $query->with('inventoryActions')->paginate(10);


    return view('staff.dashboard', compact('products'));
        }

     public function markRestocked(Request $request, $id)
{
    $product = InventoryItem::findOrFail($id);

      // Validate the request including max quantity
    $validated = $request->validate([
        'notes' => 'nullable|string',
        'quantity' => [
            'required',
            'integer',
            'min:1',
            function ($attribute, $value, $fail) use ($product) {
                if ($value > $product->quantity) {
                    $fail("Requested quantity exceeds available stock ({$product->quantity}).");
                }
            }
        ],
    ]);

    // Do not mark it as restocked yet — admin must approve it

    // Log the action
    InventoryAction::create([
        'inventory_item_id' => $id,
        'user_id' => Auth::id(),
        'action_type' => 'restocked',
        'status' => 'pending',
        'notes' => $validated['notes'],
        'quantity' => $validated['quantity'], // ✅ include quantity here
    ]);

    return redirect()->route('staff.dashboard')->with('success', 'Restock request submitted to warehouse.');
}

        public function requestUpdate(Request $request, $id)
        {
            // Find the product
            $product = InventoryItem::findOrFail($id);

             // Get the current quantity of the product
    $currentQuantity = $product->quantity;
            
            // Update the product's status
            $product->needs_update = true;  // Mark as needing update
            $product->save();

            // Validate the request to make sure notes are included
    $validated = $request->validate([
        'notes' => 'nullable|string', // Only validate the notes field
    ]);

            // Log the action
            InventoryAction::create([
                'inventory_item_id' => $id,
                'user_id' => Auth::id(),
                'action_type' => 'request_update',
                 'notes' => $validated['notes'], // Only store notes, no quantity in the request
                  'quantity' => $currentQuantity, // Store the current quantity in the action
            ]);

            return redirect()->route('staff.dashboard')->with('success', 'Update request submitted.');
        }

        
        public function showRestockForm($id)
        {
            $product = InventoryItem::findOrFail($id);
            $availableQuantity = $product->quantity;

            return view('staff.restock', compact('product', 'availableQuantity'));
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

                 // Modify the quantity display logic
            $inventoryItems->each(function ($item) {
                if ($item->restocked || $item->needs_update) {
                    // If restocked or needs update, show the actual quantity
                    $item->display_quantity = $item->quantity;
                } else {
                    // If no restock or update requested, show 0
                    $item->display_quantity = 0;
                }
            });

                    // Return a view or JSON with the filtered items
                    return response()->json($inventoryItems); // You can send data to be used on the frontend
                }


                   public function generateInventoryReport()
    {
        // Retrieve the products (you can adjust this according to your needs)
        $products = InventoryItem::all(); // Or paginate as needed

        // Create CSV content
        $csvContent = "Name,Category,Price (PHP), Unit Type, Unit Per Package, Total Value (PHP)\n";  // Header row

        foreach ($products as $product) {
            $totalValue = $product->price_php * $product->quantity; // Calculate total value for each product
            $csvContent .= "{$product->name},{$product->category},{$product->price_php},{$product->unit_type},{$product->units_per_package},{$totalValue}\n";  // Product data
        }

        // Return the response with appropriate headers to download the CSV file
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="inventory_report.csv"');
    }
}
