@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('services.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-8">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Layanan
        </a>

        <!-- Service Card -->
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Service Image -->
                <div>
                    @if($service->image)
                        <div class="h-96 rounded-lg overflow-hidden bg-gray-200">
                            <img src="{{ asset('storage/' . $service->image) }}" 
                                 alt="{{ $service->name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="h-96 bg-gradient-to-br from-purple-400 to-blue-400 rounded-lg flex items-center justify-center">
                            <svg class="h-32 w-32 text-white opacity-30" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Service Details -->
                <div class="flex flex-col justify-between">
                    <!-- Header -->
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $service->name }}</h1>
                        
                        <!-- Description -->
                        <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                            {{ $service->description }}
                        </p>

                        <!-- Info Section -->
                        <div class="space-y-4">
                            <!-- Price -->
                            <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-lg">
                                <p class="text-gray-600 text-sm font-medium mb-1">Harga Layanan</p>
                                <p class="text-4xl font-bold text-purple-600">{{ $service->formatted_price }}</p>
                            </div>

                            <!-- Duration -->
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg">
                                <p class="text-gray-600 text-sm font-medium mb-1">Durasi Layanan</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $service->formatted_duration }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 mt-8">
                        @auth
                            <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}" 
                               class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-200 font-semibold text-center">
                                Pesan Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-200 font-semibold text-center">
                                Login untuk Pesan
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Services -->
        @if($relatedServices->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Layanan Lainnya</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedServices as $relatedService)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
                            @if($relatedService->image)
                                <div class="h-48 overflow-hidden bg-gray-200">
                                    <img src="{{ asset('storage/' . $relatedService->image) }}" 
                                         alt="{{ $relatedService->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </div>
                            @else
                                <div class="h-48 bg-gradient-to-br from-purple-400 to-blue-400 flex items-center justify-center">
                                    <svg class="h-16 w-16 text-white opacity-30" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 mb-2">{{ $relatedService->name }}</h3>
                                <p class="text-purple-600 font-semibold">{{ $relatedService->formatted_price }}</p>
                                <a href="{{ route('services.show', $relatedService) }}" 
                                   class="mt-4 block text-center px-4 py-2 bg-purple-100 text-purple-600 rounded hover:bg-purple-200 transition-colors duration-200 font-medium text-sm">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
