<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'kamar']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('user', function($userQuery) use ($request) {
                    $userQuery->where('nama_lengkap', 'like', '%'.$request->input('search').'%')
                              ->orWhere('email', 'like', '%'.$request->input('search').'%');
                })
                ->orWhere('komentar', 'like', '%'.$request->input('search').'%');
            });
        }

        $reviews = $query->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $review->load(['user', 'kamar']);
        return view('admin.reviews.show', compact('review'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review berhasil dihapus');
    }
}
