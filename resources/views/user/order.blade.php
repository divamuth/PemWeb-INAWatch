@extends('layouts.user')

@section('content')
<div class="flex">
    <div class="w-64 min-h-screen">
        <div class="p-6 flex justify-center">
            <nav class="space-y-3 w-full">
                <a href="/user/profile"
                   class="inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all text-xl
                   {{ request()->is('user/profile') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }}">
                    Profile
                </a>

                <a href="/user/address"
                   class="inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all text-xl
                   {{ request()->is('user/address') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }}">
                    Address
                </a>

                <a href="/user/order"
                   class="inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all text-xl
                   {{ request()->is('user/order') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }}">
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

        <div class="p-8 bg-white h-3/4 shadow-lg rounded-[30px] m-4 flex justify-around">
            <button type="submit" class="bg-[#FFB3F8] hover:bg-[#E59DDF] w-44 h-12 py-2 rounded-[30px] text-white font-bold shadow-md text-xl">
                All
            </button>
            <button type="submit" class="bg-[#FFB3F8] hover:bg-[#E59DDF] w-44 h-12 py-2 rounded-[30px] text-white font-bold shadow-md text-xl">
                In Packing
            </button>
            <button type="submit" class="bg-[#FFB3F8] hover:bg-[#E59DDF] w-44 h-12 py-2 rounded-[30px] text-white font-bold shadow-md text-xl">
                Delivered
            </button>
            <button type="submit" class="bg-[#FFB3F8] hover:bg-[#E59DDF] w-44 h-12 py-2 rounded-[30px] text-white font-bold shadow-md text-xl">
                Finished
            </button>
            <button type="submit" class="bg-[#FFB3F8] hover:bg-[#E59DDF] w-44 h-12 py-2 rounded-[30px] text-white font-bold shadow-md text-xl">
                Cancelled
            </button>
        </div>
    </div>
</div>
@endsection