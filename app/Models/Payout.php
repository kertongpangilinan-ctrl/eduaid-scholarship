<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $primaryKey = 'payout_id';
    protected $table = 'payouts';

    protected $fillable = [
        'user_id', 'batch_id', 'amount', 'status', 'payout_date',
        'date_received', 'signature_path', 'released_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payout_date' => 'date',
        'date_received' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'batch_id');
    }

    public function releasedBy()
    {
        return $this->belongsTo(User::class, 'released_by', 'user_id');
    }
}
