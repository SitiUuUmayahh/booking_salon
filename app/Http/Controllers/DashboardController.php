<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard user dengan list services dan riwayat booking
     */
    public function index()
    {
        $services = Service::all();
        $bookings = Booking::where('user_id', Auth::id())
            ->with('service')
            ->orderBy('booking_date', 'desc')
            ->get();
        
        return view('dashboard', compact('services', 'bookings'));
    }
}