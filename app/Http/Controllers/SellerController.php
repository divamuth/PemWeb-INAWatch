<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class SellerController extends Controller
{
    public function index()
    {
        // Ambil data statistik order dari database
        $orderStats = Order::getOrderStats();
        
        // Ambil data statistik stock dari database
        $stockStats = Product::getStockStats();

        // Jika tidak ada data, gunakan data dummy
        if (empty($orderStats) || array_sum($orderStats) == 0) {
            $orderStats = [
                'finished' => 0,
                'in_packing' => 0,
                'delivered' => 0,
                'cancelled' => 0
            ];
        }

        if (empty($stockStats) || array_sum($stockStats) == 0) {
            $stockStats = [
                'sold' => 0,
                'stock' => 0
            ];
        }

        return view('seller.dashboard', compact('orderStats', 'stockStats'));
    }

    public function order()
    {
    $orders = Order::with('products')->get(); 
    return view('seller.order', compact('orders'));
    }

    public function getOrderStats()
    {
        return response()->json(Order::getOrderStats());
    }

    public function getStockStats()
    {
        return response()->json(Product::getStockStats());
    }

    public function profile () {
        return view('seller.profile');
    }
}