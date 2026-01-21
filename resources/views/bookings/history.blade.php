@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 to-purple-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <h1 class="text-3xl font-bold text-gray-800">Riwayat Booking</h1>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white font-semibold rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Booking Baru
                </a>
            </div>
            <p class="text-gray-600">Kelola dan lihat semua riwayat booking Anda</p>
        </div>

        <!-- Special call-to-action after cancellation -->
        @if(session('show_booking_button'))
            <div class="mb-6 bg-gradient-to-r from-green-400 to-blue-500 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">✨ Siap untuk Booking Lagi? ✨</h3>
                            <p class="text-green-100">Booking Anda telah dibatalkan. Sekarang Anda bisa memilih layanan lain yang sesuai dengan kebutuhan Anda!</p>
                            @auth
                                @if(Auth::user()->remaining_today_bookings > 0)
                                    <p class="text-xs text-green-100 mt-1">Sisa quota booking hari ini: <strong>{{ Auth::user()->remaining_today_bookings }}</strong></p>
                                @endif
                            @endauth
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Mulai Booking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
                                            <span class="text-xs opacity-90 block mt-1">{{ count($bookingGroup['bookings']) }} Layanan</span>
                                        </div>
                                    </div>
                                    <!-- Decorative elements -->
                                    <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-20 rounded-full -mr-10 -mt-10"></div>
                                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-white bg-opacity-20 rounded-full -ml-8 -mb-8"></div>
                                </div>
                                
                                <!-- Right Side: Group Details -->
                                <div class="md:w-3/4 p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800 mb-1">
                                                Paket Layanan
                                            </h3>
                                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                                {{ $bookingGroup['bookings'][0]->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                                   ($bookingGroup['bookings'][0]->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($bookingGroup['bookings'][0]->status) }}
                                            </span>
                                        </div>
                                        <div class="text-right text-sm text-gray-600">
                                            <div>{{ $bookingGroup['bookings'][0]->formatted_date }}</div>
                                            <div>{{ $bookingGroup['bookings'][0]->formatted_time }}</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Services in group -->
                                    <div class="space-y-3 mb-4">
                                        <h4 class="font-semibold text-gray-700">Layanan yang Dibooking:</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @foreach($bookingGroup['bookings'] as $booking)
                                                <div class="border border-gray-200 rounded-lg p-3">
                                                    <div class="flex items-center space-x-3">
                                                        @if($booking->service->image)
                                                            <img src="{{ asset('storage/' . $booking->service->image) }}" 
                                                                 alt="{{ $booking->service->name }}" 
                                                                 class="w-12 h-12 object-cover rounded-lg">
                                                        @else
                                                            <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg flex items-center justify-center">
                                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <div class="flex-1">
                                                            <h5 class="font-medium text-gray-800">{{ $booking->service->name }}</h5>
                                                            <p class="text-sm text-gray-600">{{ $booking->service->formatted_price }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <!-- Total and Actions -->
                                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                        <div class="text-lg font-bold text-gray-800">
                                            Total: {{ $bookingGroup['total_formatted'] }}
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('bookings.show', $bookingGroup['bookings'][0]->id) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                Lihat Detail
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                            @if($bookingGroup['bookings'][0]->status === 'pending')
                                                <form method="POST" action="{{ route('bookings.cancel', $bookingGroup['bookings'][0]->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            onclick="return confirm('Yakin ingin membatalkan semua booking dalam group ini?')"
                                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                        Batal Group
                                                    </button>
                                                </form>
                                            @endif
                                            @if($bookingGroup['bookings'][0]->status === 'completed')
                                                <a href="{{ route('dashboard') }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    </svg>
                                                    Booking Lagi
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Single Booking Display -->
                            @php
                                $booking = $bookingGroup['bookings'][0];
                            @endphp
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row lg:items-start lg:space-x-6">
                                    <!-- Service Image -->
                                    <div class="flex-shrink-0 mb-4 lg:mb-0">
                                        @if($booking->service->image)
                                            <img src="{{ asset('storage/' . $booking->service->image) }}" 
                                                 alt="{{ $booking->service->name }}" 
                                                 class="w-20 h-20 object-cover rounded-lg shadow-sm">
                                        @else
                                            <div class="w-20 h-20 bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg flex items-center justify-center shadow-sm">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Service Details -->
                                    <div class="flex-1">
                                        <div class="mb-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <h4 class="text-xl font-bold text-gray-800">{{ $booking->service->name }}</h4>
                                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                                       ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </div>
                                            <p class="text-gray-600 mb-3">{{ $booking->service->description }}</p>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                <div class="flex items-center text-gray-700">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                        </div>

                                        @if($booking->notes)
                                            <div class="mb-4">
                                                <p class="text-sm text-gray-600"><strong>Catatan:</strong> {{ $booking->notes }}</p>
                                            </div>
                                        @endif

                                        <!-- Actions -->
                                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                            <a href="{{ route('bookings.show', $booking->id) }}" 
                                               class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200 shadow-sm">
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

                                            @if($booking->status === 'completed')
                                                <a href="{{ route('bookings.create', ['service_id' => $booking->service->id]) }}" 
                                                   class="inline-flex items-center justify-center px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-200 shadow-sm">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    </svg>
                                                    Booking Lagi
                                                </a>
                                            @endif
                                        </div>
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