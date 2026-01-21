<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\AdminNotification;
use Illuminate\Console\Command;

class UpdateDpNotifications extends Command
{
    protected $signature = 'notifications:update-dp';
    protected $description = 'Automatically update DP verification notifications with correct remaining payment amounts';

    public function handle()
    {
        // Ambil booking terbaru yang DP verified
        $latestBooking = Booking::where('dp_status', 'verified')
            ->latest('dp_verified_at')
            ->first();

        if (!$latestBooking) {
            $this->warn('Tidak ada booking dengan DP verified');
            return 1;
        }

        // Generate message menggunakan attribute yang sudah di-fix
        // remaining_payment property sudah handle group vs single booking dengan benar
        $message = "Pembayaran DP Anda telah diverifikasi pada {$latestBooking->dp_verified_at->format('d M Y H:i')}. Booking Anda sudah terkonfirmasi!\n\n" .
                   "Sisa pembayaran {$latestBooking->remaining_payment} dibayar saat Anda datang ke salon.";

        // Update atau create notifikasi DP verified
        $notification = AdminNotification::where('title', 'like', '%DP Terverifikasi%')
            ->orWhere('title', 'like', '%Pembayaran DP%')
            ->first();

        if ($notification) {
            $notification->update([
                'message' => $message,
                'type' => 'success',
                'is_active' => true,
            ]);
            $this->info("✅ Notifikasi berhasil diupdate");
            $this->info("   - Booking ID: {$latestBooking->id}");
            $this->info("   - Total Harga: Rp " . ($latestBooking->isGroupBooking() ? number_format($latestBooking->total_group_price, 0, ',', '.') : number_format($latestBooking->service->price, 0, ',', '.')));
            $this->info("   - DP (50%): Rp " . ($latestBooking->isGroupBooking() ? number_format($latestBooking->total_group_dp, 0, ',', '.') : number_format($latestBooking->dp_amount, 0, ',', '.')));
            $this->info("   - Sisa Pembayaran: {$latestBooking->remaining_payment}");
        } else {
            AdminNotification::create([
                'title' => '✅ Pembayaran DP Terverifikasi',
                'message' => $message,
                'type' => 'success',
                'is_active' => true,
            ]);
            $this->info("✅ Notifikasi baru dibuat");
            $this->info("   - Booking ID: {$latestBooking->id}");
            $this->info("   - Total Harga: Rp " . ($latestBooking->isGroupBooking() ? number_format($latestBooking->total_group_price, 0, ',', '.') : number_format($latestBooking->service->price, 0, ',', '.')));
            $this->info("   - DP (50%): Rp " . ($latestBooking->isGroupBooking() ? number_format($latestBooking->total_group_dp, 0, ',', '.') : number_format($latestBooking->dp_amount, 0, ',', '.')));
            $this->info("   - Sisa Pembayaran: {$latestBooking->remaining_payment}");
        }

        return 0;
    }
}
