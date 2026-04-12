<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;
use App\Models\Document;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AdminApprovalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Application::with('user');

        // Apply status filter
        if ($status && $status !== '') {
            $query->where('status', $status);
        }

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('reference_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $allApps = Application::count();
        $pendingApps = Application::where('status', 'pending')->count();
        $approvedApps = Application::where('status', 'approved')->count();
        
        \Log::info('Admin Approvals - Application counts', [
            'total' => $allApps,
            'pending' => $pendingApps,
            'approved' => $approvedApps
        ]);
        
        $applications = $query->orderBy('submission_date', 'desc')
            ->paginate(20)
            ->appends(['search' => $search, 'status' => $status]);
        
        return view('admin.approvals.index', compact('applications', 'search', 'status'));
    }

    public function show(Application $application)
    {
        $application->load([
            'user.personalInfo', 
            'user.addressInfo', 
            'user.familyInfo.siblings', 
            'user.educationalInfo', 
            'user.documents'
        ]);
        return view('admin.approvals.show', compact('application'));
    }

    public function approve(Request $request, Application $application)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000'
        ]);

        // Update application status
        $application->update([
            'status' => 'approved',
            'approved_date' => now(),
            'admin_notes' => $request->notes
        ]);

        // Calculate batch ID (50 students per batch)
        $totalApproved = Application::where('status', 'approved')->count();
        $batchId = ceil($totalApproved / 50);

        // Update application with batch ID
        $application->update([
            'batch_id' => $batchId
        ]);

        // Update user status to approved and generate QR code
        $application->user->update([
            'account_status' => 'approved',
            'qr_code' => 'QR-' . strtoupper(\Illuminate\Support\Str::random(16))
        ]);

        // Create notification for the student
        Notification::create([
            'user_id' => $application->user->id,
            'sent_by' => auth()->id(),
            'title' => 'Application Approved',
            'message' => 'Congratulations! Your scholarship application has been approved. Reference: ' . $application->reference_number,
            'type' => 'application_status',
            'is_read' => false,
            'sent_at' => now()
        ]);

        // Send approval email without changing password
        try {
            $user = $application->user;

            $adminNotes = $request->notes ? "\n\nAdmin's Comment: {$request->notes}" : '';

            Mail::raw(
                "Dear {$user->name},\n\n" .
                "Congratulations! Your scholarship application has been approved.\n\n" .
                "Your Application Reference Number: {$application->reference_number}\n\n" .
                "You can now log in to the EduAid Scholarship Portal using your registration credentials.\n\n" .
                "Email: {$user->email}\n" .
                "Password: Use the password you created during registration\n\n" .
                "Login URL: " . route('login') . "\n\n" .
                "Note: Your password cannot be changed after approval. Your registration password will remain your permanent password.\n\n" .
                $adminNotes . "\n\n" .
                "If you have any questions, please don't hesitate to contact us.\n\n" .
                "Welcome to the EduAid Scholarship Program!\n\n" .
                "Best regards,\n" .
                "EduAid Scholarship Team",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('EduAid - Application Approved');
                }
            );

            return redirect()->route('admin.approvals.index')
                ->with('success', "Application approved successfully! User can log in using their registration password.");
        } catch (\Exception $e) {
            \Log::error('Failed to send approval email: ' . $e->getMessage());

            return redirect()->route('admin.approvals.index')
                ->with('success', "Application approved successfully! User can log in using their registration password. (Email not sent)");
        }
    }

    public function reject(Request $request, Application $application)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        // Update application status
        $application->update([
            'status' => 'rejected',
            'reviewed_date' => now(),
            'admin_notes' => $request->reason
        ]);

        // Update user status
        $application->user->update([
            'account_status' => 'rejected'
        ]);

        // Create notification for the student
        Notification::create([
            'user_id' => $application->user->id,
            'sent_by' => auth()->id(),
            'title' => 'Application Status Update',
            'message' => 'Your scholarship application has been reviewed. Reference: ' . $application->reference_number,
            'type' => 'rejection',
            'is_read' => false,
            'sent_at' => now()
        ]);

        // Send rejection email
        try {
            $user = $application->user;

            Mail::raw(
                "Dear {$user->name},\n\n" .
                "We regret to inform you that your scholarship application has been reviewed and was not approved at this time.\n\n" .
                "Your Application Reference Number: {$application->reference_number}\n\n" .
                "Reason for rejection: {$request->reason}\n\n" .
                "If you believe this is an error or would like to reapply, please contact our support team.\n\n" .
                "Thank you for your interest in the EduAid Scholarship Program.\n\n" .
                "Best regards,\n" .
                "EduAid Scholarship Team",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('EduAid - Application Status Update');
                }
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }

        return redirect()->route('admin.approvals.index')
            ->with('success', 'Application rejected successfully. Notification sent to user.');
    }

    public function verifyDocument(Request $request, Document $document)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000'
        ]);

        // Update document verification status
        $document->update([
            'verification_status' => 'verified',
            'verification_notes' => $request->notes,
            'verified_by' => auth()->id(),
            'verified_at' => now()
        ]);

        // Check if all documents for this application are verified
        $application = Application::with('documents')->find($document->user_id);
        $allVerified = $application->documents->every(function ($doc) {
            return $doc->verification_status === 'verified';
        });

        // If all documents verified, update application status
        if ($allVerified) {
            $application->update([
                'status' => 'under_review',
                'reviewed_at' => now()
            ]);
        }

        return back()->with('success', 'Document verified successfully');
    }

    public function rejectDocument(Request $request, Document $document)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        // Update document verification status
        $document->update([
            'verification_status' => 'rejected',
            'verification_notes' => $request->reason,
            'verified_by' => auth()->id(),
            'verified_at' => now()
        ]);

        // Update application status to requires_action
        $application = Application::where('user_id', $document->user_id)->first();
        $application->update([
            'status' => 'requires_action',
            'admin_notes' => 'Some documents were rejected. Please resubmit.'
        ]);

        // Send notification to user
        try {
            $user = User::find($document->user_id);

            Mail::raw(
                "Dear {$user->name},\n\n" .
                "One of your submitted documents has been rejected during verification.\n\n" .
                "Document Type: {$document->document_type}\n" .
                "Reason: {$request->reason}\n\n" .
                "Please resubmit the required document to continue with your application.\n\n" .
                "Best regards,\n" .
                "EduAid Scholarship Team",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('EduAid - Document Rejected');
                }
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send document rejection email: ' . $e->getMessage());
        }

        return back()->with('success', 'Document rejected. User has been notified.');
    }
}
