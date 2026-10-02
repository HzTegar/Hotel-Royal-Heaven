<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the member's wishlist.
     */
    public function index(Request $request)
    {
        // The filtering logic is now handled by the WishlistFilter Livewire component
        // This controller method is kept for backward compatibility and routing
        return view('member.wishlist.index');
    }

    /**
     * Add a room to the wishlist.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required|exists:kamar,id_kamar',
        ]);

        $id_kamar = $request->input('id_kamar');
        $id_user = Auth::id();

        // Check if already in wishlist
        $exists = Wishlist::where('id_user', $id_user)
            ->where('id_kamar', $id_kamar)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar sudah ada di wishlist Anda.'
            ]);
        }

        Wishlist::create([
            'id_user' => $id_user,
            'id_kamar' => $id_kamar,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kamar berhasil ditambahkan ke wishlist.'
        ]);
    }

    /**
     * Remove a room from the wishlist.
     */
    public function destroy($id_kamar)
    {
        $wishlist = Wishlist::where('id_user', Auth::id())
            ->where('id_kamar', $id_kamar)
            ->first();

        if (!$wishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar tidak ditemukan di wishlist Anda.'
            ]);
        }

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kamar berhasil dihapus dari wishlist.'
        ]);
    }

    /**
     * Check if a room is in the user's wishlist.
     */
    public function check($id_kamar)
    {
        $exists = Wishlist::where('id_user', Auth::id())
            ->where('id_kamar', $id_kamar)
            ->exists();

        return response()->json([
            'in_wishlist' => $exists
        ]);
    }
}
