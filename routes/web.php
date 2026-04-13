<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\OTPVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\ValidationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\AdminApprovalController;
use Inertia\Inertia;

// Public routes (accessible to all)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/requirements', [HomeController::class, 'requirements'])->name('requirements');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/track-application', [ApplicationController::class, 'track'])->name('track-application');
Route::get('/application-status/{reference}', [ApplicationController::class, 'track'])->name('application-status');

// Guest only routes
Route::middleware(['guest:web'])->group(function () {
    // Authentication routes
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // OTP Verification routes
    Route::get('/verify-otp', [OTPVerificationController::class, 'showOtpForm'])->name('verify-otp');
    Route::post('/verify-otp', [OTPVerificationController::class, 'verifyOTP'])->name('verify-otp.submit');
    Route::post('/resend-otp', [OTPVerificationController::class, 'resendOTP'])->name('resend-otp');

    // Forgot Password routes (OTP-based)
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOTP'])->name('password.email');
    Route::get('/verify-otp-password', [ForgotPasswordController::class, 'showOTPForm'])->name('password.otp');
    Route::post('/verify-otp-password', [ForgotPasswordController::class, 'verifyOTP'])->name('password.verify');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

// Logout route (accessible to authenticated users only)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

// API routes for validation
Route::get('/api/validate/username', [ValidationController::class, 'checkUsername']);
Route::get('/api/validate/email', [ValidationController::class, 'checkEmail']);

// API route for public announcements
Route::get('/api/announcements/public', [App\Http\Controllers\Api\AnnouncementController::class, 'getPublicAnnouncements']);

// API routes for OTP
Route::post('/api/send-otp', [EmailVerificationController::class, 'sendOtpApi']);
Route::post('/api/verify-otp', [EmailVerificationController::class, 'verifyOtpApi']);

// API route for tracking application
Route::get('/api/track-application/{reference}', [ApplicationController::class, 'trackApi']);

// API route for user profile
Route::middleware(['auth'])->get('/api/user-profile/{id}', function($id) {
    $user = \App\Models\User::findOrFail($id);
    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'username' => $user->username,
        'email' => $user->email,
        'role' => $user->role,
    ]);
});

// API routes for notifications
Route::middleware(['auth'])->prefix('api/notifications')->name('api.notifications.')->group(function () {
    Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])->name('index');
    Route::post('/{id}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('mark-read');
    Route::post('/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    Route::get('/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('unread-count');
});

// API route for user profile
Route::middleware(['auth'])->get('/api/user-profile/{id}', function($id) {
    $user = \App\Models\User::findOrFail($id);
    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'username' => $user->username,
        'email' => $user->email,
        'role' => $user->role,
    ]);
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\StudentDashboardController::class, 'index'])->name('dashboard');
});

