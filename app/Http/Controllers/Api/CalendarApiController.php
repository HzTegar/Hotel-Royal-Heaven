<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CalendarApiController extends Controller
{
    public function availability(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'room_type' => 'nullable|exists:tipe_kamar,id_tipe',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Don't allow queries more than 3 months
        if ($startDate->diffInMonths($endDate) > 3) {
            return response()->json(['message' => 'Date range cannot exceed 3 months'], 400);
        }

        $query = Kamar::with(['tipe', 'pemesanan' => function ($query) use ($startDate, $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tgl_check_in', [$startDate, $endDate])
                  ->orWhereBetween('tgl_check_out', [$startDate, $endDate])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('tgl_check_in', '<=', $startDate)
                         ->where('tgl_check_out', '>=', $endDate);
                  });
            })->whereIn('status_pemesanan', ['confirmed', 'pending']);
        }]);

        if ($request->room_type) {
            $query->where('id_tipe', $request->room_type);
        }

        $rooms = $query->get();

        $calendarData = [];
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($rooms as $room) {
            $roomData = [
                'id' => $room->id_kamar,
                'nomor_kamar' => $room->nomor_kamar,
                'tipe_kamar' => $room->tipe->nama_tipe,
                'harga_dasar' => $room->tipe->harga_dasar,
                'max_tamu' => $room->tipe->max_tamu,
                'status_ketersediaan' => $room->status_ketersediaan,
                'bookings' => [],
                'availability' => []
            ];

            // Process bookings for this room
            foreach ($room->pemesanan as $booking) {
                $roomData['bookings'][] = [
                    'id' => $booking->id_pemesanan,
                    'kode_pemesanan' => $booking->kode_pemesanan,
                    'check_in' => $booking->tgl_check_in,
                    'check_out' => $booking->tgl_check_out,
                    'status' => $booking->status_pemesanan,
                    'customer' => $booking->user->nama_lengkap ?? $booking->user->username,
                    'total_harga' => $booking->total_harga,
                ];
            }

            // Calculate availability for each date in the period
            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');
                $isAvailable = true;
                $bookingInfo = null;

                foreach ($room->pemesanan as $booking) {
                    $checkIn = Carbon::parse($booking->tgl_check_in);
                    $checkOut = Carbon::parse($booking->tgl_check_out);

                    if ($date->between($checkIn, $checkOut->subDay()) &&
                        in_array($booking->status_pemesanan, ['confirmed', 'pending'])) {
                        $isAvailable = false;
                        $bookingInfo = [
                            'id' => $booking->id_pemesanan,
                            'status' => $booking->status_pemesanan,
                            'customer' => $booking->user->nama_lengkap ?? $booking->user->username,
                        ];
                        break;
                    }
                }

                $roomData['availability'][] = [
                    'date' => $dateStr,
                    'available' => $isAvailable,
                    'booking' => $bookingInfo,
                ];
            }

            $calendarData[] = $roomData;
        }

        return response()->json([
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ],
            'rooms' => $calendarData,
            'summary' => [
                'total_rooms' => $rooms->count(),
                'available_rooms' => $rooms->where('status_ketersediaan', 'available')->count(),
                'occupied_rooms' => $rooms->where('status_ketersediaan', 'booked')->count(),
                'maintenance_rooms' => $rooms->where('status_ketersediaan', 'maintenance')->count(),
            ]
        ]);
    }

    public function bookings(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'nullable|in:pending,confirmed,completed,cancelled',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $query = Pemesanan::with(['user', 'kamar.tipe'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tgl_check_in', [$startDate, $endDate])
                  ->orWhereBetween('tgl_check_out', [$startDate, $endDate])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('tgl_check_in', '<=', $startDate)
                         ->where('tgl_check_out', '>=', $endDate);
                  });
            });

        if ($request->status) {
            $query->where('status_pemesanan', $request->status);
        }

        $bookings = $query->orderBy('tgl_check_in')->get();

        return response()->json([
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ],
            'bookings' => $bookings->map(function ($booking) {
                return [
                    'id' => $booking->id_pemesanan,
                    'kode_pemesanan' => $booking->kode_pemesanan,
                    'customer' => [
                        'id' => $booking->user->id,
                        'name' => $booking->user->nama_lengkap ?? $booking->user->username,
                        'email' => $booking->user->email,
                    ],
                    'room' => [
                        'id' => $booking->kamar->id_kamar,
                        'nomor_kamar' => $booking->kamar->nomor_kamar,
                        'tipe_kamar' => $booking->kamar->tipe->nama_tipe,
                    ],
                    'check_in' => $booking->tgl_check_in,
                    'check_out' => $booking->tgl_check_out,
                    'total_malam' => $booking->total_malam,
                    'total_harga' => $booking->total_harga,
                    'status' => $booking->status_pemesanan,
                    'pilihan_pembayaran' => $booking->pilihan_pembayaran,
                    'created_at' => $booking->tgl_pemesanan,
                ];
            }),
            'summary' => [
                'total_bookings' => $bookings->count(),
                'pending' => $bookings->where('status_pemesanan', 'pending')->count(),
                'confirmed' => $bookings->where('status_pemesanan', 'confirmed')->count(),
                'completed' => $bookings->where('status_pemesanan', 'completed')->count(),
                'cancelled' => $bookings->where('status_pemesanan', 'cancelled')->count(),
                'total_revenue' => $bookings->where('status_pemesanan', 'completed')->sum('total_harga'),
            ]
        ]);
    }

    public function occupancy(Request $request)
    {
        $request->validate([
            'month' => 'nullable|date_format:Y-m',
            'year' => 'nullable|integer|min:2020|max:' . (date('Y') + 1),
        ]);

        $month = $request->month ?: now()->format('Y-m');
        $year = $request->year ?: now()->format('Y');

        $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $totalRooms = Kamar::count();
        $period = CarbonPeriod::create($startDate, $endDate);

        $occupancyData = [];

        foreach ($period as $date) {
            $occupiedRooms = Pemesanan::where(function ($q) use ($date) {
                $q->where('tgl_check_in', '<=', $date->format('Y-m-d'))
                  ->where('tgl_check_out', '>', $date->format('Y-m-d'))
                  ->whereIn('status_pemesanan', ['confirmed', 'pending']);
            })->count();

            $occupancyRate = $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0;

            $occupancyData[] = [
                'date' => $date->format('Y-m-d'),
                'day_name' => $date->format('l'),
                'occupied_rooms' => $occupiedRooms,
                'total_rooms' => $totalRooms,
                'occupancy_rate' => round($occupancyRate, 2),
                'available_rooms' => $totalRooms - $occupiedRooms,
            ];
        }

        $monthlyStats = [
            'month' => $month,
            'total_rooms' => $totalRooms,
            'avg_occupancy_rate' => round(collect($occupancyData)->avg('occupancy_rate'), 2),
            'max_occupancy_rate' => round(collect($occupancyData)->max('occupancy_rate'), 2),
            'min_occupancy_rate' => round(collect($occupancyData)->min('occupancy_rate'), 2),
            'total_occupied_nights' => collect($occupancyData)->sum('occupied_rooms'),
        ];

        return response()->json([
            'period' => [
                'month' => $month,
                'year' => $year,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ],
            'daily_occupancy' => $occupancyData,
            'monthly_stats' => $monthlyStats,
        ]);
    }
}
