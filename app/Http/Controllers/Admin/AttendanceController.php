<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\QRCode;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function scanQR(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $qrCode = QRCode::where('qr_code_value', $request->qr_code)
            ->where('status', 'active')
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$qrCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired QR code'
            ], 400);
        }

        $batch = Batch::where('batch_id', $qrCode->batch_id)
            ->where('status', 'active')
            ->first();

        if (!$batch) {
            return response()->json([
                'success' => false,
                'message' => 'No active batch for this QR code'
            ], 400);
        }

        // Check if already marked present today
        $existingAttendance = Attendance::where('user_id', $qrCode->user_id)
            ->where('batch_id', $qrCode->batch_id)
            ->where('attendance_date', Carbon::today())
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Already marked present today'
            ], 400);
        }

        // Create attendance record
        Attendance::create([
            'user_id' => $qrCode->user_id,
            'batch_id' => $qrCode->batch_id,
            'attendance_date' => Carbon::today(),
            'attendance_time' => Carbon::now()->format('H:i:s'),
            'qr_code_value' => $request->qr_code,
            'status' => 'present'
        ]);

        // Mark QR code as used
        $qrCode->update([
            'status' => 'used',
            'used_at' => Carbon::now()
        ]);

        $user = User::find($qrCode->user_id);

        return response()->json([
            'success' => true,
            'message' => 'Attendance marked successfully',
            'data' => [
                'name' => $user->name,
                'time' => Carbon::now()->format('H:i:s'),
                'date' => Carbon::today()->format('F d, Y')
            ]
        ]);
    }

    public function index()
    {
        $activeBatch = Batch::where('status', 'active')->first();
        
        if (!$activeBatch) {
            return view('admin.attendance.index', [
                'attendances' => collect(),
                'batch' => null
            ]);
        }

        $attendances = Attendance::with('user')
            ->where('batch_id', $activeBatch->batch_id)
            ->orderBy('attendance_date', 'desc')
            ->orderBy('attendance_time', 'desc')
            ->paginate(50);
        
        return view('admin.attendance.index', compact('attendances', 'activeBatch'));
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
                'qr_image_path' => null, // Will be generated when viewed
                'status' => 'active',
                'generated_at' => Carbon::now(),
                'expires_at' => $expiresAt
            ]);

            $generatedCount++;
        }

        return back()->with('success', "Generated {$generatedCount} QR codes for batch {$batch->batch_number}");
    }
}
