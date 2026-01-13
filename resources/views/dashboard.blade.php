@extends('layouts.app')

@section('title', 'Dashboard - Dsisi Salon')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg shadow-xl p-8 mb-8 text-white">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-pink-100">Pilih layanan yang Anda inginkan dan buat booking sekarang!</p>
        </div>

        <!-- Services Grid -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Layanan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($services as $service)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                        <!-- Service Image Placeholder -->
                        <div class="h-48 bg-gradient-to-br from-pink-400 to-purple-500 rounded-t-lg flex items-center justify-center">
                            <span class="text-white text-6xl">💇</span>
                        </div>

                        <!-- Service Details -->
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $service->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $service->description }}</p>
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-2xl font-bold text-pink-600">{{ $service->formatted_price }}</span>
                                <span class="text-sm text-gray-500">⏱️ {{ $service->formatted_duration }}</span>
                            </div>

                            <button onclick="openBookingModal({{ $service->id }}, '{{ $service->name }}')" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                                Booking Sekarang
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Booking Info -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-blue-800">Informasi Booking</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Jam operasional: 09:00 - 20:00</li>
                            <li>Booking akan dikonfirmasi oleh admin maksimal 1x24 jam</li>
                            <li>Harap datang 10 menit sebelum waktu booking</li>
                            <li>Pembatalan booking hanya bisa dilakukan sebelum dikonfirmasi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-2xl max-w-md w-full mx-4">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-pink-500 to-purple-600 text-white p-6 rounded-t-lg">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold">Buat Booking</h3>
                <button onclick="closeBookingModal()" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <form method="POST" action="{{ route('bookings.store') }}" class="p-6">
            @csrf

            <!-- Service (Hidden) -->
            <input type="hidden" name="service_id" id="modal_service_id">

            <!-- Service Name Display -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Layanan</label>
                <p id="modal_service_name" class="text-xl font-bold text-pink-600"></p>
            </div>

            <!-- Customer Name -->
            <div class="mb-4">
                <label for="customer_name" class="block text-gray-700 font-semibold mb-2">
                    Nama Pelanggan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="customer_name" id="customer_name" value="{{ Auth::user()->name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
            </div>

            <!-- Booking Date -->
            <div class="mb-4">
                <label for="booking_date" class="block text-gray-700 font-semibold mb-2">
                    Tanggal <span class="text-red-500">*</span>
                </label>
                <input type="date" name="booking_date" id="booking_date" min="{{ date('Y-m-d') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
            </div>

            <!-- Booking Time -->
            <div class="mb-4">
                <label for="booking_time" class="block text-gray-700 font-semibold mb-2">
                    Jam <span class="text-red-500">*</span>
                </label>
                <select name="booking_time" id="booking_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="">Pilih Jam</option>
                    <option value="09:00">09:00</option>
                    <option value="10:00">10:00</option>
                    <option value="11:00">11:00</option>
                    <option value="12:00">12:00</option>
                    <option value="13:00">13:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="16:00">16:00</option>
                    <option value="17:00">17:00</option>
                    <option value="18:00">18:00</option>
                    <option value="19:00">19:00</option>
                    <option value="20:00">20:00</option>
                </select>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-gray-700 font-semibold mb-2">
                    Catatan (Opsional)
                </label>
                <textarea name="notes" id="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Tambahkan catatan khusus..."></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex space-x-3">
                <button type="button" onclick="closeBookingModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-4 rounded-lg transition duration-200">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                    Konfirmasi Booking
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openBookingModal(serviceId, serviceName) {
    document.getElementById('modal_service_id').value = serviceId;
    document.getElementById('modal_service_name').textContent = serviceName;
    document.getElementById('bookingModal').classList.remove('hidden');
}

function closeBookingModal() {
    document.getElementById('bookingModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('bookingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBookingModal();
    }
});
</script>
@endsection