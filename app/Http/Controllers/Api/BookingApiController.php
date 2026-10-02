<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;

class BookingApiController extends Controller
{
    public function index(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user && ($user->role ?? '') === 'admin') {
            $q = Pemesanan::with(['user','kamar']);
        } else {
            $q = Pemesanan::with('kamar')->where('id_user', $user->id);
        }

        $list = $q->paginate(15);
        return BookingResource::collection($list)->additional(['meta' => [
            'current_page' => $list->currentPage(),
            'last_page' => $list->lastPage(),
            'per_page' => $list->perPage(),
            'total' => $list->total(),
        ]]);
    }

    public function store(StoreBookingRequest $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $data = $request->validate([
            'id_kamar' => 'required|exists:kamar,id_kamar',
            'tgl_check_in' => 'required|date',
            'tgl_check_out' => 'required|date|after:tgl_check_in',
            'pilihan_pembayaran' => 'required|string',
        ]);

        $kamar = Kamar::findOrFail($data['id_kamar']);
        $total_malam = (new \DateTime($data['tgl_check_out']))->diff(new \DateTime($data['tgl_check_in']))->days;
        $total_harga = $total_malam * ($kamar->tipe->harga_dasar ?? 0);

        $p = Pemesanan::create([
            'kode_pemesanan' => 'KD'.time().rand(100,999),
            'id_user' => $user->id,
            'id_kamar' => $kamar->id_kamar,
            'tgl_check_in' => $data['tgl_check_in'],
            'tgl_check_out' => $data['tgl_check_out'],
            'total_malam' => $total_malam,
            'total_harga' => $total_harga,
            'pilihan_pembayaran' => $data['pilihan_pembayaran'],
            'status_pemesanan' => 'pending',
            'tgl_pemesanan' => now(),
        ]);

        $kamar->status_ketersediaan = 'booked';
        $kamar->save();

        return (new BookingResource($p))->response()->setStatusCode(201);
    }

    public function show($id)
    {
        $p = Pemesanan::with(['user','kamar'])->findOrFail($id);
        $user = \Illuminate\Support\Facades\Auth::user();
        if (($user->role ?? '') !== 'admin' && $p->id_user != $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return response()->json($p);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (($user->role ?? '') !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate(['status_pemesanan' => 'required|in:pending,confirmed,cancelled,completed']);
        $p = Pemesanan::findOrFail($id);
        $p->status_pemesanan = $request->input('status_pemesanan');
        $p->save();
        return response()->json($p);
    }
}
