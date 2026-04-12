<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payout Documents - EduAid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, .logo, .nav-links {
            font-family: 'Poppins', sans-serif;
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
                    <a href="{{ route('student.announcements') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">ANNOUNCEMENT</a>
                    <a href="{{ route('student.dashboard') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">DASHBOARD</a>
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
                    <form action="{{ route('logout') }}" method="POST" class="hidden md:block">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition-all duration-300 font-medium text-sm">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                    
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="md:hidden">
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
                <a href="{{ route('student.profile') }}" class="block py-2 text-gray-700 hover:text-red-600 text-sm">PROFILE</a>
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
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Payout Documents</h1>
            <p class="text-gray-600 mt-2">Submit your COR, COE, and COG for payout events</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                {{ session('info') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Submitted Documents</h2>
            </div>
            
            @if($documents->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin Notes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($documents as $document)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $document->payout->event_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $document->payout->event_date->format('F d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $document->submitted_at ? $document->submitted_at->format('F d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($document->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($document->status == 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                        @elseif($document->status == 'rejected')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $document->admin_notes ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-4 text-center text-gray-500">
                    No documents submitted yet.
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
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
    </script>
</body>
</html>
