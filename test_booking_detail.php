<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Booking;
use Carbon\Carbon;

echo "=== DEBUG BOOKING DETAIL ===\n\n";

// Ambil booking pertama
$booking = Booking::with('service')->first();

if ($booking) {
    echo "Booking ID: {$booking->id}\n";
    echo "Customer: {$booking->customer_name}\n";
    echo "Service: {$booking->service->name}\n";
    echo "Max Bookings: {$booking->service->max_bookings}\n\n";
    
    echo "=== TANGGAL & WAKTU ===\n";
    echo "booking_date type: " . gettype($booking->booking_date) . "\n";
    echo "booking_date value: {$booking->booking_date}\n";
    echo "booking_date formatted: " . $booking->booking_date->format('Y-m-d') . "\n\n";
    
    echo "booking_time type: " . gettype($booking->booking_time) . "\n";
    echo "booking_time value: {$booking->booking_time}\n";
    $bookingTime = Carbon::parse($booking->booking_time)->format('H:i');
    echo "booking_time formatted: {$bookingTime}\n\n";
    
    // Test getAvailableSlots
    echo "=== TESTING getAvailableSlots ===\n";
    $slotInfo = $booking->service->getAvailableSlots(
        $booking->booking_date->format('Y-m-d'),
        $bookingTime
    );
    
    echo "Hasil:\n";
    print_r($slotInfo);
    
    echo "\nDapat di-pass ke view? ";
    echo isset($slotInfo['available']) ? "✓ YA\n" : "✗ TIDAK\n";
    
} else {
    echo "Tidak ada booking di database!\n";
}
