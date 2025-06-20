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
    
    public function checkout(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to checkout.');
        }

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Store cart data and totals in session for payment page
        session([
            'checkout_cart' => $cart,
            'checkout_subtotal' => $subtotal,
            'checkout_shipping' => 17000, // Fixed shipping cost
            'checkout_total' => $subtotal + 17000
        ]);

        // Redirect to payment page
        return redirect()->route('user.payment')->with('success', 'Proceed to payment.');
    }
    
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to place order.');
        }

        // Get cart from checkout session or regular cart session
        $cart = session('checkout_cart', session('cart', []));

        if (empty($cart)) {
            return redirect()->route('user.cart')->with('error', 'Cart is empty.');
        }

        // Calculate total price
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Add shipping cost
        $shippingCost = 17000;
        $finalTotal = $totalPrice + $shippingCost;

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'In Packing',
            'order_date' => now(),
            'total_price' => $finalTotal,
            'shipping_cost' => $shippingCost,
            'subtotal' => $totalPrice,
        ]);

        // Create order items - FIXED VERSION
        foreach ($cart as $cartKey => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity'],
                'selected_strap' => $item['selected_strap'] ?? null,
                'image' => $item['image'] // Simpan gambar produk
            ]);
        }

        // Clear cart and checkout sessions
        session()->forget(['cart', 'checkout_cart', 'checkout_subtotal', 'checkout_shipping', 'checkout_total']);

        // Redirect to orders page with success message
        return redirect()->route('user.orders')->with('success', 'Order placed successfully! Order ID: #' . $order->id);
    }
    
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:In Packing,Delivered,Finished,Cancelled'
        ]);

        $order = Order::findOrFail($orderId);
        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully!'
        ]);
    }
    
    public function cancel($orderId)
    {
        $order = Order::where('id', $orderId)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        if (in_array($order->status, ['Shipped', 'Delivered'])) {
            return redirect()->back()->with('error', 'Cannot cancel order that has been shipped or delivered.');
        }

        $order->update(['status' => 'Cancelled']);

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }

   public function filter(Request $request)
    {
        try {
            $status = $request->input('status', 'all');
            
            $orders = Order::with(['items.product'])
                        ->where('user_id', auth()->id())
                        ->when($status !== 'all', function($query) use ($status) {
                                return $query->whereRaw('LOWER(status) = ?', [strtolower($status)]);
                            })
                        ->orderBy('created_at', 'desc')
                        ->get();

            // Log after variables are defined
            \Log::info('Filter query', ['status' => $status, 'orders_count' => $orders->count()]);

            return response()->json([
                'html' => view('user.orders-list', compact('orders'))->render(),
                'debug' => ['status' => $status, 'count' => $orders->count()]
            ]);

        } catch (\Exception $e) {
            \Log::error('Filter error', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}