<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kamar;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingForm extends Component
{
    public $kamars;
    public $selectedKamarId;
    public $tgl_check_in;
    public $tgl_check_out;
    public $nama;
    public $nik;
    public $nohp;
    public $pilihan_pembayaran;
    public $catatan;

    public $total_malam = 0;
    public $total_harga = 0;

    protected $rules = [
        'selectedKamarId' => 'required|exists:kamar,id_kamar',
        'tgl_check_in' => 'required|date|after_or_equal:today',
        'tgl_check_out' => 'required|date|after:tgl_check_in',
        'nama' => 'required|string|max:150',
        'nik' => 'required|string|max:20',
        'nohp' => 'required|string|max:15',
        'pilihan_pembayaran' => 'required|in:cash,transfer,kartu_kredit',
        'catatan' => 'nullable|string|max:500',
    ];

    public function mount($selectedKamarId = null)
    {
        $this->kamars = Kamar::with('tipe')->where('status_ketersediaan', 'available')->get();
        $this->selectedKamarId = $selectedKamarId;

        $user = Auth::user();
        if ($user) {
            $this->nama = $user->nama_lengkap;
            $this->nik = $user->nik;
            $this->nohp = $user->nohp;
        }

        if ($this->selectedKamarId) {
            $this->calculateTotal();
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if (in_array($propertyName, ['selectedKamarId', 'tgl_check_in', 'tgl_check_out'])) {
            $this->calculateTotal();
        }
    }

    public function setSelectedRoom($kamarId)
    {
        $this->selectedKamarId = $kamarId;
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        if ($this->selectedKamarId && $this->tgl_check_in && $this->tgl_check_out) {
            $checkIn = Carbon::parse($this->tgl_check_in);
            $checkOut = Carbon::parse($this->tgl_check_out);

            if ($checkOut > $checkIn) {
                $this->total_malam = $checkIn->diffInDays($checkOut);
                $kamar = Kamar::with('tipe')->find($this->selectedKamarId);
                if ($kamar) {
                    $this->total_harga = $this->total_malam * $kamar->tipe->harga_dasar;
                }
            } else {
                $this->total_malam = 0;
                $this->total_harga = 0;
            }
        }
    }

    public function submit()
    {
        $this->validate();

        $user = Auth::user();
        $kamar = Kamar::find($this->selectedKamarId);

        // Update user data
        $user->update([
            'nama_lengkap' => $this->nama,
            'nik' => $this->nik,
            'nohp' => $this->nohp,
        ]);

        $pemesanan = Pemesanan::create([
            'kode_pemesanan' => 'KD' . date('YmdHis') . rand(100, 999),
            'id_user' => $user->id,
            'id_kamar' => $kamar->id_kamar,
            'nama_pemesan' => $this->nama,
            'nik' => $this->nik,
            'nohp' => $this->nohp,
            'tgl_check_in' => $this->tgl_check_in,
            'tgl_check_out' => $this->tgl_check_out,
            'total_malam' => $this->total_malam,
            'total_harga' => $this->total_harga,
            'pilihan_pembayaran' => $this->pilihan_pembayaran,
            'catatan' => $this->catatan,
            'status_pemesanan' => 'pending',
            'payment_status' => 'pending',
            'tgl_pemesanan' => now(),
        ]);

        // Mark kamar as booked
        $kamar->status_ketersediaan = 'booked';
        $kamar->save();

        session()->flash('success', 'Pemesanan berhasil dibuat. Kode: ' . $pemesanan->kode_pemesanan);

        // Emit event to close modal and redirect
        $this->dispatch('booking-success');
        return redirect()->route('member.pemesanan.my');
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
