@extends('layouts.user')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
    body {
        font-family: "Inter", sans-serif;
    }
</style>

<main class="max-w-6xl mx-auto bg-white mt-6 rounded-2xl p-6 shadow">

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Table Header -->
    <div class="grid grid-cols-[0.5fr_2fr_1fr_1fr_1fr_0.5fr] gap-4 bg-gradient-to-r from-purple-200 to-purple-100 text-center font-medium py-2 rounded-xl text-sm">
        <div></div>
        <div>Product</div>
        <div>Unit Price</div>
        <div>Quantity</div>
        <div>Total Price</div>
        <div>Action</div>
    </div>

    <!-- Product Rows -->
    <div class="divide-y divide-gray-200">
        @php $total = 0; @endphp
        @forelse (session('cart', []) as $id => $item)
            @php
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            @endphp
            <div class="grid grid-cols-[0.5fr_2fr_1fr_1fr_1fr_0.5fr] gap-4 items-center py-4 text-center">
                <div><input type="checkbox" class="w-4 h-4"></div>
                <div class="flex items-center text-left gap-3">
                    <img src="{{ asset($item['image']) }}" class="w-20 h-20 rounded-md object-cover">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item['product_name'] }}</p>
                        @if(isset($item['selected_strap']) && !empty($item['selected_strap']))
                            <p class="text-sm text-gray-600">Strap: {{ $item['selected_strap'] }}</p>
                        @endif
                    </div>
                </div>
                <div class="text-gray-700">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>

                <div>
                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center justify-center gap-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}"
                            class="px-2 py-1 bg-gray-200 rounded-full text-sm hover:bg-gray-300" 
                            {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>-</button>

                        <span class="px-2 min-w-8">{{ $item['quantity'] }}</span>

                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                            class="px-2 py-1 bg-purple-200 rounded-full text-sm hover:bg-purple-300"
                            {{ (isset($item['stock']) && $item['quantity'] >= $item['stock']) ? 'disabled' : '' }}>+</button>
                    </form>
                    @if(isset($item['stock']))
                        <p class="text-xs text-gray-500 mt-1">Stock: {{ $item['stock'] }}</p>
                    @endif
                </div>

                <div class="text-gray-700 font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                <div>
                    <form action="{{ route('cart.remove', $id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to remove this item?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-lg">🗑️</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-20">
                <div class="text-6xl mb-4">🛒</div>
                <p class="text-xl font-medium">Your cart is empty.</p>
                <p class="text-gray-400 mt-2">Browse our products and add items to your cart!</p>
                <a href="{{ route('user.dashboard') }}" class="inline-block mt-4 bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700">
                    Continue Shopping
                </a>
            </div>
        @endforelse
    </div>

    <!-- Footer Checkout -->
    @if (!empty(session('cart')))
    <div class="flex justify-between items-center mt-6 bg-white shadow-lg rounded-full px-6 py-4 border">
        <div class="flex items-center gap-2">
            <input type="checkbox" checked class="w-4 h-4" id="select-all">
            <label for="select-all" class="text-sm text-gray-700 cursor-pointer">
                Choose all ({{ count(session('cart')) }})
            </label>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-sm text-gray-600">
                    Total ({{ count(session('cart')) }} product{{ count(session('cart')) > 1 ? 's' : '' }}):
                </p>
                <p class="text-xl font-bold text-gray-900">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </p>
            </div>
            <form action="{{ route('cart.proceedToCheckout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-black text-white px-6 py-3 rounded-full text-sm font-semibold hover:bg-gray-800 transition-colors">
                    Checkout
                </button>
            </form>
        </div>
    </div>
    @endif
</main>

<script>
    // Select all functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('input[type="checkbox"]:not(#select-all)');

    if (selectAllCheckbox && itemCheckboxes.length > 0) {
        selectAllCheckbox.addEventListener('change', function() {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
            });
        });
    }
</script>
@endsection