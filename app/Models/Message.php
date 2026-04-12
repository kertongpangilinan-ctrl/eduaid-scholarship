<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'message_id';
    protected $table = 'messages';

    protected $fillable = [
        'sender_id', 'receiver_id', 'message_content', 'subject', 'image_path',
        'is_read', 'read_at', 'is_archived_by_sender', 'is_archived_by_receiver'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'is_archived_by_sender' => 'boolean',
        'is_archived_by_receiver' => 'boolean',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'user_id');
    }
}
