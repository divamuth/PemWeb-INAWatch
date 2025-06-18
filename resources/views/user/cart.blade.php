@extends('layouts.user')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
    body {
        font-family: "Inter", sans-serif;
    }
</style>

<main class="max-w-6xl mx-auto bg-white mt-6 rounded-2xl p-6 shadow">

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
                <div><input type="checkbox" name="selected_items[]" value="{{ $id }}" class="w-4 h-4 item-checkbox"></div>
                <div class="flex items-center text-left gap-3">
                    <img src="{{ asset($item['image']) }}" class="w-20 h-20 rounded-md object-cover">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item['product_name'] }}</p>
                    </div>
                </div>
                <div class="text-gray-700">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>

                <div>
                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center justify-center gap-2">
                        @csrf
                        @method('PUT')
                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                            class="px-2 py-1 bg-gray-200 rounded-full text-sm">-</button>

                        <span class="px-2">{{ $item['quantity'] }}</span>

                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                            class="px-2 py-1 bg-purple-200 rounded-full text-sm">+</button>
                    </form>
                </div>

                <div class="text-gray-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                <div>
                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:text-red-700">🗑️</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-10">Your cart is empty.</p>
        @endforelse
    </div>

    <!-- Footer Checkout -->
    @if (!empty(session('cart')))
    <div class="flex justify-between items-center mt-6 bg-white shadow-lg rounded-full px-6 py-4">
        <div class="flex items-center gap-2">
            <input type="checkbox" id="choose-all" class="w-4 h-4">
            <span class="text-sm text-gray-700">Choose all ({{ count(session('cart')) }})</span>
        </div>
        <div class="flex items-center gap-6">
            <span class="text-md text-gray-700">Total (<span id="selected-count">0</span> product{{ count(session('cart')) > 1 ? 's' : '' }}):
                <strong id="selected-total">Rp 0</strong></span>
            <form action="{{ route('user.checkout') }}" method="POST" id="checkout-form">
                @csrf
                <button type="submit" class="bg-black text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-gray-800">
                    Checkout
                </button>
            </form>
        </div>
    </div>
    @endif
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chooseAll = document.getElementById('choose-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const selectedCount = document.getElementById('selected-count');
    const selectedTotal = document.getElementById('selected-total');
    const checkoutForm = document.getElementById('checkout-form');

    // Function to update total price and selected count
    function updateSummary() {
        let total = 0;
        let count = 0;
        itemCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const row = checkbox.closest('div.grid');
                const subtotal = parseFloat(row.querySelector('div:nth-child(5)').textContent.replace('Rp ', '').replace(/\./g, '').replace(',', '.'));
                total += subtotal;
                count++;
            }
        });
        selectedCount.textContent = count;
        selectedTotal.textContent = `Rp ${total.toLocaleString('id-ID', { minimumFractionDigits: 0 })}`;
    }

    // Handle choose all checkbox
    chooseAll.addEventListener('change', () => {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = chooseAll.checked;
        });
        updateSummary();
    });

    // Update summary when individual checkboxes change
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            updateSummary();
            const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(itemCheckboxes).some(cb => cb.checked);
            chooseAll.checked = allChecked;
            chooseAll.indeterminate = someChecked && !allChecked;
        });
    });

    // Add selected items to form submission
    checkoutForm.addEventListener('submit', function(e) {
        itemCheckboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                checkbox.disabled = true;
            }
        });
    });

    // Initial update
    updateSummary();
});
</script>
@endsection