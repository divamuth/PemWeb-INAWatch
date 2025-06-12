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

        <div class="flex-1 p-8 bg-white shadow-lg rounded-[30px] m-4">
            <form>
                <div class="flex flex-row justify-around items-start">
                    <div>
                        {{-- Username --}}
                        <div class="mb-4 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4" for="username">
                                Username
                            </label>
                            <input
                                class="ml-24 w-72 p-2 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300"
                                id="username"
                                type="text"
                                value="keziatbn"
                            />
                        </div>

                        <div class="mb-4 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4" for="name">
                                Name
                            </label>
                            <input
                                class="ml-24 w-72 p-2 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300"
                                id="name"
                                type="text"
                                value="Kezia Tambunan"
                            />
                        </div>

                        {{-- Email --}}
                        <div class="mb-4 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4" for="email">
                                Email
                            </label>
                            <input
                                class="ml-24 w-72 p-2 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300"
                                id="email"
                                type="email"
                                value="keziatbn@gmail.com"
                            />
                        </div>

                        {{-- Phone Number --}}
                        <div class="mb-4 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4 whitespace-nowrap" for="phone">
                                Phone Number
                            </label>
                            <input
                                class="ml-24 w-72 p-2 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300"
                                id="phone"
                                type="text"
                                value="081208120812"
                            />
                        </div>

                        {{-- Gender --}}
                        <div class="mb-4 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4">
                                Gender
                            </label>
                            <div class="ml-16 flex space-x-6">
                                <label class="inline-flex items-center">
                                    <input
                                        type="radio"
                                        name="gender"
                                        value="man"
                                        class="form-radio text-purple-500 focus:ring-2 focus:ring-purple-300 ml-9"
                                    />
                                    <span class="ml-2 text-gray-700">Man</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input
                                        type="radio"
                                        name="gender"
                                        value="woman"
                                        class="form-radio text-purple-500 focus:ring-2 focus:ring-purple-300"
                                    />
                                    <span class="ml-2 text-gray-700">Woman</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input
                                        type="radio"
                                        name="gender"
                                        value="others"
                                        class="form-radio text-purple-500 focus:ring-2 focus:ring-purple-300"
                                    />
                                    <span class="ml-2 text-gray-700">Others</span>
                                </label>
                            </div>
                        </div>

                        {{-- Birthdate --}}
                        <div class="mb-6 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4" for="birthdate">
                                Birthdate
                            </label>
                            <input
                                class="ml-24 w-72 p-2 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300"
                                id="birthdate"
                                type="date"
                                value="2025-06-12"
                            />
                        </div>

                        <!-- Save Button -->
                        <div class="text-center">
                            <button
                                type="submit"
                                class="px-6 py-2 mt-8 bg-[#A3A4F6] text-white rounded-full hover:bg-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500 font-bold"
                            >
                                Save
                            </button>
                        </div>
                    </div>

                    <!-- Profile Picture -->
                    <div class="flex flex-col items-center space-y-4">
                        <div class="w-24 h-24 bg-[#A3A4F6] rounded-full flex items-center justify-center">
                            <svg class="w-14 h-14 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <div class="relative group cursor-pointer">
                            <input
                                type="file" 
                                id="image" 
                                name="image" 
                                accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            >
                            <button
                                type="button"
                                class="px-4 py-2 bg-white border border-black text-gray-700 rounded-[30px] group-hover:bg-gray-200 transition-colors duration-200 pointer-events-none"
                            >
                                Choose Picture
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection