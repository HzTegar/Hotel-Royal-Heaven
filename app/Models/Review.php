<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'id_review';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_kamar',
        'rating',
        'komentar',
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
