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
        // Ambil statistik untuk view
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();

        // Booking terbaru (10 terakhir)
        $recentBookings = Booking::with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Booking hari ini
        $todayBookings = Booking::with(['user', 'service'])
            ->whereDate('booking_date', Carbon::today())
            ->orderBy('booking_time', 'asc')
            ->get();

        // Service paling populer
        $popularServices = Service::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'cancelledBookings',
            'recentBookings',
            'todayBookings',
            'popularServices'
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

    /**
     * Unsuspend user yang di-suspend
     */
    public function unsuspendUser($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_suspended' => false,
            'suspend_reason' => null,
        ]);

        return back()->with('success', 'User berhasil di-aktifkan kembali.');
    }

    /**
     * Reset cancel count user
     */
    public function resetCancelCount($id)
    {
        $user = User::findOrFail($id);

        $user->update(['cancel_count' => 0]);

        return back()->with('success', 'Cancel count berhasil direset.');
    }
}
