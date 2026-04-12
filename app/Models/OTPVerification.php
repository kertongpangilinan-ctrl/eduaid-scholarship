<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPVerification extends Model
{
    use HasFactory;

    protected $primaryKey = 'otp_id';
    protected $table = 'otp_verifications';

    protected $fillable = [
        'user_id', 'otp_code', 'email', 'expires_at', 'attempts', 'is_used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }
}
