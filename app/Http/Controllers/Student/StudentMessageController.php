<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Notification;

class StudentMessageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get messages sent to this user
        $messages = Message::where('receiver_id', $user->id)
                        ->with('sender')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        
        return view('student.messages.index', compact('messages'));
    }
    
    public function compose()
    {
        // Get admin users
        $admins = User::where('role', 'admin')->get();
        
        return view('student.messages.compose', compact('admins'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject,
            'message_content' => $request->message,
            'is_read' => false,
        ]);
        
        // Create notification for the receiver (admin)
        Notification::create([
            'user_id' => $request->receiver_id,
            'sent_by' => auth()->id(),
            'title' => 'New Message',
            'message' => auth()->user()->name . ' sent you a message: ' . $request->subject,
            'type' => 'message',
            'is_read' => false,
            'sent_at' => now()
        ]);
        
        return redirect()->route('student.messages')
            ->with('success', 'Message sent successfully!');
    }
}
