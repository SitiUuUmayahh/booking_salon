@extends('layouts.admin')

@section('title', 'Manage Bookings - Admin')
@section('page-title', 'Manage Bookings')

@section('content')
<!-- Filter Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Status Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
                <option value="all">Semua ({{ $stats['all'] }})</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending ({{ $stats['pending'] }})</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed ({{ $stats['confirmed'] }})</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed ({{ $stats['completed'] }})</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled ({{ $stats['cancelled'] }})</option>
            </select>
        </div>

        <!-- Date Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
        </div>

        <!-- Search -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama customer/service..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
        </div>

        <!-- Submit Button -->
        <div class="flex items-end">
            <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                Filter
            </button>
        </div>
    </form>
</div>

<!-- Bookings Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Jam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $booking->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $booking->customer_name }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $booking->service->name }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->service->formatted_price }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $booking->formatted_date }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->formatted_time }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {!! $booking->status_badge !!}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <!-- Detail Button -->
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-900">
                                Detail
                            </a>

                            <!-- Confirm Button (jika pending) -->
                            @if($booking->status === 'pending')
                                <form method="POST" action="{{ route('admin.bookings.confirm', $booking->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900">
                                        Konfirmasi
                                    </button>
                                </form>
                            @endif

                            <!-- Complete Button (jika confirmed) -->
                            @if($booking->status === 'confirmed')
                                <form method="POST" action="{{ route('admin.bookings.complete', $booking->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-purple-600 hover:text-purple-900">
                                        Selesai
                                    </button>
                                </form>
                            @endif

                            <!-- Cancel Button -->
                            @if($booking->status !== 'completed')
                                <form method="POST" action="{{ route('admin.bookings.cancel', $booking->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Yakin ingin batalkan?')" class="text-red-600 hover:text-red-900">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada data booking
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $bookings->links() }}
    </div>
</div>
@endsection