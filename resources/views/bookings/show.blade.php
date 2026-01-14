@extends('layouts.app')

@section('title', 'Detail Booking - Dsisi Salon')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('bookings.history') }}" class="text-pink-600 hover:text-pink-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Riwayat
            </a>
        </div>

        <!-- Booking Card -->
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Header with Status -->
            <div class="bg-gradient-to-r from-pink-500 to-purple-600 p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Detail Booking</h1>
                        <p class="text-pink-100">Booking ID: #{{ $booking->id }}</p>
                    </div>
                    <div>
                        {!! $booking->status_badge !!}
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="p-8">
                <!-- Service Info -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Layanan
                    </h2>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800">{{ $booking->service->name }}</h3>
                        <p class="text-gray-600 mt-2">{{ $booking->service->description }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-2xl font-bold text-pink-600">{{ $booking->service->formatted_price }}</span>
                            <span class="text-gray-600">⏱️ {{ $booking->service->formatted_duration }}</span>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi Pelanggan
                    </h2>
                    <div class="bg-gray-50 rounded-lg p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $booking->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $booking->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">No. Telepon</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $booking->user->phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Booking Schedule -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Jadwal Booking
                    </h2>
                    <div class="bg-gray-50 rounded-lg p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Tanggal</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $booking->formatted_date }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jam</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $booking->formatted_time }}</p>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($booking->notes)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            Catatan
                        </h2>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <p class="text-gray-800">{{ $booking->notes }}</p>
                        </div>
                    </div>
                @endif

                <!-- Status Info -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Status Booking</h2>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="mr-4">
                                {!! $booking->status_badge !!}
                            </div>
                            <div>
                                @if($booking->status === 'pending')
                                    <p class="text-gray-700">Menunggu konfirmasi dari admin</p>
                                @elseif($booking->status === 'confirmed')
                                    <p class="text-gray-700">Booking Anda sudah dikonfirmasi. Harap datang tepat waktu.</p>
                                @elseif($booking->status === 'completed')
                                    <p class="text-gray-700">Terima kasih! Booking telah selesai.</p>
                                @elseif($booking->status === 'cancelled')
                                    <p class="text-gray-700">Booking ini telah dibatalkan</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p>Dibuat: {{ $booking->created_at->format('d M Y H:i') }}</p>
                            <p>Terakhir diupdate: {{ $booking->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <a href="{{ route('bookings.history') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-200">
                        Kembali
                    </a>

                    @if($booking->status === 'pending')
                        <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}">
                            @csrf
                            <button type="submit" onclick="return confirm('Yakin ingin membatalkan booking ini?')" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                                Batalkan Booking
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection