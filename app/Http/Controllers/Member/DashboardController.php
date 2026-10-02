<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Pemesanan;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get booking statistics
        $totalBookings = $user->pemesanan()->count();
        $completedBookings = $user->pemesanan()->where('status_pemesanan', 'completed')->count();
        $pendingBookings = $user->pemesanan()->where('status_pemesanan', 'pending')->count();
        $confirmedBookings = $user->pemesanan()->where('status_pemesanan', 'confirmed')->count();

        // Get recent reviews (last 5)
        $recentReviews = Review::where('id_user', $user->id)
            ->with(['kamar.tipe'])
            ->latest()
            ->take(5)
            ->get();

        // Get wishlist summary
        $wishlistCount = Wishlist::where('id_user', $user->id)->count();
        $wishlistItems = Wishlist::where('id_user', $user->id)
            ->with(['kamar.tipe'])
            ->latest()
            ->take(3)
            ->get();

        // Get recent bookings (last 3)
        $recentBookings = $user->pemesanan()
            ->with('kamar.tipe')
            ->latest('tgl_pemesanan')
            ->take(3)
            ->get();

        return view('member.dashboard', compact(
            'totalBookings',
            'completedBookings',
            'pendingBookings',
            'confirmedBookings',
            'recentReviews',
            'wishlistCount',
            'wishlistItems',
            'recentBookings'
        ));
    }
}
