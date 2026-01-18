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
        $user = Auth::user();
        
        // DEBUG: Cek apakah user yang login ini seharusnya admin
        if ($user->role === 'admin') {
            \Log::warning('Admin user accessing user dashboard!', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]);
            
            // Redirect admin ke admin dashboard
            return redirect()->route('admin.dashboard')
                ->with('warning', 'Anda dialihkan ke dashboard admin.');
        }
        
        $services = Service::all();
        $bookings = Booking::where('user_id', Auth::id())
            ->with('service')
            ->orderBy('booking_date', 'desc')
            ->get();
        
        return view('dashboard', compact('services', 'bookings'));
    }
}