<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'subject',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /** Relasi ke user pengirim pesan (opsional, bisa guest). */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
