<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OTPVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EmailVerificationController extends Controller
{
    public function showOtpForm()
    {
        return view('auth.verify-otp', [
            'flash' => session('flash', [])
        ]);
    }
    
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'reference_number' => 'required|string',
            'otp_code' => 'required|string|size:6',
            'email' => 'required|email'
        ]);
        
        $user = User::where('reference_number', $request->reference_number)
                    ->where('email', $request->email)
                    ->first();
                    
        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid reference number or email.']);
        }
        
        $otpVerification = OTPVerification::where('user_id', $user->id)
                                        ->where('otp_code', $request->otp_code)
                                        ->where('is_used', false)
                                        ->first();
        
        if (!$otpVerification) {
            return back()->withErrors(['otp' => 'Invalid OTP code.']);
        }
        
        if ($otpVerification->expires_at < now()) {
            return back()->withErrors(['otp' => 'OTP code has expired.']);
        }
        
        if ($otpVerification->attempts >= 3) {
            return back()->withErrors(['otp' => 'Too many attempts. Please request a new OTP.']);
        }
        
        // Increment attempts
        $otpVerification->increment('attempts');
        
        if ($otpVerification->attempts >= 3) {
            return back()->withErrors(['otp' => 'Too many attempts. Please request a new OTP.']);
        }
        
        // Mark OTP as used
        $otpVerification->update([
            'is_used' => true,
            'attempts' => $otpVerification->attempts
        ]);
        
        // Update user status
        $user->update([
            'account_status' => 'pending_admin_approval',
            'email_verified_at' => now()
        ]);
        
        return redirect()->route('login')->with('success', 'Email verified successfully! Your application is now pending admin approval.');
    }
    
    public function resendOtp(Request $request)
    {
        $request->validate([
            'reference_number' => 'required|string',
            'email' => 'required|email'
        ]);
        
        $user = User::where('reference_number', $request->reference_number)
                    ->where('email', $request->email)
                    ->first();
                    
        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid reference number or email.']);
        }
        
        // Generate new OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Mark previous OTPs as used
        OTPVerification::where('user_id', $user->id)
                      ->where('is_used', false)
                      ->update(['is_used' => true]);
        
        // Create new OTP
        OTPVerification::create([
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'email' => $user->email,
            'expires_at' => now()->addMinutes(10),
            'attempts' => 0,
            'is_used' => false
        ]);
        
        // Send OTP email
        try {
            Mail::raw("Your new OTP code is: {$otpCode}. This code will expire in 10 minutes.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('EduAid - Email Verification OTP');
            });
        } catch (\Exception $e) {
            // Log error but continue
        }
        
        return back()->with('success', 'New OTP has been sent to your email.');
    }
    
    // API method to send OTP during registration
    public function sendOtpApi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'reference_number' => 'required|string'
        ]);
        
        // Check if email already exists
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already registered. Please use a different email address.'
            ], 400);
        }
        
        // Generate 6-digit OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store OTP in session for verification (temporary storage during registration)
        session([
            'registration_otp' => $otpCode,
            'registration_email' => $request->email,
            'registration_reference' => $request->reference_number,
            'otp_expires_at' => now()->addMinutes(10)
        ]);
        
        // Send OTP email
        try {
            Mail::raw("Your EduAid registration OTP code is: {$otpCode}\n\nThis code will expire in 10 minutes.\n\nIf you did not request this code, please ignore this email.", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('EduAid - Email Verification OTP');
            });
        } catch (\Exception $e) {
            // Log error
            \Log::error('Failed to send OTP email: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP email. Please try again.'
            ], 500);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'OTP has been sent to your email address.'
        ]);
    }
    
    // API method to verify OTP during registration
    public function verifyOtpApi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|string|size:6',
            'reference_number' => 'required|string'
        ]);
        
        // Check OTP from session
        $sessionOtp = session('registration_otp');
        $sessionEmail = session('registration_email');
        $sessionReference = session('registration_reference');
        $expiresAt = session('otp_expires_at');
        
        // Validate OTP
        if (!$sessionOtp || $sessionOtp !== $request->otp_code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP code. Please try again.'
            ], 400);
        }
        
        // Validate email matches
        if ($sessionEmail !== $request->email) {
            return response()->json([
                'success' => false,
                'message' => 'Email does not match the one used to request OTP.'
            ], 400);
        }
        
        // Check expiration
        if ($expiresAt && now()->gt($expiresAt)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP code has expired. Please request a new OTP.'
            ], 400);
        }
        
        // Mark as verified in session
        session(['email_verified' => true]);
        
        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully!'
        ]);
    }
}
