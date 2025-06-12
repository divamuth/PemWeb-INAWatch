
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'User Login - Ina Watch')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
        body {
            font-family: "Inter", sans-serif;
        }
    </style>
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
    <div class="bg-gradient-to-b from-pastel-blue-200 via-pastel-purple-200 to-pastel-pink-200 h-[120px] w-full shadow-lg rounded-bl-[30px] rounded-br-[30px]">
        <div class="flex items-center justify-between h-full px-12 max-w-[1440px] mx-auto">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
            </div>
        </div>
    </div>

    <!-- Content Container: Kiri & Kanan -->
    <div class="flex justify-center items-center mt-12 px-4 lg:px-32">
        <!-- Left Side (Gambar Jam) -->
        <div class="flex-1 flex justify-center">
            <img src="{{ asset('images/loginn.png') }}" alt="Login" class="max-h-[650px] w-auto object-contain">
        </div>

        <!-- Right Side (Form Login) -->
        <div class="flex-1 flex justify-center items-center">
            <div class="form-login bg-white shadow-lg rounded-[30px] p-10 max-w-[400px] min-h-[550px]">
                <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

                <!-- Input Username -->
                <input 
                    type="text" 
                    placeholder="Username or Email" 
                    class="w-full p-3 mb-4 rounded-full bg-gray-200 placeholder:text-gray-500 focus:outline-none"
                />

                <!-- Input Password -->
                <input 
                    type="password" 
                    placeholder="Password" 
                    class="w-full p-3 mb-4 rounded-full bg-gray-200 placeholder:text-gray-500 focus:outline-none"
                />

                <!-- Login Button -->
                <button 
                    class="w-full bg-purple-300 hover:bg-purple-400 text-white font-semibold py-2 rounded-full transition"
                >
                    LOG IN
                </button>

                <!-- Register Link -->
                <p class="text-center mt-4 text-sm">
                    Don't have an account? 
                    <a href="/register" class="underline text-purple-800 hover:text-red-700">Register here.</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
