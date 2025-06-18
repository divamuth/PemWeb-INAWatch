<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Root redirect
Route::get('/', function () {
    return redirect('/seller/dashboard');
});

// CSRF Token Route
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->middleware('web');

// Auth routes
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::post('/register', [UserController::class, 'store'])->name('register.submit');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// User Routes
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Cart (khusus tampilan user)
    Route::get('/cart', [UserController::class, 'cart'])->name('cart');

    // Address Management
    Route::get('/address', [AddressController::class, 'index'])->name('address.index');
    Route::post('/address', [AddressController::class, 'store'])->name('address.store');
    Route::put('/address/{address}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/address/{address}', [AddressController::class, 'destroy'])->name('address.destroy');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // Checkout
    Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.submit');

    // Address selection for checkout
    Route::get('/addresses/list', [UserController::class, 'getAddressesList'])->name('addresses.list');
    Route::post('/checkout/select-address', [UserController::class, 'selectCheckoutAddress'])->name('checkout.select-address');

    // Payment
    Route::get('/payment', [UserController::class, 'payment'])->name('payment');

    // Chat
    Route::get('/chat', [UserController::class, 'chatuser'])->name('chat');

    // Custom Orders
    Route::get('/custom', [UserController::class, 'custom'])->name('custom');
});

// Cart Routes (umum)
Route::prefix('cart')->name('cart.')->middleware('auth')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
});

// Checkout Routes (umum)
Route::prefix('checkout')->name('checkout.')->middleware('auth')->group(function () {
    Route::get('/', [CartController::class, 'checkout'])->name('page');
    Route::post('/proceed', [CartController::class, 'proceedToCheckout'])->name('proceed');
    Route::get('/addresses/list', [CartController::class, 'getAddressesList'])->name('addresses.list');
    Route::post('/select-address', [CartController::class, 'selectCheckoutAddress'])->name('select-address');
});

// Seller Routes
Route::prefix('seller')->name('seller.')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SellerController::class, 'index'])->name('dashboard');

    // Stock Management
    Route::get('/stock', [SellerController::class, 'stock'])->name('stock');
    Route::get('/stock/create', [SellerController::class, 'create'])->name('stock.create');
    Route::post('/stock', [ProductController::class, 'store'])->name('stock.store');
    Route::get('/stock/{id}', [ProductController::class, 'show'])->name('stock.show');
    Route::get('/stock/{id}/edit', [SellerController::class, 'edit'])->name('stock.edit');
    Route::put('/stock/{id}', [ProductController::class, 'update'])->name('stock.update');
    Route::delete('/stock/{id}', [ProductController::class, 'destroy'])->name('stock.destroy');

    // Stock Data & Stats
    Route::get('/stock-data', [SellerController::class, 'getStockData'])->name('stock.data');
    Route::get('/stock-stats', [SellerController::class, 'getStockStats'])->name('stock.stats');

    // Order Management
    Route::get('/orders', [SellerController::class, 'order'])->name('orders');
    Route::post('/orders/update-status', [SellerController::class, 'updateOrderStatus'])->name('orders.update_status');

    // Chat
    Route::get('/chat', [SellerController::class, 'chat'])->name('chat');
    Route::post('/chat/{user}/send', [SellerController::class, 'sendChat'])->name('chat.send');

    // Store Profile
    Route::get('/profile', [StoreController::class, 'edit'])->name('profile');
    Route::post('/profile', [StoreController::class, 'update'])->name('profile.update');
});

// API Routes
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/order-stats', [SellerController::class, 'getOrderStats'])->name('order_stats');
    Route::get('/stock-stats', [SellerController::class, 'getStockStats'])->name('stock_stats');
});

// Redirects (untuk kompatibilitas lama)
Route::get('/user/order', fn() => redirect()->route('user.orders'))->name('user.order');
Route::get('/user/chatuser', fn() => redirect()->route('user.chat'))->name('user.chatuser');
Route::get('/seller/chatseller', fn() => redirect()->route('seller.chat'))->name('seller.chatseller');
Route::get('/seller/order', fn() => redirect()->route('seller.orders'))->name('seller.order');
Route::post('/order', fn() => redirect()->route('user.checkout'))->name('user.store');
