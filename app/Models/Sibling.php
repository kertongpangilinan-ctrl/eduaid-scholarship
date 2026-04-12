<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sibling extends Model
{
    use HasFactory;

    protected $primaryKey = 'sibling_id';
    protected $table = 'siblings';

    protected $fillable = [
        'family_info_id', 'name', 'birth_date', 'occupation', 'gender'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function familyInfo()
    {
        return $this->belongsTo(FamilyInfo::class, 'family_info_id', 'family_info_id');
    }
}
