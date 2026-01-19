@extends('layouts.admin')

@section('title', 'Customer Detail - Admin')
@section('header', $customer->name ?? 'Customer Detail')

@section('content')
<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('admin.customers') }}" class="inline-flex items-center px-4 py-2 text-pink-600 hover:text-pink-700 font-bold rounded-lg transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Customers
    </a>
</div>

<!-- Customer Info Card -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center mb-6">
        <div class="w-16 h-16 rounded-full bg-gradient-to-r from-pink-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
            {{ $customer && $customer->name ? substr($customer->name, 0, 1) : '?' }}
        </div>
        <div class="ml-6">
            <h2 class="text-2xl font-bold text-gray-900">{{ $customer->name ?? 'Nama tidak tersedia' }}</h2>
            <p class="text-gray-600 flex items-center mt-1">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                {{ $customer->email ?? 'Email tidak tersedia' }}
            </p>
            <p class="text-gray-600 flex items-center mt-1">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                {{ $customer->phone ?? 'Telepon tidak tersedia' }}
            </p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Total Booking</p>
                    <p class="text-3xl font-bold text-blue-700">{{ $customer_stats['total_bookings'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Completed</p>
                    <p class="text-3xl font-bold text-green-700">{{ $customer_stats['completed_bookings'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-lg p-6 border border-red-200">
            <div class="flex items-center">
                <div class="p-2 bg-red-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-red-600">Cancelled</p>
                    <p class="text-3xl font-bold text-red-700">{{ $customer_stats['cancelled_bookings'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
            <div class="flex items-center">
                <div class="p-2 bg-purple-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-purple-600">Total Spent</p>
                    <p class="text-3xl font-bold text-purple-700">Rp {{ number_format($customer_stats['total_spent'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking History Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Riwayat Booking</h3>
    </div>
    
    <div class="overflow-x-auto">
        @if($bookings && $bookings->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $booking->service->name ?? 'Service tidak ditemukan' }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->service->description ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->booking_time }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($booking->status == 'pending')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Confirmed</span>
                                @elseif($booking->status == 'completed')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                @elseif($booking->status == 'cancelled')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->created_at ? $booking->created_at->format('d M Y H:i') : 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Pagination -->
            @if($bookings->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $bookings->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada booking</h3>
                <p class="mt-1 text-sm text-gray-500">Customer ini belum melakukan booking apapun.</p>
            </div>
        @endif
    </div>
</div>
@endsection