<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    /** Auto-generate slug dari name sebelum menyimpan. */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    /** Relasi ke daftar buku dalam kategori ini. */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
