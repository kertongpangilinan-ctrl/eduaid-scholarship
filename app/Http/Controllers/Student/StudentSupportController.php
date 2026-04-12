<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;

class StudentSupportController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $tickets = SupportTicket::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        
        return view('student.support.index', compact('tickets'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:profile_error,bug,concern',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        
        $imagePath = null;
        if ($request->hasFile('screenshot')) {
            $imagePath = $request->file('screenshot')->store('support_screenshots', 'public');
        }
        
        SupportTicket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'message' => $request->description,
            'status' => 'open',
            'image_path' => $imagePath,
        ]);
        
        return redirect()->route('student.support')
            ->with('success', 'Support ticket submitted successfully!');
    }
}
