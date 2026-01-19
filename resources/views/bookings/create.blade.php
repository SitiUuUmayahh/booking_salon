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
                               value="{{ old('booking_date') }}"
                               onchange="checkAvailability()">
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                onchange="checkAvailability()">
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
                        
                        <!-- Slot Availability Display -->
                        <div id="slotAvailability" class="hidden mt-3 p-4 rounded-lg border-2">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-700">Status Slot:</p>
                                    <p id="slotMessage" class="text-sm mt-1"></p>
                                </div>
                                <div class="text-right ml-4">
                                    <p id="slotCount" class="text-3xl font-bold"></p>
                                    <p class="text-xs text-gray-500">slot tersisa</p>
                                </div>
                            </div>
                            <!-- Pesan untuk slot penuh -->
                            <div id="slotFullAlert" class="hidden mt-3 p-3 bg-red-100 border border-red-300 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-red-800">Slot waktu ini sudah penuh!</p>
                                        <p class="text-xs text-red-700 mt-1">Silakan pilih waktu atau tanggal lain yang masih tersedia.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Pesan untuk slot hampir penuh -->
                            <div id="slotWarningAlert" class="hidden mt-3 p-3 bg-yellow-100 border border-yellow-300 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-yellow-800">Slot hampir penuh!</p>
                                        <p class="text-xs text-yellow-700 mt-1">Segera booking sebelum slot habis.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
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
        
        // Cek availability jika tanggal dan waktu sudah dipilih
        checkAvailability();
    } else {
        infoBox.classList.add('hidden');
        hideSlotAvailability();
    }
}

// Fungsi untuk cek slot availability via AJAX
async function checkAvailability() {
    const serviceId = document.getElementById('service_id').value;
    const bookingDate = document.getElementById('booking_date').value;
    const bookingTime = document.getElementById('booking_time').value;
    
    // Reset display jika data belum lengkap
    if (!serviceId || !bookingDate || !bookingTime) {
        hideSlotAvailability();
        return;
    }
    
    try {
        const response = await fetch('{{ route("api.bookings.check-availability") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                service_id: serviceId,
                booking_date: bookingDate,
                booking_time: bookingTime
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            showSlotAvailability(result.data);
        }
    } catch (error) {
        console.error('Error checking availability:', error);
    }
}

function showSlotAvailability(slotInfo) {
    const slotBox = document.getElementById('slotAvailability');
    const slotCount = document.getElementById('slotCount');
    const slotMessage = document.getElementById('slotMessage');
    const fullAlert = document.getElementById('slotFullAlert');
    const warningAlert = document.getElementById('slotWarningAlert');
    const submitButton = document.querySelector('button[type="submit"]');
    
    slotCount.textContent = slotInfo.available;
    slotMessage.textContent = `${slotInfo.booked} dari ${slotInfo.total} slot terisi`;
    
    // Reset classes
    slotBox.classList.remove('hidden', 'border-green-500', 'bg-green-50', 'border-yellow-500', 'bg-yellow-50', 'border-red-500', 'bg-red-50');
    slotCount.classList.remove('text-green-600', 'text-yellow-600', 'text-red-600');
    slotMessage.classList.remove('text-green-700', 'text-yellow-700', 'text-red-700');
    fullAlert.classList.add('hidden');
    warningAlert.classList.add('hidden');
    
    if (slotInfo.is_full) {
        // Slot penuh - merah dan disable submit
        slotBox.classList.add('border-red-500', 'bg-red-50');
        slotCount.classList.add('text-red-600');
        slotMessage.classList.add('text-red-700');
        fullAlert.classList.remove('hidden');
        submitButton.disabled = true;
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        submitButton.title = 'Slot penuh, pilih waktu lain';
    } else {
        // Enable submit button
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        submitButton.title = '';
        
        if (slotInfo.available <= 2) {
            // Hampir penuh - kuning
            slotBox.classList.add('border-yellow-500', 'bg-yellow-50');
            slotCount.classList.add('text-yellow-600');
            slotMessage.classList.add('text-yellow-700');
            warningAlert.classList.remove('hidden');
        } else {
            // Tersedia - hijau
            slotBox.classList.add('border-green-500', 'bg-green-50');
            slotCount.classList.add('text-green-600');
            slotMessage.classList.add('text-green-700');
        }
    }
}

function hideSlotAvailability() {
    const slotBox = document.getElementById('slotAvailability');
    const submitButton = document.querySelector('button[type="submit"]');
    slotBox.classList.add('hidden');
    
    // Re-enable submit button
    submitButton.disabled = false;
    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
    submitButton.title = '';
}

// Initialize on page load if service was selected
document.addEventListener('DOMContentLoaded', function() {
    @if($service)
        updateServiceInfo();
    @endif
});
</script>
@endsection