// Student routes
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/announcements', [App\Http\Controllers\Student\StudentAnnouncementController::class, 'index'])->name('announcements');
    Route::get('/announcements/{id}', [App\Http\Controllers\Student\StudentAnnouncementController::class, 'show'])->name('announcement.show');
    Route::get('/dashboard', [App\Http\Controllers\Student\StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/messages', [App\Http\Controllers\Student\StudentMessageController::class, 'index'])->name('messages');
    Route::get('/messages/compose', [App\Http\Controllers\Student\StudentMessageController::class, 'compose'])->name('messages.compose');
    Route::post('/messages', [App\Http\Controllers\Student\StudentMessageController::class, 'store'])->name('messages.store');
    Route::get('/support', [App\Http\Controllers\Student\StudentSupportController::class, 'index'])->name('support');
    Route::post('/support', [App\Http\Controllers\Student\StudentSupportController::class, 'store'])->name('support.store');
    Route::get('/payout-history', [App\Http\Controllers\Student\StudentPayoutController::class, 'index'])->name('payout');
    Route::get('/profile', [App\Http\Controllers\Student\StudentProfileController::class, 'index'])->name('profile');
    Route::post('/profile/password', [App\Http\Controllers\Student\StudentProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Payout document routes
    Route::get('/payout-documents', [App\Http\Controllers\Student\PayoutDocumentController::class, 'index'])->name('payout-documents.index');
    Route::get('/payout-documents/create/{eventId}', [App\Http\Controllers\Student\PayoutDocumentController::class, 'create'])->name('payout-documents.create');
    Route::post('/payout-documents/{eventId}', [App\Http\Controllers\Student\PayoutDocumentController::class, 'store'])->name('payout-documents.store');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/approvals', [AdminApprovalController::class, 'index'])->name('approvals.index');
    Route::get('/approvals/{application}', [AdminApprovalController::class, 'show'])->name('approvals.show');
    Route::post('/approvals/{application}/approve', [AdminApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{application}/reject', [AdminApprovalController::class, 'reject'])->name('approvals.reject');
    Route::post('/approvals/documents/{document}/verify', [AdminApprovalController::class, 'verifyDocument'])->name('approvals.documents.verify');
    Route::post('/approvals/documents/{document}/reject', [AdminApprovalController::class, 'rejectDocument'])->name('approvals.documents.reject');
    
    Route::get('/students', [App\Http\Controllers\Admin\AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}', [App\Http\Controllers\Admin\AdminStudentController::class, 'show'])->name('students.show');
    Route::post('/students/{id}/status', [App\Http\Controllers\Admin\AdminStudentController::class, 'updateStatus'])->name('students.update-status');
    
    Route::get('/batches', [App\Http\Controllers\Admin\BatchManagementController::class, 'index'])->name('batches.index');
    Route::get('/batches/create', [App\Http\Controllers\Admin\BatchManagementController::class, 'create'])->name('batches.create');
    Route::post('/batches', [App\Http\Controllers\Admin\BatchManagementController::class, 'store'])->name('batches.store');
    Route::get('/batches/{batch}', [App\Http\Controllers\Admin\BatchManagementController::class, 'show'])->name('batches.show');
    Route::get('/batches/{batch}/edit', [App\Http\Controllers\Admin\BatchManagementController::class, 'edit'])->name('batches.edit');
    Route::put('/batches/{batch}', [App\Http\Controllers\Admin\BatchManagementController::class, 'update'])->name('batches.update');
    Route::post('/batches/{batch}/activate', [App\Http\Controllers\Admin\BatchManagementController::class, 'activate'])->name('batches.activate');
    Route::post('/batches/{batch}/assign', [App\Http\Controllers\Admin\BatchManagementController::class, 'assignApplication'])->name('batches.assign');
    Route::delete('/batches/applications/{application}', [App\Http\Controllers\Admin\BatchManagementController::class, 'removeApplication'])->name('batches.remove-application');
    Route::post('/batches/{batch}/generate-qr', [App\Http\Controllers\Admin\BatchManagementController::class, 'generateQRForBatch'])->name('batches.generate-qr');
    
    Route::get('/attendance', [App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/scan', [App\Http\Controllers\Admin\AttendanceController::class, 'scanQR'])->name('attendance.scan');
    
    Route::get('/payouts', [App\Http\Controllers\Admin\PayoutController::class, 'index'])->name('payouts.index');
    Route::get('/payouts/create', [App\Http\Controllers\Admin\PayoutController::class, 'create'])->name('payouts.create');
    Route::post('/payouts', [App\Http\Controllers\Admin\PayoutController::class, 'store'])->name('payouts.store');
    Route::get('/payouts/{payout}', [App\Http\Controllers\Admin\PayoutController::class, 'show'])->name('payouts.show');
    Route::post('/payouts/{payout}/release', [App\Http\Controllers\Admin\PayoutController::class, 'release'])->name('payouts.release');
    Route::post('/batches/{batch}/release-payouts', [App\Http\Controllers\Admin\PayoutController::class, 'releaseBatch'])->name('payouts.release-batch');
    Route::post('/payouts/{payout}/claim', [App\Http\Controllers\Admin\PayoutController::class, 'claim'])->name('payouts.claim');
    Route::post('/payouts/{payout}/cancel', [App\Http\Controllers\Admin\PayoutController::class, 'cancel'])->name('payouts.cancel');
    
    Route::get('/announcements', [App\Http\Controllers\Admin\AdminAnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [App\Http\Controllers\Admin\AdminAnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [App\Http\Controllers\Admin\AdminAnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [App\Http\Controllers\Admin\AdminAnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [App\Http\Controllers\Admin\AdminAnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [App\Http\Controllers\Admin\AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');
    
    // Payout event routes
    Route::post('/payout-events/validate-qr', [App\Http\Controllers\Admin\AdminPayoutController::class, 'validateQR'])->name('payout-events.validate-qr');
    Route::post('/payout-events/scan-qr', [App\Http\Controllers\Admin\AdminPayoutController::class, 'scanQR'])->name('payout-events.scan-qr');
    Route::get('/payout-events', [App\Http\Controllers\Admin\AdminPayoutController::class, 'index'])->name('payout-events.index');
    Route::get('/payout-events/create', [App\Http\Controllers\Admin\AdminPayoutController::class, 'create'])->name('payout-events.create');
    Route::post('/payout-events', [App\Http\Controllers\Admin\AdminPayoutController::class, 'store'])->name('payout-events.store');
    Route::get('/payout-events/{eventId}', [App\Http\Controllers\Admin\AdminPayoutController::class, 'show'])->name('payout-events.show');
    Route::get('/payout-events/{eventId}/documents', [App\Http\Controllers\Admin\AdminPayoutController::class, 'documents'])->name('payout-events.documents');
    Route::post('/payout-events/documents/{documentId}/approve', [App\Http\Controllers\Admin\AdminPayoutController::class, 'approveDocument'])->name('payout-events.documents.approve');
    Route::post('/payout-events/documents/{documentId}/reject', [App\Http\Controllers\Admin\AdminPayoutController::class, 'rejectDocument'])->name('payout-events.documents.reject');
    Route::get('/payout-events/{eventId}/attendance', [App\Http\Controllers\Admin\AdminPayoutController::class, 'attendance'])->name('payout-events.attendance');
    Route::get('/payout-events/{eventId}/history', [App\Http\Controllers\Admin\AdminPayoutController::class, 'history'])->name('payout-events.history');
});
