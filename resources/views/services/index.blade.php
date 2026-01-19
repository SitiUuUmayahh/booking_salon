@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Layanan Kami</h1>
            <p class="text-lg text-gray-600">Pilih layanan salon terbaik untuk kebutuhan Anda</p>
        </div>

        @if($services->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada layanan</h3>
                <p class="mt-1 text-sm text-gray-500">Layanan akan segera ditambahkan</p>
            </div>
        @else
            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 group">
                        <!-- Service Image -->
                        @if($service->image)
                            <div class="relative h-64 overflow-hidden bg-gray-200">
                                <img src="{{ asset('storage/' . $service->image) }}"
                                     alt="{{ $service->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            </div>
                        @else
                            <div class="relative h-64 bg-gradient-to-br from-purple-400 to-blue-400 flex items-center justify-center">
                                <svg class="h-24 w-24 text-white opacity-30" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                                </svg>
                            </div>
                        @endif

                        <!-- Service Content -->
                        <div class="p-6">
                            <!-- Service Name -->
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $service->name }}</h3>

                            <!-- Service Description -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $service->description }}</p>

                            <!-- Service Details -->
                            <div class="space-y-3 mb-6">
                                <!-- Price -->
                                <div class="flex items-center justify-between p-2 bg-purple-50 rounded">
                                    <span class="text-gray-600 text-sm font-medium">Harga:</span>
                                    <span class="text-lg font-bold text-purple-600">{{ $service->formatted_price }}</span>
                                </div>

                                <!-- Duration -->
                                <div class="flex items-center justify-between p-2 bg-blue-50 rounded">
                                    <span class="text-gray-600 text-sm font-medium">Durasi:</span>
                                    <span class="text-sm text-blue-600 font-medium">{{ $service->formatted_duration }}</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <a href="{{ route('services.show', $service) }}"
                                   class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 text-center font-medium text-sm">
                                    Detail
                                </a>
                                @auth
                                    <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}"
                                       class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-center font-medium text-sm">
                                        Booking
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="flex-1 px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-colors duration-200 text-center font-medium text-sm">
                                        Login
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
