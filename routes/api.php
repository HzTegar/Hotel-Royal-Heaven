<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\RoomApiController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\CalendarApiController;

Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);

Route::middleware(['auth.api'])->group(function(){
    Route::post('logout', [AuthApiController::class, 'logout']);

    // rooms
    Route::get('rooms', [RoomApiController::class, 'index']);
    Route::get('rooms/{id}', [RoomApiController::class, 'show']);
    Route::post('rooms', [RoomApiController::class, 'store']);
    Route::put('rooms/{id}', [RoomApiController::class, 'update']);
    Route::delete('rooms/{id}', [RoomApiController::class, 'destroy']);

    // bookings
    Route::get('bookings', [BookingApiController::class, 'index']);
    Route::post('bookings', [BookingApiController::class, 'store']);
    Route::get('bookings/{id}', [BookingApiController::class, 'show']);
    Route::post('bookings/{id}/status', [BookingApiController::class, 'updateStatus']);

    // calendar
    Route::get('calendar/availability', [CalendarApiController::class, 'availability']);
    Route::get('calendar/bookings', [CalendarApiController::class, 'bookings']);
    Route::get('calendar/occupancy', [CalendarApiController::class, 'occupancy']);
});
