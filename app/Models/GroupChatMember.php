<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChatMember extends Model
{
    use HasFactory;

    protected $primaryKey = 'member_id';
    protected $table = 'group_chat_members';

    protected $fillable = [
        'group_chat_id', 'user_id', 'joined_at'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function groupChat()
    {
        return $this->belongsTo(GroupChat::class, 'group_chat_id', 'group_chat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
