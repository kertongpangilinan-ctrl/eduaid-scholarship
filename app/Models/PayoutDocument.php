<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutDocument extends Model
{
    use HasFactory;

    protected $primaryKey = 'document_id';
    protected $table = 'payout_documents';

    protected $fillable = [
        'payout_id',
        'user_id',
        'cor_path',
        'coe_path',
        'cog_path',
        'status',
        'admin_notes',
        'submitted_at',
        'approved_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
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
