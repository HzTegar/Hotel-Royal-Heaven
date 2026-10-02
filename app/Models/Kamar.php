<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';
    protected $primaryKey = 'id_kamar';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'nomor_kamar',
        'id_tipe',
        'deskripsi',
        'status_ketersediaan',
        'foto_kamar',
        'foto_detail',
    ];

    protected $casts = [
        'foto_detail' => 'array',
    ];

    public function tipe()
    {
        return $this->belongsTo(TipeKamar::class, 'id_tipe', 'id_tipe');
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'id_kamar', 'id_kamar');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_kamar', 'id_kamar');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'id_kamar', 'id_kamar');
    }
}
