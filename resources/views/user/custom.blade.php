@extends('layouts.user')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
    body {
        font-family: "Inter", sans-serif;
    }
</style>

<!-- Product Detail -->
<main class="max-w-6xl mx-auto bg-white mt-6 rounded-2xl p-8 shadow">
    
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Gambar dan Info -->
        <div class="bg-white rounded-2xl p-6 shadow text-center">
            <img src="{{ asset($product->image) }}" alt="{{ $product->product_name }}" class="mx-auto mb-4 rounded-xl max-w-full h-auto">
            <h2 class="text-lg font-bold text-gray-800">{{ $product->product_name }}</h2>
            <div class="flex justify-between items-center mt-2 text-sm text-gray-700">
                <span class="text-gray-700 mt-2 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="text-gray-500 text-sm mt-1">{{ $product->sold ?? 0 }} Sold</span>
            </div>
            @if($product->variation)
                <div class="mt-2">
                    <span class="text-sm text-gray-600">Variation: {{ $product->variation }}</span>
                </div>
            @endif
            <div class="mt-2">
                <span class="text-sm text-gray-600">Stock: {{ $product->stock }}</span>
            </div>
        </div>

        <!-- Opsi Custom -->
        <div>
            <h3 class="text-md font-semibold text-gray-800 mb-2">Choose your favourite strap: <span class="text-red-500">*</span></h3>
            <div class="flex flex-wrap gap-3 mb-6">
                @foreach (['L. Abu Polos', 'L. Hijau Mint', 'L. Biru Putih', 'L. Terracotta', 'L. Cream', 'L. Lapis Kuning', 'L. Lapis Putih', 'L. Orange', 'L. Orange Putih'] as $strap)
                    <button class="w-36 h-10 bg-white border border-gray-300 rounded-full text-sm flex items-center justify-center text-center hover:bg-purple-100 strap-option transition-colors" 
                            data-strap="{{ $strap }}">{{ $strap }}</button>
                @endforeach
            </div>
            <div id="strap-error" class="text-red-500 text-sm mb-4 hidden">Please select a strap first!</div>

            <!-- Kuantitas -->
            <h3 class="text-md font-semibold text-gray-800 mb-2">Kuantitas:</h3>
            <div class="flex items-center space-x-4 mt-4">
                <button id="decrease" class="w-10 h-10 rounded-full bg-gray-200 text-xl font-bold hover:bg-gray-300 transition-colors">-</button>
                <span id="quantity" class="text-xl font-semibold min-w-8 text-center">1</span>
                <button id="increase" class="w-10 h-10 rounded-full bg-gray-200 text-xl font-bold hover:bg-gray-300 transition-colors">+</button>
            </div>
            <div id="stock-error" class="text-red-500 text-sm mt-2 hidden">Stock tidak mencukupi!</div>

            <!-- Total & Button -->
            <div class="mb-4 mt-60">
                <p class="text-gray-700 text-md">Total:</p>
                <p id="total-price" class="text-2xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>

            <div class="flex gap-4 mt-5">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1" id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="quantity" id="cart-quantity" value="1">
                    <input type="hidden" name="selected_strap" id="selected-strap" value="">
                    <button type="submit" class="w-full bg-white border border-black text-black px-6 py-3 rounded-full flex items-center justify-center gap-2 hover:bg-gray-100 transition-colors">
                        Add to <span>🛒</span>
                    </button>
                </form>
                
                <form action="{{ route('cart.buyNow') }}" method="POST" class="flex-1" id="buy-now-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" id="buy-now-quantity" value="1">
                    <input type="hidden" name="selected_strap" id="buy-now-strap" value="">
                    <button type="submit" class="w-full bg-purple-300 text-white px-6 py-3 rounded-full hover:bg-pink-200 transition-colors">Buy Now</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    const quantityEl = document.getElementById('quantity');
    const increaseBtn = document.getElementById('increase');
    const decreaseBtn = document.getElementById('decrease');
    const totalPriceEl = document.getElementById('total-price');
    const cartQuantityInput = document.getElementById('cart-quantity');
    const selectedStrapInput = document.getElementById('selected-strap');
    const buyNowQuantityInput = document.getElementById('buy-now-quantity');
    const buyNowStrapInput = document.getElementById('buy-now-strap');
    const strapError = document.getElementById('strap-error');
    const stockError = document.getElementById('stock-error');
    const addToCartForm = document.getElementById('add-to-cart-form');
    const buyNowForm = document.getElementById('buy-now-form');
    
    const basePrice = {{ $product->price }};
    const maxStock = {{ $product->stock }};
    let quantity = 1;
    let selectedStrap = '';

    // Update total price
    function updateTotal() {
        const total = basePrice * quantity;
        totalPriceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        cartQuantityInput.value = quantity;
        buyNowQuantityInput.value = quantity;
    }

    // Update strap inputs
    function updateStrapInputs() {
        selectedStrapInput.value = selectedStrap;
        buyNowStrapInput.value = selectedStrap;
    }

    // Show/hide error messages
    function showStrapError() {
        strapError.classList.remove('hidden');
        setTimeout(() => {
            strapError.classList.add('hidden');
        }, 3000);
    }

    function showStockError() {
        stockError.classList.remove('hidden');
        setTimeout(() => {
            stockError.classList.add('hidden');
        }, 3000);
    }

    // Quantity controls
    increaseBtn.addEventListener('click', () => {
        if (quantity < maxStock) {
            quantity++;
            quantityEl.textContent = quantity;
            updateTotal();
        } else {
            showStockError();
        }
    });

    decreaseBtn.addEventListener('click', () => {
        if (quantity > 1) {
            quantity--;
            quantityEl.textContent = quantity;
            updateTotal();
        }
    });

    // Strap selection
    document.querySelectorAll('.strap-option').forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            document.querySelectorAll('.strap-option').forEach(btn => {
                btn.classList.remove('bg-purple-200', 'border-purple-400');
                btn.classList.add('bg-white', 'border-gray-300');
            });
            
            // Add active class to clicked button
            button.classList.remove('bg-white', 'border-gray-300');
            button.classList.add('bg-purple-200', 'border-purple-400');
            
            selectedStrap = button.dataset.strap;
            updateStrapInputs();
        });
    });

    // Form validation
    addToCartForm.addEventListener('submit', function(e) {
        if (!selectedStrap) {
            e.preventDefault();
            showStrapError();
            return false;
        }
    });

    buyNowForm.addEventListener('submit', function(e) {
        if (!selectedStrap) {
            e.preventDefault();
            showStrapError();
            return false;
        }
    });
</script>
@endsection