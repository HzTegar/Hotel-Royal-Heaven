<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_kamar' => $this->id_kamar,
            'nomor_kamar' => $this->nomor_kamar,
            'tipe' => $this->tipe ? [
                'id_tipe' => $this->tipe->id_tipe,
                'nama_tipe' => $this->tipe->nama_tipe,
                'harga_dasar' => $this->tipe->harga_dasar,
            ] : null,
            'deskripsi' => $this->deskripsi,
            'status_ketersediaan' => $this->status_ketersediaan,
        ];
    }
}
