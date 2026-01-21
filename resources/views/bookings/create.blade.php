@extends('layouts.app')

@section('title', 'Form Booking - Dsisi Salon')

@if($service)
@push('meta')
<meta name="pre-selected-service" content="{{ $service->id }}">
@endpush
@endif

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
                        <label class="block text-gray-700 font-semibold mb-2">
                            Pilih Layanan <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-500 mb-4">(Anda bisa memilih beberapa layanan sekaligus, maksimal 3 layanan dalam 1 hari)</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($services as $svc)
                                <div class="service-card border-2 border-gray-200 rounded-lg p-4 hover:border-purple-300 transition-colors cursor-pointer">
                                    <label class="flex items-start cursor-pointer">
                                        <input type="checkbox"
                                               name="service_ids[]"
                                               value="{{ $svc->id }}"
                                               class="service-checkbox mt-1 mr-3 h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                                               onchange="updateSelectedServices()"
                                               {{ $service && $service->id === $svc->id ? 'checked' : '' }}>
                                        <div class="flex-1">
                                            <div class="font-semibold text-gray-800">{{ $svc->name }}</div>
                                            <div class="text-sm text-gray-600 mb-2">{{ $svc->description ?? 'Layanan berkualitas tinggi' }}</div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-lg font-bold text-purple-600">{{ $svc->formatted_price }}</span>
                                                <span class="text-sm text-gray-500">{{ $svc->formatted_duration }}</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Selected Services Summary -->
                        <div id="selected-summary" class="mt-4 p-4 bg-purple-50 rounded-lg border hidden">
                            <h4 class="font-semibold text-purple-800 mb-2">Layanan yang Dipilih:</h4>
                            <div id="selected-list" class="space-y-1"></div>
                            <div class="mt-3 pt-3 border-t border-purple-200">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-purple-800">Total Harga:</span>
                                    <span id="total-price" class="text-xl font-bold text-purple-600">Rp 0</span>
                                </div>
                                <div class="text-sm text-purple-600 mt-1">
                                    DP (50%): <span id="dp-amount" class="font-semibold">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        @error('service_ids')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
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
                            <li>Jam operasional: 09:00 - 20:00</li>
                            <li>Setelah booking, lakukan pembayaran DP terlebih dahulu</li>
                            <li>Booking akan dikonfirmasi admin setelah pembayaran DP diterima (maksimal 1x24 jam)</li>
                            <li>Harap datang 10 menit sebelum waktu booking</li>
                            <li>Pembatalan booking hanya bisa dilakukan sebelum dikonfirmasi</li>
                            <li>Anda hanya dapat melakukan maksimal 3 booking per hari</li>
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

<!-- JavaScript Data -->
<script type="application/json" id="services-data">
@php
$servicesArray = [];
foreach($services as $svc) {
    $servicesArray[$svc->id] = [
        'name' => $svc->name,
        'price' => $svc->price,
        'priceFormatted' => $svc->formatted_price,
        'duration' => $svc->formatted_duration
    ];
}
@endphp
{!! json_encode($servicesArray) !!}
</script>

<script>
// Load data from JSON script
const servicesData = JSON.parse(document.getElementById('services-data').textContent);

function updateSelectedServices() {
    const checkboxes = document.querySelectorAll('.service-checkbox:checked');
    const summaryDiv = document.getElementById('selected-summary');
    const listDiv = document.getElementById('selected-list');
    const totalPriceSpan = document.getElementById('total-price');
    const dpAmountSpan = document.getElementById('dp-amount');

    // Update service cards visual feedback
    document.querySelectorAll('.service-card').forEach(card => {
        const checkbox = card.querySelector('.service-checkbox');
        if (checkbox.checked) {
            card.classList.add('border-purple-500', 'bg-purple-50');
            card.classList.remove('border-gray-200');
        } else {
            card.classList.remove('border-purple-500', 'bg-purple-50');
            card.classList.add('border-gray-200');
        }
    });

    if (checkboxes.length === 0) {
        summaryDiv.classList.add('hidden');
        return;
    }

    // Show summary
    summaryDiv.classList.remove('hidden');

    // Build selected services list
    let totalPrice = 0;
    let servicesHtml = '';

    checkboxes.forEach(checkbox => {
        const serviceId = checkbox.value;
        const service = servicesData[serviceId];

        if (service) {
            totalPrice += service.price;
            servicesHtml += `
                <div class="flex justify-between text-sm">
                    <span>${service.name}</span>
                    <span class="font-semibold">${service.priceFormatted}</span>
                </div>
            `;
        }
    });

    // Update display
    listDiv.innerHTML = servicesHtml;
    totalPriceSpan.textContent = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(totalPrice);

    const dpAmount = totalPrice / 2;
    dpAmountSpan.textContent = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(dpAmount);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check for pre-selected service from server
    const preSelectedServiceId = document.querySelector('meta[name="pre-selected-service"]')?.getAttribute('content');
    if (preSelectedServiceId) {
        const preSelectedCheckbox = document.querySelector('input[value="' + preSelectedServiceId + '"]');
        if (preSelectedCheckbox) {
            preSelectedCheckbox.checked = true;
            updateSelectedServices();
        }
    }
});
</script>
@endsection
