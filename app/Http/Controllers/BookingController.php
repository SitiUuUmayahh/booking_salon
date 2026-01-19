<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Menampilkan form create booking untuk service tertentu
     */
    public function create(Request $request)
    {
        $service = null;
        if ($request->has('service_id')) {
            $service = Service::findOrFail($request->get('service_id'));
        }

        $services = Service::all();
        return view('bookings.create', compact('service', 'services'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 🔒 ANTI-SPAM 1: Cek apakah user di-suspend
        if ($user->is_suspended) {
            return back()->withErrors([
                'error' => 'Akun Anda di-suspend karena: ' . $user->suspend_reason
            ])->withInput();
        }

        // 🔒 ANTI-SPAM 2: Cooldown Period (30 menit)
        if ($user->last_booking_at) {
            $minutesSinceLastBooking = Carbon::parse($user->last_booking_at)->diffInMinutes(now());
            if ($minutesSinceLastBooking < 30) {
                $remainingMinutes = 30 - $minutesSinceLastBooking;
                return back()->withErrors([
                    'error' => "Mohon tunggu {$remainingMinutes} menit lagi sebelum membuat booking baru."
                ])->withInput();
            }
        }

        // 🔒 ANTI-SPAM 3: Batasan booking aktif (max 5 booking pending/confirmed)
        $activeBookingsCount = Booking::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        if ($activeBookingsCount >= 5) {
            return back()->withErrors([
                'error' => 'Anda sudah memiliki 5 booking aktif. Silakan selesaikan atau batalkan booking lama terlebih dahulu.'
            ])->withInput();
        }

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

        // Hitung DP (50% dari harga service)
        $service = Service::findOrFail($validated['service_id']);
        
        // Cek ketersediaan slot berdasarkan max_bookings dari service
        $bookingDate = Carbon::parse($validated['booking_date']);
        $slotInfo = $service->getAvailableSlots($bookingDate->format('Y-m-d'), $validated['booking_time']);

        if ($slotInfo['is_full']) {
            return back()->withErrors([
                'booking_time' => "Maaf, slot waktu ini sudah penuh ({$slotInfo['booked']}/{$slotInfo['total']} terisi). Silakan pilih waktu lain."
            ])->withInput();
        }
        $dpAmount = $service->price * 0.5; // 50% DP

        $booking = Booking::create([
            'user_id' => Auth::id(),  // ID user yang sedang login
            'service_id' => $validated['service_id'],
            'customer_name' => $validated['customer_name'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'notes' => $validated['notes'],
            'status' => 'pending',  // Status awal selalu pending
            'dp_amount' => $dpAmount,
            'dp_status' => 'unpaid', // Belum bayar DP
        ]);

        // Update last_booking_at untuk cooldown tracking
        $user->update(['last_booking_at' => now()]);

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Booking berhasil dibuat! Silakan upload bukti pembayaran DP untuk melanjutkan.');
    }

    public function history()
    {
        // Ambil booking milik user yang login, dengan relasi service
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $bookings = $user
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
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->withErrors([
                'error' => 'Booking ini tidak dapat dibatalkan.'
            ]);
        }

        $booking->update(['status' => 'cancelled']);

        // 🔒 ANTI-SPAM: Track cancel count
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->increment('cancel_count');

        // Auto-suspend jika cancel lebih dari 5 kali
        if ($user->cancel_count >= 5) {
            $user->update([
                'is_suspended' => true,
                'suspend_reason' => 'Terlalu sering membatalkan booking (lebih dari 5 kali). Hubungi admin untuk mengaktifkan kembali akun Anda.'
            ]);

            return redirect()->route('bookings.history')
                ->with('warning', 'Booking dibatalkan. PERINGATAN: Akun Anda telah di-suspend karena terlalu sering membatalkan booking. Silakan hubungi admin.');
        }

        // Warning jika cancel 3-4 kali
        if ($user->cancel_count >= 3) {
            $remaining = 5 - $user->cancel_count;
            return redirect()->route('bookings.history')
                ->with('warning', "Booking dibatalkan. PERINGATAN: Anda telah membatalkan {$user->cancel_count}x. Jika membatalkan {$remaining}x lagi, akun akan di-suspend.");
        }

        return redirect()->route('bookings.history')
            ->with('success', 'Booking berhasil dibatalkan');
    }

    /**
     * Upload bukti pembayaran DP
     */
    public function uploadDpProof(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Security: Cek ownership
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Validasi: Hanya bisa upload jika status unpaid atau rejected
        if (!in_array($booking->dp_status, ['unpaid', 'rejected'])) {
            return back()->withErrors([
                'error' => 'Bukti DP sudah pernah diupload dan sedang diproses.'
            ]);
        }

        $validated = $request->validate([
            'dp_payment_proof' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ], [
            'dp_payment_proof.required' => 'Foto bukti transfer harus diupload',
            'dp_payment_proof.image' => 'File harus berupa gambar',
            'dp_payment_proof.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'dp_payment_proof.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Upload file ke storage/app/public/dp_proofs
        $path = $request->file('dp_payment_proof')->store('dp_proofs', 'public');

        // Update booking
        $booking->update([
            'dp_payment_proof' => $path,
            'dp_status' => 'pending',
            'dp_paid_at' => now(),
            'dp_rejection_reason' => null, // Reset rejection reason
        ]);

        return back()->with('success', 'Bukti pembayaran DP berhasil diupload. Menunggu verifikasi admin.');
    }

    /**
     * API: Cek slot tersedia untuk service, tanggal, dan waktu tertentu
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required|date_format:H:i',
        ]);

        $service = Service::findOrFail($request->service_id);
        $slotInfo = $service->getAvailableSlots($request->booking_date, $request->booking_time);

        return response()->json([
            'success' => true,
            'data' => $slotInfo,
            'message' => $slotInfo['is_full'] 
                ? "Slot penuh ({$slotInfo['booked']}/{$slotInfo['total']})" 
                : "{$slotInfo['available']} slot tersedia dari {$slotInfo['total']}"
        ]);
    }

}
