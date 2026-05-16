<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** Cek apakah user adalah admin. */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /** Relasi ke keranjang belanja user. */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /** Relasi ke daftar pesanan user. */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /** Relasi ke pesan kontak yang dikirim user. */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
