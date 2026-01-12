<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    /**
     * Menampilkan semua booking
     * 
     * Route: GET /admin/bookings
     * View: admin/bookings/index.blade.php (Anggota 5 yang buat)
     */
    public function index(Request $request)
    {
        // Query builder untuk bookings
        $query = Booking::with(['user', 'service']);

        // Filter berdasarkan status (jika ada)
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal (jika ada)
        if ($request->has('date') && $request->date) {
            $query->whereDate('booking_date', $request->date);
        }

        // Search berdasarkan nama customer atau service
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhereHas('service', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Urutkan berdasarkan tanggal terbaru
        $bookings = $query->orderBy('created_at', 'desc')->paginate(20);

        // Hitung statistik untuk filter
        $stats = [
            'all' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    /**
     * Menampilkan detail booking
     * 
     * Route: GET /admin/bookings/{id}
     * View: admin/bookings/show.blade.php (Anggota 5 yang buat)
     */
    public function show($id)
    {
        $booking = Booking::with(['user', 'service'])->findOrFail($id);
        
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Konfirmasi booking (ubah status dari pending ke confirmed)
     * 
     * Route: POST /admin/bookings/{id}/confirm
     */
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);

        // Business rule: Hanya booking pending yang bisa dikonfirmasi
        if ($booking->status !== 'pending') {
            return back()->withErrors([
                'error' => 'Hanya booking dengan status Pending yang bisa dikonfirmasi'
            ]);
        }

        // Update status ke confirmed
        $booking->update(['status' => 'confirmed']);

        return back()->with('success', 'Booking berhasil dikonfirmasi');
    }

    /**
     * Selesaikan booking (ubah status ke completed)
     * 
     * Route: POST /admin/bookings/{id}/complete
     */
    public function complete($id)
    {
        $booking = Booking::findOrFail($id);

        // Business rule: Hanya booking confirmed yang bisa diselesaikan
        if ($booking->status !== 'confirmed') {
            return back()->withErrors([
                'error' => 'Hanya booking dengan status Dikonfirmasi yang bisa diselesaikan'
            ]);
        }

        // Update status ke completed
        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Booking berhasil diselesaikan');
    }

    /**
     * Batalkan booking (ubah status ke cancelled)
     * 
     * Route: POST /admin/bookings/{id}/cancel
     */
    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Business rule: Booking completed tidak bisa dibatalkan
        if ($booking->status === 'completed') {
            return back()->withErrors([
                'error' => 'Booking yang sudah selesai tidak bisa dibatalkan'
            ]);
        }

        // Update status ke cancelled
        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking berhasil dibatalkan');
    }

    /**
     * Hapus booking
     * 
     * Route: DELETE /admin/bookings/{id}
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        // Business rule: Hanya booking cancelled yang bisa dihapus
        if ($booking->status !== 'cancelled') {
            return back()->withErrors([
                'error' => 'Hanya booking dengan status Dibatalkan yang bisa dihapus'
            ]);
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dihapus');
    }
}
