<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\TipeKamar;
use App\Models\Kamar;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Calendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $monthName;
    public $selectedRoomType = '';
    public $viewMode = 'month';
    public $selectedBooking = null;

    public function mount()
    {
        $now = now();
        $this->currentMonth = $now->month;
        $this->currentYear = $now->year;
        $this->monthName = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->format('F Y');
    }

    public function goToToday()
    {
        $now = now();
        $this->currentMonth = $now->month;
        $this->currentYear = $now->year;
        $this->monthName = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->format('F Y');
    }

    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->monthName = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->format('F Y');
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->monthName = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->format('F Y');
    }

    public function selectBooking($bookingId)
    {
        $this->selectedBooking = Pemesanan::with(['user', 'kamar.tipe'])->find($bookingId);
    }

    public function closeBookingModal()
    {
        $this->selectedBooking = null;
    }



    public function getRoomTypesProperty()
    {
        return TipeKamar::all();
    }

    public function getCalendarDataProperty()
    {
        $startDate = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $query = Kamar::with(['tipe', 'pemesanans' => function ($query) use ($startDate, $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tgl_check_in', [$startDate, $endDate])
                  ->orWhereBetween('tgl_check_out', [$startDate, $endDate])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('tgl_check_in', '<=', $startDate)
                         ->where('tgl_check_out', '>=', $endDate);
                  });
            })->whereIn('status_pemesanan', ['confirmed', 'pending']);
        }]);

        if ($this->selectedRoomType) {
            $query->where('id_tipe', $this->selectedRoomType);
        }

        $rooms = $query->get();

        return $rooms->map(function ($room) use ($startDate, $endDate) {
            $daysInMonth = $startDate->daysInMonth;
            $days = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = Carbon::createFromDate($this->currentYear, $this->currentMonth, $day);
                $isToday = $currentDate->isToday();

                $bookingsForDay = $room->pemesanans->filter(function ($booking) use ($currentDate) {
                    $checkIn = Carbon::parse($booking->tgl_check_in);
                    $checkOut = Carbon::parse($booking->tgl_check_out)->subDay(); // Check-out day is not occupied

                    return $currentDate->between($checkIn, $checkOut);
                });

                $days[] = [
                    'day' => $day,
                    'is_today' => $isToday,
                    'bookings' => $bookingsForDay->map(function ($booking) {
                        return [
                            'id' => $booking->id_pemesanan,
                            'customer' => $booking->user->nama_lengkap ?? $booking->user->username,
                            'kode_pemesanan' => $booking->kode_pemesanan,
                            'status' => $booking->status_pemesanan,
                        ];
                    })->values()->all(),
                ];
            }

            return [
                'id_kamar' => $room->id_kamar,
                'nomor_kamar' => $room->nomor_kamar,
                'tipe_kamar' => $room->tipe->nama_tipe,
                'status_ketersediaan' => $room->status_ketersediaan,
                'days' => $days,
            ];
        });
    }

    public function render()
    {
        return view('livewire.admin.calendar', [
            'roomTypes' => $this->getRoomTypesProperty(),
            'calendarData' => $this->getCalendarDataProperty(),
        ]);
    }
}
