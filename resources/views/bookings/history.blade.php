@extends('layouts.app')

@section('title', 'Riwayat Booking - Dsisi Salon')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Booking</h1>
            <p class="text-gray-600 mt-2">Lihat semua riwayat booking Anda</p>
        </div>

        @if($paginatedBookings->count() > 0)
            <!-- Bookings List -->
            <div class="space-y-4">
                @foreach($paginatedBookings as $bookingGroup)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                        @if($bookingGroup['is_group'])
                            <!-- Group Booking Display -->
                            <div class="md:flex">
                                <!-- Left Side: Group Indicator -->
                                <div class="md:w-1/4 bg-gradient-to-br from-purple-400 to-pink-500 relative overflow-hidden">
                                    <div class="flex items-center justify-center h-full min-h-[200px] text-white">
                                        <div class="text-center">
                                            <span class="text-4xl mb-2 block">📦</span>
                                            <span class="text-sm font-semibold">Paket Layanan</span>
                                            <span class="text-xs block">{{ $bookingGroup['bookings']->count() }} Services</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Side: Group Booking Details -->
                                <div class="md:w-3/4 p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800">
                                                Paket Layanan ({{ $bookingGroup['bookings']->count() }} Services)
                                            </h3>
                                            <p class="text-gray-600">{{ $bookingGroup['main_booking']->customer_name }}</p>
                                            <div class="mt-2 space-y-1">
                                                @foreach($bookingGroup['bookings'] as $booking)
                                                    <span class="inline-block text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded mr-1">
                                                        {{ $booking->service->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            {!! $bookingGroup['main_booking']->status_badge !!}
                                            <div class="mt-1">
                                                {!! $bookingGroup['main_booking']->dp_status_badge !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-sm">{{ $bookingGroup['main_booking']->formatted_date }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-sm">{{ $bookingGroup['main_booking']->formatted_time }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                            </svg>
                                            <span class="text-sm font-semibold">
                                                Rp {{ number_format($bookingGroup['bookings']->sum(function($b) { return $b->service->price; }), 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-600">{{ $bookingGroup['main_booking']->created_at->diffForHumans() }}</p>
                                        <a href="{{ route('bookings.show', $bookingGroup['main_booking']->id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                            Lihat Detail
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Single Booking Display -->
                            @php $booking = $bookingGroup['main_booking']; @endphp
                            <div class="md:flex">
                                <!-- Left Side: Service Image -->
                                <div class="md:w-1/4 bg-gradient-to-br from-pink-400 to-purple-500 relative overflow-hidden">
                                    @if($booking->service->image)
                                        <img src="{{ asset('storage/' . $booking->service->image) }}"
                                             alt="{{ $booking->service->name }}"
                                             class="w-full h-full object-cover absolute inset-0">
                                    @else
                                        <div class="flex items-center justify-center h-full min-h-[200px]">
                                            <span class="text-white text-6xl">💇</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Right Side: Booking Details -->
                                <div class="md:w-3/4 p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800">{{ $booking->service->name }}</h3>
                                            <p class="text-gray-600">{{ $booking->customer_name }}</p>
                                        </div>
                                        <div class="text-right">
                                            {!! $booking->status_badge !!}
                                            <div class="mt-1">
                                                {!! $booking->dp_status_badge !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-sm">{{ $booking->formatted_date }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-sm">{{ $booking->formatted_time }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-700">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                            </svg>
                                            <span class="text-sm">{{ $booking->service->formatted_price }}</span>
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-600">{{ $booking->created_at->diffForHumans() }}</p>
                                        <a href="{{ route('bookings.show', $booking->id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                            Lihat Detail
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $paginatedBookings->links() }}
            </div>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $booking->formatted_date }}
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $booking->formatted_time }}
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $booking->service->formatted_price }}
                                    </div>
                                </div>

                                @if($booking->notes)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600"><strong>Catatan:</strong> {{ $booking->notes }}</p>
                                    </div>
                                @endif

                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 pt-4 border-t border-gray-200">
                                    <span class="text-sm text-gray-500">
                                        Dibuat: {{ $booking->created_at->format('d M Y H:i') }}
                                    </span>
                                    <div class="flex gap-2 w-full sm:w-auto">
                                        <a href="{{ route('bookings.show', $booking->id) }}"
                                           class="flex-1 sm:flex-none text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-200 shadow-sm">
                                            Detail
                                        </a>

                                        @if($booking->status === 'pending')
                                            <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" class="flex-1 sm:flex-none">
                                                @csrf
                                                <button type="submit"
                                                        onclick="return confirm('Yakin ingin membatalkan booking ini?')"
                                                        class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-200 shadow-sm">
                                                    Batal
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-800">Belum Ada Booking</h3>
                <p class="mt-2 text-gray-600">Anda belum memiliki riwayat booking</p>
                <a href="{{ route('dashboard') }}" class="mt-6 inline-block bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                    Buat Booking Sekarang
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
