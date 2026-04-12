<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutAttendance extends Model
{
    use HasFactory;

    protected $primaryKey = 'attendance_id';
    protected $table = 'payout_attendance';

    protected $fillable = [
        'payout_id',
        'user_id',
        'qr_code',
        'attendance_type',
        'scanned_at'
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function payout()
    {
        return $this->belongsTo(PayoutEvent::class, 'payout_id', 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
