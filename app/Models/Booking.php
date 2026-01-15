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
];

protected $casts = [
    'booking_date' => 'date',
    'booking_time' => 'datetime',
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
        ->translatedFormat('dddd, D MMMM YYYY');
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
}
