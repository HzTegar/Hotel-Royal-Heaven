<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Kamar;
use App\Models\Review;
use App\Services\PaymentService;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mail;

class PemesananController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    // Member's bookings
    public function myBookings(Request $request)
    {
        $user = Auth::user();
        $query = $user->pemesanan()->with('kamar');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_pemesanan', 'like', '%' . $search . '%')
                  ->orWhere('nama_pemesan', 'like', '%' . $search . '%')
                  ->orWhereHas('kamar', function($kamarQuery) use ($search) {
                      $kamarQuery->where('nomor_kamar', 'like', '%' . $search . '%')
                                ->orWhereHas('tipe', function($tipeQuery) use ($search) {
                                    $tipeQuery->where('nama_tipe', 'like', '%' . $search . '%');
                                });
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $status = $request->status;
            if ($status === 'upcoming') {
                $query->where('status_pemesanan', 'confirmed')
                      ->where('tgl_check_in', '>', now());
            } elseif ($status === 'completed') {
                $query->where('status_pemesanan', 'completed');
            } elseif ($status === 'cancelled') {
                $query->where('status_pemesanan', 'cancelled');
            } elseif ($status === 'pending') {
                $query->where('status_pemesanan', 'pending');
            }
        }

        $pemesanan = $query->latest('tgl_pemesanan')->paginate(10)->withQueryString();

        // Get IDs of rooms that the user has already reviewed
        $reviewedKamarIds = Review::where('id_user', $user->id)
            ->pluck('id_kamar')
            ->toArray();

        return view('member.pemesanan.my', compact('pemesanan', 'reviewedKamarIds'));
    }

    // Store pemesanan
    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();

        $user = Auth::user();
        $kamar = Kamar::findOrFail($data['id_kamar']);
        
        $tgl_check_in = new \DateTime($data['tgl_check_in']);
        $tgl_check_out = new \DateTime($data['tgl_check_out']);
        $total_malam = $tgl_check_out->diff($tgl_check_in)->days;
        $total_harga = $total_malam * ($kamar->tipe->harga_dasar ?? 0);

        // Update user profile with booking information
        $user->update([
            'nama_lengkap' => $data['nama'],
            'nik' => $data['nik'],
            'nohp' => $data['nohp'],
        ]);

        $pemesanan = Pemesanan::create([
            'kode_pemesanan' => 'KD' . date('YmdHis') . rand(100, 999),
            'id_user' => $user->id,
            'id_kamar' => $kamar->id_kamar,
            'nama_pemesan' => $data['nama'],
            'nik' => $data['nik'],
            'nohp' => $data['nohp'],
            'tgl_check_in' => $data['tgl_check_in'],
            'tgl_check_out' => $data['tgl_check_out'],
            'total_malam' => $total_malam,
            'total_harga' => $total_harga,
            'pilihan_pembayaran' => $data['pilihan_pembayaran'],
            'catatan' => $data['catatan'] ?? null,
            'status_pemesanan' => 'pending',
            'payment_status' => 'pending',
            'tgl_pemesanan' => now(),
        ]);

        // Create payment record
        $this->paymentService->createPayment($pemesanan, $data['pilihan_pembayaran']);

        // Send booking confirmation email
        try {
            \Mail::to($user->email)->send(new \App\Mail\BookingConfirmation($pemesanan));
        } catch (\Exception $e) {
            // Log error but don't fail the booking creation
            Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
        }

        return redirect()->route('member.pemesanan.my')->with('success', 'Pemesanan berhasil dibuat. Kode pemesanan: ' . $pemesanan->kode_pemesanan);
    }

    // Show pemesanan detail
    public function show(Pemesanan $pemesanan)
    {
        $user = Auth::user();
        if ($pemesanan->id_user != $user->id) {
            abort(403);
        }
        return view('member.pemesanan.show', compact('pemesanan'));
    }

    // Cancel pemesanan
    public function cancelBooking(Pemesanan $pemesanan)
    {
        $user = Auth::user();
        if ($pemesanan->id_user != $user->id) {
            abort(403);
        }

        // Only allow cancellation if status is pending
        if ($pemesanan->status_pemesanan !== 'pending') {
            return back()->with('error', 'Pemesanan tidak dapat dibatalkan karena sudah dikonfirmasi atau selesai.');
        }

        // Update status to cancelled
        $pemesanan->status_pemesanan = 'cancelled';
        $pemesanan->save();

        // Mark kamar as available again
        if ($pemesanan->kamar) {
            $pemesanan->kamar->status_ketersediaan = 'available';
            $pemesanan->kamar->save();
        }

        return back()->with('success', 'Pemesanan berhasil dibatalkan.');
    }
}
