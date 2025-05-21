<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\InventoryAdjustmentController;
use App\Http\Controllers\Admin\InventoryActionController;
use App\Http\Controllers\Admin\ReportController;

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
            Route::get('/inventory-actions', [InventoryActionController::class, 'index'])->name('inventoryActions');
            Route::post('/inventory-actions/{item}/approve/{type}', [InventoryActionController::class, 'approved'])->name('inventoryActions.approve');
            Route::post('/inventory-actions/{item}/reject/{type}', [InventoryActionController::class, 'reject'])->name('inventoryActions.reject'); // Reject route
            Route::get('/live-search', [InventoryController::class, 'liveSearch'])->name('liveSearch');

               Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');


              Route::get('/{inventoryItem}/adjust', [InventoryAdjustmentController::class, 'create'])->name('adjust');
            Route::post('/{inventoryItem}/adjust', [InventoryAdjustmentController::class, 'store'])
                 ->name('inventory.adjust');
        });

        // Add other admin-related routes here
    });

     // Staff Dashboard Route
     Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {
        Route::get('/dashboard', [StaffController::class, 'index'])->name('dashboard');

        Route::get('/dashboard/restock/{id}', [StaffController::class, 'showRestockForm'])->name('showRestockForm');
        Route::get('/dashboard/request-update/{id}', [StaffController::class, 'showUpdateForm'])->name('showUpdateForm');

        Route::post('/dashboard/{id}/restock', [StaffController::class, 'markRestocked'])->name('markRestocked');
        Route::post('/dashboard/{id}/request-update', [StaffController::class, 'requestUpdate'])->name('requestUpdate');
       Route::get('/dashboard/live-search', [StaffController::class, 'liveSearch'])->name('dashboard.liveSearch');
         Route::get('/dashboard/generate-inventory-report', [StaffController::class, 'generateInventoryReport'])->name('generateInventoryReport');

        

    });
 
});

require __DIR__.'/auth.php';