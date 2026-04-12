<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalInfo extends Model
{
    use HasFactory;

    protected $primaryKey = 'educational_info_id';
    protected $table = 'educational_info';

    protected $fillable = [
        'user_id', 'education_level', 'school_name', 'semester_type', 'current_semester', 'year_level', 'lrn', 'shs_strand', 'school_id_type', 'school_id_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
