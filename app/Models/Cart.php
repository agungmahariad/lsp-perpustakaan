<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'book_id', 'quantity'];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /** Relasi ke user pemilik keranjang. */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Relasi ke buku dalam keranjang. */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /** Hitung subtotal harga (qty * harga buku). */
    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->book->price;
    }
}
