<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    use HasFactory;

    protected $primaryKey = 'group_message_id';
    protected $table = 'group_messages';

    protected $fillable = [
        'group_chat_id', 'sender_id', 'message_content', 'image_path'
    ];

    public function groupChat()
    {
        return $this->belongsTo(GroupChat::class, 'group_chat_id', 'group_chat_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }
}
