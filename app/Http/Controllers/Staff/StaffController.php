<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Http\Controllers\Controller;

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

    

}
