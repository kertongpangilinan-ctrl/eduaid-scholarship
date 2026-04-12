<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StudentProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->load('personalInfo', 'addressInfo', 'familyInfo', 'educationalInfo');
        
        $application = \App\Models\Application::where('user_id', $user->id)->first();
        
        return view('student.profile', compact('user', 'application'));
    }
    
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        
        // Prevent password change if user is approved (active)
        if ($user->account_status === 'active') {
            return back()->withErrors(['password' => 'Password cannot be changed after approval. Your registration password will remain your permanent password.']);
        }
        
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Clear any session errors after successful password change
        $request->session()->forget('errors');
        
        return back()->with('success', 'Password updated successfully!');
    }
}
