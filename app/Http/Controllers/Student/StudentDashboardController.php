<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Application;
use App\Models\Message;
use App\Models\Announcement;
use App\Models\PayoutEvent;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get unread messages count
        $unreadMessages = Message::where('receiver_id', $user->id)
                                ->where('is_read', false)
                                ->count();
        
        // Get recent announcements (last 7 days)
        $recentAnnouncements = Announcement::where('published_at', '>=', now()->subDays(7))
                                        ->orderBy('published_at', 'desc')
                                        ->take(5)
                                        ->get(['announcement_id', 'title', 'content', 'image_path', 'published_at']);
        
        // Get application status
        $application = Application::where('user_id', $user->id)->first();
        
        // Get payout events for the current month and upcoming
        $payoutEvents = PayoutEvent::where('event_date', '>=', now()->subMonth()->startOfMonth())
                                  ->where('event_date', '<=', now()->addMonth()->endOfMonth())
                                  ->orderBy('event_date', 'asc')
                                  ->get(['event_id', 'event_date', 'event_name', 'event_time', 'status', 'location']);
        
        return view('student.dashboard', compact('user', 'unreadMessages', 'recentAnnouncements', 'application', 'payoutEvents'));
    }
}
