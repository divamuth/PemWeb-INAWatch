<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;

// Redirect root to seller dashboard
Route::get('/', function () {
    return redirect('/seller/dashboard');
});

// Redirect root to user dashboard
Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
Route::get('/user/cart', [UserController::class, 'cart'])->name('user.cart');
Route::post('/user/address', [AddressController::class, 'store'])->name('user.address.store');
Route::get('/user/address', [AddressController::class, 'index'])
    ->middleware('auth')
    ->name('user.address');

Route::get('/user/address', [AddressController::class, 'index'])->name('user.address');
Route::get('/user/order', [UserController::class, 'order'])->name('user.order');
Route::get('/user/chatuser', [UserController::class, 'chatuser'])->name('user.chatuser');
Route::get('/user/custom', [UserController::class, 'custom'])->name('user.custom');
Route::get('/payment', [UserController::class, 'payment'])->name('user.payment');

// Auth routes
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::post('/register', [UserController::class, 'store'])->name('register.submit');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Seller routes
Route::prefix('seller')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');
    
    // Stock routes - Complete CRUD
    Route::get('/stock', [SellerController::class, 'stock'])->name('seller.stock');
    Route::get('/stock/create', [SellerController::class, 'create'])->name('stock.create');
    Route::post('/stock', [ProductController::class, 'store'])->name('stock.store');
    Route::get('/stock/{id}/edit', [SellerController::class, 'edit'])->name('stock.edit');
    Route::put('/stock/{id}', [SellerController::class, 'update'])->name('stock.update');
    
    // Stock data and stats
    Route::get('/stock-data', [SellerController::class, 'getStockData'])->name('seller.stock.data');
    Route::get('/stock-stats', [SellerController::class, 'getStockStats'])->name('seller.getStockStats');
    
    // Order routes
    Route::get('/order', [SellerController::class, 'order'])->name('seller.order');
    Route::post('/update-order-status', [SellerController::class, 'updateOrderStatus'])->name('seller.updateOrderStatus');
    
    // Chat routes
    Route::get('/chatseller', [SellerController::class, 'chat'])->name('seller.chatseller');
    Route::post('/chatseller/{user}/send', [SellerController::class, 'sendChat'])->name('seller.chatseller.send');
    
    // Store profile routes
    Route::get('/profile', [StoreController::class, 'edit'])->name('seller.profile');
    Route::post('/profile', [StoreController::class, 'update'])->name('seller.profile.update');
});

// Route untuk ProductController
Route::get('/seller/stock/{id}', [ProductController::class, 'show'])->name('stock.show');
Route::put('/seller/stock/{id}', [ProductController::class, 'update'])->name('stock.update');
Route::delete('/seller/stock/{id}', [ProductController::class, 'destroy'])->name('stock.destroy');

// API routes
Route::get('/api/order-stats', [SellerController::class, 'getOrderStats']);
Route::get('/api/stock-stats', [SellerController::class, 'getStockStats']);