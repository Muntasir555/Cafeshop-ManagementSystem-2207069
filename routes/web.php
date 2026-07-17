<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreLocatorController;

// ── Public store locator ─────────────────────────────────────
Route::get('/find-store', [StoreLocatorController::class, 'index'])->name('stores.locator');
Route::get('/api/stores', [StoreLocatorController::class, 'apiStores']);

// ── Public homepage ──────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ── Public rewards page ───────────────────────────────────────
Route::get('/rewards', function () {
    return view('rewards');
})->name('rewards');

// ── Public gift cards page ────────────────────────────────────
Route::get('/gift-cards', function () {
    return view('gift-cards');
})->name('gift.cards');

// ── Public menu page ─────────────────────────────────────────
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// ── Public order placement (from menu page cart) ──────────────
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

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
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

    // Customers
    Route::get('users', [UserController::class, 'index'])->name('users.index');
});
