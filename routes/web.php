<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and assigned to the "web"
| middleware group. Make something great!
|
*/

// Redirect root to seller dashboard
Route::get('/', function () {
    return redirect('/seller/dashboard');
});

// Seller routes
Route::prefix('seller')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');
    Route::get('/profile', [SellerController::class, 'profile'])->name('seller.profile');
    Route::get('/stock', [SellerController::class, 'stock'])->name('seller.stock');
    Route::get('/order', [SellerController::class, 'order'])->name('seller.order');
    Route::post('/update-order-status', [SellerController::class, 'updateOrderStatus'])->name('seller.updateOrderStatus');
});

// API routes
Route::get('/api/order-stats', [SellerController::class, 'getOrderStats']);
Route::get('/api/stock-stats', [SellerController::class, 'getStockStats']);
?>