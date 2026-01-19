<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Service;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Check booking availability
Route::post('/bookings/check-availability', function (Request $request) {
    $service = Service::findOrFail($request->service_id);
    $slotInfo = $service->getAvailableSlots($request->booking_date, $request->booking_time);
    
    return response()->json([
        'success' => true,
        'data' => $slotInfo
    ]);
})->name('api.bookings.check-availability');
