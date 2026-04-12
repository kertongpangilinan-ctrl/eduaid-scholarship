<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PayoutEvent;
use App\Models\PayoutDocument;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PayoutDocumentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $documents = PayoutDocument::where('user_id', $user->id)
            ->with('payout')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.payout-documents', compact('documents'));
    }

    public function create($eventId)
    {
        $payoutEvent = PayoutEvent::findOrFail($eventId);
        
        // Check if payout event has ended
        if ($payoutEvent->event_date < now()->toDateString()) {
            return redirect()->route('student.payout-documents.index')
                ->with('error', 'This payout event has ended. You can no longer submit documents for this event.');
        }
        
        // Check if user already submitted documents for this event
        $existingDocument = PayoutDocument::where('payout_id', $eventId)
            ->where('user_id', auth()->id())
            ->first();
        
        if ($existingDocument) {
            return redirect()->route('student.payout-documents.index')
                ->with('info', 'You have already submitted documents for this payout event.');
        }

        return view('student.payout-documents-create', compact('payoutEvent'));
    }

    public function store(Request $request, $eventId)
    {
        $request->validate([
            'cor' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'coe' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'cog' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $payoutEvent = PayoutEvent::findOrFail($eventId);
        
        // Check if payout event has ended
        if ($payoutEvent->event_date < now()->toDateString()) {
            return redirect()->route('student.payout-documents.index')
                ->with('error', 'This payout event has ended. You can no longer submit documents for this event.');
        }

        // Upload documents
        $corPath = $request->file('cor')->store('payout_documents/cor', 'public');
        $coePath = $request->file('coe')->store('payout_documents/coe', 'public');
        $cogPath = $request->file('cog')->store('payout_documents/cog', 'public');

        PayoutDocument::create([
            'payout_id' => $eventId,
            'user_id' => auth()->id(),
            'cor_path' => $corPath,
            'coe_path' => $coePath,
            'cog_path' => $cogPath,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        // Create notification for all admin users
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'sent_by' => auth()->id(),
                'title' => 'New Payout Document Submission',
                'message' => auth()->user()->name . ' submitted documents for payout event: ' . $payoutEvent->event_name,
                'type' => 'payout_document',
                'is_read' => false,
                'sent_at' => now()
            ]);
        }

        return redirect()->route('student.payout-documents.index')
            ->with('success', 'Documents submitted successfully. Please wait for admin approval.');
    }
}
