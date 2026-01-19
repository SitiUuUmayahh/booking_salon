@extends('layouts.app')

@section('title', 'Profile - Dsisi Salon')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <p class="text-green-700 font-medium">✅ {{ session('success') }}</p>
            </div>
        @endif

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-pink-500 to-purple-600 h-24"></div>

            <div class="px-6 pb-6">
                <!-- Avatar -->
                <div class="flex items-center -mt-12 mb-4">
                    <div class="w-24 h-24 rounded-full border-4 border-white bg-gray-200 flex items-center justify-center">
                        <span class="text-4xl">👤</span>
                    </div>
                    <div class="ml-6 mt-12">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        @if($user->phone)
                            <p class="text-gray-600 text-sm">📱 {{ $user->phone }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t">
                    <div class="flex items-center gap-4">
                        @if($user->is_admin)
                            <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">Admin</span>
                        @else
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">Customer</span>
                        @endif
                        <span class="text-sm text-gray-500">Member sejak {{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                       class="px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white text-sm font-medium rounded-lg transition">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Account Status (if suspended) -->
        @if($user->is_suspended)
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <p class="text-red-800 font-semibold">⚠️ Akun Di-suspend</p>
                <p class="text-red-700 text-sm mt-1">{{ $user->suspend_reason }}</p>
            </div>
        @endif

        <!-- Booking Statistics -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Booking</h3>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-purple-600">{{ $bookingStats['total'] }}</p>
                    <p class="text-xs text-gray-600 mt-1">Total</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-yellow-600">{{ $bookingStats['pending'] }}</p>
                    <p class="text-xs text-gray-600 mt-1">Menunggu</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-blue-600">{{ $bookingStats['confirmed'] }}</p>
                    <p class="text-xs text-gray-600 mt-1">Dikonfirmasi</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-600">{{ $bookingStats['completed'] }}</p>
                    <p class="text-xs text-gray-600 mt-1">Selesai</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-red-600">{{ $bookingStats['cancelled'] }}</p>
                    <p class="text-xs text-gray-600 mt-1">Dibatalkan</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold {{ $user->cancel_count >= 3 ? 'text-red-600' : 'text-gray-600' }}">
                        {{ $user->cancel_count }}/5
                    </p>
                    <p class="text-xs text-gray-600 mt-1">Cancel Count</p>
                </div>
            </div>

            @if($user->cancel_count >= 3 && !$user->is_suspended)
                <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded">
                    <p class="text-xs text-yellow-800">
                        ⚠️ Anda telah membatalkan {{ $user->cancel_count }}x booking.
                        Jika membatalkan {{ 5 - $user->cancel_count }}x lagi, akun akan di-suspend.
                    </p>
                </div>
            @endif
        </div>

        <!-- Quick Menu -->
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('dashboard') }}"
               class="bg-white hover:bg-gray-50 p-4 rounded-lg shadow-md transition flex items-center">
                <span class="text-2xl mr-3">🏠</span>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">Dashboard</p>
                    <p class="text-xs text-gray-600">Kembali ke dashboard</p>
                </div>
            </a>

            <a href="{{ route('services.index') }}"
               class="bg-white hover:bg-gray-50 p-4 rounded-lg shadow-md transition flex items-center">
                <span class="text-2xl mr-3">💇</span>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">Layanan</p>
                    <p class="text-xs text-gray-600">Lihat semua layanan</p>
                </div>
            </a>

            <a href="{{ route('bookings.history') }}"
               class="bg-white hover:bg-gray-50 p-4 rounded-lg shadow-md transition flex items-center">
                <span class="text-2xl mr-3">📜</span>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">Riwayat</p>
                    <p class="text-xs text-gray-600">Semua booking Anda</p>
                </div>
            </a>

            <a href="{{ route('profile.edit') }}"
               class="bg-white hover:bg-gray-50 p-4 rounded-lg shadow-md transition flex items-center">
                <span class="text-2xl mr-3">✏️</span>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">Edit</p>
                    <p class="text-xs text-gray-600">Ubah profile Anda</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
