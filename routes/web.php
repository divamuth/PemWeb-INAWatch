<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;

//Redirect root to user dashboard
Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
Route::get('/user/cart', [UserController::class, 'cart'])->name('user.cart');

// Redirect root to seller dashboard
Route::get('/', function () {
    return redirect('/seller/dashboard');
});

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
    Route::get('/dashboard', [SellerController::class, 'index'])
        // ->middleware('auth')
        ->name('seller.dashboard');
    Route::get('/profile', [SellerController::class, 'profile'])->name('seller.profile');
    Route::get('/stock', [SellerController::class, 'stock'])->name('seller.stock');
    Route::get('/order', [SellerController::class, 'order'])->name('seller.order');
    Route::post('/update-order-status', [SellerController::class, 'updateOrderStatus'])->name('seller.updateOrderStatus');
});

// API routes
Route::get('/api/order-stats', [SellerController::class, 'getOrderStats']);
Route::get('/api/stock-stats', [SellerController::class, 'getStockStats']);
?>