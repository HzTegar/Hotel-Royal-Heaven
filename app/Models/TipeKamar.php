<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeKamar extends Model
{
    use HasFactory;

    protected $table = 'tipe_kamar';
    protected $primaryKey = 'id_tipe';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'nama_tipe',
        'harga_dasar',
        'max_tamu',
    ];

    public function kamars()
    {
        return $this->hasMany(Kamar::class, 'id_tipe', 'id_tipe');
    }
}
