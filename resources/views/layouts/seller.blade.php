<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - Ina Watch</title>
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
    <style>
        /* Desktop sidebar collapsed state */
        .sidebar-collapsed {
            width: 0 !important;
            padding: 0 !important;
            border: none !important;
            overflow: hidden;
        }
        
        /* Smooth transitions */
        #sidebar {
            transition: width 0.3s ease-in-out;
        }
        
        #mainContent {
            transition: margin-left 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-b from-pastel-blue-200 via-pastel-purple-200 to-pastel-pink-200 p-6">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center">
                <!-- Hamburger Menu for Mobile -->
                <button id="
                Toggle" class="md:hidden mr-4 focus:outline-none">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <!-- Desktop Toggle Button -->
                <button id="sidebarToggleDesktop" class="hidden md:block mr-4 focus:outline-none">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
            </div>
            <div class="flex gap-4">
                <a href="/seller/dashboard" class="hover:scale-110 transition-transform">
                    <img src="{{ asset(request()->is('seller/dashboard') || request()->is('seller') ? 'images/home-black.png' : 'images/home-white.png') }}" alt="Home" class="h-8 w-8">
                </a>
                <a href="/seller/chatseller" class="hover:scale-110 transition-transform">
                    <img src="{{ asset(request()->is('seller/chatseller') || request()->is('seller') ? 'images/chat-black.png' : 'images/chat-white.png') }}" alt="Chat" class="h-8 w-8">
                </a>
            </div>
        </div>
    </div>

    <div class="flex">
       <!-- Sidebar -->
        <div id="sidebar" class="w-64 bg-white border-t-[3px] border-r-[3px] border-[#CBA3F6] rounded-tr-[30px] transform md:translate-x-0 -translate-x-full md:static fixed top-0 bottom-0 left-0 transition-transform duration-300 ease-in-out z-50">
            <div class="p-6 flex justify-between items-center">
                <h2 id="sidebarTitle" class="font-bold text-lg">Menu</h2>
                <!-- Sidebar Toggle Button for Desktop -->
                <button id="sidebarToggleDesktopInside" class="hidden md:block focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav class="space-y-3 w-full px-6">
                <a href="/seller/dashboard"
                class="nav-item inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all
                {{ request()->is('seller/dashboard') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }} hover:scale-105 transform transition-all duration-200">
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="/seller/profile"
                class="nav-item inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all
                {{ request()->is('seller/profile') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }} hover:scale-105 transform transition-all duration-200">
                    <span class="nav-text">Store Profile</span>
                </a>
                <a href="/seller/stock"
                class="nav-item inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all
                {{ request()->is('seller/stock') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }} hover:scale-105 transform transition-all duration-200">
                    <span class="nav-text">Stock</span>
                </a>
                <a href="/seller/order"
                class="nav-item inline-flex justify-center items-center w-full px-4 py-3 text-white rounded-[30px] font-bold shadow-md transition-all
                {{ request()->is('seller/order') ? 'bg-[#A3BEF6]' : 'bg-[#CFDEFE] hover:bg-[#A3BEF6]' }} hover:scale-105 transform transition-all duration-200">
                    <span class="nav-text">Order</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div id="mainContent" class="flex-1 p-8 bg-white border-t-[3px] border-l-[3px] border-[#FFB3F8] rounded-tl-[30px] transition-all duration-300 ease-in-out">
            @yield('content')
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarToggleDesktop = document.getElementById('sidebarToggleDesktop');
        const sidebarToggleDesktopInside = document.getElementById('sidebarToggleDesktopInside');
        
        let isCollapsed = false;

        function toggleSidebar() {
            if (window.innerWidth >= 768) {
                // Desktop behavior - hide/show completely
                isCollapsed = !isCollapsed;
                if (isCollapsed) {
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.style.marginLeft = '0';
                } else {
                    sidebar.classList.remove('sidebar-collapsed');
                    mainContent.style.marginLeft = '1rem';
                }
            } else {
                // Mobile behavior - slide in/out
                sidebar.classList.toggle('-translate-x-full');
            }
        }

        // Event listeners
        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarToggleDesktop.addEventListener('click', toggleSidebar);
        sidebarToggleDesktopInside.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 && 
                !sidebar.contains(e.target) && 
                !sidebarToggle.contains(e.target) && 
                !sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                // Reset mobile transform when switching to desktop
                sidebar.classList.remove('-translate-x-full');
                // Restore desktop margin if not collapsed
                if (!isCollapsed) {
                    mainContent.style.marginLeft = '1rem';
                }
            } else {
                // Reset collapsed state when switching to mobile
                sidebar.classList.remove('sidebar-collapsed');
                mainContent.style.marginLeft = '0';
                isCollapsed = false;
            }
        });
    </script>
</body>
</html>