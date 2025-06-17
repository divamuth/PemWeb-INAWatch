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

    <!-- Main Content -->
    <div class="flex-1 pt-2 pl-8 m-4">
        <div class="flex pl-8">
            <img src="{{ asset('images/profile-gray.png') }}" alt="Profile" class="h-8 w-8"> 
            <strong class="text-xl pl-4 pt-1">Kezia</strong>
        </div>

        <div class="p-8 bg-white shadow-lg rounded-[30px] m-4">
            <div class="flex justify-around">
                <button type="submit" class="bg-[#FFB3F8] hover:bg-[#E59DDF] w-40 h-12 py-2 mx-1 rounded-[30px] text-white font-bold shadow-md text-xl hover:scale-105 transform transition-all duration-200">
                    All
                </button>
                <button type="submit" class="bg-[#FFB3F8] hover:bg-[#E59DDF] w-40 h-12 py-2 mx-1 rounded-[30px] text-white font-bold shadow-md text-xl hover:scale-105 transform transition-all duration-200">
                    In Packing
                </button>
                <button type="submit" class="bg-[#FFB3F8] hover:bg-[#E59DDF] w-40 h-12 py-2 mx-1 rounded-[30px] text-white font-bold shadow-md text-xl hover:scale-105 transform transition-all duration-200">
                    Delivered
                </button>
                <button type="submit" class="bg-[#FFB3F8] hover:bg-[#E59DDF] w-40 h-12 py-2 mx-1 rounded-[30px] text-white font-bold shadow-md text-xl hover:scale-105 transform transition-all duration-200">
                    Finished
                </button>
                <button type="submit" class="bg-[#FFB3F8] hover:bg-[#E59DDF] w-40 h-12 py-2 mx-1 rounded-[30px] text-white font-bold shadow-md text-xl hover:scale-105 transform transition-all duration-200">
                    Cancelled
                </button>
            </div>
            
            <div class="my-4 border border-gray-300 rounded-[30px] p-5 text-md relative mt-6">
                <div class="flex flex-row">
                    <p class="font-bold ml-4 mr-10">05 Juni 2025</p>
                    <p class="text-green-700 text-sm bg-green-200 py-0.5 px-4 rounded-full shadow-md">Finished</p>
                </div>
                <div class="flex flex-row my-4">
                    <img src="{{ asset('images/contoh1.png') }}" alt="jam" class="h-28 mx-12">
                    <div>
                        <p class="w-64">INA Watch Jam Tangan Kayu Jati Seri Rara Ngigel</p>
                        <p class="text-sm text-gray-400">Variasi: L. Abu Polos</p>
                        <p>x1</p>
                    </div>
                </div>
                <div class="absolute bottom-5 right-5">
                    <p class="text-sm text-gray-400">Total Order:</p>
                    <p class="font-bold text-lg">Rp214.900</p>
                </div>
            </div>
            <div class="my-4 border border-gray-300 rounded-[30px] p-5 text-md relative mt-6">
                <div class="flex flex-row">
                    <p class="font-bold ml-4 mr-10">05 Juni 2025</p>
                    <p class="text-gray-700 text-sm bg-gray-200 py-0.5 px-4 rounded-full shadow-md">Cancelled</p>
                </div>
                <div class="flex flex-row my-4">
                    <img src="{{ asset('images/contoh1.png') }}" alt="jam" class="h-28 mx-12">
                    <div>
                        <p class="w-64">INA Watch Jam Tangan Kayu Jati Seri Rara Ngigel</p>
                        <p class="text-sm text-gray-400">Variasi: L. Abu Polos</p>
                        <p>x1</p>
                    </div>
                </div>
                <div class="absolute bottom-5 right-5">
                    <p class="text-sm text-gray-400">Total Order:</p>
                    <p class="font-bold text-lg">Rp214.900</p>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection