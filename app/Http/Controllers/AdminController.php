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

        return view('admin.dashboard', compact('totalProducts', 'totalStock'));
    }
}