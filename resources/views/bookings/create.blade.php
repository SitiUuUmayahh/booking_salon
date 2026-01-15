@extends('layouts.app')

@section('title', 'Form Booking - Dsisi Salon')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-8">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Dashboard
        </a>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-pink-500 to-purple-600 text-white p-8">
                <h1 class="text-3xl font-bold">Buat Booking Baru</h1>
                <p class="text-pink-100 mt-2">Lengkapi form di bawah untuk booking layanan</p>
            </div>

            <!-- Form Body -->
            <div class="p-8">
                <form method="POST" action="{{ route('bookings.store') }}" class="space-y-6">
                    @csrf

                    <!-- Service Selection -->
                    <div>
                        <label for="service_id" class="block text-gray-700 font-semibold mb-2">
                            Pilih Layanan <span class="text-red-500">*</span>
                        </label>
                        <select name="service_id" id="service_id" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                onchange="updateServiceInfo()">
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($services as $svc)
                                <option value="{{ $svc->id }}" {{ $service && $service->id === $svc->id ? 'selected' : '' }}>
                                    {{ $svc->name }} ({{ $svc->formatted_price }}) - {{ $svc->formatted_duration }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Service Info Display -->
                    <div id="serviceInfo" class="hidden bg-gradient-to-r from-purple-50 to-blue-50 p-6 rounded-lg border border-purple-200">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600 text-sm">Harga:</p>
                                <p id="servicePrice" class="text-2xl font-bold text-purple-600"></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Durasi:</p>
                                <p id="serviceDuration" class="text-2xl font-bold text-blue-600"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Name -->
                    <div>
                        <label for="customer_name" class="block text-gray-700 font-semibold mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="customer_name" id="customer_name" 
                               value="{{ Auth::user()->name }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                               placeholder="Masukkan nama Anda">
                        @error('customer_name')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Booking Date -->
                    <div>
                        <label for="booking_date" class="block text-gray-700 font-semibold mb-2">
                            Tanggal Booking <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="booking_date" id="booking_date" 
                               min="{{ date('Y-m-d') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                               value="{{ old('booking_date') }}">
                        <p class="text-gray-500 text-sm mt-1">📅 Minimal 1 hari dari hari ini</p>
                        @error('booking_date')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Booking Time -->
                    <div>
                        <label for="booking_time" class="block text-gray-700 font-semibold mb-2">
                            Jam Booking <span class="text-red-500">*</span>
                        </label>
                        <select name="booking_time" id="booking_time" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                            <option value="">-- Pilih Jam --</option>
                            <option value="09:00" {{ old('booking_time') === '09:00' ? 'selected' : '' }}>09:00</option>
                            <option value="10:00" {{ old('booking_time') === '10:00' ? 'selected' : '' }}>10:00</option>
                            <option value="11:00" {{ old('booking_time') === '11:00' ? 'selected' : '' }}>11:00</option>
                            <option value="12:00" {{ old('booking_time') === '12:00' ? 'selected' : '' }}>12:00</option>
                            <option value="13:00" {{ old('booking_time') === '13:00' ? 'selected' : '' }}>13:00</option>
                            <option value="14:00" {{ old('booking_time') === '14:00' ? 'selected' : '' }}>14:00</option>
                            <option value="15:00" {{ old('booking_time') === '15:00' ? 'selected' : '' }}>15:00</option>
                            <option value="16:00" {{ old('booking_time') === '16:00' ? 'selected' : '' }}>16:00</option>
                            <option value="17:00" {{ old('booking_time') === '17:00' ? 'selected' : '' }}>17:00</option>
                            <option value="18:00" {{ old('booking_time') === '18:00' ? 'selected' : '' }}>18:00</option>
                            <option value="19:00" {{ old('booking_time') === '19:00' ? 'selected' : '' }}>19:00</option>
                            <option value="20:00" {{ old('booking_time') === '20:00' ? 'selected' : '' }}>20:00</option>
                        </select>
                        <p class="text-gray-500 text-sm mt-1">⏰ Jam operasional: 09:00 - 20:00</p>
                        @error('booking_time')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-gray-700 font-semibold mb-2">
                            Catatan Khusus (Opsional)
                        </label>
                        <textarea name="notes" id="notes" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                  placeholder="Contoh: Saya memiliki rambut panjang, ingin style modern, dll...">{{ old('notes') }}</textarea>
                        <p class="text-gray-500 text-sm mt-1">Maksimal 500 karakter</p>
                        @error('notes')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <p class="text-blue-800 text-sm">
                            <strong>ⓘ Informasi Penting:</strong>
                        </p>
                        <ul class="text-blue-700 text-sm mt-2 space-y-1 list-disc list-inside">
                            <li>Booking akan dikonfirmasi admin maksimal 1x24 jam</li>
                            <li>Harap datang 10 menit sebelum waktu booking</li>
                            <li>Pembatalan hanya bisa dilakukan sebelum dikonfirmasi</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-6">
                        <a href="{{ route('dashboard') }}" 
                           class="flex-1 px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition-colors duration-200 font-semibold text-center">
                            Batal
                        </a>
                        <button type="submit" 
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-lg transition-all duration-200 font-semibold">
                            Konfirmasi Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Testimonial Section -->
        <div class="mt-12 bg-white rounded-lg shadow-lg p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Apa kata pelanggan kami?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="flex justify-center mb-4">
                        <span class="text-yellow-400">★★★★★</span>
                    </div>
                    <p class="text-gray-600 italic">"Pelayanan sangat memuaskan dan tepat waktu!"</p>
                    <p class="text-gray-700 font-semibold mt-2">Siti Nurhaliza</p>
                </div>
                <div class="text-center">
                    <div class="flex justify-center mb-4">
                        <span class="text-yellow-400">★★★★★</span>
                    </div>
                    <p class="text-gray-600 italic">"Hasil styling sempurna, puas banget!"</p>
                    <p class="text-gray-700 font-semibold mt-2">Dian Sastro</p>
                </div>
                <div class="text-center">
                    <div class="flex justify-center mb-4">
                        <span class="text-yellow-400">★★★★★</span>
                    </div>
                    <p class="text-gray-600 italic">"Harganya terjangkau dan hasilnya premium!"</p>
                    <p class="text-gray-700 font-semibold mt-2">Ayu Sekar</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Data service dari database
const servicesData = {
    @foreach($services as $svc)
        '{{ $svc->id }}': {
            name: '{{ $svc->name }}',
            price: '{{ $svc->formatted_price }}',
            duration: '{{ $svc->formatted_duration }}'
        },
    @endforeach
};

function updateServiceInfo() {
    const serviceId = document.getElementById('service_id').value;
    const infoBox = document.getElementById('serviceInfo');
    
    if (serviceId && servicesData[serviceId]) {
        const service = servicesData[serviceId];
        document.getElementById('servicePrice').textContent = service.price;
        document.getElementById('serviceDuration').textContent = service.duration;
        infoBox.classList.remove('hidden');
    } else {
        infoBox.classList.add('hidden');
    }
}

// Initialize on page load if service was selected
document.addEventListener('DOMContentLoaded', function() {
    @if($service)
        updateServiceInfo();
    @endif
});
</script>
@endsection
