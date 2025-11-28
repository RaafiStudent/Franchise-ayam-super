<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'payment_status',
        'order_status',
        'snap_token',
        'resi_number',
        'courier_name'
    ];

    // Relasi: Satu Order punya banyak Item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: Order milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}