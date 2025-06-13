@extends('layouts.seller')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
body {
    font-family: "Inter", sans-serif;
}
</style>

<div class="flex w-full">
    <!-- Konten utama -->
    <div class="flex-1 bg-white rounded-2xl shadow p-4 m-4">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="bg-[#FFB3F8] text-white px-10 py-3 rounded-[30px] inline-block font-bold text-lg shadow-lg">
                Stock
            </div>
        </div>

        <!-- HEADER -->
        <div class="bg-gradient-to-r from-purple-300 to-purple-400 text-white font-bold px-6 py-4">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">Product</div>
                <div class="col-span-2 text-center">Sale</div>
                <div class="col-span-2 text-center">Price</div>
                <div class="col-span-3 text-center">Stock</div>
                <div class="col-span-1 text-center">Action</div>
            </div>
        </div>

        <!-- ROW -->
        @for ($i = 0; $i < 4; $i++)
        <div class="border-b px-6 py-4">
            <div class="grid grid-cols-12 gap-4 items-center">
                <div class="col-span-4 flex items-center gap-2">
                <img src="{{ asset('images/contoh2.png') }}" alt="Jam" class="h-40 rounded-md">
                <div>
                    <div class="font-semibold">INA Watch Jam Tangan Kayu Jati Seri Rara Ngigel</div>
                    <div class="text-gray-500 text-xs">Varian: L. Abu Polos</div>
                </div>
                </div>
                <div class="col-span-2 text-center">3,6K</div>
                <div class="col-span-2 text-center">Rp 214.900</div>
                <div class="col-span-3 text-center">38</div>
                <div class="col-span-1 text-center text-red-500">
                    <button type="button" onclick="openPopup()" class="mr-2 underline">
                        Edit
                    </button>
                    <br>
                <button class="underline">Delete</button>
                </div>
            </div>
        </div>
        @endfor
    </div>

    {{-- Pop Up --}}
    <div id="editPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-[#F6F6FF] rounded-[30px] w-2/3 py-8 px-16 max-h-[90vh] overflow-y-aut">
        <div class="flex justify-between items-center mb-4">
            <strong class="text-xl">Edit</strong>
            <button type="submit" form="editForm" class="px-10 py-3 mt-8 bg-[#A3A4F6] text-white rounded-full hover:bg-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500 font-bold hover:scale-105 transform transition-all duration-200">Save</button>
        </div>
        <form action="" method="POST">
        <div class="flex gap-8">
            @csrf
            <!-- Gambar Produk -->
            <div class="bg-white rounded-xl border p-4 flex justify-center items-center relative w-1/3">
                <img src="{{ asset('images/contoh2.png') }}" alt="Product Image" class="max-h-96 object-contain" />
                <div class="absolute bottom-2 right-2 flex space-x-2">
                    <button class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                    <button class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Form Input -->
            <div class="w-2/3">
                <div class="space-y-4 w-full">
                    <div class="flex flex-col mb-2">
                        <label class="text-gray-400 text-lg font-semibold pl-2">Product Name<span class="text-red-500">*</span></label>
                        <input type="text" value="INA Watch Jam Tangan Kayu Jati Seri Rara Ngigel" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                    </div>
                    <div class="flex flex-col mb-2">
                        <label class="text-gray-400 text-lg font-semibold pl-2">Variation<span class="text-red-500">*</span></label>
                        <input type="text" value="L. Abu Polos" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                    </div>
                    <div class="flex flex-col mb-2">
                        <label class="text-gray-400 text-lg font-semibold pl-2">Sale<span class="text-red-500">*</span></label>
                        <input type="text" value="3,6K" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                    </div>
                    <div class="flex flex-col mb-2">
                        <label class="text-gray-400 text-lg font-semibold pl-2">Price<span class="text-red-500">*</span></label>
                        <input type="text" value="Rp 214.900" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                    </div>
                    <div class="flex flex-col mb-2">
                        <label class="text-gray-400 text-lg font-semibold pl-2">Stock<span class="text-red-500">*</span></label>
                        <input type="text" value="38" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openPopup() {
            document.getElementById('editPopup').classList.remove('hidden');
        }
        function closePopup() {
            document.getElementById('editPopup').classList.add('hidden');
        }
        document.addEventListener('click', function(e) {
            const popup = document.getElementById('editPopup');
            if (e.target === popup) {
                closePopup();
            }
        });
    </script>
@endsection