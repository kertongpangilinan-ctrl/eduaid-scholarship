<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutHistory extends Model
{
    use HasFactory;

    protected $primaryKey = 'history_id';
    protected $table = 'payout_history';

    protected $fillable = [
        'payout_id',
        'user_id',
        'status',
        'claimed_at',
        'amount'
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
        'amount' => 'decimal:2',
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
