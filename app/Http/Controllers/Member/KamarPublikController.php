<?php

namespace App\Http\Controllers\Member; // Namespace tetap

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KamarPublikController extends Controller // <<< Perubahan NAMA CLASS
{
    /**
     * Tampilkan halaman landing/utama dengan kamar unggulan (Public Route: /).
     */
    public function landing(): View
    {
        $featured_kamar = kamar::where('status_ketersediaan', 'available')
                               ->with('tipe')
                               ->inRandomOrder()
                               ->limit(4)
                               ->get();

        // Get recent reviews for testimonials section
        $recent_reviews = \App\Models\Review::with(['user', 'kamar'])
                                           ->whereHas('user', function($query) {
                                               $query->where('role', 'member');
                                           })
                                           ->latest()
                                           ->limit(3)
                                           ->get();

        return view('home', [
            'featured_kamar' => $featured_kamar,
            'recent_reviews' => $recent_reviews
        ]);
    }

    /**
     * Tampilkan daftar semua kamar (Public Route: /daftarkamar, Member Route: /member/kamar).
     */
    public function index(Request $request): View
    {
        $query = kamar::with('tipe')->where('status_ketersediaan', 'available');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_kamar', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhereHas('tipe', function ($q) use ($search) {
                      $q->where('nama_tipe', 'like', '%' . $search . '%');
                  });
            });
        }

        // Apply room type filter
        if ($request->filled('tipe_kamar')) {
            $query->where('id_tipe', $request->tipe_kamar);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status_ketersediaan', $request->status);
        }

        // Apply price range filters
        if ($request->filled('harga_min')) {
            $query->whereHas('tipe', function ($q) use ($request) {
                $q->where('harga_dasar', '>=', $request->harga_min);
            });
        }

        if ($request->filled('harga_max')) {
            $query->whereHas('tipe', function ($q) use ($request) {
                $q->where('harga_dasar', '<=', $request->harga_max);
            });
        }

        // Apply sorting
        $sort = $request->get('sort', 'recommendation');
        switch ($sort) {
            case 'price_low':
                $query->join('tipe_kamar', 'kamar.id_tipe', '=', 'tipe_kamar.id_tipe')
                      ->orderBy('tipe_kamar.harga_dasar', 'asc')
                      ->select('kamar.*');
                break;
            case 'price_high':
                $query->join('tipe_kamar', 'kamar.id_tipe', '=', 'tipe_kamar.id_tipe')
                      ->orderBy('tipe_kamar.harga_dasar', 'desc')
                      ->select('kamar.*');
                break;
            case 'rating':
                $query->leftJoin('reviews', 'kamar.id_kamar', '=', 'reviews.id_kamar')
                      ->select('kamar.*', \DB::raw('AVG(reviews.rating) as avg_rating'))
                      ->groupBy('kamar.id_kamar')
                      ->orderBy('avg_rating', 'desc');
                break;
            case 'newest':
                $query->orderBy('kamar.created_at', 'desc');
                break;
            case 'recommendation':
            default:
                $query->orderBy('kamar.created_at', 'desc');
                break;
        }

        $kamars = $query->paginate(10)->withQueryString();
        $tipekamars = \App\Models\Tipekamar::whereHas('kamars', function ($q) {
            $q->where('status_ketersediaan', 'available');
        })->get();

        // Check if this is member route
        if ($request->is('member/kamar')) {
            return view('member.kamar.index', compact('kamars', 'tipekamars'));
        }

        return view('kamar.index', compact('kamars', 'tipekamars'));
    }

    /**
     * Tampilkan detail kamar.
     */
    public function show(kamar $kamar)
    {
        $kamar->load('tipe');

        // Load reviews with user information
        $reviews = $kamar->reviews()->with('user')->latest()->paginate(5);

        // Calculate average rating
        $averageRating = $kamar->reviews()->avg('rating') ?? 0;
        $totalReviews = $kamar->reviews()->count();

        // Check if authenticated user can review this room
        $canReview = false;
        if (Auth::check() && Auth::user()->role === 'member') {
            $userId = Auth::id();
            $canReview = !\App\Models\Review::where('id_user', $userId)
                ->where('id_kamar', $kamar->id_kamar)
                ->exists();
        }

        // Check if room is in user's wishlist
        $inWishlist = false;
        if (Auth::check() && Auth::user()->role === 'member') {
            $inWishlist = \App\Models\Wishlist::where('id_user', Auth::id())
                ->where('id_kamar', $kamar->id_kamar)
                ->exists();
        }

        return view('kamar.show', compact('kamar', 'reviews', 'averageRating', 'totalReviews', 'canReview', 'inWishlist'))->with('hideNavbar', true);
    }
}
