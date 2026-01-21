<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class FixGroupDpDistribution extends Command
{
    protected $signature = 'bookings:fix-group-dp';
    protected $description = 'Fix group booking DP amounts - only first booking should have full DP, others should be 0';

    public function handle()
    {
        // Ambil semua group bookings
        $groupBookings = Booking::whereNotNull('booking_group_id')
            ->orderBy('booking_group_id')
            ->orderBy('created_at')
            ->get()
            ->groupBy('booking_group_id');

        $this->info("Processing " . $groupBookings->count() . " booking group(s)...\n");

        foreach ($groupBookings as $groupId => $bookings) {
            $firstBooking = $bookings->first();
            $totalPrice = $firstBooking->total_group_price;
            $correctDp = $totalPrice * 0.5;

            // Set DP untuk booking pertama = 50% dari total group
            $firstBooking->update(['dp_amount' => $correctDp]);
            
            // Set DP untuk booking lainnya = 0 (karena sudah terhitung di first booking)
            foreach ($bookings->skip(1) as $booking) {
                $booking->update(['dp_amount' => 0]);
            }

            $this->info("✅ Group ID: {$groupId}");
            $this->info("   - Total Price: Rp " . number_format($totalPrice, 0, ',', '.'));
            $this->info("   - First Booking DP (50%): Rp " . number_format($correctDp, 0, ',', '.'));
            $this->info("   - Other Bookings DP: Rp 0");
            $this->info("   - Total in Group: {$bookings->count()} bookings\n");
        }

        $this->info("✅ All group booking DP distributions have been fixed!");
        return 0;
    }
}
