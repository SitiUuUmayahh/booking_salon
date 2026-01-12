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
];

public function bookings()
{
    return $this->hasMany(Booking::class);
}
}
