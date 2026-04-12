<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class StudentAnnouncementController extends Controller
{
    public function index(Request $request)
    {
        // Get priority announcements (pinned or scholarship type) for carousel
        $priorityAnnouncements = Announcement::where('is_pinned', true)
                                        ->orWhere('announcement_type', 'scholarship')
                                        ->orderBy('published_at', 'desc')
                                        ->take(5)
                                        ->get(['announcement_id', 'title', 'content', 'image_path', 'published_at', 'announcement_type']);
        
        // Get all announcements with search and filter
        $query = Announcement::query();
        
        // Search
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }
        
        // Filter by type
        if ($request->type && $request->type !== 'all') {
            $query->where('announcement_type', $request->type);
        }
        
        $announcements = $query->orderBy('published_at', 'desc')->paginate(10);
        
        return view('student.announcements.index', compact('announcements', 'priorityAnnouncements'));
    }
    
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('student.announcements.show', compact('announcement'));
    }
}
