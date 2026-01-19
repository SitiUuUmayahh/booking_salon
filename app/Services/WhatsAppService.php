<?php

namespace App\Services;

use App\Models\Booking;

class WhatsAppService
{
    /**
     * Format nomor WhatsApp ke format international (tanpa +)
     * Format untuk wa.me: hanya angka, tanpa + atau karakter lain
     */
    public static function formatNumber(string $number): string
    {
        // Hapus semua karakter kecuali angka
        $number = preg_replace('/[^0-9]/', '', $number);
        
        // Jika awalan 0, ganti dengan 62
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }
        
        // Jika belum ada 62 di depan, tambahkan
        if (substr($number, 0, 2) !== '62') {
            $number = '62' . $number;
        }
        
        return $number;
    }

    /**
     * Generate WhatsApp link untuk admin
     * 
     * Format: https://wa.me/62xxxxxxxxx?text=...
     */
    public static function generateAdminLink(Booking $booking): string
    {
        $adminNumber = self::formatNumber(config('services.whatsapp.admin_number'));
        $message = self::generateAdminMessage($booking);
        
        return self::generateLink($adminNumber, $message);
    }

    /**
     * Generate WhatsApp link untuk customer
     */
    public static function generateCustomerLink(Booking $booking): string
    {
        $adminNumber = self::formatNumber(config('services.whatsapp.admin_number'));
        $message = self::generateCustomerMessage($booking);
        
        return self::generateLink($adminNumber, $message);
    }

    /**
     * Generate pesan untuk admin
     */
    public static function generateAdminMessage(Booking $booking): string
    {
        return sprintf(
            "Halo, ada booking baru!\n\n" .
            "🎫 Booking ID: #%d\n" .
            "👤 Customer: %s\n" .
            "💇 Layanan: %s\n" .
            "📅 Tanggal: %s\n" .
            "⏰ Jam: %s\n" .
            "💰 DP: %s\n\n" .
            "Status: %s\n" .
            "Link detail: %s",
            $booking->id,
            $booking->customer_name,
            $booking->service->name,
            $booking->booking_date->format('d M Y'),
            $booking->booking_time->format('H:i'),
            "Rp " . number_format($booking->dp_amount, 0, ',', '.'),
            $booking->dp_status,
            route('admin.bookings.show', $booking->id)
        );
    }

    /**
     * Generate pesan untuk customer
     */
    public static function generateCustomerMessage(Booking $booking): string
    {
        return sprintf(
            "Halo Dsisi Salon,\n\n" .
            "Saya ingin konfirmasi booking saya:\n\n" .
            "🎫 Booking ID: #%d\n" .
            "👤 Nama: %s\n" .
            "💇 Layanan: %s\n" .
            "📅 Tanggal: %s\n" .
            "⏰ Jam: %s\n" .
            "💰 DP: %s\n\n" .
            "Status pembayaran: %s",
            $booking->id,
            $booking->customer_name,
            $booking->service->name,
            $booking->booking_date->format('d M Y'),
            $booking->booking_time->format('H:i'),
            "Rp " . number_format($booking->dp_amount, 0, ',', '.'),
            $booking->dp_status
        );
    }

    /**
     * Generate WhatsApp link dengan message
     * 
     * URL encode message untuk keamanan
     */
    private static function generateLink(string $number, string $message): string
    {
        // Pastikan hanya angka (sudah diformat di formatNumber)
        $number = preg_replace('/[^0-9]/', '', $number);
        
        // Encode message untuk URL
        $encodedMessage = urlencode($message);
        
        return "https://wa.me/{$number}?text={$encodedMessage}";
    }

    /**
     * Generate WhatsApp link untuk share (tanpa +62)
     * Untuk dipakai di href attribute
     */
    public static function generateShareLink(Booking $booking, string $type = 'customer'): string
    {
        if ($type === 'admin') {
            return self::generateAdminLink($booking);
        }
        
        return self::generateCustomerLink($booking);
    }
}
