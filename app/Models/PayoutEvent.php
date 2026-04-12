<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutEvent extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id';
    protected $table = 'payout_events';

    protected $fillable = [
        'announcement_id',
        'event_name',
        'event_date',
        'event_time',
        'location',
        'status',
        'description'
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime:H:i:s',
    ];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'announcement_id', 'announcement_id');
    }

    public function documents()
    {
        return $this->hasMany(PayoutDocument::class, 'payout_id', 'event_id');
    }

    public function attendance()
    {
        return $this->hasMany(PayoutAttendance::class, 'payout_id', 'event_id');
    }

    public function history()
    {
        return $this->hasMany(PayoutHistory::class, 'payout_id', 'event_id');
    }
}
