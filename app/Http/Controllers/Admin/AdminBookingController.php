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

        // 🔒 ANTI-SPAM: DP harus sudah verified sebelum bisa confirm
        if ($booking->dp_status !== 'verified') {
            return back()->withErrors([
                'error' => 'Pembayaran DP harus diverifikasi terlebih dahulu sebelum mengkonfirmasi booking'
            ]);
        }

        // 🔥 FITUR BARU: Konfirmasi semua booking terkait yang dibuat bersamaan
        $relatedBookings = Booking::where('user_id', $booking->user_id)
            ->where('booking_date', $booking->booking_date)
            ->where('booking_time', $booking->booking_time)
            ->where('status', 'pending')
            ->where('dp_status', 'verified')
            ->get();

        // Update semua booking terkait ke confirmed
        foreach ($relatedBookings as $relatedBooking) {
            $relatedBooking->update(['status' => 'confirmed']);
        }

        $bookingCount = $relatedBookings->count();
        $message = $bookingCount > 1
            ? "Berhasil mengkonfirmasi {$bookingCount} booking sekaligus!"
            : 'Booking berhasil dikonfirmasi';

        return back()->with('success', $message);
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

    /**
     * Verifikasi pembayaran DP
     *
     * Route: POST /admin/bookings/{id}/verify-dp
     */
    public function verifyDp($id)
    {
        $booking = Booking::findOrFail($id);

        // Validasi: Hanya bisa verify jika status pending
        if ($booking->dp_status !== 'pending') {
            return back()->withErrors([
                'error' => 'Hanya DP dengan status Pending yang bisa diverifikasi'
            ]);
        }

        // 🔥 FITUR BARU: Verifikasi semua booking terkait dengan bukti DP yang sama
        $relatedBookings = Booking::where('user_id', $booking->user_id)
            ->where('booking_date', $booking->booking_date)
            ->where('booking_time', $booking->booking_time)
            ->where('dp_payment_proof', $booking->dp_payment_proof)
            ->where('dp_status', 'pending')
            ->get();

        // Update semua booking terkait
        foreach ($relatedBookings as $relatedBooking) {
            $relatedBooking->update([
                'dp_status' => 'verified',
                'dp_verified_at' => now(),
            ]);
        }

        $bookingCount = $relatedBookings->count();
        $message = $bookingCount > 1
            ? "Pembayaran DP berhasil diverifikasi untuk {$bookingCount} booking!"
            : 'Pembayaran DP berhasil diverifikasi!';

        return back()->with('success', $message);
    }

    /**
     * Tolak pembayaran DP
     *
     * Route: POST /admin/bookings/{id}/reject-dp
     */
    public function rejectDp(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Validasi: Hanya bisa reject jika status pending
        if ($booking->dp_status !== 'pending') {
            return back()->withErrors([
                'error' => 'Hanya DP dengan status Pending yang bisa ditolak'
            ]);
        }

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan harus diisi',
        ]);

        // 🔥 FITUR BARU: Tolak semua booking terkait dengan bukti DP yang sama
        $relatedBookings = Booking::where('user_id', $booking->user_id)
            ->where('booking_date', $booking->booking_date)
            ->where('booking_time', $booking->booking_time)
            ->where('dp_payment_proof', $booking->dp_payment_proof)
            ->where('dp_status', 'pending')
            ->get();

        // Update semua booking terkait
        foreach ($relatedBookings as $relatedBooking) {
            $relatedBooking->update([
                'dp_status' => 'rejected',
                'dp_rejection_reason' => $validated['rejection_reason'],
            ]);
        }

        $bookingCount = $relatedBookings->count();
        $message = $bookingCount > 1
            ? "Pembayaran DP ditolak untuk {$bookingCount} booking. Customer akan diminta upload ulang."
            : 'Pembayaran DP ditolak. Customer akan diminta upload ulang.';

        return back()->with('success', $message);
    }

    /**
     * View bukti pembayaran DP
     *
     * Route: GET /admin/bookings/{id}/dp-proof-view
     */
    public function viewDpProof($id)
    {
        $booking = Booking::findOrFail($id);

        // Validasi: pastikan file ada
        if (!$booking->dp_payment_proof) {
            abort(404, 'Bukti pembayaran DP tidak ditemukan');
        }

        // Validasi: pastikan file exists di storage
        $filePath = storage_path('app/public/' . $booking->dp_payment_proof);
        if (!file_exists($filePath)) {
            abort(404, 'File bukti pembayaran tidak ditemukan di server');
        }

        // Return file as image
        return response()->file($filePath);
    }
}
