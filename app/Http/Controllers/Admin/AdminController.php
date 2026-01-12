<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin
     * 
     * Route: GET /admin/dashboard
     * View: admin/dashboard.blade.php (Anggota 5 yang buat)
     */
    public function dashboard()
    {
        // Statistik umum
        $stats = [
            // Total bookings
            'total_bookings' => Booking::count(),
            
            // Booking pending (menunggu konfirmasi)
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            
            // Booking hari ini
            'today_bookings' => Booking::whereDate('booking_date', Carbon::today())->count(),
            
            // Total revenue dari booking completed
            'total_revenue' => Booking::where('status', 'completed')
                ->join('services', 'bookings.service_id', '=', 'services.id')
                ->sum('services.price'),
            
            // Total customers (users)
            'total_customers' => User::where('role', 'user')->count(),
            
            // Total services
            'total_services' => Service::count(),
        ];

        // Booking terbaru (10 terakhir)
        $recent_bookings = Booking::with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Booking hari ini
        $today_bookings = Booking::with(['user', 'service'])
            ->whereDate('booking_date', Carbon::today())
            ->orderBy('booking_time', 'asc')
            ->get();

        // Service paling populer
        $popular_services = Service::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_bookings',
            'today_bookings',
            'popular_services'
        ));
    }

    /**
     * Menampilkan daftar semua customers
     * 
     * Route: GET /admin/customers
     * View: admin/customers.blade.php (Anggota 5 yang buat)
     */
    public function customers()
    {
        // Ambil semua user dengan role 'user'
        $customers = User::where('role', 'user')
            ->withCount('bookings')  // Hitung jumlah booking per customer
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.customers', compact('customers'));
    }

    /**
     * Menampilkan detail customer
     * 
     * Route: GET /admin/customers/{id}
     * View: admin/customers-detail.blade.php (Anggota 5 yang buat)
     */
    public function customerDetail($id)
    {
        // Ambil customer dengan semua bookingnya
        $customer = User::where('role', 'user')
            ->where('id', $id)
            ->firstOrFail();

        // Ambil riwayat booking customer
        $bookings = $customer->bookings()
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistik customer
        $customer_stats = [
            'total_bookings' => $customer->bookings()->count(),
            'completed_bookings' => $customer->bookings()->where('status', 'completed')->count(),
            'cancelled_bookings' => $customer->bookings()->where('status', 'cancelled')->count(),
            'total_spent' => $customer->bookings()
                ->where('status', 'completed')
                ->join('services', 'bookings.service_id', '=', 'services.id')
                ->sum('services.price'),
        ];

        return view('admin.customers-detail', compact('customer', 'bookings', 'customer_stats'));
    }

    /**
     * Menampilkan daftar semua services
     * 
     * Route: GET /admin/services
     * View: admin/services.blade.php (Anggota 5 yang buat)
     */
    public function services()
    {
        // Ambil semua services dengan jumlah booking
        $services = Service::withCount('bookings')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.services', compact('services'));
    }
}