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

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::post('/register', [UserController::class, 'store'])->name('register.submit');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update')->middleware('auth');
    
    // Cart
    Route::get('/cart', [UserController::class, 'cart'])->name('cart');
    
    // Address Management
    Route::middleware(['auth'])->group(function () {
        Route::get('/address', [AddressController::class, 'index'])->name('address.index');
        Route::post('/address', [AddressController::class, 'store'])->name('address.store');
        Route::put('/address/{address}', [AddressController::class, 'update'])->name('address.update');
        Route::delete('/address/{address}', [AddressController::class, 'destroy'])->name('address.destroy');
    });
    
    // Orders & Checkout
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    
    // Payment
    Route::get('/payment', [UserController::class, 'payment'])->name('payment');
    
    // Chat
    Route::get('/chat', [UserController::class, 'chatuser'])->name('chat');
    
    // Custom Orders
    Route::get('/custom', [UserController::class, 'custom'])->name('custom');
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
});

Route::prefix('seller')->name('seller.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SellerController::class, 'index'])->name('dashboard');
    
    // Stock Management - Complete CRUD
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

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/order-stats', [SellerController::class, 'getOrderStats'])->name('order_stats');
    Route::get('/stock-stats', [SellerController::class, 'getStockStats'])->name('stock_stats');
});

// Legacy user routes - redirect to new structure
Route::get('/user/order', function () {
    return redirect()->route('user.orders');
})->name('user.order');

Route::get('/user/chatuser', function () {
    return redirect()->route('user.chat');
})->name('user.chatuser');

Route::get('/user/address', function () {
    return redirect()->route('user.address.index');
})->name('user.address');

// Legacy seller routes - redirect to new structure
Route::get('/seller/chatseller', function () {
    return redirect()->route('seller.chat');
})->name('seller.chatseller');

Route::get('/seller/order', function () {
    return redirect()->route('seller.orders');
})->name('seller.order');

// Legacy product routes - maintain for now
Route::put('/seller/stock/{id}', [ProductController::class, 'update'])->name('stock.update');
Route::delete('/seller/stock/{id}', [ProductController::class, 'destroy'])->name('stock.destroy');

// Legacy order route - redirect to new checkout
Route::post('/order', function () {
    return redirect()->route('user.checkout');
})->name('user.store');