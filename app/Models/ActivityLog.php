<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    // Mengizinkan kolom-kolom ini diisi data
    protected $fillable = ['user_id', 'action', 'target_user', 'description', 'ip_address'];

    // Relasi: Setiap log dimiliki oleh satu User (Admin)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}