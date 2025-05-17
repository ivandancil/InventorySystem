<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryAdjustment;

class AdminController extends Controller
{
    public function index()
    {
        $totalProducts = InventoryItem::count();
        $totalStock = InventoryItem::sum('quantity');

        // Fetch product names and quantities together and ensure they're aligned
        $inventoryData = InventoryItem::select('name', 'quantity')->get();
        $productNames = $inventoryData->pluck('name');
        $stockCounts = $inventoryData->pluck('quantity')->map(fn($quantity) => (int)$quantity); // Ensure integers

        // Detect DB driver
    $driver = DB::getDriverName();

    // SQLite uses strftime('%m'), MySQL uses MONTH()
    $monthExpr = $driver === 'sqlite'
        ? DB::raw("strftime('%m', created_at) as month")
        : DB::raw("MONTH(created_at) as month");

    $monthlySales = InventoryAdjustment::select(
            $monthExpr,
            DB::raw('SUM(quantity * price_php) as total_sales')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total_sales', 'month')
        ->toArray();

    // Ensure all 12 months are accounted for
    $fullMonthlySales = [];
    for ($i = 1; $i <= 12; $i++) {
        $fullMonthlySales[] = $monthlySales[$i] ?? 0;
    }
    

     return view('admin.dashboard', compact(
        'totalProducts',
        'totalStock',
        'productNames',
        'stockCounts',
        'fullMonthlySales'
    ));
  }
}