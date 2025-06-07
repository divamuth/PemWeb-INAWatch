<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Dashboard') - Ina Watch</title>
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
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-b from-pastel-blue-200 via-pastel-purple-200 to-pastel-pink-200 p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            </div>
            <div class="flex gap-4">
                <a href="/seller/dashboard">
                    <img src="{{ asset('images/home.png') }}" alt="Home" class="h-7 w-7">
                </a>
                <a href="/seller/chatseller">
                    <img src="{{ asset('images/chat.png') }}" alt="Chat" class="h-7 w-7">
                </a>
            </div>
        </div>
    </div>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white min-h-screen border-[3px] border-[#CBA3F6] rounded-tr-[30px]">
            <div class="p-6 flex justify-center">
                <nav class="space-y-3 w-full">
                    <a href="/seller/dashboard" class="inline-flex justify-center items-center w-full px-4 py-3 bg-[#A3BEF6] text-white rounded-[30px] font-bold shadow-md">
                        Dashboard
                    </a>
                    <a href="/seller/profile" class="inline-flex justify-center items-center w-full px-4 py-3 text-white bg-[#CFDEFE] hover:bg-[#A3BEF6] rounded-[30px] transition-all font-bold shadow-md">
                        Store Profile
                    </a>
                    <a href="/seller/stock" class="inline-flex justify-center items-center w-full px-4 py-3 text-white bg-[#CFDEFE] hover:bg-[#A3BEF6] rounded-[30px] transition-all font-bold shadow-md">
                        Stock
                    </a>
                    <a href="/seller/order" class="inline-flex justify-center items-center w-full px-4 py-3 text-white bg-[#CFDEFE] hover:bg-[#A3BEF6] rounded-[30px] transition-all font-bold shadow-md">
                        Order
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white border-t-[3px] border-l-[3px] border-[#FFB3F8] rounded-tl-[30px] ml-4">
            @yield('content')
        </div>
    </div>
</body>
</html>