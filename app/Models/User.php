<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public $timestamps = false;
    protected $fillable = [
        'username',
        'email',
        'password',
        'nama_lengkap',
        'nohp',
        'nik',
        'role',
        'api_token',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(\App\Models\Pemesanan::class, 'id_user', 'id');
    }

    public function pemesanan()
    {
        return $this->hasMany(\App\Models\Pemesanan::class, 'id_user', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_user', 'id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'id_user', 'id');
    }

    public function isAdmin(): bool
    {
        return ($this->role ?? '') === 'admin';
    }

    /**
     * Get the user's full name (accessor for nama_lengkap column)
     */
    public function getNameAttribute()
    {
        return $this->nama_lengkap;
    }

    /**
     * Set the user's full name (mutator for nama_lengkap column)
     */
    public function setNameAttribute($value)
    {
        $this->attributes['nama_lengkap'] = $value;
    }
}
