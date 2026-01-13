@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Sidebar -->
    <div class="lg:col-span-1">
        @include('components.admin.sidebar')
    </div>

    <!-- Main Content -->
    <div class="lg:col-span-3 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Ringkasan Admin</h1>
            <div class="text-sm text-gray-500">Terakhir diperbarui: {{ now()->format('d M Y H:i') }}</div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <x-stats-card
                title="Total Booking"
                :value="$totalBookings ?? 0"
                subtitle="Semua status"
                :changeUp="isset($bookingChangeUp) ? $bookingChangeUp : null"
                :change="isset($bookingChange) ? $bookingChange : null"
                color="pink"
            />
            <x-stats-card
                title="Pending"
                :value="$pendingBookings ?? 0"
                color="indigo"
            />
            <x-stats-card
                title="Terkonfirmasi"
                :value="$confirmedBookings ?? 0"
                color="emerald"
            />
            <x-stats-card
                title="Dibatalkan"
                :value="$cancelledBookings ?? 0"
                color="rose"
            />
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Booking Terbaru</h2>
            </div>
            <div class="p-6 overflow-x-auto">
                @php $items = $recentBookings ?? []; @endphp
                @if(!empty($items) && count($items))
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($items as $booking)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $booking->customer_name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $booking->service->name ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $booking->booking_time }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        @php
                                            $map = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'confirmed' => 'bg-emerald-100 text-emerald-800',
                                                'cancelled' => 'bg-rose-100 text-rose-800',
                                            ];
                                            $cls = $map[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $cls }}">{{ ucfirst($booking->status) }}</span>
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ url('/admin/bookings/'.$booking->id) }}" class="text-pink-600 hover:text-pink-700 font-medium">Detail</a>
                                            @if($booking->status === 'pending')
                                                <form method="POST" action="{{ url('/admin/bookings/'.$booking->id.'/confirm') }}">
                                                    @csrf
                                                    <button type="submit" class="text-emerald-600 hover:text-emerald-700 font-medium">Konfirmasi</button>
                                                </form>
                                                <form method="POST" action="{{ url('/admin/bookings/'.$booking->id.'/cancel') }}">
                                                    @csrf
                                                    <button type="submit" class="text-rose-600 hover:text-rose-700 font-medium">Batalkan</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center text-gray-600">
                        <p>Belum ada booking terbaru.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
