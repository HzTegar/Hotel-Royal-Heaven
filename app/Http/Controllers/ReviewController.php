<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pemesanan;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the user's reviews.
     */
    public function index()
    {
        // Get reviews only for rooms where user has completed or cancelled bookings
        $reviews = Review::where('id_user', Auth::id())
            ->whereHas('kamar.pemesanan', function($query) {
                $query->where('id_user', Auth::id())
                      ->whereIn('status_pemesanan', ['completed', 'cancelled']);
            })
            ->with(['kamar.tipe'])
            ->latest()
            ->paginate(10);

        return view('member.reviews.index', compact('reviews'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required|exists:kamar,id_kamar',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $id_kamar = $request->input('id_kamar');
        $id_user = Auth::id();

        // Cek apakah user memiliki pemesanan yang sudah selesai atau dibatalkan untuk kamar ini
        $hasValidBooking = Pemesanan::where('id_user', $id_user)
            ->where('id_kamar', $id_kamar)
            ->whereIn('status_pemesanan', ['completed', 'cancelled'])
            ->exists();

        if (!$hasValidBooking) {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan review untuk pemesanan yang sudah selesai atau dibatalkan.');
        }

        // Cek apakah user sudah pernah mereview kamar ini
        $alreadyReviewed = Review::where('id_user', $id_user)
            ->where('id_kamar', $id_kamar)
            ->exists();

        if ($alreadyReviewed) {
             return redirect()->back()->with('error', 'Anda sudah pernah memberikan review untuk kamar ini.');
        }

        Review::create([
            'id_user' => $id_user,
            'id_kamar' => $id_kamar,
            'rating' => $request->input('rating'),
            'komentar' => $request->input('komentar'),
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas review Anda!');
    }
}
