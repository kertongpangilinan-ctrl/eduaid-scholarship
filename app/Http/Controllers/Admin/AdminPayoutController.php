<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayoutDocument;
use App\Models\PayoutEvent;
use App\Models\User;
use App\Models\PayoutAttendance;
use App\Models\PayoutHistory;
use App\Models\Notification;
use App\Mail\PayoutEventNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class AdminPayoutController extends Controller
{
    public function index()
    {
        // Update status based on event date/time
        PayoutEvent::where('event_date', '<', now()->toDateString())
            ->where('status', 'upcoming')
            ->update(['status' => 'completed']);

        // Mark today's events as active if time has passed
        PayoutEvent::where('event_date', now()->toDateString())
            ->where('event_time', '<=', now()->toTimeString())
            ->where('status', 'upcoming')
            ->update(['status' => 'active']);

        $payoutEvents = PayoutEvent::withCount('documents', 'attendance')
            ->orderBy('event_date', 'desc')
            ->get();

        return view('admin.payout-events', compact('payoutEvents'));
    }

    public function create()
    {
        return view('admin.payout-events-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $payoutEvent = PayoutEvent::create([
            'event_name' => $request->event_name,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'location' => $request->location,
            'description' => $request->description,
            'status' => 'upcoming',
        ]);

        // Send email notification to all students
        $students = User::where('role', 'student')->where('account_status', 'active')->get();
        foreach ($students as $student) {
            Mail::to($student->email)->send(new PayoutEventNotification($payoutEvent));
            
            // Create notification for each student
            Notification::create([
                'user_id' => $student->id,
                'sent_by' => auth()->id(),
                'title' => 'New Payout Event: ' . $payoutEvent->event_name,
                'message' => 'Date: ' . $payoutEvent->event_date->format('M d, Y') . 
                            ($payoutEvent->event_time ? ' at ' . $payoutEvent->event_time : '') .
                            ($payoutEvent->location ? ' - ' . $payoutEvent->location : ''),
                'type' => 'payout',
                'is_read' => false,
                'sent_at' => now()
            ]);
        }

        return redirect()->route('admin.payout-events.index')
            ->with('success', 'Payout event created successfully. Email notifications have been sent to all students.');
    }

    public function show($eventId)
    {
        $payoutEvent = PayoutEvent::with('documents.user', 'attendance.user', 'history.user')
            ->findOrFail($eventId);

        return view('admin.payout-events-show', compact('payoutEvent'));
    }

    public function documents($eventId)
    {
        $payoutEvent = PayoutEvent::findOrFail($eventId);
        $documents = PayoutDocument::where('payout_id', $eventId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.payout-documents', compact('payoutEvent', 'documents'));
    }

    public function approveDocument($documentId)
    {
        $document = PayoutDocument::findOrFail($documentId);
        $document->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Document approved successfully.');
    }

    public function rejectDocument(Request $request, $documentId)
    {
        $request->validate([
            'admin_notes' => 'required|string',
        ]);

        $document = PayoutDocument::findOrFail($documentId);
        $document->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Document rejected successfully.');
    }

    public function attendance($eventId)
    {
        $payoutEvent = PayoutEvent::findOrFail($eventId);
        $attendance = PayoutAttendance::where('payout_id', $eventId)
            ->with('user')
            ->orderBy('scanned_at', 'desc')
            ->get();

        return view('admin.payout-attendance', compact('payoutEvent', 'attendance'));
    }

    public function validateQR(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
            'payout_id' => 'required|integer',
        ]);

        $user = User::where('qr_code', $request->qr_code)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid QR code. Student not found.'
            ]);
        }

        $payoutEvent = PayoutEvent::findOrFail($request->payout_id);

        // Get batch information
        $application = \App\Models\Application::where('user_id', $user->id)->first();
        $batch = $application ? \App\Models\Batch::find($application->batch_id) : null;
        $batchName = $batch ? 'Batch ' . $batch->batch_number : 'N/A';

        // Check if document is approved for this specific payout event
        $document = PayoutDocument::where('payout_id', $request->payout_id)
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->first();

        // Check if already scanned for this specific payout event
        $existingAttendance = PayoutAttendance::where('payout_id', $request->payout_id)
            ->where('user_id', $user->id)
            ->first();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'qr_code' => $user->qr_code,
                'status' => $user->account_status,
                'batch' => $batchName,
            ],
            'document_approved' => $document ? true : false,
            'already_attended' => $existingAttendance ? true : false,
        ]);
    }

    public function scanQR(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
            'payout_id' => 'required|integer',
        ]);

        $user = User::where('qr_code', $request->qr_code)->first();

        if (!$user) {
            return back()->with('error', 'Invalid QR code. Student not found.');
        }

        $payoutEvent = PayoutEvent::findOrFail($request->payout_id);

        // Check if document is approved for this specific payout event
        $document = PayoutDocument::where('payout_id', $request->payout_id)
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->first();

        if (!$document) {
            return back()->with('error', 'Student must submit and have approved documents for this payout event before scanning QR code.');
        }

        // Check if already scanned for this specific payout event
        $existingAttendance = PayoutAttendance::where('payout_id', $request->payout_id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingAttendance) {
            return back()->with('info', 'Student has already attended this payout event. QR code cannot be used again for this event.');
        }

        // Determine if on time or late
        $eventDateTime = $payoutEvent->event_date->setTimeFrom($payoutEvent->event_time);
        $attendanceType = now()->lte($eventDateTime) ? 'on_time' : 'late';

        // Create attendance record
        PayoutAttendance::create([
            'payout_id' => $request->payout_id,
            'user_id' => $user->id,
            'qr_code' => $request->qr_code,
            'attendance_type' => $attendanceType,
            'scanned_at' => now(),
        ]);

        // Update user consecutive missed payouts
        $user->update(['consecutive_missed_payouts' => 0]);

        return back()->with('success', 'QR code scanned successfully. Attendance recorded for ' . $payoutEvent->event_name . '.');
    }

    public function history($eventId)
    {
        $payoutEvent = PayoutEvent::findOrFail($eventId);
        $history = PayoutHistory::where('payout_id', $eventId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.payout-history', compact('payoutEvent', 'history'));
    }
}
