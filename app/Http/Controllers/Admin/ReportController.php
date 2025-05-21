<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
   public function index(Request $request)
{
    // Get the month value from the request (default to current month)
    $yearMonth = $request->input('month', now()->format('Y-m'));  // Default to current month
    $year = substr($yearMonth, 0, 4);  // Extract the year from the Y-m format
    $month = substr($yearMonth, 5, 2);  // Extract the month from the Y-m format

    // Log the selected year and month for debugging
    \Log::info("Selected Year: " . $year);
    \Log::info("Selected Month: " . $month);

    // Fetch inventory items filtered by year and month
    $inventoryItems = InventoryItem::whereYear('created_at', $year)
                                   ->whereMonth('created_at', $month)
                                   ->get();

    // Calculate totals
    $totalItems = $inventoryItems->count();
    $lowStockCount = $inventoryItems->where('quantity', '<=', 10)->count();
    $outOfStockCount = $inventoryItems->where('quantity', 0)->count();
    $totalInventoryValue = $inventoryItems->sum(fn($item) => $item->price_php * $item->quantity);

    // Return the view with the inventory data
    return view('admin.reports.index', [
        'inventoryItems' => $inventoryItems,
        'totalItems' => $totalItems,
        'lowStockCount' => $lowStockCount,
        'outOfStockCount' => $outOfStockCount,
        'totalInventoryValue' => $totalInventoryValue,
        'month' => $yearMonth,  // Ensure the month is passed back to the view
    ]);
}


    public function export(Request $request)
{
    // Get the selected year and month from the request (default to the current month)
    $yearMonth = $request->input('month', now()->format('Y-m'));  // Default to current month
    $year = substr($yearMonth, 0, 4);  // Extract the year from the Y-m format
    $month = substr($yearMonth, 5, 2);  // Extract the month from the Y-m format

    // Fetch inventory items filtered by year and month
    $items = InventoryItem::whereYear('created_at', $year)
                          ->whereMonth('created_at', $month)
                          ->get();

    // Log the items to verify that data is being fetched correctly
    \Log::info('Exported Items:', $items->toArray());

    // Create the CSV file content
    $csv = "Item Name,Category,Stock,Price (PHP),Total Value (PHP)\n";
    
    // Add the data for each item
    foreach ($items as $item) {
        $csv .= "{$item->name},{$item->category},{$item->quantity},{$item->price_php}," . 
                number_format($item->price_php * $item->quantity, 2) . "\n";
    }

    // If no items are found, add a message to the CSV file
    if ($items->isEmpty()) {
        $csv .= "No inventory items found for this month.\n";
    }

    // Return the CSV response
    return response()->make($csv, 200, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="inventory_report_' . $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '.csv"'
    ]);
}

}
