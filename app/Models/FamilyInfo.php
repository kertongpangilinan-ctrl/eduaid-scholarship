<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyInfo extends Model
{
    use HasFactory;

    protected $primaryKey = 'family_info_id';
    protected $table = 'family_info';

    protected $fillable = [
        'user_id', 'father_name', 'father_occupation', 'father_salary', 'father_birth_date',
        'mother_name', 'mother_occupation', 'mother_salary', 'mother_birth_date',
        'total_siblings'
    ];

    protected $casts = [
        'father_salary' => 'decimal:2',
        'mother_salary' => 'decimal:2',
        'father_birth_date' => 'date',
        'mother_birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function siblings()
    {
        return $this->hasMany(Sibling::class, 'family_info_id', 'family_info_id');
    }
}
