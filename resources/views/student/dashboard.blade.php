<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Dashboard - EduAid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
        .glass-effect { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
        .glass-card { 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .floating-animation { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .slide-in { animation: slideIn 0.6s ease-out; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite;
        }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(220, 38, 38, 0.3); }
            50% { box-shadow: 0 0 40px rgba(220, 38, 38, 0.6); }
        }
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        .gradient-border {
            position: relative;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            padding: 2px;
            border-radius: 1rem;
        }
        .gradient-border > div {
            background: white;
            border-radius: calc(1rem - 2px);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-red-50 via-white to-red-50">
    
    <!-- ========== NAVBAR ========== -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-[#E5E5E5]">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-full flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-xl">E</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-[#B91C1C] to-[#7F1D1D] bg-clip-text text-transparent">
                            EduAid
                        </h1>
                        <p class="text-xs text-[#737373]">Scholarship Program</p>
                    </div>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('student.dashboard') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">DASHBOARD</a>
                    <a href="{{ route('student.announcements') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">ANNOUNCEMENTS</a>
                    <a href="{{ route('student.payout') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">PAYOUT</a>
                    <a href="{{ route('student.messages') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">MESSAGE</a>
                    <a href="{{ route('student.support') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">SUPPORT</a>
                    <a href="{{ route('student.profile') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">PROFILE</a>
                </div>
                
                <!-- User Info & Logout -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative" x-data="notifications">
                        <button @click="open = !open" @click.outside="open = false" class="w-10 h-10 bg-[#F5F5F5] hover:bg-[#FEE2E2] rounded-xl flex items-center justify-center transition-all duration-250 ease group relative">
                            <i class="fas fa-bell text-[#525252] group-hover:text-[#B91C1C]"></i>
                            <span x-show="unreadCount > 0" x-text="unreadCount > 99 ? '99+' : unreadCount" class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1.5 bg-[#B91C1C] text-white text-xs rounded-full flex items-center justify-center font-bold"></span>
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-[#E5E5E5] z-50">
                            <div class="p-4 border-b border-[#E5E5E5] flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-800">Notifications</h3>
                                <button @click="markAllAsRead()" class="text-xs text-[#B91C1C] hover:text-[#7F1D1D] font-medium">Mark all as read</button>
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                <template x-if="notifications.length > 0">
                                    <div class="divide-y divide-[#E5E5E5]">
                                        <template x-for="notification in notifications" :key="notification.notification_id">
                                            <div @click="markAsRead(notification.notification_id)" class="p-4 hover:bg-[#F5F5F5] transition-colors cursor-pointer" :class="{ 'bg-[#FEE2E2]': !notification.is_read }">
                                                <p class="text-sm font-medium text-gray-800" x-text="notification.title"></p>
                                                <p class="text-xs text-gray-600 mt-1" x-text="notification.message"></p>
                                                <p class="text-xs text-[#A3A3A3] mt-2" x-text="new Date(notification.sent_at).toLocaleString()"></p>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="notifications.length === 0">
                                    <div class="p-8 text-center">
                                        <div class="w-12 h-12 bg-[#F5F5F5] rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-bell text-[#A3A3A3] text-xl"></i>
                                        </div>
                                        <p class="text-sm text-[#525252] font-medium">No notifications</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center space-x-2 bg-[#FEE2E2] rounded-full px-4 py-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-full flex items-center justify-center shadow-sm">
                            <span class="text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-[#737373]">Scholar</p>
                        </div>
                    </div>
                    <button onclick="showQRModal()" class="hidden md:flex items-center px-4 py-2 bg-gradient-to-r from-[#B91C1C] to-[#7F1D1D] text-white rounded-lg hover:from-[#991B1B] hover:to-[#7F1D1D] transition-all duration-250 ease font-medium text-sm shadow-md">
                        <i class="fas fa-qrcode mr-2"></i>QR Code
                    </button>
                    <form action="{{ route('logout') }}" method="POST" class="hidden md:block">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-[#B91C1C] border border-[#B91C1C] rounded-lg hover:bg-[#FEE2E2] transition-all duration-250 ease font-medium text-sm">
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
                <a href="{{ route('student.announcements') }}" class="block py-2 text-gray-700 hover:text-[#B91C1C] text-sm">ANNOUNCEMENT</a>
                <a href="{{ route('student.dashboard') }}" class="block py-2 text-gray-700 hover:text-[#B91C1C] text-sm">DASHBOARD</a>
                <a href="{{ route('student.payout') }}" class="block py-2 text-gray-700 hover:text-[#B91C1C] text-sm">PAYOUT</a>
                <a href="{{ route('student.messages') }}" class="block py-2 text-gray-700 hover:text-[#B91C1C] text-sm">MESSAGE</a>
                <a href="{{ route('student.support') }}" class="block py-2 text-gray-700 hover:text-[#B91C1C] text-sm">SUPPORT</a>
                <a href="{{ route('student.profile') }}" class="block py-2 text-gray-700 hover:text-[#B91C1C] text-sm">PROFILE</a>
                <div class="relative" x-data="notifications">
                    <button @click="open = !open" class="flex items-center py-2 text-gray-700 hover:text-[#B91C1C] text-sm">
                        <i class="fas fa-bell mr-2"></i>
                        <span>NOTIFICATIONS</span>
                        <span x-show="unreadCount > 0" x-text="unreadCount > 99 ? '99+' : unreadCount" class="ml-2 min-w-[20px] h-5 px-1.5 bg-[#B91C1C] text-white text-xs rounded-full flex items-center justify-center font-bold"></span>
                    </button>
                    
                    <!-- Notification Dropdown -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-[#E5E5E5] z-50">
                        <div class="p-4 border-b border-[#E5E5E5] flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-800">Notifications</h3>
                            <button @click="markAllAsRead()" class="text-xs text-[#B91C1C] hover:text-[#7F1D1D] font-medium">Mark all as read</button>
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            <template x-if="notifications.length > 0">
                                <div class="divide-y divide-[#E5E5E5]">
                                    <template x-for="notification in notifications" :key="notification.notification_id">
                                        <div @click="markAsRead(notification.notification_id)" class="p-4 hover:bg-[#F5F5F5] transition-colors cursor-pointer" :class="{ 'bg-[#FEE2E2]': !notification.is_read }">
                                            <p class="text-sm font-medium text-gray-800" x-text="notification.title"></p>
                                            <p class="text-xs text-gray-600 mt-1" x-text="notification.message"></p>
                                            <p class="text-xs text-[#A3A3A3] mt-2" x-text="new Date(notification.sent_at).toLocaleString()"></p>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="notifications.length === 0">
                                <div class="p-8 text-center">
                                    <div class="w-12 h-12 bg-[#F5F5F5] rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-bell text-[#A3A3A3] text-xl"></i>
                                    </div>
                                    <p class="text-sm text-[#525252] font-medium">No notifications</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block py-2 text-left text-[#B91C1C] text-sm font-medium">LOGOUT</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- ========== MAIN CONTENT ========== -->
    <div class="container mx-auto px-4 py-8">
        
        <!-- Welcome Section -->
        <div class="slide-in mb-8">
            <div class="bg-gradient-to-r from-red-600 via-red-700 to-red-800 rounded-3xl shadow-2xl p-8 md:p-10 text-white relative overflow-hidden hover-lift">
                <div class="absolute top-0 right-0 w-80 h-80 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/2 floating-animation"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-400 opacity-10 rounded-full translate-y-1/2 -translate-x-1/2 floating-animation" style="animation-delay: 1s;"></div>
                <div class="absolute top-1/2 right-1/4 w-32 h-32 bg-white opacity-5 rounded-full floating-animation" style="animation-delay: 2s;"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <p class="text-red-200 text-sm font-medium mb-2 tracking-wide">WELCOME BACK</p>
                            <h1 class="text-3xl md:text-5xl font-bold mb-3">
                                {{ auth()->user()->name }}! 👋
                            </h1>
                            <p class="text-red-100 text-lg md:text-xl">Your scholarship journey continues</p>
                        </div>
                        <div class="text-right">
                            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-3 border border-white/30 pulse-glow">
                                <span class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>
                                <span class="text-sm md:text-base font-semibold">
                                    {{ ucfirst(str_replace('_', ' ', auth()->user()->account_status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6 mb-8 slide-in">
            <div class="card p-3 md:p-6 hover:shadow-lg transition-all duration-250 ease group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-[10px] md:text-xs font-medium tracking-wide mb-1">UNREAD MESSAGES</p>
                        <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $unreadMessages ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 md:w-14 md:h-14 bg-gradient-to-br from-[#3B82F6] to-[#2563EB] rounded-xl md:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md">
                        <i class="fas fa-envelope text-white text-sm md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="card p-3 md:p-6 hover:shadow-lg transition-all duration-250 ease group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-[10px] md:text-xs font-medium tracking-wide mb-1">ANNOUNCEMENTS</p>
                        <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $recentAnnouncements->count() ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 md:w-14 md:h-14 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-xl md:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md">
                        <i class="fas fa-bullhorn text-white text-sm md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="card p-3 md:p-6 hover:shadow-lg transition-all duration-250 ease group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-[10px] md:text-xs font-medium tracking-wide mb-1">BATCH NO.</p>
                        <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $application->batch_id ?? 'N/A' }}</p>
                    </div>
                    <div class="w-10 h-10 md:w-14 md:h-14 bg-gradient-to-br from-[#10B981] to-[#059669] rounded-xl md:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md">
                        <i class="fas fa-users text-white text-sm md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="card p-3 md:p-6 hover:shadow-lg transition-all duration-250 ease group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-[10px] md:text-xs font-medium tracking-wide mb-1">STATUS</p>
                        <p class="text-base md:text-xl font-bold mt-1">
                            @if($application && $application->status === 'approved')
                                <span class="text-[#10B981]">Approved</span>
                            @elseif($application && $application->status === 'rejected')
                                <span class="text-[#EF4444]">Rejected</span>
                            @elseif($application && $application->status === 'pending')
                                <span class="text-[#F59E0B]">Pending</span>
                            @else
                                <span class="text-gray-600">N/A</span>
                            @endif
                        </p>
                    </div>
                    <div class="w-10 h-10 md:w-14 md:h-14 bg-gradient-to-br from-[#8B5CF6] to-[#7C3AED] rounded-xl md:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md">
                        <i class="fas fa-file-signature text-white text-sm md:text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 slide-in">
            <!-- Quick Actions - Small squares on left in desktop -->
            <div class="lg:col-span-1 hidden lg:block space-y-6">
                <div class="card p-4 hover:shadow-lg transition-all duration-250 ease">
                    <h2 class="heading-4 flex items-center text-sm mb-3">
                        <i class="fas fa-bolt text-[#B91C1C] mr-2"></i>
                        Quick Actions
                    </h2>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('student.profile') }}" class="group">
                            <div class="rounded-xl p-3 text-center bg-gradient-to-br from-[#D1FAE5] to-[#A7F3D0] border border-[#D1FAE5] hover:from-[#A7F3D0] hover:to-[#6EE7B7] transition-all duration-250 ease">
                                <div class="w-10 h-10 bg-gradient-to-br from-[#10B981] to-[#059669] rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform shadow-md">
                                    <i class="fas fa-user text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-gray-800 text-xs">Profile</h3>
                            </div>
                        </a>
                        <a href="{{ route('student.payout') }}" class="group">
                            <div class="rounded-xl p-3 text-center bg-gradient-to-br from-[#DBEAFE] to-[#BFDBFE] border border-[#DBEAFE] hover:from-[#BFDBFE] hover:to-[#93C5FD] transition-all duration-250 ease">
                                <div class="w-10 h-10 bg-gradient-to-br from-[#3B82F6] to-[#2563EB] rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform shadow-md">
                                    <i class="fas fa-money-bill-wave text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-gray-800 text-xs">Payout</h3>
                            </div>
                        </a>
                        <a href="{{ route('student.messages') }}" class="group">
                            <div class="rounded-xl p-3 text-center bg-gradient-to-br from-[#FEF3C7] to-[#FDE68A] border border-[#FEF3C7] hover:from-[#FDE68A] hover:to-[#FCD34D] transition-all duration-250 ease">
                                <div class="w-10 h-10 bg-gradient-to-br from-[#F59E0B] to-[#D97706] rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform shadow-md">
                                    <i class="fas fa-envelope text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-gray-800 text-xs">Message</h3>
                            </div>
                        </a>
                        <a href="{{ route('student.support') }}" class="group">
                            <div class="rounded-xl p-3 text-center bg-gradient-to-br from-[#FEE2E2] to-[#FECACA] border border-[#FEE2E2] hover:from-[#FECACA] hover:to-[#FCA5A5] transition-all duration-250 ease">
                                <div class="w-10 h-10 bg-gradient-to-br from-[#EF4444] to-[#DC2626] rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform shadow-md">
                                    <i class="fas fa-headset text-white text-lg"></i>
                                </div>
                                <h3 class="font-bold text-gray-800 text-xs">Support</h3>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Mini Calendar - Small square below quick actions -->
                <div class="card p-4 hover:shadow-lg transition-all duration-250 ease">
                    <h2 class="heading-4 flex items-center text-sm">
                        <i class="fas fa-calendar-alt text-[#B91C1C] mr-2"></i>
                        Calendar
                    </h2>
                    <div class="text-center mt-4">
                        <p class="text-xs font-semibold text-gray-600 mb-3">{{ now()->format('F Y') }}</p>
                        <div class="grid grid-cols-7 gap-1 text-[10px]">
                            <div class="text-[#A3A3A3] font-bold py-1">S</div>
                            <div class="text-[#A3A3A3] font-bold py-1">M</div>
                            <div class="text-[#A3A3A3] font-bold py-1">T</div>
                            <div class="text-[#A3A3A3] font-bold py-1">W</div>
                            <div class="text-[#A3A3A3] font-bold py-1">T</div>
                            <div class="text-[#A3A3A3] font-bold py-1">F</div>
                            <div class="text-[#A3A3A3] font-bold py-1">S</div>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-[10px]">
                            @php
                                $currentDay = now()->day;
                                $currentMonth = now()->month;
                                $currentYear = now()->year;
                                $firstDayOfMonth = now()->firstOfMonth()->dayOfWeekIso;
                                $daysInMonth = now()->daysInMonth;
                                $payoutEvents = $payoutEvents ?? collect();
                            @endphp
                            
                            @for($i = 1; $i < $firstDayOfMonth; $i++)
                                <div class="py-1"></div>
                            @endfor
                            
                            @for($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $date = \Carbon\Carbon::create($currentYear, $currentMonth, $day);
                                    $hasPayoutEvent = $payoutEvents->contains('event_date', $date->format('Y-m-d'));
                                    $isToday = $day === $currentDay;
                                @endphp
                                <div class="py-1 rounded-full @if($isToday) bg-[#B91C1C] text-white font-bold @elseif($hasPayoutEvent) bg-[#FEE2E2] text-[#B91C1C] font-bold @endif hover:bg-gray-100 cursor-default">
                                    {{ $day }}
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Announcements - Full right side -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Recent Announcements Preview -->
                <div class="card p-6 hover:shadow-lg transition-all duration-250 ease">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="heading-4 flex items-center">
                            <i class="fas fa-newspaper text-[#B91C1C] mr-2"></i>
                            Recent Announcements
                        </h2>
                        <a href="{{ route('student.announcements') }}" class="inline-flex items-center px-4 py-2 bg-[#FEE2E2] text-[#B91C1C] rounded-xl font-medium hover:bg-[#FECACA] transition-colors">
                            View All <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    
                    @if($recentAnnouncements->count() > 0)
                    <div class="relative">
                        <!-- Carousel Container -->
                        <div id="announcementCarousel" class="overflow-hidden rounded-2xl">
                            <div id="carouselInner" class="flex transition-transform duration-500 ease-in-out">
                                @foreach($recentAnnouncements as $announcement)
                                <div class="w-full flex-shrink-0 h-96 rounded-2xl cursor-pointer hover:shadow-md transition-all duration-250 ease overflow-hidden relative" onclick="window.location.href='{{ route('student.announcement.show', $announcement->announcement_id) }}'">
                                    @if($announcement->image_path)
                                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $announcement->image_path) }}')"></div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                                    @else
                                    <div class="absolute inset-0 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] flex items-center justify-center">
                                        <i class="fas fa-bullhorn text-white text-4xl"></i>
                                    </div>
                                    @endif
                                    <div class="absolute bottom-0 left-0 right-0 p-5">
                                        <p class="font-bold text-white">{{ $announcement->title }}</p>
                                        <p class="text-sm text-white/90 mt-1">{{ Str::limit($announcement->content, 100) }}</p>
                                        <p class="text-xs text-white/80 mt-2">
                                            <i class="fas fa-calendar mr-1"></i>{{ $announcement->published_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Carousel Controls -->
                        @if($recentAnnouncements->count() > 1)
                        <button onclick="prevSlide()" class="absolute left-2 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-100 transition-colors z-10">
                            <i class="fas fa-chevron-left text-gray-700"></i>
                        </button>
                        <button onclick="nextSlide()" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-100 transition-colors z-10">
                            <i class="fas fa-chevron-right text-gray-700"></i>
                        </button>
                        
                        <!-- Carousel Indicators -->
                        <div class="flex justify-center mt-4 space-x-2">
                            @foreach($recentAnnouncements as $index => $announcement)
                            <button onclick="goToSlide({{ $index }})" class="carousel-indicator w-2 h-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-[#B91C1C] w-6' : 'bg-gray-300' }}"></button>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="text-center py-10">
                        <div class="w-16 h-16 bg-[#F5F5F5] rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-[#A3A3A3] text-2xl"></i>
                        </div>
                        <p class="text-[#525252] font-medium">No recent announcements</p>
                        <p class="text-[#A3A3A3] text-sm mt-1">Check back later for updates</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- QR Code Modal -->
    <div id="qrModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full mx-4 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Your QR Code</h3>
                <button onclick="hideQRModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="flex flex-col items-center">
                @if(auth()->user()->qr_code)
                    <div class="bg-white p-4 rounded-xl border-2 border-gray-200 mb-4">
                        <img id="qrCodeImage" src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ auth()->user()->qr_code }}" alt="QR Code" class="w-48 h-48">
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{{ auth()->user()->qr_code }}</p>
                    <p class="text-xs text-gray-500 text-center mb-4">Show this QR code for payout attendance</p>
                    <button onclick="downloadQRCode()" class="px-6 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 font-medium text-sm shadow-md">
                        <i class="fas fa-download mr-2"></i>Download QR Code
                    </button>
                @else
                    <div class="bg-gray-100 p-8 rounded-xl mb-4">
                        <i class="fas fa-qrcode text-gray-400 text-6xl"></i>
                    </div>
                    <p class="text-sm text-gray-500 text-center">QR code not yet generated</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        function showQRModal() {
            const modal = document.getElementById('qrModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function hideQRModal() {
            const modal = document.getElementById('qrModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function downloadQRCode() {
            const qrCodeImage = document.getElementById('qrCodeImage');
            const qrCode = "{{ auth()->user()->qr_code }}";
            
            // Create a temporary link to download the image
            const link = document.createElement('a');
            link.href = qrCodeImage.src;
            link.download = `QR-Code-${qrCode}.png`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

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

        // Download QR Code
        function downloadQRCode() {
            const qrCode = "{{ $qrCode->qr_code ?? '' }}";
            if (!qrCode) return;
            
            const link = document.createElement('a');
            link.href = "{{ asset('storage/' . ($qrCode->qr_image_path ?? '')) }}";
            link.download = `QR-Code-${qrCode}.png`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Initialize map for payout location
        document.addEventListener('DOMContentLoaded', function() {
            const payoutLocation = "{{ $payoutEvents->first()->location ?? '' }}";
            if (payoutLocation) {
                // Geocode the location using Nominatim (OpenStreetMap)
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(payoutLocation)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            
                            // Initialize map
                            const map = L.map('payout-map').setView([lat, lon], 13);
                            
                            // Add OpenStreetMap tiles
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(map);
                            
                            // Add marker
                            L.marker([lat, lon]).addTo(map)
                                .bindPopup(payoutLocation)
                                .openPopup();
                        }
                    })
                    .catch(error => console.error('Error geocoding location:', error));
            }
        });

        // Tooltip functions
        function showTooltip(tooltipId) {
            const tooltip = document.getElementById(tooltipId);
            if (tooltip) {
                tooltip.classList.remove('opacity-0', 'invisible');
                tooltip.classList.add('opacity-100', 'visible');
            }
        }

        function hideTooltip(tooltipId) {
            const tooltip = document.getElementById(tooltipId);
            if (tooltip) {
                tooltip.classList.remove('opacity-100', 'visible');
                tooltip.classList.add('opacity-0', 'invisible');
            }
        }

        // Carousel functions
        let currentSlide = 0;
        const totalSlides = {{ $recentAnnouncements->count() }};

        function showSlide(index) {
            const carouselInner = document.getElementById('carouselInner');
            if (!carouselInner) return;
            
            currentSlide = index;
            if (currentSlide >= totalSlides) currentSlide = 0;
            if (currentSlide < 0) currentSlide = totalSlides - 1;
            
            carouselInner.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update indicators
            const indicators = document.querySelectorAll('.carousel-indicator');
            indicators.forEach((indicator, i) => {
                if (i === currentSlide) {
                    indicator.classList.remove('bg-gray-300', 'w-2');
                    indicator.classList.add('bg-[#B91C1C]', 'w-6');
                } else {
                    indicator.classList.remove('bg-[#B91C1C]', 'w-6');
                    indicator.classList.add('bg-gray-300', 'w-2');
                }
            });
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }

        function goToSlide(index) {
            showSlide(index);
        }

        // Auto-advance carousel every 5 seconds
        if (totalSlides > 1) {
            setInterval(nextSlide, 5000);
        }
    </script>
</body>
</html>
