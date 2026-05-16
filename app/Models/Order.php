<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'total_price',
        'status',
        'payment_method',
        'shipping_address',
        'phone',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /** Status badge warna untuk tampilan UI. */
    public const STATUS_COLORS = [
        'pending'    => 'yellow',
        'processing' => 'blue',
        'shipped'    => 'indigo',
        'delivered'  => 'green',
        'cancelled'  => 'red',
    ];

    /** Relasi ke user yang melakukan pesanan. */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Relasi ke item-item dalam pesanan. */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /** Format total harga ke Rupiah. */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /** Generate nomor pesanan unik dengan format ORD-YYYYMMDD-XXXX. */
    public static function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
    }
}
