<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->where('user_id', Auth::id())->latest()->get();
        return view('user.order', compact('orders'));
    }
    
    public function store(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        // 1. Simpan order utama (tanpa total_price)
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'In Packing',
            'order_date' => now(),
        ]);

        // 2. Simpan setiap item
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_name' => $item['product_name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity'],
            ]);
        }

        // 3. Kosongkan cart
        session()->forget('cart');

        // 4. Redirect ke halaman order
        return redirect()->route('user.order')->with('success', 'Order placed successfully!');
    }
}