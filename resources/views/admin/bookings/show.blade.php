@extends('layouts.admin')

@section('title', 'Detail Booking - Admin')
@section('page-title', 'Detail Booking')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.bookings.index') }}" class="text-pink-600 hover:text-pink-700 flex items-center font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Booking
        </a>
        <div class="flex items-center gap-2">
            {!! $booking->status_badge !!}
            {!! $booking->dp_status_badge !!}
        </div>
    </div>

    <!-- Booking ID Badge -->
    <div class="mt-4 bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90 mb-1">Booking ID</p>
                <h1 class="text-3xl font-bold">#{{ $booking->id }}</h1>
            </div>
            <div class="text-right">
                <p class="text-sm opacity-90 mb-1">Tanggal & Waktu</p>
                <p class="text-xl font-semibold">{{ $booking->formatted_date }}</p>
                <p class="text-lg">{{ $booking->formatted_time }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="xl:col-span-2 space-y-6">
        <!-- Service Info Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-pink-50 to-purple-50 px-6 py-4 border-b">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Informasi Layanan
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Nama Layanan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $booking->service->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Deskripsi</p>
                        <p class="text-gray-700 leading-relaxed">{{ $booking->service->description }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                        <div class="bg-pink-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-1">Harga Layanan</p>
                            <p class="text-2xl font-bold text-pink-600">{{ $booking->service->formatted_price }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-1">Durasi</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $booking->service->formatted_duration }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Info Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informasi Pelanggan
                </h3>
                {!! $booking->user->reputation_badge !!}
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Nama Customer</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Email</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">No. Telepon</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Terdaftar Sejak</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->user->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Total Booking</p>
                        <p class="text-lg font-semibold text-blue-600">{{ $booking->user->bookings()->count() }} kali</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Riwayat Cancel</p>
                        <p class="text-lg font-semibold {{ $booking->user->cancel_count > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $booking->user->cancel_count }} kali
                        </p>
                    </div>
                </div>

                @if($booking->user->is_suspended)
                    <div class="mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-red-800">⛔ User Di-Suspend</p>
                                <p class="text-sm text-red-700 mt-1">{{ $booking->user->suspend_reason }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Notes Card -->
        @if($booking->notes)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 px-6 py-4 border-b">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Catatan Customer
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 leading-relaxed italic">"{{ $booking->notes }}"</p>
                </div>
            </div>
        @endif

        <!-- Timeline Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-4 border-b">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Waktu
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Dibuat:</span>
                        <span class="font-semibold text-gray-900">{{ $booking->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Terakhir Update:</span>
                        <span class="font-semibold text-gray-900">{{ $booking->updated_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    @if($booking->dp_paid_at)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">DP Diupload:</span>
                            <span class="font-semibold text-gray-900">{{ $booking->dp_paid_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                    @endif
                    @if($booking->dp_verified_at)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">DP Diverifikasi:</span>
                            <span class="font-semibold text-green-600">{{ $booking->dp_verified_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Payment Summary Card -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow-lg overflow-hidden border-2 border-green-200">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    💰 Ringkasan Pembayaran
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-green-200">
                    <span class="text-gray-700">Total Harga</span>
                    <span class="text-xl font-bold text-gray-900">{{ $booking->service->formatted_price }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b border-green-200">
                    <span class="text-gray-700">DP (50%)</span>
                    <span class="text-xl font-bold text-pink-600">{{ $booking->formatted_dp_amount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-700 font-semibold">Sisa Bayar</span>
                    <span class="text-2xl font-bold text-green-600">{{ $booking->remaining_payment }}</span>
                </div>
                <div class="bg-white rounded-lg p-3 mt-4">
                    <p class="text-xs text-gray-600 text-center">💡 Sisa dibayar saat customer datang</p>
                </div>
            </div>
        </div>

        <!-- Bukti Transfer Card (if exists) -->
        @if($booking->dp_payment_proof)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        📸 Bukti Transfer DP
                    </h3>
                </div>
                <div class="p-6">
                    <a href="{{ route('admin.bookings.dp-proof-view', $booking->id) }}" target="_blank" class="block group">
                        <div class="relative overflow-hidden rounded-lg border-2 border-gray-200 group-hover:border-blue-400 transition">
                            <img src="{{ route('admin.bookings.dp-proof-view', $booking->id) }}"
                                 alt="Bukti DP"
                                 class="w-full max-h-96 object-cover group-hover:scale-102 transition duration-300">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition flex items-center justify-center">
                                <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <p class="text-xs text-gray-500 mt-3 text-center">
                        📅 Diupload: {{ $booking->dp_paid_at ? $booking->dp_paid_at->format('d M Y, H:i') : '-' }} WIB
                    </p>
                    <p class="text-xs text-center text-gray-400 mt-1">Klik untuk memperbesar</p>
                </div>
            </div>
        @endif

        <!-- DP Verification Actions -->
        @if($booking->dp_status === 'pending')
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-yellow-200">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        ⏳ Verifikasi DP
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <form method="POST" action="{{ route('admin.bookings.verify-dp', $booking->id) }}">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 px-4 rounded-lg transition transform hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Verifikasi DP
                            </span>
                        </button>
                    </form>

                    <button onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                            class="w-full bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-bold py-4 px-4 rounded-lg transition transform hover:scale-105 shadow-lg">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tolak DP
                        </span>
                    </button>
                </div>
            </div>
        @elseif($booking->dp_status === 'verified')
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow-lg p-6 border-2 border-green-300">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500 rounded-full mb-3">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="font-bold text-green-800 text-lg">DP Terverifikasi</p>
                    <p class="text-sm text-green-600 mt-1">
                        {{ $booking->dp_verified_at ? $booking->dp_verified_at->format('d M Y, H:i') : '' }} WIB
                    </p>
                </div>
            </div>
        @endif

        <!-- Booking Actions -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    ⚡ Actions Booking
                </h3>
            </div>
            <div class="p-6 space-y-3">
                @if($booking->status === 'pending')
                    @if($booking->dp_status === 'verified')
                        <form method="POST" action="{{ route('admin.bookings.confirm', $booking->id) }}">
                            @csrf
                            <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 px-4 rounded-lg transition transform hover:scale-105 shadow-lg">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Konfirmasi Booking
                                </span>
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-4">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <p class="text-center text-gray-600 font-semibold text-sm">Konfirmasi Booking Terkunci</p>
                            <p class="text-center text-gray-500 text-xs mt-1">Verifikasi DP terlebih dahulu</p>
                        </div>
                    @endif
                @endif

                @if($booking->status === 'confirmed')
                    <form method="POST" action="{{ route('admin.bookings.complete', $booking->id) }}">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-4 px-4 rounded-lg transition transform hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                Tandai Selesai
                            </span>
                        </button>
                    </form>
                @endif

                @if($booking->status !== 'completed')
                    <form method="POST" action="{{ route('admin.bookings.cancel', $booking->id) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Yakin ingin batalkan booking ini?')" class="w-full bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white font-semibold py-3 px-4 rounded-lg transition shadow">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batalkan Booking
                            </span>
                        </button>
                    </form>
                @endif

                @if($booking->status === 'cancelled')
                    <form method="POST" action="{{ route('admin.bookings.destroy', $booking->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin hapus booking ini?')" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus Booking
                            </span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- User Management -->
        @if($booking->user->cancel_count > 0 || $booking->user->is_suspended)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        👤 Kelola User
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    @if($booking->user->is_suspended)
                        <form method="POST" action="{{ route('admin.users.unsuspend', $booking->user->id) }}">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition shadow">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                    </svg>
                                    Aktifkan Kembali User
                                </span>
                            </button>
                        </form>
                    @endif

                    @if($booking->user->cancel_count > 0)
                        <form method="POST" action="{{ route('admin.users.reset-cancel-count', $booking->user->id) }}">
                            @csrf
                            <button type="submit" onclick="return confirm('Reset cancel count user ini?')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition shadow">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Reset Cancel Count
                                </span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Tolak DP -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Tolak Pembayaran DP</h3>
        <form method="POST" action="{{ route('admin.bookings.reject-dp', $booking->id) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Alasan Penolakan:</label>
                <textarea name="rejection_reason" rows="4" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                          placeholder="Contoh: Bukti transfer tidak jelas, nominal tidak sesuai, dll"></textarea>
            </div>
            <div class="flex space-x-3">
                <button type="button"
                        onclick="document.getElementById('rejectModal').classList.add('hidden')"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-4 rounded-lg transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                    Tolak DP
                </button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
