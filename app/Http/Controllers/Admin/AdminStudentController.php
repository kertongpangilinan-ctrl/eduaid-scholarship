<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminStudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student');
        
        // Search by name, email, or username
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->status && $request->status !== 'all') {
            $query->where('account_status', $request->status);
        }
        
        // Filter by batch
        if ($request->batch && $request->batch !== 'all') {
            $query->whereHas('currentApplication', function($q) use ($request) {
                $q->where('batch_id', $request->batch);
            });
        }
        
        $students = $query->with('currentApplication')->orderBy('created_at', 'desc')->paginate(10);
        
        // Get all unique batch IDs for filter dropdown
        $batches = \App\Models\Application::whereNotNull('batch_id')
            ->distinct()
            ->orderBy('batch_id')
            ->pluck('batch_id');
        
        return view('admin.students', compact('students', 'batches'));
    }

    public function show($id)
    {
        $student = User::where('role', 'student')
            ->findOrFail($id);
        
        $payoutHistory = \App\Models\PayoutHistory::where('user_id', $id)
            ->with('payout')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $payoutDocuments = \App\Models\PayoutDocument::where('user_id', $id)
            ->with('payout')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.students-show', compact('student', 'payoutHistory', 'payoutDocuments'));
    }

    public function updateStatus(Request $request, $id)
    {
        $student = User::findOrFail($id);
        $student->update([
            'account_status' => $request->status
        ]);
        
        return redirect()->back()->with('success', 'Student status updated successfully.');
    }
}
