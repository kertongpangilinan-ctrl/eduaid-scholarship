<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;

class StudentProgressController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $application = Application::where('user_id', $user->id)->first();
        
        return view('student.progress', compact('application'));
    }
}
