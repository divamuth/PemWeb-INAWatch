<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;

// Redirect root to user dashboard
Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard')->middleware('auth');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
Route::get('/user/cart', [UserController::class, 'cart'])->name('user.cart');
Route::get('/user/address', [UserController::class, 'address'])->name('user.address');
Route::get('/user/order', [UserController::class, 'order'])->name('user.order');
Route::get('/user/chatuser', [UserController::class, 'chatuser'])->name('user.chatuser');
Route::get('/user/custom', [UserController::class, 'custom'])->name('user.custom');
Route::get('/payment', [UserController::class, 'payment'])->name('user.payment');

// Redirect root to seller dashboard
Route::get('/', function () {
    return redirect('/login');
});

// Auth routes
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::post('/register', [UserController::class, 'store'])->name('register.submit');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Menampilkan form login
Route::get('/login', [\App\Http\Controllers\UserController::class, 'showLogin'])->name('login');
Route::get('/register', [UserController::class, 'register'])->name('register');

// Menangani form login
Route::post('/login', [\App\Http\Controllers\UserController::class, 'login'])->name('login.submit');
Route::post('/register', [UserController::class, 'store'])->name('register.submit');

// Logout
Route::get('/logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('logout');

// Seller routes
Route::prefix('seller')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');
    Route::get('/stock', [SellerController::class, 'stock'])->name('seller.stock');
    Route::get('/order', [SellerController::class, 'order'])->name('seller.order');
    Route::post('/update-order-status', [SellerController::class, 'updateOrderStatus'])->name('seller.updateOrderStatus');  
    Route::get('/stock-data', [SellerController::class, 'getStockData'])->name('seller.stock.data');
    Route::get('/stock/edit', [SellerController::class, 'edit'])->name('seller.stock.edit');
    Route::get('/seller/stock-stats', [SellerController::class, 'getStockStats'])->name('seller.getStockStats');
    Route::get('/chatseller', [SellerController::class, 'chat'])->name('seller.chatseller');
    Route::post('/chatseller/{user}/send', [SellerController::class, 'sendChat'])->name('seller.chatseller.send');

    // ✅ Gunakan StoreController untuk profil toko
    Route::get('/profile', [StoreController::class, 'edit'])->name('seller.profile');
    Route::post('/profile', [StoreController::class, 'update'])->name('seller.profile.update');
});

// API routes
Route::get('/api/order-stats', [SellerController::class, 'getOrderStats']);
Route::get('/api/stock-stats', [SellerController::class, 'getStockStats']);