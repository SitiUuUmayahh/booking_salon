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

        // 🔒 ANTI-SPAM 2: Cooldown Period (30 menit) - DINONAKTIFKAN UNTUK MEMUNGKINKAN 3 BOOKING/HARI
        // if ($user->last_booking_at) {
        //     $minutesSinceLastBooking = Carbon::parse($user->last_booking_at)->diffInMinutes(now());
        //     if ($minutesSinceLastBooking < 30) {
        //         $remainingMinutes = 30 - $minutesSinceLastBooking;
        //         return back()->withErrors([
        //             'error' => "Mohon tunggu {$remainingMinutes} menit lagi sebelum membuat booking baru."
        //         ])->withInput();
        //     }
        // }

        // 🔒 ANTI-SPAM 2.1: Batasan booking per hari (max 3 booking per hari)
        if ($user->hasReachedDailyBookingLimit()) {
            return back()->withErrors([
                'error' => 'Anda sudah mencapai batas maksimal 3 booking per hari. Silakan coba lagi besok.'
            ])->withInput();
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
            'service_ids' => ['required', 'array', 'min:1', 'max:3'],
            'service_ids.*' => ['required', 'exists:services,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'service_ids.required' => 'Pilih minimal satu layanan',
            'service_ids.min' => 'Pilih minimal satu layanan',
            'service_ids.max' => 'Maksimal 3 layanan per booking',
            'service_ids.*.exists' => 'Salah satu layanan yang dipilih tidak valid',
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

        // Hitung total harga dan DP untuk semua services
        $serviceIds = $validated['service_ids'];
        $services = Service::whereIn('id', $serviceIds)->get();

        // Generate unique group ID untuk multiple bookings
        $bookingGroupId = 'BG-' . uniqid() . '-' . time();

        // Create bookings untuk setiap service dalam satu grup
        $bookings = [];
        foreach ($serviceIds as $serviceId) {
            // Cari service untuk mendapatkan harga individual
            $service = Service::findOrFail($serviceId);
            $individualDpAmount = $service->price * 0.5; // 50% DP dari harga layanan ini

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'service_id' => $serviceId,
                'booking_group_id' => $bookingGroupId,
                'customer_name' => $validated['customer_name'],
                'booking_date' => $validated['booking_date'],
                'booking_time' => $validated['booking_time'],
                'notes' => $validated['notes'],
                'status' => 'pending',
                'dp_amount' => $individualDpAmount, // DP berdasarkan harga layanan individual
                'dp_status' => 'unpaid',
            ]);

            $bookings[] = $booking;
        }

        // Update last_booking_at untuk cooldown tracking
        $user->update(['last_booking_at' => now()]);

        // Redirect ke booking pertama dalam grup (untuk tampilan)
        $firstBooking = $bookings[0];
        return redirect()->route('bookings.show', $firstBooking->id)
            ->with('success', 'Booking berhasil dibuat untuk ' . count($services) . ' layanan! Silakan upload bukti pembayaran DP untuk melanjutkan.');
    }

    public function history()
    {
        // Ambil booking milik user yang login, dengan relasi service
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Group bookings by booking_group_id atau individual booking
        $allBookings = $user
            ->bookings()
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group berdasarkan booking_group_id
        $groupedBookings = [];
        $processedGroups = [];

        foreach ($allBookings as $booking) {
            if ($booking->booking_group_id && !in_array($booking->booking_group_id, $processedGroups)) {
                // Group booking - ambil sebagai group
                $groupBookings = $allBookings->where('booking_group_id', $booking->booking_group_id)->values();

                // Hitung total untuk group
                $totalPrice = $groupBookings->sum(function($b) {
                    return $b->service->price;
                });

                $groupedBookings[] = [
                    'is_group' => true,
                    'group_id' => $booking->booking_group_id,
                    'bookings' => $groupBookings,
                    'main_booking' => $groupBookings->first(),
                    'created_at' => $booking->created_at,
                    'total_formatted' => 'Rp ' . number_format($totalPrice, 0, ',', '.')
                ];
                $processedGroups[] = $booking->booking_group_id;
            } elseif (!$booking->booking_group_id) {
                // Individual booking
                $groupedBookings[] = [
                    'is_group' => false,
                    'bookings' => collect([$booking]),
                    'main_booking' => $booking,
                    'created_at' => $booking->created_at,
                    'total_formatted' => $booking->service->formatted_price
                ];
            }
        }

        // Sort by created_at dan convert ke collection
        $bookings = collect($groupedBookings)->sortByDesc('created_at')->values();

        // Manual pagination
        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $offset = ($currentPage - 1) * $perPage;

        $paginatedItems = $bookings->slice($offset, $perPage)->values();
        $paginatedBookings = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedItems,
            $bookings->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        return view('bookings.history', compact('paginatedBookings'));
    }

    public function show($id)
    {
        // Ambil booking dengan relasi service
        $booking = Booking::with('service')->findOrFail($id);

        // Security: Cek apakah booking milik user yang login
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini');
        }

        // Hitung slot availability untuk slot waktu booking ini
        $bookingTime = Carbon::parse($booking->booking_time)->format('H:i');
        $slotInfo = $booking->service->getAvailableSlots(
            $booking->booking_date->format('Y-m-d'),
            $bookingTime
        );

        return view('bookings.show', compact('booking', 'slotInfo'));
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

        // Cek apakah ini adalah booking group
        $isGroupBooking = !is_null($booking->booking_group_id);
        $cancelledCount = 1;

        if ($isGroupBooking) {
            // Batalkan semua booking dalam group yang sama
            $groupBookings = Booking::where('booking_group_id', $booking->booking_group_id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->get();
            
            foreach ($groupBookings as $groupBooking) {
                $groupBooking->update(['status' => 'cancelled']);
            }
            $cancelledCount = $groupBookings->count();
        } else {
            $booking->update(['status' => 'cancelled']);
        }

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
                ->with('warning', "Booking dibatalkan. PERINGATAN: Anda telah membatalkan {$user->cancel_count}x. Jika membatalkan {$remaining}x lagi, akun akan di-suspend.")
                ->with('show_booking_button', true);
        }

        $remainingBookings = $user->remaining_today_bookings;
        $message = $isGroupBooking 
            ? "Booking berhasil dibatalkan ({$cancelledCount} layanan). Anda masih bisa melakukan {$remainingBookings} booking lagi hari ini."
            : "Booking berhasil dibatalkan. Anda masih bisa melakukan {$remainingBookings} booking lagi hari ini.";

        return redirect()->route('bookings.history')
            ->with('success', $message)
            ->with('show_booking_button', true);
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

        // 🔥 FITUR BARU: Share bukti DP ke semua booking yang dibuat bersamaan
        // Cari semua booking dengan user yang sama, tanggal yang sama, dan waktu yang sama
        $relatedBookings = Booking::where('user_id', $booking->user_id)
            ->where('booking_date', $booking->booking_date)
            ->where('booking_time', $booking->booking_time)
            ->whereIn('dp_status', ['unpaid', 'rejected']) // Hanya yang belum upload atau ditolak
            ->get();

        // Update semua booking terkait dengan bukti DP yang sama
        foreach ($relatedBookings as $relatedBooking) {
            $relatedBooking->update([
                'dp_payment_proof' => $path,
                'dp_status' => 'pending',
                'dp_paid_at' => now(),
                'dp_rejection_reason' => null, // Reset rejection reason
            ]);
        }

        $bookingCount = $relatedBookings->count();
        $message = $bookingCount > 1
            ? "Bukti pembayaran DP berhasil diupload untuk {$bookingCount} booking. Menunggu verifikasi admin."
            : 'Bukti pembayaran DP berhasil diupload. Menunggu verifikasi admin.';

        return back()->with('success', $message);
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
