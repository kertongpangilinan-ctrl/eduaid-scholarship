<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'announcement_type' => 'required|in:general,scholarship,payout,event,deadline',
            'when_info' => 'nullable|string',
            'where_info' => 'nullable|string',
            'what_info' => 'nullable|string',
            'is_pinned' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'link_url' => 'nullable|url|max:500',
            'published_at' => 'nullable|date'
        ]);

        $announcement = Announcement::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'announcement_type' => $validated['announcement_type'],
            'when_info' => $validated['when_info'] ?? null,
            'where_info' => $validated['where_info'] ?? null,
            'what_info' => $validated['what_info'] ?? null,
            'is_pinned' => $validated['is_pinned'] ?? false,
            'link_url' => $validated['link_url'] ?? null,
            'published_at' => $validated['published_at'] ?? now()
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('announcements', 'public');
            $announcement->update(['image_path' => $path]);
        }

        // Create notifications for all active students
        $students = User::where('account_status', 'active')->get();
        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'sent_by' => auth()->id(),
                'title' => $announcement->title,
                'message' => substr($announcement->content, 0, 150),
                'type' => 'announcement',
                'is_read' => false,
                'sent_at' => now()
            ]);
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'announcement_type' => 'required|in:general,scholarship,payout,event,deadline',
            'when_info' => 'nullable|string',
            'where_info' => 'nullable|string',
            'what_info' => 'nullable|string',
            'is_pinned' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'link_url' => 'nullable|url|max:500',
            'published_at' => 'nullable|date'
        ]);

        $announcement->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'announcement_type' => $validated['announcement_type'],
            'when_info' => $validated['when_info'] ?? null,
            'where_info' => $validated['where_info'] ?? null,
            'what_info' => $validated['what_info'] ?? null,
            'is_pinned' => $validated['is_pinned'] ?? false,
            'link_url' => $validated['link_url'] ?? null,
            'published_at' => $validated['published_at']
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($announcement->image_path) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            
            $image = $request->file('image');
            $path = $image->store('announcements', 'public');
            $announcement->update(['image_path' => $path]);
        }

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully');
    }

    public function destroy(Announcement $announcement)
    {
        // Delete image if exists
        if ($announcement->image_path) {
            Storage::disk('public')->delete($announcement->image_path);
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully');
    }
}
