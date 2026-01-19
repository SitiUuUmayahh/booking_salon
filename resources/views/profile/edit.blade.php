@extends('layouts.app')

@section('title', 'Edit Profile - Dsisi Salon')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <a href="{{ route('profile.show') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Profile
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left: Edit Profile Info -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">📝 Edit Informasi Profile</h2>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $user->name) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        @error('name')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', $user->email) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        @error('email')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-6">
                        <label for="phone" class="block text-gray-700 font-semibold mb-2">
                            Nomor Telepon
                        </label>
                        <input type="text" name="phone" id="phone"
                               value="{{ old('phone', $user->phone) }}"
                               placeholder="08xxxxxxxxxx"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        @error('phone')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                        💾 Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Right: Change Password -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">🔒 Ubah Password</h2>

                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div class="mb-4">
                        <label for="current_password" class="block text-gray-700 font-semibold mb-2">
                            Password Saat Ini <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="current_password" id="current_password"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        @error('current_password')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-semibold mb-2">
                            Password Baru <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" id="password"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        <p class="text-sm text-gray-500 mt-1">Minimal 8 karakter</p>
                        @error('password')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">
                            Konfirmasi Password Baru <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>

                    <!-- Security Warning -->
                    <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                        <div class="flex">
                            <svg class="h-5 w-5 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-yellow-800">
                                Setelah mengubah password, Anda akan tetap login di perangkat ini.
                            </p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                        🔐 Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
