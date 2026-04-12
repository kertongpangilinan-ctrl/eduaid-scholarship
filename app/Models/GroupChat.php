<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    use HasFactory;

    protected $primaryKey = 'group_chat_id';
    protected $table = 'group_chats';

    protected $fillable = [
        'group_name', 'batch_id', 'created_by'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'batch_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_chat_members', 'group_chat_id', 'user_id')
                    ->withPivot('joined_at')
                    ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(GroupMessage::class, 'group_chat_id', 'group_chat_id');
    }
}
