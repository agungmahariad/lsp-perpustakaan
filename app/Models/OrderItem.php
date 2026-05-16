<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'book_id', 'quantity', 'price'];

    protected $casts = [
        'quantity' => 'integer',
        'price'    => 'decimal:2',
    ];

    /** Relasi ke pesanan induk. */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /** Relasi ke buku yang dipesan. */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /** Hitung subtotal item (qty * harga saat pemesanan). */
    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }
}
