<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Chat;

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

    public function stock()
    {
        $products = Product::all();

        return view('seller.stock', compact('products'));
    }

    public function getStockData()
    {
        $stockData = Product::select('name', 'stock', 'sold')->get();
        return response()->json($stockData);
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
        $sold = Product::sum('sold');
        $stock = Product::sum('stock');

        return response()->json([
            'sold' => $sold,
            'stock' => $stock,
        ]);
    }

    public function profile () {
        return view('seller.profile');
    }

    public function chat(Request $request)
    {
        $userList = User::all();
        $activeUserId = $request->query('user');
        $activeUser = $activeUserId ? User::find($activeUserId) : null;

        $messages = $activeUser ? Chat::where('user_id', $activeUserId)->get() : [];

        return view('seller.chatseller', compact('userList', 'activeUser', 'messages'));
    }

    public function sendChat(Request $request, $userId)
    {
        Chat::create([
            'user_id' => $userId,
            'sender' => 'seller',
            'message' => $request->input('message')
        ]);

        return redirect()->route('seller.chatseller', ['user' => $userId]);
    }
}