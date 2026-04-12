<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'username', 'email', 'password', 'role', 'account_status',
        'email_verified_at', 'reference_number', 'qr_code', 'consecutive_missed_payouts'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function personalInfo()
    {
        return $this->hasOne(PersonalInfo::class, 'user_id');
    }

    public function addressInfo()
    {
        return $this->hasOne(AddressInfo::class, 'user_id');
    }

    public function familyInfo()
    {
        return $this->hasOne(FamilyInfo::class, 'user_id');
    }

    public function educationalInfo()
    {
        return $this->hasOne(EducationalInfo::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }

    public function currentApplication()
    {
        return $this->hasOne(Application::class, 'user_id')->latest();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function attendanceRecords()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function payouts()
    {
        return $this->hasMany(Payout::class, 'user_id');
    }

    public function qrCodes()
    {
        return $this->hasMany(QRCode::class, 'user_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'user_id');
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class, 'user_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    public function groupChats()
    {
        return $this->belongsToMany(GroupChat::class, 'group_chat_members', 'user_id', 'group_chat_id');
    }

    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'staff']);
    }

    public function canLogin()
    {
        return $this->account_status === 'approved';
    }

    public function getFullNameAttribute()
    {
        $personal = $this->personalInfo;
        if (!$personal) return $this->username;

        $name = $personal->first_name . ' ' . $personal->last_name;
        if ($personal->extension_name) {
            $name .= ' ' . $personal->extension_name;
        }
        return $name;
    }

    public function getAgeAttribute()
    {
        if (!$this->personalInfo || !$this->personalInfo->date_of_birth) return null;
        return $this->personalInfo->date_of_birth->age;
    }
}
