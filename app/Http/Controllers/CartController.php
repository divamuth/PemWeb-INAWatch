<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Address;

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

        return view('user.payment');
    }

    public function getAddressesList()
    {
        $addresses = auth()->user()->addresses;
        
        return response()->json([
            'success' => true,
            'addresses' => $addresses
        ]);
    }

    public function selectCheckoutAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id'
        ]);

        $address = auth()->user()->addresses()->find($request->address_id);
        
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

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

    public function proceedToCheckout(Request $request)
{
    // Log input untuk debugging
    \Log::info('Received selected_items:', $request->input('selected_items', []));

    // Validasi input selected_items
    $request->validate([
        'selected_items' => 'required|array|min:1',
        'selected_items.*' => 'exists:products,id'
    ], [
        'selected_items.required' => 'Please select at least one item to checkout.',
        'selected_items.min' => 'Please select at least one item to checkout.',
        'selected_items.*.exists' => 'One or more selected items are invalid.'
    ]);

    $cart = session()->get('cart', []);
    $selectedItems = $request->input('selected_items', []);

    // Jika cart kosong
    if (empty($cart)) {
        \Log::info('Cart is empty');
        return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
    }

    // Filter hanya item yang dipilih
    $checkoutCart = [];
    $subtotal = 0;

    foreach ($selectedItems as $id) {
        if (isset($cart[$id])) {
            $checkoutCart[$id] = $cart[$id];
            $subtotal += $cart[$id]['price'] * $cart[$id]['quantity'];
        }
    }

    // Jika tidak ada item yang valid dipilih
    if (empty($checkoutCart)) {
        \Log::info('No valid items selected for checkout');
        return redirect()->route('cart.index')->with('error', 'No valid items selected for checkout.');
    }

    // Hitung total dengan biaya pengiriman
    $shipping = 17000; // Sesuaikan dengan logika pengiriman
    $total = $subtotal + $shipping;

    // Simpan data checkout ke session
    session([
        'checkout_cart' => $checkoutCart,
        'checkout_subtotal' => $subtotal,
        'checkout_shipping' => $shipping,
        'checkout_total' => $total
    ]);

    return redirect()->route('checkout.page');
}

    
}