<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_kamar' => [
                'required',
                'integer',
                'exists:kamar,id_kamar',
                function ($attribute, $value, $fail) {
                    $kamar = \App\Models\Kamar::find($value);
                    if ($kamar && $kamar->status_ketersediaan !== 'available') {
                        $fail('Kamar yang dipilih tidak tersedia untuk dipesan.');
                    }
                },
            ],
            'nik' => [
                'required',
                'string',
                'regex:/^[0-9]{16}$/',
                'max:20'
            ],
            'nama' => [
                'required',
                'string',
                'min:2',
                'max:150',
                'regex:/^[\p{L}\s\-\.\']+$/u'
            ],
            'nohp' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)[8-9][0-9]{7,11}$/',
                'max:15'
            ],
            'tgl_check_in' => [
                'required',
                'date',
                'after:today',
                'before:tgl_check_out'
            ],
            'tgl_check_out' => [
                'required',
                'date',
                'after:tgl_check_in'
            ],
            'pilihan_pembayaran' => [
                'required',
                Rule::in(['cash', 'transfer', 'kartu_kredit'])
            ],
            'catatan' => [
                'nullable',
                'string',
                'max:500'
            ]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'id_kamar' => 'kamar',
            'nik' => 'NIK',
            'nama' => 'nama lengkap',
            'nohp' => 'nomor telepon',
            'tgl_check_in' => 'tanggal check-in',
            'tgl_check_out' => 'tanggal check-out',
            'pilihan_pembayaran' => 'metode pembayaran',
            'catatan' => 'catatan tambahan'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nik.regex' => 'NIK harus berupa 16 digit angka.',
            'nama.regex' => 'Nama hanya boleh berisi huruf, spasi, tanda hubung, titik, dan apostrof.',
            'nama.min' => 'Nama minimal harus 2 karakter.',
            'nohp.regex' => 'Format nomor telepon tidak valid. Gunakan format Indonesia (contoh: 08123456789).',
            'tgl_check_in.after' => 'Tanggal check-in harus setelah hari ini.',
            'tgl_check_in.before' => 'Tanggal check-in harus sebelum tanggal check-out.',
            'tgl_check_out.after' => 'Tanggal check-out harus setelah tanggal check-in.',
            'pilihan_pembayaran.in' => 'Metode pembayaran yang dipilih tidak valid.',
            'catatan.max' => 'Catatan tambahan maksimal 500 karakter.'
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $checkIn = Carbon::parse($this->tgl_check_in);
            $checkOut = Carbon::parse($this->tgl_check_out);
            $days = $checkIn->diffInDays($checkOut);

            if ($days > 30) {
                $validator->errors()->add('tgl_check_out', 'Maksimal durasi menginap adalah 30 hari.');
            }

            if ($days < 1) {
                $validator->errors()->add('tgl_check_out', 'Minimal durasi menginap adalah 1 hari.');
            }

            // Check if room is available for the selected dates
            if ($this->id_kamar) {
                $existingBookings = \App\Models\Pemesanan::where('id_kamar', $this->id_kamar)
                    ->where('status_pemesanan', '!=', 'cancelled')
                    ->where(function ($query) use ($checkIn, $checkOut) {
                        $query->whereBetween('tgl_check_in', [$checkIn, $checkOut])
                              ->orWhereBetween('tgl_check_out', [$checkIn, $checkOut])
                              ->orWhere(function ($q) use ($checkIn, $checkOut) {
                                  $q->where('tgl_check_in', '<=', $checkIn)
                                    ->where('tgl_check_out', '>=', $checkOut);
                              });
                    })
                    ->exists();

                if ($existingBookings) {
                    $validator->errors()->add('id_kamar', 'Kamar tidak tersedia untuk tanggal yang dipilih.');
                }
            }
        });
    }
}
