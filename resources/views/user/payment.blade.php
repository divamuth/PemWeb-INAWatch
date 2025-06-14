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
                        <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            Change
                        </button>
                    </div>
                    <div class="space-y-2">
                        <p class="font-bold text-gray-900">Kos</p>
                        <p class="font-bold text-gray-900">Kezia</p>
                        <p class="text-gray-700">081208120812</p>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Wisma Butter Jalan Jalan Ke Gunung Kidul (Cakep)<br>
                            JEBRES, KOTA SURAKARTA (SOLO), JAWA TENGAH, ID, 66666
                        </p>
                    </div>
                </div>

                <!-- Order Section -->
                <div class="bg-white p-6 shadow-lg" style="border-radius: 30px;">
                    <h3 class="text-2xl font-bold mb-6" style="color: #a3bef6;">ORDER</h3>
                    <div class="space-y-6">
                        @for ($i = 0; $i < 2; $i++)
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('images/jam.png') }}" alt="Watch" class="w-16 h-16 object-cover rounded-lg">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-900 mb-2 leading-tight">
                                    INA Watch Jam Tangan Kayu Jati Seri Rara Nggiel
                                </h4>
                                <p class="text-sm text-gray-500 mb-3">Variasi: L. Abu Polos</p>
                            </div>
                            <div class="text-right flex flex-col items-end gap-2">
                                <p class="text-lg font-bold text-gray-900 item-price" data-base-price="214900" data-index="{{ $i }}">Rp214.900</p>
                                <div class="flex items-center gap-2">
                                    <button class="quantity-btn w-6 h-6 flex items-center justify-center rounded border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors" data-action="decrease" data-index="{{ $i }}">
                                        −
                                    </button>
                                    <span class="quantity-display font-medium text-gray-900 min-w-[20px] text-center" data-index="{{ $i }}">1</span>
                                    <button class="quantity-btn w-6 h-6 flex items-center justify-center rounded border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors" data-action="increase" data-index="{{ $i }}">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endfor
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
                                <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center">
                                    <span class="text-xs font-bold text-gray-600">
                                        {{ strtoupper(substr($method['name'], 0, 2)) }}
                                    </span>
                                </div>
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
                            <span class="font-semibold text-gray-900" id="subtotal">Rp429.800</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-semibold text-gray-900">Rp17.000</span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-gray-900" id="total">Rp446.800</span>
                        </div>
                    </div>

                    <button id="buyNow" class="w-full bg-gradient-to-r from-purple-400 to-purple-500 hover:from-purple-500 hover:to-purple-600 text-white py-4 rounded-2xl text-lg font-semibold transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                        Buy Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALS -->
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
    const modalOverlay = document.getElementById("modalOverlay");
    const qrisContent = document.getElementById("qrisContent");
    const vaContent = document.getElementById("vaContent");
    const successContent = document.getElementById("successContent");
    const closeModal = document.getElementById("closeModal");

    // Quantity functionality
    let quantities = [1, 1]; // Initialize quantities for each item
    const basePrice = 214900; // Base price per item
    const shippingPrice = 17000; // Shipping cost

    function formatRupiah(amount) {
        return 'Rp' + amount.toLocaleString('id-ID');
    }

    function updatePricing() {
        // Calculate total for each item and overall subtotal
        let subtotal = 0;
        
        quantities.forEach((qty, index) => {
            const itemTotal = basePrice * qty;
            subtotal += itemTotal;
            
            // Update individual item price display
            const priceElement = document.querySelector(`.item-price[data-index="${index}"]`);
            if (priceElement) {
                priceElement.textContent = formatRupiah(itemTotal);
            }
        });

        // Update subtotal and total
        document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('total').textContent = formatRupiah(subtotal + shippingPrice);
    }

    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            const index = parseInt(this.getAttribute('data-index'));
            const display = document.querySelector(`.quantity-display[data-index="${index}"]`);
            
            if (action === 'increase') {
                quantities[index]++;
            } else if (action === 'decrease' && quantities[index] > 1) {
                quantities[index]--;
            }
            
            display.textContent = quantities[index];
            updatePricing();
        });
    });

    // Initialize pricing on page load
    updatePricing();

    document.getElementById("buyNow").addEventListener("click", function () {
        let selected = document.querySelector('input[name="payment"]:checked');
        if (!selected) {
            alert("Please select a payment method");
            return;
        }

        modalOverlay.classList.remove("hidden");
        hideAllModalContent();

        if (selected.value === "QRIS") {
            qrisContent.classList.remove("hidden");
        } else {
            vaContent.classList.remove("hidden");
        }
    });

    document.getElementById("qrisPaidBtn").addEventListener("click", showSuccess);
    document.getElementById("vaPaidBtn").addEventListener("click", showSuccess);

    function hideAllModalContent() {
        qrisContent.classList.add("hidden");
        vaContent.classList.add("hidden");
        successContent.classList.add("hidden");
    }

    function showSuccess() {
        hideAllModalContent();
        successContent.classList.remove("hidden");

        setTimeout(() => {
            modalOverlay.classList.add("hidden");
        }, 3000);
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

    // Add keyboard support
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape" && !modalOverlay.classList.contains("hidden")) {
            closeModalHandler();
        }
    });
</script>
@endsection