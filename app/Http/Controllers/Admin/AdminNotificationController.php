<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminNotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     */
    public function index()
    {
        $notifications = AdminNotification::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create()
    {
        return view('admin.notifications.create');
    }

    /**
     * Store a newly created notification in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success,urgent',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date_format:Y-m-d\TH:i',
            'expired_at' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        // Convert datetime format if provided
        if ($validated['published_at']) {
            $validated['published_at'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['published_at']);
        }
        if ($validated['expired_at']) {
            $validated['expired_at'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['expired_at']);
            // Validate that expired_at is after published_at
            if ($validated['published_at'] && $validated['expired_at'] <= $validated['published_at']) {
                return back()->withErrors(['expired_at' => 'Waktu kadaluarsa harus setelah waktu publikasi']);
            }
        }

        AdminNotification::create($validated);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notifikasi berhasil dibuat');
    }

    /**
     * Display the specified notification.
     */
    public function show(AdminNotification $notification)
    {
        return view('admin.notifications.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified notification.
     */
    public function edit(AdminNotification $notification)
    {
        return view('admin.notifications.edit', compact('notification'));
    }

    /**
     * Update the specified notification in storage.
     */
    public function update(Request $request, AdminNotification $notification)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success,urgent',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date_format:Y-m-d\TH:i',
            'expired_at' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        // Convert datetime format if provided
        if ($validated['published_at']) {
            $validated['published_at'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['published_at']);
        }
        if ($validated['expired_at']) {
            $validated['expired_at'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['expired_at']);
            // Validate that expired_at is after published_at
            if ($validated['published_at'] && $validated['expired_at'] <= $validated['published_at']) {
                return back()->withErrors(['expired_at' => 'Waktu kadaluarsa harus setelah waktu publikasi']);
            }
        }

        $notification->update($validated);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notifikasi berhasil diperbarui');
    }

    /**
     * Remove the specified notification from storage.
     */
    public function destroy(AdminNotification $notification)
    {
        $notification->delete();
        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notifikasi berhasil dihapus');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(AdminNotification $notification)
    {
        $notification->update(['is_active' => !$notification->is_active]);
        return redirect()->route('admin.notifications.index')
            ->with('success', 'Status notifikasi berhasil diubah');
    }
}
