<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $primaryKey = 'batch_id';
    protected $table = 'batches';

    protected $fillable = [
        'academic_year', 'batch_number', 'status', 'start_date', 'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class, 'batch_id', 'batch_id');
    }

    public function scholars()
    {
        return $this->hasManyThrough(User::class, Application::class, 'batch_id', 'user_id', 'batch_id', 'user_id')
                    ->where('applications.status', 'approved');
    }

    public function attendanceRecords()
    {
        return $this->hasMany(Attendance::class, 'batch_id', 'batch_id');
    }

    public function payouts()
    {
        return $this->hasMany(Payout::class, 'batch_id', 'batch_id');
    }

    public function groupChat()
    {
        return $this->hasOne(GroupChat::class, 'batch_id', 'batch_id');
    }

    public function getScholarCountAttribute()
    {
        return $this->scholars()->count();
    }

    public function getTotalPayoutAttribute()
    {
        return $this->payouts()->where('status', 'claimed')->sum('amount');
    }
}
