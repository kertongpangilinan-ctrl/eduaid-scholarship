<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Application;
use App\Models\User;
use App\Models\QRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BatchManagementController extends Controller
{
    public function index()
    {
        $batches = Batch::withCount('applications')
            ->orderBy('academic_year', 'desc')
            ->orderBy('batch_number', 'desc')
            ->paginate(20);
        
        return view('admin.batches.index', compact('batches'));
    }

    public function create()
    {
        return view('admin.batches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year' => 'required|string|max:20',
            'batch_number' => 'required|integer|unique:batches',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        Batch::create([
            'academic_year' => $request->academic_year,
            'batch_number' => $request->batch_number,
            'status' => 'upcoming',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch created successfully');
    }

    public function show(Batch $batch)
    {
        $batch->load(['applications.user', 'scholars', 'payouts']);
        
        return view('admin.batches.show', compact('batch'));
    }

    public function edit(Batch $batch)
    {
        return view('admin.batches.edit', compact('batch'));
    }

    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'academic_year' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:upcoming,active,completed'
        ]);

        $batch->update([
            'academic_year' => $request->academic_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status
        ]);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch updated successfully');
    }

    public function activate(Batch $batch)
    {
        // Deactivate all other active batches
        Batch::where('status', 'active')->update(['status' => 'completed']);

        // Activate this batch
        $batch->update([
            'status' => 'active'
        ]);

        // Assign pending approved applications to this batch
        $pendingApplications = Application::where('status', 'approved')
            ->whereNull('batch_id')
            ->get();

        foreach ($pendingApplications as $application) {
            $application->update(['batch_id' => $batch->batch_id]);
        }

        return redirect()->route('admin.batches.show', $batch)
            ->with('success', 'Batch activated successfully. Pending applications assigned.');
    }

    public function assignApplication(Request $request, Batch $batch)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,application_id'
        ]);

        $application = Application::findOrFail($request->application_id);

        if ($application->status !== 'approved') {
            return back()->withErrors(['application_id' => 'Only approved applications can be assigned to a batch']);
        }

        $application->update(['batch_id' => $batch->batch_id]);

        return back()->with('success', 'Application assigned to batch successfully');
    }

    public function removeApplication(Application $application)
    {
        $application->update(['batch_id' => null]);

        return back()->with('success', 'Application removed from batch successfully');
    }

    public function generateQRForBatch(Request $request, Batch $batch)
    {
        $request->validate([
            'expires_in_hours' => 'nullable|integer|min:1|max:24'
        ]);

        $expiresAt = Carbon::now()->addHours($request->expires_in_hours ?? 8);

        // Generate QR codes for all scholars in the batch
        $scholars = $batch->scholars;
        $generatedCount = 0;

        foreach ($scholars as $scholar) {
            // Deactivate any existing active QR codes for this user
            QRCode::where('user_id', $scholar->user_id)
                ->where('status', 'active')
                ->update(['status' => 'expired']);

            // Generate new QR code
            $qrValue = 'EA-' . $batch->batch_number . '-' . $scholar->user_id . '-' . uniqid();

            QRCode::create([
                'user_id' => $scholar->user_id,
                'batch_id' => $batch->batch_id,
                'qr_code_value' => $qrValue,
                'qr_image_path' => null,
                'status' => 'active',
                'generated_at' => Carbon::now(),
                'expires_at' => $expiresAt
            ]);

            $generatedCount++;
        }

        return back()->with('success', "Generated {$generatedCount} QR codes for batch {$batch->batch_number}");
    }
}
