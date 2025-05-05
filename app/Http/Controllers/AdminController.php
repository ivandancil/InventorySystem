<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;

class AdminController extends Controller
{
    public function index()
    {
        $totalProducts = InventoryItem::count();
        $totalStock = InventoryItem::sum('quantity');

         // For the chart
    $productNames = InventoryItem::pluck('name');
    $stockCounts = InventoryItem::pluck('quantity');

        return view('admin.dashboard', compact('totalProducts', 'totalStock', 'productNames', 'stockCounts'));
    }
}