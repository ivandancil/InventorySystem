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

         // For the bar chart (Stock Overview)
    $productNames = InventoryItem::pluck('name');
    $stockCounts = InventoryItem::pluck('quantity');

      // For the line chart (Monthly Sales)
    $monthlySales = InventoryAdjustment::select(
            DB::raw('MONTH(created_at) as month'),
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