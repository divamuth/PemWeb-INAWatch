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
                <img src="{{ asset('images/contoh1.png') }}" alt="Jam Kayu" class="mx-auto mb-4 rounded-xl">
                <h2 class="text-lg font-bold text-gray-800">INA Watch Jam Tangan Kayu Jati Seri Rara Ngigel</h2>
                <div class="flex justify-between items-center mt-2 text-sm text-gray-700">
                    <span class="text-gray-700 mt-2 text-lg">Rp 214.900</span>
                    <span class="text-gray-500 text-sm mt-1">2 Sold</span>
                </div>
            </div>

            <!-- Opsi Custom -->
            <div>
                <h3 class="text-md font-semibold text-gray-800 mb-2">Choose your favourite strap:</h3>
                <div class="flex flex-wrap gap-3 mb-6">
                    @foreach (['L. Abu Polos', 'L. Hijau Mint', 'L. Biru Putih', 'L. Terracotta', 'L. Cream', 'L. Lapis Kuning', 'L. Lapis Putih', 'L. Orange', 'L. Orange Putih'] as $strap)
                        <button class="w-36 h-10 bg-white border border-gray-300 rounded-full text-sm flex items-center justify-center text-center hover:bg-purple-100">{{ $strap }}</button>
                    @endforeach
                </div>

                <!-- Kuantitas -->
                <h3 class="text-md font-semibold text-gray-800 mb-2">Kuantitas:</h3>
                <div class="flex items-center gap-4 mb-6">
                    <button class="w-8 h-8 bg-gray-200 rounded-full text-lg font-bold">-</button>
                    <span class="text-lg">1</span>
                    <button class="w-8 h-8 bg-gray-200 rounded-full text-lg font-bold">+</button>
                </div>

                <!-- Total & Button -->
                <div class="mb-4 mt-60">
                    <p class="text-gray-700 text-md">Total:</p>
                    <p class="text-2xl font-bold text-gray-900">Rp 214.900</p>
                </div>

                <div class="flex gap-4 mt-5">
                    <button class="flex-1 bg-white border border-black text-black px-6 py-3 rounded-full flex items-center justify-center gap-2 hover:bg-gray-100">
                        Add to <span>🛒</span>
                    </button>
                    <button class="flex-1 bg-black text-white px-6 py-3 rounded-full hover:bg-gray-800">Buy Now</button>
                </div>
            </div>
        </div>
    </main>
@endsection