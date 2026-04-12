<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $primaryKey = 'announcement_id';
    protected $table = 'announcements';

    protected $fillable = [
        'user_id', 'title', 'content', 'when_info', 'where_info', 'what_info',
        'announcement_type', 'is_pinned', 'image_path', 'published_at', 'link_url'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
