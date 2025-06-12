@extends('layouts.user')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
    body {
        font-family: "Inter", sans-serif;
    }
</style>
  <!-- Cart Container -->
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
            @for ($i = 0; $i < 4; $i++)
            <div class="grid grid-cols-[0.5fr_2fr_1fr_1fr_1fr_0.5fr] gap-4 items-center py-4 text-center">
                <div><input type="checkbox" class="w-4 h-4"></div>
                <div class="flex items-center text-left gap-3">
                    <img src="{{ asset('images/contoh1.png') }}" class="w-40 h-40 rounded-md">
                    <div>
                        <p class="font-semibold text-gray-800">INA Watch Jam Tangan Kayu Jati Seri Rara Ngigel</p>
                        <p class="text-sm text-gray-500">Variasi: L. Abu Polos</p>
                    </div>
                </div>
                <div class="text-gray-700">Rp 214.900</div>
                <div>1</div>
                <div class="text-gray-700">Rp 214.900</div>
                <div>
                    <button class="text-red-500 hover:text-red-700">🗑️</button>
                </div>
            </div>
            @endfor
        </div>

        <!-- Footer Checkout -->
        <div class="flex justify-between items-center mt-6 bg-white shadow-lg rounded-full px-6 py-4">
            <div class="flex items-center gap-2">
                <input type="checkbox" checked class="w-4 h-4">
                <span class="text-sm text-gray-700">Choose all (3)</span>
            </div>
            <div class="flex items-center gap-6">
                <span class="text-md text-gray-700">Total (1 product): <strong>Rp 214.900</strong></span>
                <a href="#" class="bg-black text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-gray-800">
                    Checkout
                </a>
            </div>
        </div>
    </main>
@endsection