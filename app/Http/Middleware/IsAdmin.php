<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * 
     * Middleware ini memastikan hanya user dengan role 'admin' yang bisa akses route tertentu
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            // Jika belum login, redirect ke halaman login
            return redirect()->route('login')
                ->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        // Cek apakah user adalah admin
        if (auth()->user()->role !== 'admin') {
            // Jika bukan admin, redirect ke dashboard user dengan pesan error
            return redirect()->route('dashboard')
                ->withErrors(['error' => 'Anda tidak memiliki akses ke halaman ini']);
        }

        // Jika user adalah admin, lanjutkan request
        return $next($request);
    }
}