<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlists';
    protected $primaryKey = 'id_wishlist';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_kamar',
        'created_at',
    ];

    protected $dates = ['created_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }
}
