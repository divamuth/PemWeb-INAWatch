@extends('layouts.seller')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
body {
    font-family: "Inter", sans-serif;
}
</style>

<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white rounded-3xl shadow-lg p-6 w-full max-w-2xl relative">
    <!-- Edit Label -->
    <div class="absolute -top-4 left-6">
      <span class="bg-pink-300 text-white px-4 py-1 rounded-full text-sm font-semibold">Edit</span>
    </div>

        {{-- Main Content --}}
        <div class="flex-1 pt-2 pl-8 m-4">
            <div class="flex pl-8">
                <strong class="text-xl pl-4 pt-1">My Addresses</strong>
            </div>

            <div class="flex-1 p-8 bg-white shadow-lg rounded-[30px] m-4">
                <div class="flex justify-end pr-5">
                    <button type="button" onclick="openPopup()" class="px-6 py-2 bg-[#CBA3F6] text-white rounded-full hover:bg-purple-400 font-bold hover:scale-105 transform transition-all duration-200">
                        + Add New Addresses
                    </button>
                </div>
                <div class="bg-pastel-pink-200 m-4 border border-gray-300 rounded-[30px] p-5 text-md">
                    <strong>Kos</strong><br>
                    <strong>Kezia</strong>
                    <p class="font-semibold">081208120812</p>
                    <p class="text-gray-400">Wisma Butter Jalan Jalan Ke Gunung Kidul (Cakep)</p>
                    <p class="text-gray-400">JEBRES, KOTA SURAKARTA (SOLO), JAWA TENGAH, ID, 66666</p>
                </div>
                <div class="bg-white m-4 border border-gray-300 rounded-[30px] p-5 text-md">
                    <strong>Kos</strong><br>
                    <strong>Kezia</strong>
                    <p class="font-semibold">081208120812</p>
                    <p class="text-gray-400">Wisma Butter Jalan Jalan Ke Gunung Kidul (Cakep)</p>
                    <p class="text-gray-400">JEBRES, KOTA SURAKARTA (SOLO), JAWA TENGAH, ID, 66666</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Pop Up --}}
    <div id="addressPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-[#F6F6FF] rounded-[30px] w-2/3 py-8 px-16 max-h-[90vh] overflow-y-auto">
            <strong class="flex mb-4 text-xl">New Address</strong>
            <form action="" method="POST">
                @csrf
                <div class="flex flex-col mb-2">
                    <label for="category" class="text-gray-400 text-lg font-semibold pl-2">Category</label>
                    <input type="text" name="category" id="category" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required>
                </div>
                <div class="flex justify-between space-x-4 mb-2">
                    <div class="flex flex-col w-1/2">
                        <label for="name" class="text-gray-400 text-lg font-semibold pl-2">Name</label>
                        <input type="text" name="name" id="name" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4 w-full" required>
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label for="phone" class="text-gray-400 text-lg font-semibold pl-2">Phone Number</label>
                        <input type="number" name="phone" id="phone" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4 w-full" required>
                    </div>
                </div>
                <div class="flex flex-col mb-2">
                    <label for="province" class="text-gray-400 text-lg font-semibold pl-2">Province</label>
                    <input type="text" name="province" id="province" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required>
                </div>
                <div class="flex flex-col mb-2">
                    <label for="city" class="text-gray-400 text-lg font-semibold pl-2">City</label>
                    <input type="text" name="city" id="city" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required>
                </div>
                <div class="flex flex-col mb-2">
                    <label for="district" class="text-gray-400 text-lg font-semibold pl-2">District</label>
                    <input type="text" name="district" id="district" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required>
                </div>
                <div class="flex flex-col mb-2">
                    <label for="post" class="text-gray-400 text-lg font-semibold pl-2">Post ID</label>
                    <input type="number" name="post" id="post" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4" required>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closePopup()" class="px-6 py-2 mt-8 bg-gray-400 text-white rounded-full hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-700 font-bold hover:scale-105 transform transition-all duration-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 mt-8 bg-[#A3A4F6] text-white rounded-full hover:bg-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500 font-bold hover:scale-105 transform transition-all duration-200">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openPopup() {
        document.getElementById('addressPopup').classList.remove('hidden');
    }

    function closePopup() {
        document.getElementById('addressPopup').classList.add('hidden');
    }

    document.addEventListener('click', function(e) {
        const popup = document.getElementById('addressPopup');
        if (e.target === popup) {
            closePopup();
        }
    });
    </script>
  </div>
</div>

@endsection