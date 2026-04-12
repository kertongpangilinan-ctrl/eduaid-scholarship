<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasFactory;

    protected $primaryKey = 'personal_info_id';
    protected $table = 'personal_info';

    protected $fillable = [
        'user_id', 'last_name', 'first_name', 'middle_name', 'extension_name',
        'gender', 'date_of_birth', 'civil_status', 'contact_number'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
