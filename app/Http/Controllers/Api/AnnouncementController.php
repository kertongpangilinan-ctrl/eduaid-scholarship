<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function getPublicAnnouncements()
    {
        // Temporarily remove published_at filter to show all general announcements
        $announcements = Announcement::where('announcement_type', 'general')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($announcement) {
                return [
                    'id' => $announcement->announcement_id,
                    'title' => $announcement->title,
                    'content' => $announcement->content,
                    'date' => $announcement->published_at ? $announcement->published_at->format('F d, Y') : 'No date',
                    'image' => $announcement->image_path ? asset('storage/' . $announcement->image_path) : null,
                    'link_url' => $announcement->link_url
                ];
            });

        return response()->json($announcements);
    }
}
