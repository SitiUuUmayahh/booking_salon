@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Ringkasan Admin</h1>
        <div class="text-sm text-gray-500">Terakhir diperbarui: {{ now()->format('d M Y H:i') }}</div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Booking Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-pink-600">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Booking</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalBookings ?? 0 }}</p>
                        <p class="text-gray-500 text-xs mt-1">Semua status</p>
                    </div>
                    <div class="bg-pink-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-600">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pending</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pendingBookings ?? 0 }}</p>
                        <p class="text-gray-500 text-xs mt-1">Menunggu konfirmasi</p>
                    </div>
                    <div class="bg-yellow-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Confirmed Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-600">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Terkonfirmasi</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $confirmedBookings ?? 0 }}</p>
                        <p class="text-gray-500 text-xs mt-1">Sudah dikonfirmasi</p>
                    </div>
                    <div class="bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cancelled Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-600">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Dibatalkan</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $cancelledBookings ?? 0 }}</p>
                        <p class="text-gray-500 text-xs mt-1">Sudah dibatalkan</p>
                    </div>
                    <div class="bg-red-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Terbaru Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Booking Terbaru</h2>
            </div>
            <div class="p-6">
                @if($recentBookings && count($recentBookings) > 0)
                    <div class="space-y-4">
                        @foreach($recentBookings as $booking)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $booking->customer_name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $booking->service->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        📅 {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }} at {{ $booking->booking_time }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'confirmed' => 'bg-green-100 text-green-800',
                                            'completed' => 'bg-blue-100 text-blue-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $classes = $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $classes }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="text-pink-600 hover:text-pink-700 font-medium text-sm">
                                        Detail →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-gray-600 font-medium">Belum ada booking terbaru</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Booking Hari Ini Section -->
        @if($todayBookings && count($todayBookings) > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-900">Jadwal Hari Ini</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @foreach($todayBookings as $booking)
                            <div class="flex items-center justify-between p-3 border border-blue-200 bg-blue-50 rounded-lg">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $booking->booking_time }} - {{ $booking->customer_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->service->name }}</p>
                                </div>
                                <span class="px-3 py-1 bg-blue-600 text-white rounded-full text-xs font-medium">{{ ucfirst($booking->status) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
