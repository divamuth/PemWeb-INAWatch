<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'User Dashboard - Ina Watch')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pastel-blue-200': '#c5d7f9',
                        'pastel-purple-200': '#dfc6fa',
                        'pastel-pink-200': '#ffd8fb',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#f6f6ff] min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-b from-pastel-blue-200 via-pastel-purple-200 to-pastel-pink-200 h-[120px] w-full shadow-lg rounded-bl-[30px] rounded-br-[30px]">
        <div class="flex items-center justify-between h-full px-12 max-w-[1440px] mx-auto">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
            </div>

            <!-- Search Box -->
            <div class="flex-grow flex justify-center">
                <form action="{{ route('user.dashboard') }}" method="GET" class="relative w-full max-w-2xl h-[45px]">
                    <input type="text" name="search" placeholder="Search product" value="{{ request()->query('search') }}"
                        class="w-full h-full pl-6 pr-16 rounded-[30px] text-lg shadow-md focus:outline-none" />
                    <button type="submit" class="absolute right-5 top-1/2 transform -translate-y-1/2 h-6 w-6 opacity-70">
                        <img src="{{ asset('images/search.png') }}" alt="Search">
                    </button>
                </form>
            </div>

            <!-- Icons -->
            <div class="flex items-center gap-6">
                <!-- Home -->
                <a href="{{ route('user.dashboard') }}" class="hover:scale-110 transition-transform">
                    <img src="{{ asset(request()->is('user/dashboard') || request()->is('user') ? 'images/home-black.png' : 'images/home-white.png') }}" alt="Home" class="h-8 w-8">
                </a>

                <!-- Chat -->
                <a href="{{ route('user.chatuser') }}" class="hover:scale-110 transition-transform">
                    <img src="{{ asset(request()->is('user/chatuser') ? 'images/chat-black.png' : 'images/chat-white.png') }}" alt="Chat" class="h-8 w-8">
                </a>

                <!-- Cart -->
                <a href="/user/cart" class="hover:scale-110 transition-transform">
                    <img src="{{ asset(request()->is('user/cart') ? 'images/cart-black.png' : 'images/cart-white.png') }}" alt="Cart" class="h-8 w-8">
                </a>

                <!-- Profile -->
                <a href="/user/profile" class="hover:scale-110 transition-transform">
                    <img src="{{ asset(request()->is('user/profile') ? 'images/profile-black.png' : 'images/profile-white.png') }}" alt="Profile" class="h-8 w-8">
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-[1440px] mx-auto">
        @yield('content')
    </div>
</body>
</html>