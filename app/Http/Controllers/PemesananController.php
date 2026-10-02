<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Kamar;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Menggunakan Carbon secara eksplisit
use Illuminate\Support\Facades\Validator;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource for Admin.
     */
    public function index()
    {
        $pemesanans = Pemesanan::with(['user', 'kamar'])
            ->latest('tgl_pemesanan')
            ->paginate(10);

        return view('admin.pemesanan.index', compact('pemesanans'));
    }

    // Tampilkan form untuk membuat pemesanan baru
    public function create(Request $request)
    {
        $roomId = $request->query('room_id');
        $kamar = null;
        
        // Cari kamar spesifik yang tersedia berdasarkan ID dari query string
        if ($roomId) {
            $kamar = Kamar::where('id', $roomId)
                ->where('status_ketersediaan', 'available')
                ->first();
        }

        // Jika kamar spesifik tidak ditemukan atau ID tidak ada, ambil kamar tersedia pertama
        if (!$kamar) {
            $kamar = Kamar::where('status_ketersediaan', 'available')->first();
        }

        // Jika tidak ada kamar yang tersedia sama sekali
        if (!$kamar) {
            // Instead of redirect, prepare an empty rooms list and show info message in blade
            $kamars = collect(); // empty collection
            $selectedKamarId = null;

            return view('Member.pemesanan.create', [
                'kamars' => $kamars,
                'selectedKamarId' => $selectedKamarId,
                'noRoomsAvailable' => true,
            ]);
        }

        // Ambil semua kamar yang tersedia untuk form select
        $kamars = Kamar::where('status_ketersediaan', 'available')->with('tipe')->get();

        $selectedKamarId = $kamar->id;

        // View dipanggil dari resources/views/Member/pemesanan/create.blade.php
        return view('Member.pemesanan.create', [
            'kamars' => $kamars,
            'selectedKamarId' => $selectedKamarId,
        ]);
    }

    // Simpan pemesanan baru
    public function store(Request $request)
    {
        $rules = [
            'id_kamar' => 'required|exists:kamar,id',
            'tgl_check_in' => 'required|date|after_or_equal:today',
            'tgl_check_out' => 'required|date|after:tgl_check_in',
            'nama_pemesan' => 'required|string|max:255',
            'nik' => 'required|string|max:50',
            'nohp' => 'required|string|max:20',
            'pilihan_pembayaran' => 'required|in:cash,transfer,kartu_kredit',
            'catatan' => 'nullable|string|max:500'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 1. Ambil kamar dengan relasi 'tipe' untuk mengambil harga (Eager Loading)
        $kamar = Kamar::with('tipe')->findOrFail($request->id_kamar);

        // 2. Pengecekan Konflik Tanggal yang Kuat
        // Memeriksa apakah ada pemesanan 'pending' atau 'confirmed' yang bertabrakan tanggalnya
        $isConflict = Pemesanan::where('id_kamar', $request->id_kamar)
            ->whereIn('status_pemesanan', ['pending', 'confirmed']) 
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('tgl_check_in', '<', $request->tgl_check_out)
                      ->where('tgl_check_out', '>', $request->tgl_check_in);
                });
            })
            ->exists();

        if ($isConflict) {
            return redirect()->back()->with('error', 'Kamar ini sudah dipesan untuk tanggal tersebut.');
        }
        
        $checkIn = Carbon::parse($request->tgl_check_in);
        $checkOut = Carbon::parse($request->tgl_check_out);
        $totalMalam = $checkIn->diffInDays($checkOut);

        // Akses harga melalui relasi 'tipe'
        $hargaPerMalam = $kamar->tipe->harga_dasar ?? $kamar->harga ?? 0; 
        $totalHarga = $hargaPerMalam * $totalMalam;

        $kodePemesanan = 'INV'.strtoupper(uniqid());

        // Membuat objek pemesanan
        $pemesanan = new Pemesanan();
        $pemesanan->id_user = Auth::id();
        $pemesanan->id_kamar = $kamar->id;
        $pemesanan->kode_pemesanan = $kodePemesanan;
        $pemesanan->tgl_pemesanan = now();
        $pemesanan->tgl_check_in = $checkIn;
        $pemesanan->tgl_check_out = $checkOut;
        $pemesanan->total_malam = $totalMalam;
        $pemesanan->total_harga = $totalHarga;
        $pemesanan->nama_pemesan = $request->nama_pemesan;
        $pemesanan->nik = $request->nik;
        $pemesanan->nohp = $request->nohp;
        $pemesanan->pilihan_pembayaran = $request->pilihan_pembayaran;
        $pemesanan->catatan = $request->catatan;
        $pemesanan->status_pemesanan = 'pending';
        $pemesanan->payment_status = 'pending';

        // Simpan pemesanan
        $pemesanan->save();

        // ⚠️ LOGIKA STATUS KAMAR BERDASARKAN KETERSEDIAAN DIHAPUS 
        // Karena ketersediaan ditangani oleh pengecekan konflik tanggal yang lebih kuat di atas.

        // Generate Midtrans Snap Token jika pilihan pembayaran bukan tunai
        $snapToken = null;
        if ($pemesanan->pilihan_pembayaran != 'cash') {
            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $pemesanan->kode_pemesanan,
                    'gross_amount' => $pemesanan->total_harga,
                ],
                'customer_details' => [
                    'first_name' => $pemesanan->nama_pemesan,
                    'email' => Auth::user()->email,
                    'phone' => $pemesanan->nohp,
                ],
                'enabled_payments' => ['credit_card', 'bank_transfer'],
                'vtweb' => []
            ];

            try {
                \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
                \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                $snapToken = \Midtrans\Snap::getSnapToken($midtransParams);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Payment gateway error: ' . $e->getMessage());
            }
        }

        if ($snapToken) {
            // View pemesanan.payment (kemungkinan di resources/views/pemesanan/payment.blade.php)
            return view('pemesanan.payment', [
                'pemesanan' => $pemesanan,
                'snapToken' => $snapToken,
            ]);
        } else {
            // Untuk pembayaran tunai, redirect ke daftar pemesanan pengguna
            return redirect()->route('pemesanan.my')->with('success', 'Pemesanan berhasil dibuat. Silakan lakukan pembayaran tunai saat check-in.');
        }
    }

    // Daftar pemesanan pengguna
    public function myBookings()
    {
        $userId = Auth::id();
        $pemesanan = Pemesanan::where('id_user', $userId)
            ->with('kamar') // Eager load kamar untuk tampilan
            ->orderBy('tgl_pemesanan', 'desc')
            ->paginate(10);

        // Ambil ID kamar yang sudah di-review oleh pengguna
        $reviewedKamarIds = Review::where('id_user', $userId)->pluck('id_kamar')->toArray();

        // 3. Panggilan view yang dikoreksi (resources/views/member/pemesanan/my.blade.php)
        return view('member.pemesanan.my', compact('pemesanan', 'reviewedKamarIds')); 
    }

    // Tampilkan detail pemesanan
    public function show(Pemesanan $pemesanan)
    {
        // Pengecekan otorisasi menggunakan Policy
        $this->authorize('view', $pemesanan); 

        // View pemesanan.show (kemungkinan di resources/views/pemesanan/show.blade.php atau member/pemesanan/show.blade.php)
        return view('member.pemesanan.show', compact('pemesanan'));
    }

    // Batalkan pemesanan
    public function cancelBooking(Pemesanan $pemesanan)
    {
        $this->authorize('cancel', $pemesanan);

        if ($pemesanan->status_pemesanan != 'pending') {
            return redirect()->back()->with('error', 'Pemesanan tidak bisa dibatalkan selain status pending.');
        }

        $pemesanan->status_pemesanan = 'cancelled';
        $pemesanan->payment_status = 'failed';
        $pemesanan->save();

        // Ubah status ketersediaan kamar kembali ke 'available'
        if ($pemesanan->kamar) {
            $pemesanan->kamar->status_ketersediaan = 'available';
            $pemesanan->kamar->save();
        }

        return redirect()->route('pemesanan.my')->with('success', 'Pemesanan berhasil dibatalkan.');
    }

    // Admin update booking status
    public function updateStatus(Request $request, Pemesanan $pemesanan)
    {
        $request->validate([
            'status_pemesanan' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $pemesanan->status_pemesanan = $request->status_pemesanan;

        if ($request->status_pemesanan == 'cancelled') {
            $pemesanan->payment_status = 'failed';

            // Make room available
            if ($pemesanan->kamar) {
                $pemesanan->kamar->status_ketersediaan = 'available';
                $pemesanan->kamar->save();
            }
        } elseif ($request->status_pemesanan == 'confirmed') {
            $pemesanan->payment_status = 'paid';
        }

        $pemesanan->save();

        return redirect()->back()->with('success', 'Status pemesanan berhasil diperbarui.');
    }

    /**
     * Handle Midtrans payment notification webhook callback
     */
    public function midtransNotification(Request $request)
    {
        // Configure Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $notif = new \Midtrans\Notification();

        // Get order_id from Midtrans notification
        $orderId = $notif->order_id ?? null;
        $transactionStatus = $notif->transaction_status ?? null;
        $fraudStatus = $notif->fraud_status ?? null;
        $paymentType = $notif->payment_type ?? null;

        if (!$orderId) {
            return response('Invalid notification', 400);
        }

        // Find the booking record
        $pemesanan = Pemesanan::where('kode_pemesanan', $orderId)->first();

        if (!$pemesanan) {
            return response('Booking not found', 404);
        }

        // Update booking status based on Midtrans transaction status
        if ($transactionStatus == 'capture') {
            if ($paymentType == 'credit_card') {
                if ($fraudStatus == 'challenge') {
                    // Payment challenge
                    $pemesanan->payment_status = 'challenge';
                    $pemesanan->status_pemesanan = 'pending';
                } else {
                    // Payment success
                    $pemesanan->payment_status = 'paid';
                    $pemesanan->status_pemesanan = 'confirmed';
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            // Payment success
            $pemesanan->payment_status = 'paid';
            $pemesanan->status_pemesanan = 'confirmed';
        } elseif ($transactionStatus == 'pending') {
            $pemesanan->payment_status = 'pending';
            $pemesanan->status_pemesanan = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $pemesanan->payment_status = 'failed';
            $pemesanan->status_pemesanan = 'cancelled';

            // Mark room as available again
            if ($pemesanan->kamar) {
                $pemesanan->kamar->status_ketersediaan = 'available';
                $pemesanan->kamar->save();
            }
        }

        $pemesanan->save();

        return response('OK', 200);
    }
}