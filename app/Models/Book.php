<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'author',
        'publisher',
        'year',
        'price',
        'stock',
        'cover_image',
        'description',
        'isbn',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'year' => 'integer',
    ];

    /** Auto-generate slug unik dari title sebelum menyimpan. */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($book) {
            $book->slug = Str::slug($book->title);
        });

        static::updating(function ($book) {
            $book->slug = Str::slug($book->title);
        });
    }

    /** Relasi ke kategori buku. */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /** Relasi ke item keranjang yang memuat buku ini. */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /** Relasi ke item pesanan yang memuat buku ini. */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /** Format harga ke format Rupiah. */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
