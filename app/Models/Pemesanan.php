<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_pemesanan
 * @property int $id_user
 * @property int $id_kamar
 * @property string $kode_pemesanan
 * @property \Illuminate\Support\Carbon $tgl_pemesanan
 * @property \Illuminate\Support\Carbon $tgl_check_in
 * @property \Illuminate\Support\Carbon $tgl_check_out
 * @property int $total_malam
 * @property float $total_harga
 * @property string $nama_pemesan
 * @property string $nik
 * @property string $nohp
 * @property string $pilihan_pembayaran
 * @property string|null $catatan
 * @property string $status_pemesanan
 * @property string $payment_status
 * @property \App\Models\User $user
 * @property \App\Models\Kamar $kamar
 */
class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    public $incrementing = true;
    public $timestamps = false;

    protected $casts = [
        'tgl_check_in' => 'date',
        'tgl_check_out' => 'date',
        'tgl_pemesanan' => 'datetime',
    ];

    protected $fillable = [
        'kode_pemesanan',
        'id_user',
        'id_kamar',
        'nama_pemesan',
        'nik',
        'nohp',
        'tgl_check_in',
        'tgl_check_out',
        'total_malam',
        'total_harga',
        'pilihan_pembayaran',
        'catatan',
        'status_pemesanan',
        'payment_status',
        'midtrans_transaction_id',
        'payment_url',
        'tgl_pemesanan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'pemesanan_id', 'id_pemesanan');
    }
}
