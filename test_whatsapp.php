<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test nomor dari config
$adminNumber = config('services.whatsapp.admin_number');
echo "Nomor dari .env: " . $adminNumber . "\n";

// Test format number
use App\Services\WhatsAppService;

$formatted = WhatsAppService::formatNumber($adminNumber);
echo "Setelah format: " . $formatted . "\n";

// Test generate link
$booking = App\Models\Booking::first();
if ($booking) {
    $link = $booking->whatsapp_customer_link;
    echo "Link generated: " . $link . "\n";
}
