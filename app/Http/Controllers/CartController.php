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
        $quantity = $request->input('quantity', 1);
        $selectedStrap = $request->input('selected_strap', '');

        // Validasi strap harus dipilih
        if (empty($selectedStrap)) {
            return redirect()->back()->with('error', 'Please select a strap first!');
        }

        // Validasi stock
        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Stock tidak mencukupi!');
        }

        $cart = session()->get('cart', []);

        // Buat key unik berdasarkan product_id dan strap yang dipilih
        $cartKey = $id . '_' . str_replace(' ', '_', $selectedStrap);

        if (isset($cart[$cartKey])) {
            // Jika item sudah ada, tambah quantity
            $newQuantity = $cart[$cartKey]['quantity'] + $quantity;
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'Stock tidak mencukupi!');
            }
            $cart[$cartKey]['quantity'] = $newQuantity;
        } else {
            // Jika item belum ada, buat baru
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
                'selected_strap' => $selectedStrap,
                'stock' => $product->stock
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
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
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $newQty = max(1, intval($request->quantity));
            
            // Validasi dengan stock yang tersedia
            if (isset($cart[$id]['stock']) && $newQty > $cart[$id]['stock']) {
                return redirect()->route('cart.index')->with('error', 'Stock tidak mencukupi!');
            }
            
            $cart[$id]['quantity'] = $newQty;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    // Method untuk buy now langsung dari product detail
    public function buyNow(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $selectedStrap = $request->input('selected_strap', '');

        // Validasi input
        if (empty($selectedStrap)) {
            return redirect()->back()->with('error', 'Please select a strap first!');
        }

        $product = Product::findOrFail($productId);

        // Validasi stock
        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Stock tidak mencukupi!');
        }

        // Buat temporary cart untuk buy now
        $buyNowItem = [
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => $quantity,
            'selected_strap' => $selectedStrap,
            'stock' => $product->stock
        ];

        // Hitung total
        $subtotal = $product->price * $quantity;
        $shipping = 17000; // atau sesuaikan dengan logika shipping Anda
        $total = $subtotal + $shipping;

        // Simpan data buy now ke session
        session([
            'buy_now_item' => $buyNowItem,
            'checkout_cart' => [$productId . '_' . str_replace(' ', '_', $selectedStrap) => $buyNowItem],
            'checkout_subtotal' => $subtotal,
            'checkout_shipping' => $shipping,
            'checkout_total' => $total,
            'is_buy_now' => true // flag untuk membedakan buy now dengan checkout biasa
        ]);

        return redirect()->route('cart.checkout');
    }

    // ===== PAYMENT/CHECKOUT METHODS =====

    public function checkout()
    {
        // Cek apakah ini buy now atau checkout dari cart
        $isBuyNow = session('is_buy_now', false);
        
        if (!$isBuyNow) {
            if (!session('checkout_cart')) {
                $cart = session()->get('cart', []);
                
                if (empty($cart)) {
                    return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
                }

                // Hitung total untuk semua item di cart (fallback jika tidak ada item terpilih)
                $subtotal = 0;
                foreach ($cart as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }
                
                $shipping = 17000;
                $total = $subtotal + $shipping;

                // Simpan data checkout ke session
                session([
                    'checkout_cart' => $cart,
                    'checkout_subtotal' => $subtotal,
                    'checkout_shipping' => $shipping,
                    'checkout_total' => $total,
                    'is_buy_now' => false
                ]);
            }
        }

        // Validasi: pastikan ada item di checkout_cart
        $checkoutCart = session('checkout_cart', []);
        if (empty($checkoutCart)) {
            return redirect()->route('cart.index')->with('error', 'No items selected for checkout!');
        }

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
        $cart = session()->get('cart', []);
        $selectedItems = $request->input('selected_items', []);

        // Jika cart kosong
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Jika tidak ada item yang dipilih
        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Please select at least one item to checkout.');
        }

        // Validasi bahwa semua selected items ada di cart
        $validSelectedItems = [];
        foreach ($selectedItems as $cartKey) {
            if (isset($cart[$cartKey])) {
                $validSelectedItems[] = $cartKey;
            }
        }

        if (empty($validSelectedItems)) {
            return redirect()->route('cart.index')->with('error', 'No valid items selected for checkout.');
        }

        // Filter hanya item yang dipilih
        $checkoutCart = [];
        $subtotal = 0;

        foreach ($validSelectedItems as $cartKey) {
            $checkoutCart[$cartKey] = $cart[$cartKey];
            $subtotal += $cart[$cartKey]['price'] * $cart[$cartKey]['quantity'];
        }

        // Hitung total dengan biaya pengiriman
        $shipping = 17000;
        $total = $subtotal + $shipping;

        // CLEAR session checkout sebelumnya untuk memastikan data fresh
        session()->forget(['checkout_cart', 'checkout_subtotal', 'checkout_shipping', 'checkout_total', 'is_buy_now']);

        // Simpan data checkout ke session
        session([
            'checkout_cart' => $checkoutCart,
            'checkout_subtotal' => $subtotal,
            'checkout_shipping' => $shipping,
            'checkout_total' => $total,
            'is_buy_now' => false
        ]);

        // Debug log (opsional)
        \Log::info('Checkout process completed', [
            'selected_items_count' => count($validSelectedItems),
            'subtotal' => $subtotal,
            'total' => $total,
            'selected_items' => $validSelectedItems
        ]);

        // Redirect ke halaman checkout
        return redirect()->route('cart.checkout');
    }
}