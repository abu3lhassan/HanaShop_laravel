<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Shopping;

Route::get('/', [Shopping::class, 'index'])->name('index');

Route::get('/electric', [Shopping::class, 'electric'])->name('electric');
Route::get('/zena', [Shopping::class, 'zena'])->name('zena');
Route::get('/kitchen-tools', [Shopping::class, 'kitchenTools'])->name('kitchenTools');

Route::get('/category/{slug}', [Shopping::class, 'category'])->name('category.show');
Route::get('/product/{category}/{id}', [Shopping::class, 'productdetails'])->name('proddet');

Route::get('/cart', [Shopping::class, 'cart'])->name('cart');
Route::post('/add-to-cart', [Shopping::class, 'addToCart'])->name('add_to_cart');
Route::post('/cart/update', [Shopping::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [Shopping::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [Shopping::class, 'clearCart'])->name('cart.clear');
Route::post('/cart/checkout', [Shopping::class, 'checkout'])->name('cart.checkout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/products', [DashboardController::class, 'products'])->name('products');
    Route::post('/products', [DashboardController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [DashboardController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [DashboardController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [DashboardController::class, 'deleteProduct'])->name('products.destroy');

    Route::get('/categories', [DashboardController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [DashboardController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{id}', [DashboardController::class, 'updateCategory'])->name('categories.update');
    Route::post('/categories/{id}/toggle', [DashboardController::class, 'toggleCategory'])->name('categories.toggle');

    Route::get('/product-details', [DashboardController::class, 'productDetails'])->name('product-details.index');
    Route::post('/product-details', [DashboardController::class, 'storeProductDetails'])->name('product-details.store');

    Route::get('/customers', [DashboardController::class, 'customers'])->name('customers.index');

    Route::get('/invoices', [DashboardController::class, 'invoices'])->name('invoices.index');
    Route::get('/invoices/{id}', [DashboardController::class, 'showInvoice'])->name('invoices.show');

    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings.index');
    Route::put('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');

    Route::get('/admin-users', [DashboardController::class, 'adminUsers'])->name('admin-users.index');
    Route::post('/admin-users', [DashboardController::class, 'storeAdminUser'])->name('admin-users.store');
    Route::put('/admin-users/{id}', [DashboardController::class, 'updateAdminUser'])->name('admin-users.update');
    Route::delete('/admin-users/{id}', [DashboardController::class, 'deleteAdminUser'])->name('admin-users.destroy');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');