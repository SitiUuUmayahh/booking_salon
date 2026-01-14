@extends('layouts.admin')

@section('title', 'Services - Admin')
@section('page-title', 'Services')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($services as $service)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            <!-- Service Icon -->
            <div class="h-40 bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center">
                <span class="text-white text-6xl">💇</span>
            </div>

            <!-- Service Details -->
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $service->name }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $service->description }}</p>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-xs text-gray-500">Harga</p>
                        <p class="text-lg font-bold text-pink-600">{{ $service->formatted_price }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Durasi</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $service->formatted_duration }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="text-sm text-gray-600">
                        <strong>{{ $service->bookings_count }}</strong> bookings
                    </span>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection