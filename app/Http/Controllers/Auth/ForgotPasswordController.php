<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OTPVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
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
        OTPVerification::where('user_id', $user->id)->delete();

        // Create new OTP record for password reset
        OTPVerification::create([
            'user_id' => $user->id,
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
                "Your password reset OTP code is: {$otp}\n\n" .
                "This code will expire in 15 minutes.\n\n" .
                "If you did not request this code, please ignore this email.\n\n" .
                "Best regards,\n" .
                "EduAid Scholarship Team",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('EduAid - Password Reset OTP');
                }
            );

            return redirect()->route('password.otp')->with(['success' => 'OTP sent successfully to your email', 'email' => $request->email]);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }
    }

    public function showOTPForm()
    {
        return view('auth.verify-otp-password');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp_code' => 'required|string|size:6'
        ]);

        $user = User::where('email', $request->email)->first();
        $otpRecord = OTPVerification::where('user_id', $user->id)
            ->where('otp_code', $request->otp_code)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp_code' => 'Invalid or expired OTP code']);
        }

        // Mark OTP as used
        $otpRecord->update(['is_used' => true]);

        // Redirect to reset password form with verified email
        return redirect()->to('/reset-password?email=' . urlencode($user->email))
            ->with('success', 'OTP verified successfully');
    }

    public function showResetForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.reset-password', ['email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'Password reset successfully');
    }
}
