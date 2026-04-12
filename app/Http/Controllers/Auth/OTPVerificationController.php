<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OTPVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OTPVerificationController extends Controller
{
    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate 6-digit OTP
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete any existing OTPs for this user
        OTPVerification::where('user_id', $user->user_id)->delete();

        // Create new OTP record
        OTPVerification::create([
            'user_id' => $user->user_id,
            'otp_code' => $otp,
            'email' => $user->email,
            'expires_at' => Carbon::now()->addMinutes(15),
            'attempts' => 0,
            'is_used' => false
        ]);

        // Send OTP via email
        try {
            Mail::raw(
                "Dear {$user->name},\n\n" .
                "Your OTP verification code is: {$otp}\n\n" .
                "This code will expire in 15 minutes.\n\n" .
                "If you did not request this code, please ignore this email.\n\n" .
                "Best regards,\n" .
                "EduAid Scholarship Team",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('EduAid - OTP Verification Code');
                }
            );

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp_code' => 'required|string|size:6'
        ]);

        $user = User::where('email', $request->email)->first();
        $otpRecord = OTPVerification::where('user_id', $user->user_id)
            ->where('otp_code', $request->otp_code)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpRecord) {
            // Increment attempts
            $existingOTP = OTPVerification::where('user_id', $user->user_id)
                ->where('is_used', false)
                ->first();
            
            if ($existingOTP) {
                $existingOTP->increment('attempts');
                
                if ($existingOTP->attempts >= 3) {
                    // Mark as used after 3 failed attempts
                    $existingOTP->update(['is_used' => true]);
                    return back()->withErrors(['otp_code' => 'Too many failed attempts. Please request a new OTP.']);
                }
            }

            return back()->withErrors(['otp_code' => 'Invalid or expired OTP code']);
        }

        // Mark OTP as used
        $otpRecord->update(['is_used' => true]);

        // Update user account status
        $user->update([
            'account_status' => 'pending_admin_approval',
            'email_verified_at' => Carbon::now()
        ]);

        // Get reference number
        $referenceNumber = $user->reference_number;

        return redirect()->route('application-status', ['reference' => $referenceNumber])
            ->with('success', 'Email verified successfully! Your application is now under review.');
    }

    public function resendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if user has already verified
        if ($user->account_status !== 'pending_verification') {
            return back()->withErrors(['email' => 'Account already verified']);
        }

        // Generate new OTP
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete any existing OTPs for this user
        OTPVerification::where('user_id', $user->user_id)->delete();

        // Create new OTP record
        OTPVerification::create([
            'user_id' => $user->user_id,
            'otp_code' => $otp,
            'email' => $user->email,
            'expires_at' => Carbon::now()->addMinutes(15),
            'attempts' => 0,
            'is_used' => false
        ]);

        // Send OTP via email
        try {
            Mail::raw(
                "Dear {$user->name},\n\n" .
                "Your new OTP verification code is: {$otp}\n\n" .
                "This code will expire in 15 minutes.\n\n" .
                "Best regards,\n" .
                "EduAid Scholarship Team",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('EduAid - New OTP Verification Code');
                }
            );

            return back()->with('success', 'New OTP sent successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }
    }
}
