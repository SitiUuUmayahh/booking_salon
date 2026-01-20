<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Service;
use App\Models\Booking;

echo "=== TEST SLOT AVAILABILITY ===\n\n";

// Ambil service pertama
$service = Service::first();

if ($service) {
    echo "Service: {$service->name}\n";
    echo "Max Bookings: {$service->max_bookings}\n";
    echo "Duration: {$service->duration} menit\n\n";
    
    // Ambil booking pertama untuk service ini
    $booking = Booking::where('service_id', $service->id)
        ->whereIn('status', ['pending', 'confirmed'])
        ->first();
    
    if ($booking) {
        echo "Booking ID: {$booking->id}\n";
        echo "Tanggal: {$booking->booking_date->format('Y-m-d')}\n";
        echo "Waktu: " . \Carbon\Carbon::parse($booking->booking_time)->format('H:i') . "\n\n";
        
        // Test method getAvailableSlots
        $slotInfo = $service->getAvailableSlots(
            $booking->booking_date->format('Y-m-d'),
            \Carbon\Carbon::parse($booking->booking_time)->format('H:i')
        );
        
        echo "=== SLOT INFO ===\n";
        echo "Total Slots: {$slotInfo['total']}\n";
        echo "Booked: {$slotInfo['booked']}\n";
        echo "Available: {$slotInfo['available']}\n";
        echo "Is Full: " . ($slotInfo['is_full'] ? 'Ya' : 'Tidak') . "\n";
    } else {
        echo "Tidak ada booking aktif untuk service ini.\n";
        echo "Silakan buat booking terlebih dahulu.\n";
    }
} else {
    echo "Tidak ada service di database.\n";
    echo "Jalankan seeder: php artisan db:seed\n";
}

echo "\n=== SELESAI ===\n";
