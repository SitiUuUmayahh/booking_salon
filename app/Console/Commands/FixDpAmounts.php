<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class FixDpAmounts extends Command
{
    protected $signature = 'bookings:fix-dp-amounts {--booking-id= : Fix specific booking ID, or leave empty to fix all}';
    protected $description = 'Fix DP amounts to be exactly 50% of total price (handles both single and group bookings)';

    public function handle()
    {
        $bookingId = $this->option('booking-id');

        $query = Booking::query();
        
        if ($bookingId) {
            $query->where('id', $bookingId);
        }

        $bookings = $query->get();

        if ($bookings->isEmpty()) {
            $this->warn('No bookings found');
            return 1;
        }

        $this->info("Processing " . $bookings->count() . " booking(s)...\n");

        foreach ($bookings as $booking) {
            // Calculate correct DP amount
            if ($booking->isGroupBooking()) {
                // For group booking: 50% of total group price
                $totalPrice = $booking->total_group_price;
                $correctDp = $totalPrice * 0.5;

                // Update all bookings in this group with the same DP amount
                Booking::where('booking_group_id', $booking->booking_group_id)
                    ->update(['dp_amount' => $correctDp]);

                $this->info("✅ Group Booking ID: {$booking->id}");
                $this->info("   - Total Group Price: Rp " . number_format($totalPrice, 0, ',', '.'));
                $this->info("   - Correct DP (50%): Rp " . number_format($correctDp, 0, ',', '.'));
                $this->info("   - Updated all {$booking->groupedBookings()->count()} bookings in group");
            } else {
                // For single booking: 50% of service price
                $totalPrice = $booking->service->price ?? 0;
                $correctDp = $totalPrice * 0.5;

                $booking->update(['dp_amount' => $correctDp]);

                $this->info("✅ Single Booking ID: {$booking->id}");
                $this->info("   - Service Price: Rp " . number_format($totalPrice, 0, ',', '.'));
                $this->info("   - Correct DP (50%): Rp " . number_format($correctDp, 0, ',', '.'));
            }

            $this->info("");
        }

        $this->info("✅ All DP amounts have been fixed!");
        return 0;
    }
}
