<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    // List all pemesanan (admin only)
    public function index()
    {
        $pemesanan = Pemesanan::with(['user', 'kamar'])->latest('tgl_pemesanan')->paginate(6);
        return view('admin.pemesanan.index', compact('pemesanan'));
    }

    // Show pemesanan detail
    public function show(Pemesanan $pemesanan)
    {
        return view('admin.pemesanan.show', compact('pemesanan'));
    }

    // Update status (admin only)
    public function updateStatus(Request $request, Pemesanan $pemesanan)
    {
        $request->validate(['status_pemesanan' => 'required|in:pending,confirmed,cancelled,completed']);

        $oldStatus = $pemesanan->status_pemesanan;
        $newStatus = $request->input('status_pemesanan');

        $pemesanan->status_pemesanan = $newStatus;
        $pemesanan->save();

        // Update room availability based on booking status
        if ($pemesanan->kamar) {
            if ($newStatus == 'confirmed') {
                // When confirmed, room becomes unavailable
                $pemesanan->kamar->status_ketersediaan = 'booked';
                $pemesanan->kamar->save();
            } elseif ($newStatus == 'cancelled') {
                // When cancelled, room becomes available again
                $pemesanan->kamar->status_ketersediaan = 'available';
                $pemesanan->kamar->save();
            } elseif ($newStatus == 'completed') {
                // When completed, room becomes available again
                $pemesanan->kamar->status_ketersediaan = 'available';
                $pemesanan->kamar->save();
            }
        }

        // Send email notification to member
        try {
            \Mail::to($pemesanan->user->email)->send(new \App\Mail\BookingStatusUpdate($pemesanan, $oldStatus, $newStatus));
        } catch (\Exception $e) {
            // Log error but don't fail the status update
            \Log::error('Failed to send booking status update email: ' . $e->getMessage());
        }

        return back()->with('success', 'Status pemesanan berhasil diperbarui.');
    }

    // Confirm cash payment (admin only)
    public function confirmCashPayment(Pemesanan $pemesanan)
    {
        // Check if booking uses cash payment
        if ($pemesanan->pilihan_pembayaran !== 'cash') {
            return back()->with('error', 'Pembayaran ini bukan menggunakan metode cash.');
        }

        // Check if payment is still pending
        if ($pemesanan->payment_status !== 'pending') {
            return back()->with('error', 'Status pembayaran sudah dikonfirmasi atau dibatalkan.');
        }

        // Use PaymentService to confirm cash payment
        $paymentService = app(\App\Services\PaymentService::class);
        $result = $paymentService->confirmCashPayment($pemesanan);

        if ($result) {
            return back()->with('success', 'Pembayaran cash berhasil dikonfirmasi.');
        } else {
            return back()->with('error', 'Gagal mengkonfirmasi pembayaran cash.');
        }
    }
}
