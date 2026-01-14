@section('title', 'Detail Booking - Admin')
@section('page-title', 'Detail Booking #' . $booking->id)

@section('content')
<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('admin.bookings.index') }}" class="text-pink-600 hover:text-pink-700 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Service Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Layanan</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Layanan</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $booking->service->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Deskripsi</p>
                    <p class="text-gray-800">{{ $booking->service->description }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Harga</p>
                        <p class="text-lg font-semibold text-pink-600">{{ $booking->service->formatted_price }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Durasi</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $booking->service->formatted_duration }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Pelanggan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Nama</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $booking->customer_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $booking->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">No. Telepon</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $booking->user->phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Terdaftar Sejak</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $booking->user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($booking->notes)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Catatan Customer</h3>
                <p class="text-gray-800">{{ $booking->notes }}</p>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status & Schedule -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Status & Jadwal</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600 mb-2">Status</p>
                    {!! $booking->status_badge !!}
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tanggal</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $booking->formatted_date }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Jam</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $booking->formatted_time }}</p>
                </div>
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500">Dibuat: {{ $booking->created_at->format('d M Y H:i') }}</p>
                    <p class="text-xs text-gray-500">Update: {{ $booking->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Actions</h3>
            <div class="space-y-3">
                @if($booking->status === 'pending')
                    <form method="POST" action="{{ route('admin.bookings.confirm', $booking->id) }}">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                            ✓ Konfirmasi Booking
                        </button>
                    </form>
                @endif

                @if($booking->status === 'confirmed')
                    <form method="POST" action="{{ route('admin.bookings.complete', $booking->id) }}">
                        @csrf
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                            ✓ Tandai Selesai
                        </button>
                    </form>
                @endif

                @if($booking->status !== 'completed')
                    <form method="POST" action="{{ route('admin.bookings.cancel', $booking->id) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Yakin ingin batalkan booking ini?')" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                            ✕ Batalkan Booking
                        </button>
                    </form>
                @endif

                @if($booking->status === 'cancelled')
                    <form method="POST" action="{{ route('admin.bookings.destroy', $booking->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin hapus booking ini?')" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                            🗑️ Hapus Booking
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection