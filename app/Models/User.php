<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Booking;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',    // TAMBAHAN
        'role',     // TAMBAHAN
        'cancel_count',
        'last_booking_at',
        'is_suspended',
        'suspend_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_booking_at' => 'datetime',
        'is_suspended' => 'boolean',
    ];

    /**
     * Helper method untuk cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Helper method untuk cek apakah user adalah user biasa
     */
    public function isUser()
    {
        return $this->role === 'user';
    }

    /**
     * Relasi ke bookings (akan digunakan nanti)
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Helper: Get user reputation badge
     */
    public function getReputationBadgeAttribute()
    {
        if ($this->is_suspended) {
            return '<span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">⛔ Suspended</span>';
        }

        if ($this->cancel_count >= 3) {
            return '<span class="px-2 py-1 text-xs font-semibold rounded bg-orange-100 text-orange-800">⚠️ Warning</span>';
        }

        if ($this->cancel_count >= 1) {
            return '<span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">⚡ ' . $this->cancel_count . 'x Cancel</span>';
        }

        return '<span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">✓ Baik</span>';
    }

    /**
     * Helper: Cek jumlah booking aktif hari ini (excluding cancelled)
     */
    public function getTodayBookingsCountAttribute()
    {
        return $this->bookings()
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->count();
    }

    /**
     * Helper: Cek apakah user sudah mencapai limit booking harian (3 per hari)
     */
    public function hasReachedDailyBookingLimit()
    {
        return $this->today_bookings_count >= 3;
    }

    /**
     * Helper: Sisa booking yang bisa dilakukan hari ini
     */
    public function getRemainingTodayBookingsAttribute()
    {
        return max(0, 3 - $this->today_bookings_count);
    }

    /**
     * Helper: Cek apakah user masih bisa melakukan booking setelah pembatalan
     */
    public function canBookAfterCancellation()
    {
        return $this->remaining_today_bookings > 0;
    }
}
