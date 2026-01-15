<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminBookingController;

/*
|--------------------------------------------------------------------------
| Guest Routes - Hanya untuk user yang belum login
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

/*
|--------------------------------------------------------------------------
| Public Routes - Bisa diakses siapa saja
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

/*
|--------------------------------------------------------------------------
| Admin Routes - Protected by 'auth' dan 'admin' middleware
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    Route::get('/customers/{id}', [AdminController::class, 'customerDetail'])->name('customers.detail');
    Route::get('/services', [AdminController::class, 'services'])->name('services');
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{id}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');
    Route::post('/bookings/{id}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::delete('/bookings/{id}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
});

/*
|--------------------------------------------------------------------------
| Protected Routes - Hanya untuk user yang sudah login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/history', [BookingController::class, 'history'])->name('bookings.history');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});