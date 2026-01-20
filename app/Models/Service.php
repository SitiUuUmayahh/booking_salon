<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'image',
        'max_bookings',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDurationAttribute()
    {
        if ($this->duration >= 60) {
            $hours = floor($this->duration / 60);
            $minutes = $this->duration % 60;

            if ($minutes > 0) {
                return $hours . ' jam ' . $minutes . ' menit';
            }
            return $hours . ' jam';
        }
        return $this->duration . ' menit';
    }

    /**
     * Cek slot tersedia untuk tanggal dan waktu tertentu
     * 
     * @param string $date Format: Y-m-d
     * @param string $time Format: H:i
     * @return array ['available' => int, 'booked' => int, 'is_full' => bool]
     */
    public function getAvailableSlots($date, $time)
    {
        $bookedCount = Booking::where('service_id', $this->id)
            ->where('booking_date', $date)
            ->where('booking_time', $time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        $availableSlots = $this->max_bookings - $bookedCount;

        return [
            'available' => max(0, $availableSlots),
            'booked' => $bookedCount,
            'total' => $this->max_bookings,
            'is_full' => $bookedCount >= $this->max_bookings
        ];
    }
}
