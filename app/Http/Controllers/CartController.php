<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Address; // Pastikan model Address sudah ada

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'product_name' => $product->product_name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function index()
    {
        return view('user.cart');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    public function update(Request $request, $id)
    {
        $quantity = $request->quantity;
        $cart = session('cart', []);
        if ($quantity <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] = $quantity;
        }
        session(['cart' => $cart]);
        return redirect()->route('cart.index');
    }

    // ===== PAYMENT/CHECKOUT METHODS =====

    public function checkout()
    {
        // Jika belum ada address yang dipilih, ambil address default/pertama
        if (!session('selected_address')) {
            $defaultAddress = auth()->user()->addresses()->first();
            if ($defaultAddress) {
                session([
                    'selected_address' => [
                        'id' => $defaultAddress->id,
                        'category' => $defaultAddress->category,
                        'name' => $defaultAddress->name,
                        'phone' => $defaultAddress->phone,
                        'address_detail' => $defaultAddress->address_detail,
                        'district' => $defaultAddress->district,
                        'city' => $defaultAddress->city,
                        'province' => $defaultAddress->province,
                        'post' => $defaultAddress->post
                    ]
                ]);
            }
        }

        return view('user.payment'); // atau sesuaikan dengan nama view payment Anda
    }

    // Method untuk mendapatkan list address dalam format JSON
    public function getAddressesList()
    {
        $addresses = auth()->user()->addresses; // Sesuaikan dengan relasi di model User
        
        return response()->json([
            'success' => true,
            'addresses' => $addresses
        ]);
    }

    // Method untuk menyimpan address yang dipilih ke session
    public function selectCheckoutAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id'
        ]);

        // Cari address berdasarkan user yang login dan address_id
        $address = auth()->user()->addresses()->find($request->address_id);
        
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        // Simpan address yang dipilih ke session
        session([
            'selected_address' => [
                'id' => $address->id,
                'category' => $address->category,
                'name' => $address->name,
                'phone' => $address->phone,
                'address_detail' => $address->address_detail,
                'district' => $address->district,
                'city' => $address->city,
                'province' => $address->province,
                'post' => $address->post
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address selected successfully'
        ]);
    }

    // Method untuk proses checkout ke payment
    public function proceedToCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Hitung total
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $shipping = 17000; // atau sesuaikan dengan logika shipping Anda
        $total = $subtotal + $shipping;

        // Simpan data checkout ke session
        session([
            'checkout_cart' => $cart,
            'checkout_subtotal' => $subtotal,
            'checkout_shipping' => $shipping,
            'checkout_total' => $total
        ]);

        return redirect()->route('cart.checkout');
    }
}