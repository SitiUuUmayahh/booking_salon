<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'service_id',
        'customer_name',
        'booking_date',
        'booking_time',
        'notes',
        'status',
        'dp_amount',
        'dp_status',
        'dp_payment_proof',
        'dp_rejection_reason',
        'dp_paid_at',
        'dp_verified_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime',
        'dp_paid_at' => 'datetime',
        'dp_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->booking_date)
            ->locale('id')
            ->translatedFormat('d, D M Y');
    }

    public function getFormattedTimeAttribute()
    {
        return Carbon::parse($this->booking_time)->format('H:i');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>',
            'confirmed' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Dikonfirmasi</span>',
            'completed' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>',
            'cancelled' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>',
        ];
        return $badges[$this->status] ?? $this->status;
    }

    public function getDpStatusBadgeAttribute()
    {
        $badges = [
            'unpaid' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Belum Bayar DP</span>',
            'pending' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">⏳ Menunggu Verifikasi</span>',
            'verified' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">✓ DP Terverifikasi</span>',
            'rejected' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">✗ DP Ditolak</span>',
        ];
        return $badges[$this->dp_status] ?? $this->dp_status;
    }

    public function getFormattedDpAmountAttribute()
    {
        return 'Rp ' . number_format($this->dp_amount, 0, ',', '.');
    }

    public function getRemainingPaymentAttribute()
    {
        $totalPrice = $this->service->price ?? 0;
        $remaining = $totalPrice - $this->dp_amount;
        return 'Rp ' . number_format($remaining, 0, ',', '.');
    }
}
