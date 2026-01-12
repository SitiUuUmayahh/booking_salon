<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'service_id.required' => 'Pilih layanan yang ingin Anda booking',
            'service_id.exists' => 'Layanan yang dipilih tidak valid',
            'customer_name.required' => 'Nama pelanggan harus diisi',
            'booking_date.required' => 'Tanggal booking harus diisi',
            'booking_date.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu',
            'booking_time.required' => 'Jam booking harus diisi',
            'booking_time.date_format' => 'Format jam tidak valid',
        ]);

        $bookingTime = Carbon::createFromFormat('H:i', $validated['booking_time']);
        $openTime = Carbon::createFromFormat('H:i', '09:00');
        $closeTime = Carbon::createFromFormat('H:i', '20:00');

        if ($bookingTime->lt($openTime) || $bookingTime->gt($closeTime)) {
            return back()->withErrors([
                'booking_time' => 'Jam booking harus antara 09:00 - 20:00'
            ])->withInput();
        }

        $bookingDate = Carbon::parse($validated['booking_date']);
        $existingBookings = Booking::where('booking_date', $bookingDate)
            ->where('booking_time', $validated['booking_time'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        if ($existingBookings >= 3) {
            return back()->withErrors([
                'booking_time' => 'Maaf, slot waktu ini sudah penuh. Silakan pilih waktu lain.'
            ])->withInput();
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),  // ID user yang sedang login
            'service_id' => $validated['service_id'],
            'customer_name' => $validated['customer_name'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'notes' => $validated['notes'],
            'status' => 'pending',  // Status awal selalu pending
        ]);
        return redirect()->route('dashboard')
            ->with('success', 'Booking berhasil dibuat! Kami akan menghubungi Anda untuk konfirmasi.');
    }

    public function history()
    {
        // Ambil booking milik user yang login, dengan relasi service
        $bookings = Auth::user()
            ->bookings()
            ->with('service')  // Eager loading untuk avoid N+1 query
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }

    public function show($id)
    {
        // Ambil booking dengan relasi service
        $booking = Booking::with('service')->findOrFail($id);

        // Security: Cek apakah booking milik user yang login
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini');
        }

        return view('bookings.show', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        // Security: Cek ownership
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        if ($booking->status !== 'pending') {
            return back()->withErrors([
                'error' => 'Booking yang sudah dikonfirmasi tidak bisa dibatalkan. Silakan hubungi admin.'
            ]);
        }
        $booking->update(['status' => 'cancelled']);

        return redirect()->route('bookings.history')
            ->with('success', 'Booking berhasil dibatalkan');
    }
}
