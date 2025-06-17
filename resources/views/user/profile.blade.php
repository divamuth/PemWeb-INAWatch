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

    <div class="flex-1 pt-2 pl-8 m-4">
        <div class="flex pl-8">
            <img src="{{ asset('images/profile-gray.png') }}" alt="Profile" class="h-8 w-8"> 
            <strong class="text-xl pl-4 pt-1">{{ $user->name }}</strong>
        </div>

        <div class="flex-1 p-8 bg-white shadow-lg rounded-[30px] m-4">
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-row justify-around items-start">
                    <div>
                        {{-- Username --}}
                        <div class="mb-4 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4" for="username">
                                Username
                            </label>
                            <input class="ml-24 w-72 p-2 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300"
                                name="username" id="username" type="text"
                                value="{{ old('username', $user->name) }}" />
                        </div>

                        {{-- Name --}}
                        <div class="mb-4 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4" for="name">
                                Name
                            </label>
                            <input class="ml-24 w-72 p-2 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300"
                                name="name" id="name" type="text"
                                value="{{ old('name', $profil->name ?? '') }}" />
                        </div>

                        {{-- Email --}}
                        <div class="mb-4 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4" for="email">
                                Email
                            </label>
                            <input class="ml-24 w-72 p-2 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300"
                                name="email" id="email" type="email"
                                value="{{ old('email', $user->email) }}" />
                        </div>

                        {{-- Phone --}}
                        <div class="mb-4 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4" for="phone">
                                Phone Number
                            </label>
                            <input class="ml-24 w-72 p-2 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300"
                                name="phone" id="phone" type="text"
                                value="{{ old('phone', $profil->phone ?? '') }}" />
                        </div>

                        {{-- Gender --}}
                        <div class="mb-4 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4">
                                Gender
                            </label>
                            <div class="ml-16 flex space-x-6">
                                @foreach(['man' => 'Man', 'woman' => 'Woman', 'others' => 'Others'] as $val => $label)
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="gender" value="{{ $val }}"
                                            {{ old('gender', $profil->gender ?? '') == $val ? 'checked' : '' }}
                                            class="form-radio text-purple-500 focus:ring-2 focus:ring-purple-300 ml-9" />
                                        <span class="ml-2 text-gray-700">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Birthdate --}}
                        <div class="mb-6 flex">
                            <label class="block text-gray-400 text-lg font-bold w-32 text-right pr-4" for="birthdate">
                                Birthdate
                            </label>
                            <input class="ml-24 w-72 p-2 border rounded-[30px] focus:outline-none focus:ring-2 focus:ring-purple-300"
                                name="birthdate" id="birthdate" type="date"
                                value="{{ old('birthdate', $profil->birthdate ?? '') }}" />
                        </div>

                        {{-- Save Button --}}
                        <div class="text-center">
                            <button type="submit"
                                class="px-6 py-2 mt-8 bg-[#A3A4F6] text-white rounded-full hover:bg-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500 font-bold hover:scale-105 transform transition-all duration-200">
                                Save
                            </button>
                        </div>
                    </div>

                    {{-- Profile Picture --}}
                    <div class="flex flex-col items-center space-y-4">
                        <div class="w-24 h-24 bg-gray-200 rounded-full overflow-hidden">
                            @php
                                $imagePath = $profil->image
                                    ? asset('uploads/profiles/' . $profil->image)
                                    : asset('uploads/profile/profil-default.png');
                            @endphp
                            <img src="{{ $imagePath }}" alt="Profile Picture" class="w-full h-full object-cover">
                        </div>
                        <div class="relative group cursor-pointer">
                            <input type="file" id="image" name="image" accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <button type="button"
                                class="px-4 py-2 bg-white border border-black text-gray-700 rounded-[30px] group-hover:bg-gray-200 transition-colors duration-200 pointer-events-none">
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fileInput = document.getElementById('image');
        const previewImage = document.querySelector('img[alt="Profile Picture"]');

        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
