<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressInfo extends Model
{
    use HasFactory;

    protected $primaryKey = 'address_id';
    protected $table = 'address_info';

    protected $fillable = [
        'user_id', 'house_unit_number', 'street_name', 'barangay',
        'municipality_city', 'province'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
