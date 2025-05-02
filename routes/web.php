<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Staff\StaffController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Admin Dashboard Route
        Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::prefix('inventory')->name('inventory.')->group(function () {
            Route::get('/create', [InventoryController::class, 'create'])->name('create');
            Route::post('/store', [InventoryController::class, 'store'])->name('store');
            Route::get('/', [InventoryController::class, 'index'])->name('index'); // For listing items (next task)
            Route::get('/{inventoryItem}/edit', [InventoryController::class, 'edit'])->name('edit'); // For displaying the edit form
            Route::put('/{inventoryItem}', [InventoryController::class, 'update'])->name('update'); // For handling the update
            Route::delete('/{inventoryItem}', [InventoryController::class, 'destroy'])->name('destroy'); // The new delete route
        });

        // Add other admin-related routes here
    });

     // Staff Dashboard Route
     Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {
        Route::get('/dashboard', [StaffController::class, 'index'])->name('dashboard');

        

    });
 
});

require __DIR__.'/auth.php';