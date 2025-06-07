@extends('layouts.seller')

@section('title', 'Dashboard')

@section('content')
    <!-- ORDER Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">ORDER</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-[#FFD5FB] p-6 text-center transform hover:scale-105 transition-transform">
                <div class="text-4xl font-bold text-[#4C2B49] mb-2">{{ $orderStats['finished'] }}</div>
                <div class="text-[#4C2B49] font-medium">Finished</div>
            </div>
            <div class="bg-[#FFD5FB] p-6 text-center transform hover:scale-105 transition-transform">
                <div class="text-4xl font-bold text-[#4C2B49] mb-2">{{ $orderStats['in_packing'] }}</div>
                <div class="text-[#4C2B49] font-medium">In Packing</div>
            </div>
            <div class="bg-[#FFD5FB] p-6 text-center transform hover:scale-105 transition-transform">
                <div class="text-4xl font-bold text-[#4C2B49] mb-2">{{ $orderStats['delivered'] }}</div>
                <div class="text-[#4C2B49] font-medium">Delivered</div>
            </div>
            <div class="bg-[#FFD5FB] p-6 text-center transform hover:scale-105 transition-transform">
                <div class="text-4xl font-bold text-[#4C2B49] mb-2">{{ $orderStats['cancelled'] }}</div>
                <div class="text-[#4C2B49] font-medium">Cancelled</div>
            </div>
        </div>
    </div>

    <!-- STOCK Section -->
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">STOCK</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-[#E5CFFE] p-8 text-center transform hover:scale-105 transition-transform">
                <div class="text-5xl font-bold text-[#47325D] mb-3">{{ $stockStats['sold'] }}</div>
                <div class="text-[#47325D] font-medium text-lg">Sold</div>
            </div>
            <div class="bg-[#E5CFFE] p-8 text-center transform hover:scale-105 transition-transform">
                <div class="text-5xl font-bold text-[#47325D] mb-3">{{ $stockStats['stock'] }}</div>
                <div class="text-[#47325D] font-medium text-lg">Stock</div>
            </div>
        </div>
    </div>
@endsection