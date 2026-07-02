<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/slug/{slug}', [ProductController::class, 'showBySlug'])->name('products.show.slug');
Route::get('/category/{slug}', [ProductController::class, 'byCategory'])->name('category.show');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::post('/location', [LocationController::class, 'store'])->name('location.store');
Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
Route::get('/qr-reader', [QrController::class, 'index'])->name('qr.index');
Route::middleware('auth')->get('/payments', [PaymentController::class, 'index'])->name('payments.index');

// Cart Routes
Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    Route::post('/products/{product}/favorite', [EngagementController::class, 'toggleFavorite'])->name('products.favorite');
    Route::post('/products/{product}/reviews', [EngagementController::class, 'storeReview'])->name('products.reviews.store');

    // Order Routes
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware([\App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
        Route::resource('categories', AdminController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('products', AdminController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        // Orders (admin)
        Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/pending', [App\Http\Controllers\Admin\OrderController::class, 'pending'])->name('orders.pending');
        Route::get('orders/create', [App\Http\Controllers\Admin\OrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [App\Http\Controllers\Admin\OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');
        Route::patch('orders/{order}/deliver', [App\Http\Controllers\Admin\OrderController::class, 'deliver'])->name('orders.deliver');
    });
});

// Auth Routes
require __DIR__.'/auth.php';
