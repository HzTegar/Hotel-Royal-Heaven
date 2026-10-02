<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin.
     *
     * @return View
     */
    public function index(): View
    {
        // 1. Data Ringkasan (Counts)
        $totalKamar = Kamar::count();
        $kamarTersedia = Kamar::where('status_ketersediaan', 'available')->count();
        $totalPemesanan = Pemesanan::count();
        $totalMember = User::where('role', 'member')->count();

        // 2. Data Pemesanan & Pendapatan Bulanan (12 bulan mulai dari Jan 2025)
        $monthlyBookings = [];
        $monthlyRevenue = [];
        $months = [];

        // --- PERUBAHAN UTAMA DI SINI ---
        // Mulai dari 1 Januari 2025
        $current = Carbon::create(2025, 1, 1)->startOfMonth(); 
        // ---------------------------------
        
        for ($i = 0; $i < 12; $i++) {
            $year = $current->year;
            $monthNumber = $current->month;

            $monthLabel = $current->format('M Y');

            // Hitung total pemesanan untuk bulan saat ini
            $bookings = Pemesanan::whereYear('tgl_pemesanan', $year)
                                 ->whereMonth('tgl_pemesanan', $monthNumber)
                                 ->count();
            
            // Hitung total pendapatan untuk bulan saat ini
            $revenue = Pemesanan::whereYear('tgl_pemesanan', $year)
                                ->whereMonth('tgl_pemesanan', $monthNumber)
                                ->sum('total_harga');

            $monthlyBookings[] = $bookings;
            $monthlyRevenue[] = (int) $revenue;
            $months[] = $monthLabel;

            // Pindah ke bulan berikutnya
            $current = $current->addMonth();
        }

        // 3. Distribusi Status Pemesanan
        $statusCounts = Pemesanan::selectRaw('status_pemesanan, COUNT(*) as count')
                                 ->groupBy('status_pemesanan')
                                 ->pluck('count', 'status_pemesanan')
                                 ->toArray();

        // Data yang dikirim ke View
        return view('admin.dashboard.index', compact(
            'totalKamar',
            'kamarTersedia',
            'totalPemesanan',
            'totalMember',
            'monthlyBookings',
            'monthlyRevenue',
            'months',
            'statusCounts'
        ));
    }
}