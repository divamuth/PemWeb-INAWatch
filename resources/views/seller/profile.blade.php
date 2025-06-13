@extends('layouts.seller')

@section('content')
<div>
    <p class="bg-[#FFB3F8] py-2 px-6 w-40 font-bold text-white rounded-[30px] shadow-md text-center">Store Profile</p>
    <div class="relative p-4">
        <img src="{{ asset('images/header.png') }}" alt="header" class="w-full h-auto z-10">
        <img src="{{ asset('images/logo.png') }}" alt="logo" class="bg-white rounded-full size-28 p-2 shadow-md border border-gray-200 object-contain object-center overflow-hidden absolute bottom-0 left-12 translate-y-1/2 z-20">
    </div>
    <div class="pt-2 p-8">
        <form action="">
            <div class="pt-20 p-8">
                <div class="flex flex-row gap-24 relative before:content-[''] before:absolute before:left-1/2 before:top-0 before:bottom-0 before:w-px before:bg-gray-300 before:transform before:-translate-x-1/2">
                    <div class="w-1/2">
                        <div class="flex flex-col py-2 pb-10">
                            <label for="name" class="text-gray-400 font-bold text-xl">Name</label>
                            <input type="text" value="INA Watch" class="w-full m-1 p-1 border border-black shadow-md rounded-md">
                        </div>
                        <div class="flex flex-col py-2">
                            <label for="description" class="text-gray-400 font-bold text-xl">Description</label>
                            <textarea name="description" id="description" cols="30" rows="3" class="w-full m-1 p-1 border border-black shadow-md rounded-md">INA Watch adalah jam tangan kayu yang autentik tetapi tetap modern.</textarea>
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div>
                            <p class="text-gray-400 font-bold text-xl pb-2">Social Media</p>
                            <div class="flex flex-row">
                                <label for="instagram" class="w-2/3 font-semibold text-right pr-20">Instagram</label>
                                <input type="text" class="w-full m-1 p-1 border border-black shadow-md rounded-md">
                            </div>
                            <div class="flex flex-row">
                                <label for="X" class="w-2/3 font-semibold text-right pr-20">X</label>
                                <input type="text" class="w-full m-1 p-1 border border-black shadow-md rounded-md">
                            </div>
                            <div class="flex flex-row">
                                <label for="tiktok" class="w-2/3 font-semibold text-right pr-20">Tiktok</label>
                                <input type="text" class="w-full m-1 p-1 border border-black shadow-md rounded-md">
                            </div>
                        </div>
                        <div class="flex flex-col py-2">
                            <label for="address" class="text-gray-400 font-bold text-xl pb-2">Address</label>
                            <textarea name="address" id="address" cols="30" rows="3" class="w-full m-1 p-1 border border-black shadow-md rounded-md">Jalan Jalan Ke Gunung Kidul (Cakep) JEBRES, KOTA SURAKARTA (SOLO), JAWA TENGAH, ID, 66666 </textarea>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pt-8">
                    <button class="mt-4 px-6 py-2 bg-[#A3A4F6] text-white rounded-full hover:bg-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500 font-bold hover:scale-105 transform transition-all duration-200">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
