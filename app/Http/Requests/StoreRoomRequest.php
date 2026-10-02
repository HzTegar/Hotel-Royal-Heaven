<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nomor_kamar' => 'required|string|unique:kamar,nomor_kamar',
            'id_tipe' => 'required|exists:tipe_kamar,id_tipe',
            'deskripsi' => 'nullable|string',
            'status_ketersediaan' => 'required|in:available,booked,maintenance',
        ];
    }
}
