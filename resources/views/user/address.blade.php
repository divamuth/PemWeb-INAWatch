@extends('layouts.user')

@section('content')
<div class="flex">
    <div class="w-64 min-h-screen">
        <div class="p-6 flex justify-center">
            <nav class="space-y-3 w-full">
                <a href="/user/profile"
                   class="inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all text-xl
                   {{ request()->is('user/profile') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }} hover:scale-105 transform transition-all duration-200">
                    Profile
                </a>

                <a href="/user/address"
                   class="inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all text-xl
                   {{ request()->is('user/address') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }} hover:scale-105 transform transition-all duration-200">
                    Address
                </a>

                <a href="/user/order"
                   class="inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all text-xl
                   {{ request()->is('user/order') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }} hover:scale-105 transform transition-all duration-200">
                    Order
                </a>
            </nav>
        </div>
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

            @foreach ($addresses as $address)
                <div class="bg-pastel-pink-200 m-4 border border-gray-300 rounded-[30px] p-5 text-md">
                    <strong>{{ $address->category }}</strong><br>
                    <strong>{{ $address->name }}</strong>
                    <p class="font-semibold">{{ $address->phone }}</p>
                    <p class="text-gray-400">{{ $address->address_detail }}</p>
                    <p class="text-gray-400">
                        {{ strtoupper($address->district) }}, {{ strtoupper($address->city) }}, 
                        {{ strtoupper($address->province) }}, {{ $address->post }}
                    </p>
                </div>
            @endforeach
            
        </div>
    </div>
</div>

{{-- Pop Up --}}
<div id="addressPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-[#F6F6FF] rounded-[30px] w-2/3 py-8 px-16 max-h-[90vh] overflow-y-auto">
        <strong class="flex mb-4 text-xl">New Address</strong>
        <form action="{{ route('user.address.store') }}" method="POST">
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
                    <input type="text" name="phone" id="phone" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4 w-full" required>
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
            <div class="flex flex-col mb-2">
                <label for="address_detail" class="text-gray-400 text-lg font-semibold pl-2">Detail</label>
                <input type="text" name="address_detail" id="address_detail" class="bg-white h-8 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300 pl-4">
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

@endsection