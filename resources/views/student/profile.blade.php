<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - EduAid</title>
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
            background: rgba(255, 255, 255, 0.95); 
            backdrop-filter: blur(20px); 
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(220, 38, 38, 0.08);
            position: relative;
            overflow: hidden;
        }
        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }
        .glass-card:hover::before {
            left: 100%;
        }
        .slide-in { animation: slideIn 0.6s ease-out; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .hover-lift {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 50px rgba(220, 38, 38, 0.15);
        }
        .gradient-border {
            position: relative;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            padding: 2px;
            border-radius: 1.5rem;
        }
        .gradient-border-inner {
            background: white;
            border-radius: 1.4rem;
            padding: 1.5rem;
        }
        .pulse-glow {
            animation: pulseGlow 2s infinite;
        }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(220, 38, 38, 0.3); }
            50% { box-shadow: 0 0 40px rgba(220, 38, 38, 0.6); }
        }
        .avatar-glow {
            box-shadow: 0 0 30px rgba(220, 38, 38, 0.4);
            animation: avatarGlow 3s infinite alternate;
        }
        @keyframes avatarGlow {
            from { box-shadow: 0 0 30px rgba(220, 38, 38, 0.4); }
            to { box-shadow: 0 0 50px rgba(220, 38, 38, 0.7); }
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
                    <a href="{{ route('student.payout') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">PAYOUT</a>
                    <a href="{{ route('student.messages') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">MESSAGE</a>
                    <a href="{{ route('student.support') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">SUPPORT</a>
                    <a href="{{ route('student.profile') }}" class="text-red-600 font-medium transition-colors text-sm">PROFILE</a>
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
                    <form action="{{ route('logout') }}" method="POST" class="hidden md:block">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition-all duration-300 font-medium text-sm">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>

                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="md:hidden w-10 h-10 bg-[#F5F5F5] hover:bg-[#FEE2E2] rounded-xl flex items-center justify-center transition-all duration-250 ease">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden mt-4 pb-3 space-y-2">
                <a href="{{ route('student.dashboard') }}" class="block py-2 text-gray-700 hover:text-red-600 text-sm">DASHBOARD</a>
                <a href="{{ route('student.announcements') }}" class="block py-2 text-gray-700 hover:text-red-600 text-sm">ANNOUNCEMENTS</a>
                <a href="{{ route('student.payout') }}" class="block py-2 text-gray-700 hover:text-red-600 text-sm">PAYOUT</a>
                <a href="{{ route('student.messages') }}" class="block py-2 text-gray-700 hover:text-red-600 text-sm">MESSAGE</a>
                <a href="{{ route('student.support') }}" class="block py-2 text-gray-700 hover:text-red-600 text-sm">SUPPORT</a>
                <a href="{{ route('student.profile') }}" class="block py-2 text-red-600 font-medium text-sm">PROFILE</a>
                <div class="relative" x-data="notifications">
                    <button @click="open = !open" class="flex items-center py-2 text-gray-700 hover:text-red-600 text-sm">
                        <i class="fas fa-bell mr-2"></i>
                        <span>NOTIFICATIONS</span>
                        <span x-show="unreadCount > 0" x-text="unreadCount > 99 ? '99+' : unreadCount" class="ml-2 min-w-[20px] h-5 px-1.5 bg-red-600 text-white text-xs rounded-full flex items-center justify-center font-bold"></span>
                    </button>
                    
                    <!-- Notification Dropdown -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 z-50">
                        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-800">Notifications</h3>
                            <button @click="markAllAsRead()" class="text-xs text-red-600 hover:text-red-800 font-medium">Mark all as read</button>
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            <template x-if="notifications.length > 0">
                                <div class="divide-y divide-gray-200">
                                    <template x-for="notification in notifications" :key="notification.notification_id">
                                        <div @click="markAsRead(notification.notification_id)" class="p-4 hover:bg-gray-50 transition-colors cursor-pointer" :class="{ 'bg-red-50': !notification.is_read }">
                                            <p class="text-sm font-medium text-gray-800" x-text="notification.title"></p>
                                            <p class="text-xs text-gray-600 mt-1" x-text="notification.message"></p>
                                            <p class="text-xs text-gray-400 mt-2" x-text="new Date(notification.sent_at).toLocaleString()"></p>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="notifications.length === 0">
                                <div class="p-8 text-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-bell text-gray-400 text-xl"></i>
                                    </div>
                                    <p class="text-sm text-gray-500 font-medium">No notifications</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block py-2 text-left text-red-600 text-sm font-medium">LOGOUT</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- ========== MAIN CONTENT ========== -->
    <div class="container mx-auto px-4 py-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">My Profile</h1>
            <p class="text-gray-600">View and manage your account information</p>
        </div>

        <!-- Profile Header -->
        <div class="gradient-border slide-in hover-lift mb-8">
            <div class="gradient-border-inner p-6">
                <div class="flex flex-col md:flex-row items-center md:justify-between gap-4">
                    <div class="flex items-center space-x-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-red-600 via-red-700 to-red-800 rounded-full flex items-center justify-center avatar-glow">
                            <span class="text-white font-bold text-3xl">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">{{ auth()->user()->name }}</h1>
                            <div class="flex items-center space-x-3 mt-2 flex-wrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                    @if(auth()->user()->account_status === 'approved') bg-gradient-to-r from-green-400 to-green-600 text-white
                                    @elseif(auth()->user()->account_status === 'pending_verification') bg-gradient-to-r from-yellow-400 to-yellow-600 text-white
                                    @elseif(auth()->user()->account_status === 'rejected') bg-gradient-to-r from-red-400 to-red-600 text-white
                                    @else bg-gradient-to-r from-gray-400 to-gray-600 text-white
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', auth()->user()->account_status)) }}
                                </span>
                                <span class="text-sm text-gray-600">{{ ucfirst(auth()->user()->role) }}</span>
                                <span class="text-sm text-gray-600">•</span>
                                <span class="text-sm text-gray-600">Joined {{ auth()->user()->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Payouts Mini & Change Password -->
                    <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-3 w-full md:w-auto">
                        <div class="flex items-center space-x-2 bg-gradient-to-r from-green-50 to-green-100 px-4 py-2 rounded-xl border border-green-200">
                            <i class="fas fa-wallet text-green-600"></i>
                            <span class="text-sm font-bold text-gray-700">Recent Payouts: {{ auth()->user()->payouts ? auth()->user()->payouts->take(10)->count() : 0 }}</span>
                        </div>
                        <button onclick="togglePasswordModal()" class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-bold hover:from-red-700 hover:to-red-800 transition-all shadow-xl flex items-center pulse-glow">
                            <i class="fas fa-lock mr-2"></i>
                            Change Password
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Progress Section -->
        @if($application)
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
            @if($application->status === 'rejected' && $application->admin_notes)
            <div class="mt-8 bg-gradient-to-r from-red-50 to-red-100 border-2 border-red-200 rounded-2xl p-6">
                <h3 class="font-bold text-red-800 mb-3 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Admin Notes
                </h3>
                <p class="text-red-700">{{ $application->admin_notes }}</p>
            </div>
            @endif
        </div>
        @endif

        <!-- Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Account Information -->
            <div class="rounded-3xl p-6 slide-in hover-lift border-2 border-red-200 bg-white">
                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-red-600 mr-2"></i>
                    Account Information
                </h2>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">Full Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" disabled class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">Username</label>
                        <input type="text" value="{{ auth()->user()->username }}" disabled class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">Email Address</label>
                        <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                    </div>
                </div>
            </div>

            @if(auth()->user()->personalInfo)
            <!-- Personal Information -->
            <div class="gradient-border slide-in hover-lift">
                <div class="gradient-border-inner">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user text-red-600 mr-2"></i>
                        Personal Information
                    </h2>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Contact Number</label>
                            <input type="text" value="{{ auth()->user()->personalInfo->contact_number ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Date of Birth</label>
                            <input type="text" value="{{ auth()->user()->personalInfo->date_of_birth ? auth()->user()->personalInfo->date_of_birth->format('M d, Y') : 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Gender</label>
                            <input type="text" value="{{ auth()->user()->personalInfo->gender ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Civil Status</label>
                            <input type="text" value="{{ auth()->user()->personalInfo->civil_status ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(auth()->user()->addressInfo)
            <!-- Address Information -->
            <div class="gradient-border slide-in hover-lift">
                <div class="gradient-border-inner">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>
                        Address Information
                    </h2>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">House/Unit Number</label>
                            <input type="text" value="{{ auth()->user()->addressInfo->house_unit_number ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Street Name</label>
                            <input type="text" value="{{ auth()->user()->addressInfo->street_name ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Barangay</label>
                            <input type="text" value="{{ auth()->user()->addressInfo->barangay ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Municipality/City</label>
                            <input type="text" value="{{ auth()->user()->addressInfo->municipality_city ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Province</label>
                            <input type="text" value="{{ auth()->user()->addressInfo->province ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(auth()->user()->familyInfo)
            <!-- Family Information -->
            <div class="gradient-border slide-in hover-lift">
                <div class="gradient-border-inner">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-users text-red-600 mr-2"></i>
                        Family Information
                    </h2>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Father's Name</label>
                            <input type="text" value="{{ auth()->user()->familyInfo->father_name ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Father's Occupation</label>
                            <input type="text" value="{{ auth()->user()->familyInfo->father_occupation ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Mother's Name</label>
                            <input type="text" value="{{ auth()->user()->familyInfo->mother_name ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Mother's Occupation</label>
                            <input type="text" value="{{ auth()->user()->familyInfo->mother_occupation ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Number of Siblings</label>
                            <input type="text" value="{{ auth()->user()->familyInfo->total_siblings ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        
                        @if(auth()->user()->familyInfo && auth()->user()->familyInfo->siblings && auth()->user()->familyInfo->siblings->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <label class="block text-xs font-bold text-gray-500 mb-3">Siblings Details</label>
                                <div class="space-y-3">
                                    @foreach(auth()->user()->familyInfo->siblings as $index => $sibling)
                                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg p-3">
                                            <p class="text-xs font-semibold text-gray-700 mb-2">Sibling {{ $index + 1 }}</p>
                                            <div class="grid grid-cols-2 gap-2 text-xs">
                                                <div>
                                                    <span class="text-gray-500">Name:</span>
                                                    <span class="text-gray-700">{{ $sibling->name ?? 'N/A' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Gender:</span>
                                                    <span class="text-gray-700">{{ $sibling->gender ?? 'N/A' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Birth Date:</span>
                                                    <span class="text-gray-700">{{ $sibling->birth_date ? $sibling->birth_date->format('M d, Y') : 'N/A' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Occupation:</span>
                                                    <span class="text-gray-700">{{ $sibling->occupation ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            @if(auth()->user()->educationalInfo)
            <!-- Educational Information -->
            <div class="gradient-border slide-in hover-lift">
                <div class="gradient-border-inner">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-graduation-cap text-red-600 mr-2"></i>
                        Educational Information
                    </h2>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">School Name</label>
                            <input type="text" value="{{ auth()->user()->educationalInfo->school_name ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Education Level</label>
                            <input type="text" value="{{ auth()->user()->educationalInfo->education_level ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Year Level</label>
                            <input type="text" value="{{ auth()->user()->educationalInfo->year_level ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Semester Type</label>
                            <input type="text" value="{{ auth()->user()->educationalInfo->semester_type ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Current Semester</label>
                            <input type="text" value="{{ auth()->user()->educationalInfo->current_semester ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Learner Reference Number (LRN)</label>
                            <input type="text" value="{{ auth()->user()->educationalInfo->lrn ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">SHS Strand</label>
                            <input type="text" value="{{ auth()->user()->educationalInfo->shs_strand ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">School ID Type</label>
                            <input type="text" value="{{ auth()->user()->educationalInfo->school_id_type ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">School ID Number</label>
                            <input type="text" value="{{ auth()->user()->educationalInfo->school_id_number ?? 'N/A' }}" disabled class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-not-allowed">
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-lock mr-2"></i>
                        Change Password
                    </h2>
                    <button onclick="togglePasswordModal()" class="text-white hover:text-red-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form action="{{ route('student.profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Current Password</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="currentPassword" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all">
                            <button type="button" onclick="togglePassword('currentPassword')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">New Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="newPassword" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all" oninput="checkPasswordStrength()">
                            <button type="button" onclick="togglePassword('newPassword')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-center space-x-2">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div id="strengthBar" class="h-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <span id="strengthText" class="text-xs font-bold text-gray-500">Enter password</span>
                            </div>
                            <p id="strengthMessage" class="text-xs text-gray-500 mt-1">Must be at least 8 characters with uppercase, lowercase, number, and special character</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="confirmPassword" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all">
                            <button type="button" onclick="togglePassword('confirmPassword')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl font-bold hover:from-red-700 hover:to-red-800 transition-all shadow-xl">
                        <i class="fas fa-key mr-2"></i>
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }

        function togglePasswordModal() {
            const modal = document.getElementById('passwordModal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('newPassword').value;
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            const strengthMessage = document.getElementById('strengthMessage');
            
            let strength = 0;
            
            // Check length
            if (password.length >= 8) strength += 1;
            // Check uppercase
            if (/[A-Z]/.test(password)) strength += 1;
            // Check lowercase
            if (/[a-z]/.test(password)) strength += 1;
            // Check numbers
            if (/[0-9]/.test(password)) strength += 1;
            // Check special characters
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            // Update UI based on strength
            if (password.length === 0) {
                strengthBar.style.width = '0%';
                strengthBar.className = 'h-full transition-all duration-300';
                strengthText.textContent = 'Enter password';
                strengthText.className = 'text-xs font-bold text-gray-500';
                strengthMessage.textContent = 'Must be at least 8 characters with uppercase, lowercase, number, and special character';
            } else if (strength <= 2) {
                strengthBar.style.width = '33%';
                strengthBar.className = 'h-full transition-all duration-300 bg-red-500';
                strengthText.textContent = 'Weak';
                strengthText.className = 'text-xs font-bold text-red-500';
                strengthMessage.textContent = 'Add uppercase, lowercase, number, and special character';
            } else if (strength <= 3) {
                strengthBar.style.width = '66%';
                strengthBar.className = 'h-full transition-all duration-300 bg-yellow-500';
                strengthText.textContent = 'Medium';
                strengthText.className = 'text-xs font-bold text-yellow-500';
                strengthMessage.textContent = 'Almost there! Add more complexity';
            } else {
                strengthBar.style.width = '100%';
                strengthBar.className = 'h-full transition-all duration-300 bg-green-500';
                strengthText.textContent = 'Strong';
                strengthText.className = 'text-xs font-bold text-green-500';
                strengthMessage.textContent = 'Great! Your password is strong';
            }
        }

        // Add form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Check if passwords match
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match');
                return false;
            }
        });

        // Notification functionality
        document.addEventListener('alpine:init', () => {
            Alpine.data('notifications', () => ({
                open: false,
                notifications: [],
                unreadCount: 0,

                async init() {
                    await this.fetchNotifications();
                    await this.fetchUnreadCount();
                    
                    // Refresh notifications every 30 seconds
                    setInterval(() => {
                        this.fetchNotifications();
                        this.fetchUnreadCount();
                    }, 30000);
                },

                async fetchNotifications() {
                    try {
                        const response = await fetch('/api/notifications');
                        this.notifications = await response.json();
                    } catch (error) {
                        console.error('Error fetching notifications:', error);
                    }
                },

                async fetchUnreadCount() {
                    try {
                        const response = await fetch('/api/notifications/unread-count');
                        const data = await response.json();
                        this.unreadCount = data.count;
                    } catch (error) {
                        console.error('Error fetching unread count:', error);
                    }
                },

                async markAsRead(id) {
                    try {
                        await fetch(`/api/notifications/${id}/mark-read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        await this.fetchNotifications();
                        await this.fetchUnreadCount();
                    } catch (error) {
                        console.error('Error marking notification as read:', error);
                    }
                },

                async markAllAsRead() {
                    try {
                        await fetch('/api/notifications/mark-all-read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        await this.fetchNotifications();
                        await this.fetchUnreadCount();
                    } catch (error) {
                        console.error('Error marking all notifications as read:', error);
                    }
                }
            }));
        });
    </script>
</body>
</html>
