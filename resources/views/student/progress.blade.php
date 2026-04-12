<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracker - EduAid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --red-primary: #dc2626;
            --red-dark: #b91c1c;
            --red-darker: #991b1b;
            --red-light: #ef4444;
            --red-lighter: #fca5a5;
            --red-soft: #fef2f2;
            --gold: #fbbf24;
            --gold-dark: #f59e0b;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, .logo, .nav-links {
            font-family: 'Poppins', sans-serif;
        }
        .bg-red-gradient { background: linear-gradient(135deg, #dc2626, #b91c1c); }
        .text-red-gradient { background: linear-gradient(135deg, #dc2626, #b91c1c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .glass-card { 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .slide-in { animation: slideIn 0.6s ease-out; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        .timeline-item {
            position: relative;
            padding-left: 40px;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, #dc2626, #b91c1c);
            border-radius: 3px;
        }
        .timeline-item::after {
            content: '';
            position: absolute;
            left: -6px;
            top: 0;
            width: 15px;
            height: 15px;
            background: #dc2626;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 3px #dc2626;
        }
        .timeline-item.completed::after {
            background: #10b981;
            box-shadow: 0 0 0 3px #10b981;
        }
        .timeline-item.pending::after {
            background: #f59e0b;
            box-shadow: 0 0 0 3px #f59e0b;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-red-50 via-white to-red-50">
    
    <!-- ========== NAVBAR ========== -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-800 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-xl">E</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-red-600 to-red-800 bg-clip-text text-transparent">
                            EduAid
                        </h1>
                        <p class="text-xs text-gray-500">Scholarship Program</p>
                    </div>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('student.dashboard') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">DASHBOARD</a>
                    <a href="{{ route('student.announcements') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">ANNOUNCEMENTS</a>
                    <a href="{{ route('student.qr') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">QR CODE</a>
                    <a href="{{ route('student.payout') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">PAYOUT</a>
                    <a href="{{ route('student.messages') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">MESSAGE</a>
                    <a href="{{ route('student.support') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">SUPPORT</a>
                    <a href="{{ route('student.profile') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">PROFILE</a>
                </div>
                
                <!-- User Info & Logout -->
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-2 bg-red-50 rounded-full px-4 py-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-red-600 to-red-800 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Scholar</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition-all duration-300 font-medium text-sm">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- ========== MAIN CONTENT ========== -->
    <div class="container mx-auto px-4 py-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Progress Tracker</h1>
            <p class="text-gray-600">Track your scholarship application status</p>
        </div>

        @if($application)
        <!-- Application Status Card -->
        <div class="glass-card rounded-3xl p-8 mb-8 slide-in hover-lift">
            <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Application Status</h2>
                    <p class="text-gray-600">Reference Number: <span class="font-mono font-semibold text-gray-800">{{ $application->reference_number }}</span></p>
                </div>
                <div class="text-right">
                    @if($application->status === 'approved')
                    <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl shadow-lg">
                        <i class="fas fa-check-circle text-white text-xl mr-2"></i>
                        <span class="text-white font-bold text-lg">Approved</span>
                    </div>
                    @elseif($application->status === 'rejected')
                    <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl shadow-lg">
                        <i class="fas fa-times-circle text-white text-xl mr-2"></i>
                        <span class="text-white font-bold text-lg">Rejected</span>
                    </div>
                    @elseif($application->status === 'pending')
                    <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl shadow-lg">
                        <i class="fas fa-clock text-white text-xl mr-2"></i>
                        <span class="text-white font-bold text-lg">Pending</span>
                    </div>
                    @else
                    <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 rounded-2xl shadow-lg">
                        <i class="fas fa-spinner text-white text-xl mr-2"></i>
                        <span class="text-white font-bold text-lg">{{ ucfirst($application->status) }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="space-y-6">
                <div class="timeline-item completed pb-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="fas fa-check text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Application Submitted</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $application->submission_date->format('F d, Y - g:i A') }}</p>
                        </div>
                    </div>
                </div>

                @if($application->status === 'under_review')
                <div class="timeline-item pending pb-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="fas fa-search text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Under Review</h3>
                            <p class="text-sm text-gray-500 mt-1">Your application is being reviewed by the admin team.</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($application->status === 'approved')
                <div class="timeline-item completed pb-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="fas fa-award text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Approved</h3>
                            <p class="text-sm text-gray-500 mt-1">@if($application->approved_date)Approved on {{ $application->approved_date->format('F d, Y - g:i A') }}@endif</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($application->status === 'rejected')
                <div class="timeline-item pb-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="fas fa-times-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Rejected</h3>
                            <p class="text-sm text-gray-500 mt-1">Your application was not approved.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Admin Notes (if rejected) -->
            @if($application->status === 'rejected' && $application->rejection_reason)
            <div class="mt-8 bg-gradient-to-r from-red-50 to-red-100 border-2 border-red-200 rounded-2xl p-6">
                <h3 class="font-bold text-red-800 mb-3 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Reason for Rejection
                </h3>
                <p class="text-red-700">{{ $application->rejection_reason }}</p>
            </div>
            @endif

            @if($application->admin_notes)
            <div class="mt-8 bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl p-6">
                <h3 class="font-bold text-blue-800 mb-3 flex items-center">
                    <i class="fas fa-sticky-note mr-2"></i>
                    Admin Notes
                </h3>
                <p class="text-blue-700">{{ $application->admin_notes }}</p>
            </div>
            @endif
        </div>

        <!-- Re-Apply Form (if rejected) -->
        @if($application->status === 'rejected')
        <div class="glass-card rounded-3xl p-8 slide-in hover-lift">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-redo text-red-600 mr-2"></i>
                Re-Apply for Scholarship
            </h2>
            <p class="text-gray-600 mb-6">Your application was rejected. You can re-apply with updated information. No need to create a new account.</p>
            
            <form action="{{ route('register') }}" method="GET" class="space-y-6">
                <div class="bg-gradient-to-r from-red-50 to-red-100 border-2 border-red-200 rounded-2xl p-5">
                    <p class="text-sm text-red-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Important:</strong> Please review the rejection reason above and ensure you have addressed all issues before re-applying.
                    </p>
                </div>
                
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl font-bold hover:from-red-700 hover:to-red-800 transition-all shadow-xl">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Start Re-Application
                </button>
            </form>
        </div>
        @endif
        @else
        <!-- No Application Found -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-100">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-file-signature text-gray-400 text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">No Application Found</h2>
            <p class="text-gray-600 mb-6">You haven't submitted a scholarship application yet.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Apply Now
            </a>
        </div>
        @endif
    </div>
</body>
</html>
