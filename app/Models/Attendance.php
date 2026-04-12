<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $primaryKey = 'attendance_id';
    protected $table = 'attendance_records';

    protected $fillable = [
        'user_id', 'batch_id', 'attendance_date', 'attendance_time',
        'qr_code_value', 'status'
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'attendance_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'batch_id');
    }
}
