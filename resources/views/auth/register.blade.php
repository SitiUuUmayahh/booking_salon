<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dsisi Salon</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-pink-100 via-purple-50 to-blue-100 min-h-screen flex items-center justify-center py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-salon-rose mb-2">Dsisi Salon</h1>
                <p class="text-gray-600">Buat akun baru</p>
            </div>

            <!-- Card Register -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Register -->
                <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">
                            Nama Lengkap *
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-salon-rose focus:border-transparent transition @error('name') border-red-500 @enderror"
                            placeholder="Nama Lengkap Anda"
                            required
                            autofocus
                        >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">
                            Email *
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-salon-rose focus:border-transparent transition @error('email') border-red-500 @enderror"
                            placeholder="nama@email.com"
                            required
                        >
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-semibold mb-2">
                            Nomor Telepon (Opsional)
                        </label>
                        <input
                            type="tel"
                            name="phone"
                            id="phone"
                            value="{{ old('phone') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-salon-rose focus:border-transparent transition"
                            placeholder="08123456789"
                        >
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-semibold mb-2">
                            Password *
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-salon-rose focus:border-transparent transition @error('password') border-red-500 @enderror"
                            placeholder="Minimal 8 karakter"
                            required
                        >
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">
                            Konfirmasi Password *
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-salon-rose focus:border-transparent transition"
                            placeholder="Ketik ulang password"
                            required
                        >
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full btn-primary"
                    >
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Divider -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-salon-rose font-semibold hover:underline">
                            Masuk Sekarang
                        </a>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="mt-4 text-center">
                    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
