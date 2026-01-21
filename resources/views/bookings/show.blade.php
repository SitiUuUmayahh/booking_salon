@extends('layouts.app')

@section('title', 'Detail Booking - Dsisi Salon')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Admin Notifications -->
        @include('components.admin-notifications')

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
                        {{ $booking->isGroupBooking() ? 'Paket Layanan' : 'Layanan' }}
                    </h2>
                    
                    @if($booking->isGroupBooking())
                        <!-- Multiple Services Display -->
                        <div class="space-y-4">
                            @foreach($booking->groupedBookings() as $groupBooking)
                                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-purple-500">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-800">{{ $groupBooking->service->name }}</h3>
                                            <p class="text-gray-600 text-sm">{{ $groupBooking->service->description ?? 'Layanan berkualitas tinggi' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-lg font-bold text-pink-600">{{ $groupBooking->service->formatted_price }}</span>
                                            <p class="text-sm text-gray-500">{{ $groupBooking->service->formatted_duration }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Total Price Summary -->
                            <div class="bg-gradient-to-r from-pink-50 to-purple-50 rounded-lg p-6 border border-pink-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">Total Paket ({{ $booking->groupedBookings()->count() }} Layanan)</h3>
                                        <p class="text-sm text-gray-600">Semua layanan akan dilakukan pada waktu yang sama</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-pink-600">
                                            Rp {{ number_format($booking->total_group_price, 0, ',', '.') }}
                                        </span>
                                        <p class="text-sm text-pink-500">Hemat dengan paket!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Single Service Display -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-xl font-bold text-gray-800">{{ $booking->service->name }}</h3>
                            <p class="text-gray-600 mt-2">{{ $booking->service->description }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-2xl font-bold text-pink-600">{{ $booking->service->formatted_price }}</span>
                                <span class="text-gray-600">⏱️ {{ $booking->service->formatted_duration }}</span>
                            </div>
                        </div>
                    @endif
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
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Tanggal</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $booking->formatted_date }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Jam</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $booking->formatted_time }}</p>
                            </div>
                        </div>
                        
                        <!-- Slot Availability Info -->
                        <div class="mt-4 p-4 rounded-lg border-2 
                            @if($slotInfo['is_full']) 
                                bg-red-50 border-red-500
                            @elseif($slotInfo['available'] <= 2) 
                                bg-yellow-50 border-yellow-500
                            @else 
                                bg-green-50 border-green-500
                            @endif">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold 
                                        @if($slotInfo['is_full']) 
                                            text-red-700
                                        @elseif($slotInfo['available'] <= 2) 
                                            text-yellow-700
                                        @else 
                                            text-green-700
                                        @endif">
                                        Ketersediaan Slot Waktu Ini:
                                    </p>
                                    <p class="text-sm 
                                        @if($slotInfo['is_full']) 
                                            text-red-600
                                        @elseif($slotInfo['available'] <= 2) 
                                            text-yellow-600
                                        @else 
                                            text-green-600
                                        @endif">
                                        {{ $slotInfo['booked'] }} dari {{ $slotInfo['total'] }} slot terisi
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-4xl font-bold 
                                        @if($slotInfo['is_full']) 
                                            text-red-600
                                        @elseif($slotInfo['available'] <= 2) 
                                            text-yellow-600
                                        @else 
                                            text-green-600
                                        @endif">
                                        {{ $slotInfo['available'] }}
                                    </p>
                                    <p class="text-xs text-gray-500">slot tersisa</p>
                                </div>
                            </div>
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

                <!-- Down Payment (DP) Section -->
                <div class="mb-8 border-t-4 border-pink-500 bg-pink-50 rounded-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        💳 Down Payment (DP 50%)
                    </h2>

                    <!-- Payment Info -->
                    <div class="bg-white rounded-lg p-6 mb-4">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Total Harga</p>
                                <p class="text-xl font-bold text-gray-800">
                                    @if($booking->isGroupBooking())
                                        Rp {{ number_format($booking->total_group_price, 0, ',', '.') }}
                                    @else
                                        {{ $booking->service->formatted_price }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">DP yang Harus Dibayar (50%)</p>
                                <p class="text-xl font-bold text-pink-600">
                                    @if($booking->isGroupBooking())
                                        {{ $booking->formatted_total_group_dp }}
                                    @else
                                        {{ $booking->formatted_dp_amount }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-sm text-gray-600">Sisa Pembayaran (dibayar saat datang)</p>
                            <p class="text-2xl font-bold text-green-600">
                                @if($booking->isGroupBooking())
                                    {{ $booking->group_remaining_payment }}
                                @else
                                    {{ $booking->remaining_payment }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- DP Status -->
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Status Pembayaran DP:</p>
                        {!! $booking->dp_status_badge !!}
                    </div>

                    <!-- Bank Account Info -->
                    @if($booking->dp_status === 'unpaid' || $booking->dp_status === 'rejected')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <p class="font-semibold text-blue-800 mb-2">📋 Transfer ke Rekening:</p>
                            <div class="text-blue-900">
                                <p><strong>Bank:</strong> BCA</p>
                                <p><strong>No. Rekening:</strong> 1234567890</p>
                                <p><strong>Atas Nama:</strong> Dsisi Salon</p>
                                <p class="mt-2 text-sm text-blue-700">⚠️ Transfer tepat 
                                    <strong>
                                        @if($booking->isGroupBooking())
                                            {{ $booking->formatted_total_group_dp }}
                                        @else
                                            {{ $booking->formatted_dp_amount }}
                                        @endif
                                    </strong> untuk mempermudah verifikasi
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Upload Bukti DP -->
                    @if($booking->dp_status === 'unpaid' || $booking->dp_status === 'rejected')
                        @if($booking->dp_status === 'rejected')
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                <p class="font-semibold text-red-800 mb-1">❌ Bukti Pembayaran Ditolak</p>
                                <p class="text-sm text-red-700">{{ $booking->dp_rejection_reason }}</p>
                                <p class="text-sm text-red-600 mt-2">Silakan upload ulang bukti pembayaran yang benar.</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('bookings.upload-dp', $booking->id) }}" enctype="multipart/form-data" class="bg-white rounded-lg p-6">
                            @csrf
                            <label class="block mb-4">
                                <span class="text-gray-700 font-semibold">Upload Bukti Transfer</span>
                                <input type="file" name="dp_payment_proof" accept="image/*" required
                                       class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                @error('dp_payment_proof')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                            <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-4 rounded-lg transition">
                                📤 Upload Bukti Pembayaran
                            </button>
                        </form>
                    @endif

                    <!-- Pending Verification -->
                    @if($booking->dp_status === 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="font-semibold text-yellow-800 mb-2">⏳ Bukti Pembayaran Sedang Diverifikasi</p>
                            <p class="text-sm text-yellow-700">Bukti transfer Anda telah diupload pada {{ $booking->dp_paid_at->format('d M Y H:i') }}. Admin sedang memverifikasi pembayaran Anda.</p>
                            @if($booking->dp_payment_proof)
                                <div class="mt-3">
                                    <p class="text-sm text-yellow-700 mb-2">Bukti yang diupload:</p>
                                    <img src="{{ asset('storage/' . $booking->dp_payment_proof) }}" alt="Bukti DP" class="max-w-xs rounded border">
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Verified -->
                    @if($booking->dp_status === 'verified')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="font-semibold text-green-800 mb-2">✅ Pembayaran DP Terverifikasi</p>
                            <p class="text-sm text-green-700">Pembayaran DP Anda telah diverifikasi pada {{ $booking->dp_verified_at->format('d M Y H:i') }}. Booking Anda sudah terkonfirmasi!</p>
                            <p class="text-sm text-green-600 mt-2">💰 Sisa pembayaran <strong>{{ $booking->remaining_payment }}</strong> dibayar saat Anda datang ke salon.</p>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200 gap-2">
                    <a href="{{ route('bookings.history') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-200">
                        Kembali
                    </a>

                    <!-- WhatsApp Button -->
                    <a href="{{ $booking->whatsapp_admin_link }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.272-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-9.746 9.798c0 2.734.75 5.404 2.177 7.697l-2.313 6.348 6.487-2.313c2.258 1.494 4.882 2.277 7.596 2.277 5.391 0 9.799-4.411 9.798-9.799 0-2.618-.758-5.07-2.177-7.218a9.867 9.867 0 00-7.217-2.59z"/>
                        </svg>
                        Chat Admin
                    </a>

                    @if($booking->status === 'pending' && $booking->dp_status === 'unpaid')
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
