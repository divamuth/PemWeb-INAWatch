@extends('layouts.user')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

        <div class="flex gap-8">
            <!-- LEFT SIDE -->
            <div class="flex-1 space-y-6">
                <!-- Address Section -->
                <div class="bg-white p-6 shadow-lg" style="border-radius: 30px;">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-bold" style="color: #a3bef6;">ADDRESS</h3>
                        <button onclick="openAddressSelection()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            Change
                        </button>
                    </div>
                    <div class="space-y-2" id="selectedAddressDisplay">
                        @if(session('selected_address'))
                            @php $selectedAddress = session('selected_address'); @endphp
                            <p class="font-bold text-gray-900">{{ $selectedAddress['category'] }}</p>
                            <p class="font-bold text-gray-900">{{ $selectedAddress['name'] }}</p>
                            <p class="text-gray-700">{{ $selectedAddress['phone'] }}</p>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                {{ $selectedAddress['address_detail'] }}<br>
                                {{ strtoupper($selectedAddress['district']) }}, {{ strtoupper($selectedAddress['city']) }}, {{ strtoupper($selectedAddress['province']) }}, {{ $selectedAddress['post'] }}
                            </p>
                        @else
                            <div class="text-center py-4">
                                <p class="text-gray-500 mb-4">No address selected</p>
                                <button onclick="openAddressSelection()" class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                                    Select Address
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Section -->
                <div class="bg-white p-6 shadow-lg" style="border-radius: 30px;">
                    <h3 class="text-2xl font-bold mb-6" style="color: #a3bef6;">ORDER</h3>
                    <div class="space-y-6">
                        @php
                            $checkoutCart = session('checkout_cart', []);
                            $subtotal = session('checkout_subtotal', 0);
                            $shipping = session('checkout_shipping', 17000);
                            $total = session('checkout_total', 0);
                        @endphp
                        
                        @forelse($checkoutCart as $id => $item)
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['product_name'] }}" class="w-16 h-16 object-cover rounded-lg">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-900 mb-2 leading-tight">
                                    {{ $item['product_name'] }}
                                </h4>
                                <p class="text-sm text-gray-500 mb-3">Quantity: {{ $item['quantity'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">No items in checkout.</p>
                            <a href="{{ route('user.cart') }}" class="mt-4 inline-block bg-purple-500 text-white px-6 py-2 rounded-lg hover:bg-purple-600">
                                Go to Cart
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="w-[420px]">
                <!-- Payment Methods and Details in one box -->
                <div class="bg-white p-6 shadow-lg" style="border-radius: 30px;">
                    <h3 class="text-2xl font-bold mb-6" style="color: #a3bef6;">PAYMENT METHODS</h3>
                    <div class="space-y-3 mb-8">
                        @php 
                        $methods = [
                            ['name' => 'QRIS', 'logo' => 'qris-logo.png'],
                            ['name' => 'BNI Virtual Account', 'logo' => 'bni-logo.png'],
                            ['name' => 'BCA Virtual Account', 'logo' => 'bca-logo.png'],
                            ['name' => 'Mandiri Virtual Account', 'logo' => 'mandiri-logo.png']
                        ]; 
                        @endphp
                        
                        @foreach ($methods as $method)
                        <label class="flex items-center gap-4 cursor-pointer hover:bg-gray-50 transition-colors p-2 rounded-lg">
                            <input type="radio" name="payment" value="{{ $method['name'] }}" class="payment-method w-5 h-5 text-purple-600">

                            <div class="flex items-center gap-3 flex-1">
                                <!-- Logo -->
                                <div class="w-8 h-8 flex items-center justify-center">
                                    <img src="{{ asset('images/' . $method['logo']) }}" alt="{{ $method['name'] }}" class="object-contain h-8 w-8">
                                </div>

                                <!-- Text -->
                                <span class="font-medium text-gray-900">{{ $method['name'] }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <!-- Payment Details -->
                    <h3 class="text-2xl font-bold mb-6" style="color: #a3bef6;">PAYMENT DETAILS</h3>
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Update the Buy Now button to actually create the order -->
                    <form action="{{ route('user.orders.store') }}" method="POST" id="paymentForm">
                        @csrf
                        <input type="hidden" name="payment_method" id="selectedPaymentMethod">
                        <input type="hidden" name="address_id" value="{{ session('selected_address.id') }}">
                        <button type="button" id="buyNow" class="w-full bg-gradient-to-r from-purple-400 to-purple-500 hover:from-purple-500 hover:to-purple-600 text-white py-4 rounded-2xl text-lg font-semibold transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                            Buy Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Address Selection Modal -->
<div id="addressModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl w-2/3 max-h-[80vh] overflow-y-auto m-4">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold" style="color: #a3bef6;">Select Address</h3>
                <button onclick="closeAddressModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="p-6" id="addressList">
            <!-- Address list will be loaded here -->
        </div>
    </div>
</div>

<!-- PAYMENT MODALS -->
<div id="modalOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div id="modalContent" class="bg-white rounded-2xl p-8 w-full max-w-md text-center space-y-6 relative shadow-2xl">
        <!-- QRIS -->
        <div id="qrisContent" class="hidden">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Scan the QR Code to Pay</h3>
            <div class="bg-gray-50 p-6 rounded-xl mb-6">
                <img src="{{ asset('images/qris.png') }}" alt="QRIS" class="mx-auto w-48 h-48 object-contain">
            </div>
            <p class="text-sm text-gray-600 mb-6">Scan this QR code using your preferred payment app</p>
            <button id="qrisPaidBtn" class="w-full bg-gray-900 hover:bg-gray-800 text-white py-3 rounded-xl font-semibold transition-colors">
                I have completed the payment
            </button>
        </div>

        <!-- VA -->
        <div id="vaContent" class="hidden">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Virtual Account Number</h3>
            <div class="bg-gray-50 p-6 rounded-xl mb-6">
                <p class="text-2xl font-mono font-bold text-gray-900 tracking-wider">1234 5678 9101 1121</p>
            </div>
            <p class="text-sm text-gray-600 mb-6">Use this virtual account number to complete your payment</p>
            <button id="vaPaidBtn" class="w-full bg-gray-900 hover:bg-gray-800 text-white py-3 rounded-xl font-semibold transition-colors">
                I have completed the payment
            </button>
        </div>

        <!-- Success -->
        <div id="successContent" class="hidden">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Payment Successful!</h3>
            <p class="text-gray-600">Your order has been processed successfully</p>
        </div>

        <!-- Close button -->
        <button id="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    // Payment Modal Functions
    const modalOverlay = document.getElementById("modalOverlay");
    const qrisContent = document.getElementById("qrisContent");
    const vaContent = document.getElementById("vaContent");
    const successContent = document.getElementById("successContent");
    const closeModal = document.getElementById("closeModal");
    const paymentForm = document.getElementById("paymentForm");
    const selectedPaymentMethod = document.getElementById("selectedPaymentMethod");

    // Address Modal Functions
    const addressModal = document.getElementById("addressModal");

    function openAddressSelection() {
        // Load addresses via AJAX
        fetch('/checkout/addresses/list')
            .then(response => response.json())
            .then(data => {
                let addressListHtml = '';
                data.addresses.forEach(address => {
                    addressListHtml += `
                        <div class="border border-gray-300 rounded-[30px] p-4 mb-4 cursor-pointer hover:bg-gray-50 transition-colors" 
                             onclick="selectAddress(${JSON.stringify(address).replace(/"/g, '&quot;')})">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-gray-900">${address.category}</p>
                                    <p class="font-bold text-gray-900">${address.name}</p>
                                    <p class="text-gray-700">${address.phone}</p>
                                    <p class="text-sm text-gray-500 leading-relaxed">
                                        ${address.address_detail}<br>
                                        ${address.district.toUpperCase()}, ${address.city.toUpperCase()}, ${address.province.toUpperCase()}, ${address.post}
                                    </p>
                                </div>
                                <button class="px-3 py-1 bg-purple-500 text-white rounded-full text-sm font-bold hover:bg-purple-600">
                                    Select
                                </button>
                            </div>
                        </div>
                    `;
                });

                if (data.addresses.length === 0) {
                    addressListHtml = `
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">No addresses found</p>
                            <a href="/user/address" class="inline-block bg-purple-500 text-white px-6 py-2 rounded-lg hover:bg-purple-600">
                                Add New Address
                            </a>
                        </div>
                    `;
                }

                document.getElementById('addressList').innerHTML = addressListHtml;
                addressModal.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error loading addresses:', error);
                alert('Failed to load addresses');
            });
    }

    function selectAddress(address) {
        // Send selected address to server
        fetch('/checkout/select-address', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ address_id: address.id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the display
                document.getElementById('selectedAddressDisplay').innerHTML = `
                    <p class="font-bold text-gray-900">${address.category}</p>
                    <p class="font-bold text-gray-900">${address.name}</p>
                    <p class="text-gray-700">${address.phone}</p>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        ${address.address_detail}<br>
                        ${address.district.toUpperCase()}, ${address.city.toUpperCase()}, ${address.province.toUpperCase()}, ${address.post}
                    </p>
                `;
                
                // Update hidden input
                document.querySelector('input[name="address_id"]').value = address.id;
                
                closeAddressModal();
            }
        })
        .catch(error => {
            console.error('Error selecting address:', error);
            alert('Failed to select address');
        });
    }

    function closeAddressModal() {
        addressModal.classList.add('hidden');
    }

    // Payment Modal Logic
    document.getElementById("buyNow").addEventListener("click", function () {
        // Check if address is selected
        if (!document.querySelector('input[name="address_id"]').value) {
            alert("Please select a delivery address first");
            return;
        }

        let selected = document.querySelector('input[name="payment"]:checked');
        if (!selected) {
            alert("Please select a payment method");
            return;
        }

        selectedPaymentMethod.value = selected.value;

        modalOverlay.classList.remove("hidden");
        hideAllModalContent();

        if (selected.value === "QRIS") {
            qrisContent.classList.remove("hidden");
        } else {
            vaContent.classList.remove("hidden");
        }
    });

    document.getElementById("qrisPaidBtn").addEventListener("click", function() {
        paymentForm.submit();
    });

    document.getElementById("vaPaidBtn").addEventListener("click", function() {
        paymentForm.submit();
    });

    function hideAllModalContent() {
        qrisContent.classList.add("hidden");
        vaContent.classList.add("hidden");
        successContent.classList.add("hidden");
    }

    function closeModalHandler() {
        modalOverlay.classList.add("hidden");
    }

    closeModal.addEventListener("click", closeModalHandler);
    
    modalOverlay.addEventListener("click", function (e) {
        if (e.target.id === "modalOverlay") {
            closeModalHandler();
        }
    });

    // Close address modal when clicking outside
    addressModal.addEventListener("click", function (e) {
        if (e.target.id === "addressModal") {
            closeAddressModal();
        }
    });

    // Add keyboard support
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") {
            if (!modalOverlay.classList.contains("hidden")) {
                closeModalHandler();
            }
            if (!addressModal.classList.contains("hidden")) {
                closeAddressModal();
            }
        }
    });
</script>
@endsection