
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'User Register - Ina Watch')</title>
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
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
            </div>
        </div>
    </div>

    <div class="flex justify-center items-center mt-12 px-4 lg:px-32">
        <!-- Sisi Kiri -->
        <div class="flex-1 flex justify-center">
            <img src="{{ asset('images/loginn.png') }}" alt="Login" class="max-h-[650px] w-auto object-contain">
        </div>

        <!-- Form Register -->
        <form method="POST" action="{{ route('register.submit') }}">
            @csrf
            <div class="flex-1 flex justify-center items-center">
                <div class="form-login bg-white shadow-lg rounded-[30px] p-10 max-w-[400px] min-h-[550px]">
                    <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

                    <!-- Validasi Error -->
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-3 rounded-full mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <input type="email" name="email"placeholder="Email" class="w-full p-3 mb-4 rounded-full bg-gray-200 placeholder:text-gray-500 focus:outline-none"/>
                    <input type="text" name="name"placeholder="Username" class="w-full p-3 mb-4 rounded-full bg-gray-200 placeholder:text-gray-500 focus:outline-none"/>
                    <input type="password" name="password" placeholder="Password" class="w-full p-3 mb-4 rounded-full bg-gray-200 placeholder:text-gray-500 focus:outline-none"/>
                    <input type="password" name="password_confirmation"placeholder="Confirm password" class="w-full p-3 mb-4 rounded-full bg-gray-200 placeholder:text-gray-500 focus:outline-none"/>
                    <button class="w-full bg-purple-300 hover:bg-purple-400 text-white font-semibold py-2 rounded-full transition"type="submit">REGISTER</button>
                    <p class="text-center mt-4 text-sm"> Already have an account?<a href="{{ route('login') }}" class="underline text-purple-800 hover:text-red-700">Login here.</a></p>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
