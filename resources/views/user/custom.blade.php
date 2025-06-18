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
            <h3 class="text-md font-semibold text-gray-800 mb-2">Choose your favourite strap:</h3>
            <div class="flex flex-wrap gap-3 mb-6">
                @foreach (['L. Abu Polos', 'L. Hijau Mint', 'L. Biru Putih', 'L. Terracotta', 'L. Cream', 'L. Lapis Kuning', 'L. Lapis Putih', 'L. Orange', 'L. Orange Putih'] as $strap)
                    <button class="w-36 h-10 bg-white border border-gray-300 rounded-full text-sm flex items-center justify-center text-center hover:bg-purple-100 strap-option" 
                            data-strap="{{ $strap }}">{{ $strap }}</button>
                @endforeach
            </div>

            <!-- Kuantitas -->
            <h3 class="text-md font-semibold text-gray-800 mb-2">Kuantitas:</h3>
            <div class="flex items-center space-x-4 mt-4">
                <button id="decrease" class="w-10 h-10 rounded-full bg-gray-200 text-xl font-bold hover:bg-gray-300">-</button>
                <span id="quantity" class="text-xl font-semibold">1</span>
                <button id="increase" class="w-10 h-10 rounded-full bg-gray-200 text-xl font-bold hover:bg-gray-300">+</button>
            </div>

            <!-- Total & Button -->
            <div class="mb-4 mt-60">
                <p class="text-gray-700 text-md">Total:</p>
                <p id="total-price" class="text-2xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>

            <div class="flex gap-4 mt-5">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="quantity" id="cart-quantity" value="1">
                    <input type="hidden" name="selected_strap" id="selected-strap" value="">
                    <button type="submit" class="w-full bg-white border border-black text-black px-6 py-3 rounded-full flex items-center justify-center gap-2 hover:bg-gray-100">
                        Add to <span>🛒</span>
                    </button>
                </form>
                <button class="flex-1 bg-black text-white px-6 py-3 rounded-full hover:bg-gray-800" onclick="buyNow()">Buy Now</button>
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
    
    const basePrice = {{ $product->price }};
    const maxStock = {{ $product->stock }};
    let quantity = 1;
    let selectedStrap = '';

    // Update total price
    function updateTotal() {
        const total = basePrice * quantity;
        totalPriceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        cartQuantityInput.value = quantity;
    }

    // Quantity controls
    increaseBtn.addEventListener('click', () => {
        if (quantity < maxStock) {
            quantity++;
            quantityEl.textContent = quantity;
            updateTotal();
        } else {
            alert('Stock tidak mencukupi!');
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
            selectedStrapInput.value = selectedStrap;
        });
    });

    // Buy now function
    function buyNow() {
        if (!selectedStrap) {
            alert('Please select a strap first!');
            return;
        }
        
        // Create form for buy now
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("user.checkout") }}';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add product data
        const productId = document.createElement('input');
        productId.type = 'hidden';
        productId.name = 'product_id';
        productId.value = '{{ $product->id }}';
        form.appendChild(productId);
        
        const productQuantity = document.createElement('input');
        productQuantity.type = 'hidden';
        productQuantity.name = 'quantity';
        productQuantity.value = quantity;
        form.appendChild(productQuantity);
        
        const productStrap = document.createElement('input');
        productStrap.type = 'hidden';
        productStrap.name = 'selected_strap';
        productStrap.value = selectedStrap;
        form.appendChild(productStrap);
        
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection