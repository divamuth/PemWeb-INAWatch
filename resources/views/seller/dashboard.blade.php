@extends('layouts.seller')

@section('title', 'Dashboard')

@section('content')
    <!-- ORDER Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">ORDER</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-[#FFD5FB] p-6 text-center">
                <div class="text-4xl font-bold text-[#4C2B49] mb-2">{{ $orderStats['finished'] }}</div>
                <div class="text-[#4C2B49] font-medium">Finished</div>
            </div>
            <div class="bg-[#FFD5FB] p-6 text-center">
                <div class="text-4xl font-bold text-[#4C2B49] mb-2">{{ $orderStats['in_packing'] }}</div>
                <div class="text-[#4C2B49] font-medium">In Packing</div>
            </div>
            <div class="bg-[#FFD5FB] p-6 text-center">
                <div class="text-4xl font-bold text-[#4C2B49] mb-2">{{ $orderStats['delivered'] }}</div>
                <div class="text-[#4C2B49] font-medium">Delivered</div>
            </div>
            <div class="bg-[#FFD5FB] p-6 text-center">
                <div class="text-4xl font-bold text-[#4C2B49] mb-2">{{ $orderStats['cancelled'] }}</div>
                <div class="text-[#4C2B49] font-medium">Cancelled</div>
            </div>
        </div>
    </div>

    <!-- STOCK Section -->
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">STOCK</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-[#E5CFFE] p-8 text-center">
                <div class="text-5xl font-bold text-[#47325D] mb-3" id="sold-count">{{ $stockStats['sold'] }}</div>
                <div class="text-[#47325D] font-medium text-lg">Sold</div>
            </div>
            <div class="bg-[#E5CFFE] p-8 text-center">
                <div class="text-5xl font-bold text-[#47325D] mb-3" id="stock-count">{{ $stockStats['stock'] }}</div>
                <div class="text-[#47325D] font-medium text-lg">Stock</div>
            </div>
        </div>
        <div id="stock-error" class="text-red-500 text-center mt-4 hidden">Failed to load stock data. Please try again later.</div>
    </div>

    <script>
        function updateStockStats() {
            fetch('{{ route("seller.getStockStats") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update the DOM with new stock data
                    document.getElementById('sold-count').textContent = data.sold || 0;
                    document.getElementById('stock-count').textContent = data.stock || 0;
                    document.getElementById('stock-error').classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error fetching stock stats:', error);
                    document.getElementById('stock-error').classList.remove('hidden');
                });
        }

        // Call updateStockStats every 10 seconds
        setInterval(updateStockStats, 10000);

        // Call immediately on page load
        document.addEventListener('DOMContentLoaded', updateStockStats);
    </script>
@endsection