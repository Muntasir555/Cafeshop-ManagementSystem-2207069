<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;

// ── Public homepage ──────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ── Smart "dashboard" redirect (required by Laravel Breeze) ───
// Breeze controllers redirect to route('dashboard') after login/register.
// We intercept this and send admins to /admin, customers to /.
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect('/');
})->middleware('auth')->name('dashboard');

// ── Auth routes (Laravel Breeze) ─────────────────────────────
require __DIR__.'/auth.php';

// ── Admin panel (auth + admin role required) ──────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Products CRUD
    Route::resource('products', ProductController::class);
    Route::patch('products/{product}/toggle', [ProductController::class, 'toggleAvailable'])
         ->name('products.toggle');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    // Customers
    Route::get('users', [UserController::class, 'index'])->name('users.index');
});
