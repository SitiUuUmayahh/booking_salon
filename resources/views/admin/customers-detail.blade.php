@extends('layouts.admin')

@section('title', 'Customer Detail - Admin')
@section('page-title', 'Customer Detail')

@section('content')
<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('admin.customers') }}" class="text-pink-600 hover:text-pink-700 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>
</div>

<!-- Customer Info -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center mb-6">
        <div class="w-20 h-20 rounded-full bg-pink-600 flex items-center justify-center text-white text-3xl font-bold">
            {{ substr($customer->name, 0, 1) }}
        </div>
        <div class="ml-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ $customer->name }}</h2>
            <p class="text-gray-600">{{ $customer->email }}</p>
            <p class="text-gray-600">{{ $customer->phone }}</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-blue-50 rounded-lg p-4">
            <p class="text-sm text-gray-600">Total Booking</p>
            <p class="text-2xl font-bold text-blue-600">{{ $customer_stats['total_bookings'] }}</p>
        </div>
        <div class="bg-green-50 rounded-lg p-4">
            <p class="text-sm text-gray-600">Completed</p>
            <p class="text-2xl font-bold text-green-600">{{ $customer_stats['completed_bookings'] }}</p>
        </div>
        <div class="bg-red-50 rounded-lg p-4">
            <p class="text-sm text-gray-600">Cancelled</p>
            <p class="text-2xl font-bold text-red-600">{{ $customer_stats['cancelled_bookings'] }}</p>
        </div>
        <div class="bg-purple-50 rounded-lg p-4">
            <p class="text-sm text-gray-600">Total Spent</p>
            <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($customer_stats['total_spent'], 0, ',', '.') }}</p>
        </div>
    </div>
</div>

<!-- Booking History -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-6">Riwayat Booking</h3>
    
    <div class="space-y-4">
        @forelse($bookings as $booking)
            <div class="border border-gray-200 rounded-lg p-4 hover:border-pink-300 transition">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $booking->service->name }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->formatted_date }} - {{ $booking->formatted_time }}</p>
                    </div>
                    {!! $booking->status_badge !!}
                </div>
                <div class="flex justify-between items-center mt-3">
                    <p class="text-sm font-semibold text-pink-600">{{ $booking->service->formatted_price }}</p>
                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-sm text-pink-600 hover:text-pink-700">
                        Detail →
                    </a>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-8">Belum ada booking</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</div>
@endsection