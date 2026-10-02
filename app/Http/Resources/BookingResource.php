<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_pemesanan' => $this->id_pemesanan,
            'kode_pemesanan' => $this->kode_pemesanan,
            'user' => $this->user ? [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'nama_lengkap' => $this->user->nama_lengkap,
            ] : null,
            'kamar' => $this->kamar ? [
                'id_kamar' => $this->kamar->id_kamar,
                'nomor_kamar' => $this->kamar->nomor_kamar,
            ] : null,
            'tgl_check_in' => $this->tgl_check_in,
            'tgl_check_out' => $this->tgl_check_out,
            'total_malam' => $this->total_malam,
            'total_harga' => $this->total_harga,
            'pilihan_pembayaran' => $this->pilihan_pembayaran,
            'status_pemesanan' => $this->status_pemesanan,
            'tgl_pemesanan' => $this->tgl_pemesanan,
        ];
    }
}
