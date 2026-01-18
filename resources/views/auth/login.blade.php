<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dsisi Salon</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-pink-100 via-purple-50 to-blue-100 min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-salon-rose mb-2">Dsisi Salon</h1>
                <p class="text-gray-600">Masuk ke akun Anda</p>
            </div>

            <!-- Card Login -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Success Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Form Login -->
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    
                    <!-- DEBUG INFO -->
                    @if(config('app.debug'))
                        <div class="bg-yellow-50 p-3 rounded mb-4 text-sm">
                            <p><strong>Debug Info:</strong></p>
                            <p>Admin Email: admin@dsisisalon.com</p>
                            <p>Admin Password: admin123</p>
                        </div>
                    @endif

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-salon-rose focus:border-transparent transition @error('email') border-red-500 @enderror"
                            placeholder="nama@email.com"
                            required
                            autofocus
                        >
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 font-semibold mb-2">
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-salon-rose focus:border-transparent transition @error('password') border-red-500 @enderror"
                            placeholder="••••••••"
                            required
                        >
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input
                                type="checkbox"
                                name="remember"
                                class="w-4 h-4 text-salon-rose border-gray-300 rounded focus:ring-salon-rose"
                            >
                            <span class="ml-2 text-gray-700">Ingat Saya</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full btn-primary"
                    >
                        Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-salon-rose font-semibold hover:underline">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
