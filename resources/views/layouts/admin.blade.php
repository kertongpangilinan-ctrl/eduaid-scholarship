<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - EduAid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, .logo, .nav-links {
            font-family: 'Poppins', sans-serif;
        }
        .nav-item {
            transition: all 0.25s ease;
        }
        .nav-item:hover {
            transform: translateX(4px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-56 bg-gray-800 text-white flex flex-col shadow-2xl transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <!-- Logo -->
            <div class="p-5 border-b border-[#374151]/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="logo text-lg font-bold tracking-tight">EduAid</h1>
                        <p class="text-[10px] text-[#9CA3AF] font-medium tracking-wide uppercase">Admin Portal</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false" class="nav-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#B91C1C] to-[#7F1D1D] text-white shadow-md' : 'text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white' }} transition-all text-sm font-medium">
                    <i class="fas fa-th-large w-5 text-center"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('admin.approvals.index') }}" @click="sidebarOpen = false" class="nav-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.approvals.*') ? 'bg-gradient-to-r from-[#B91C1C] to-[#7F1D1D] text-white shadow-md' : 'text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white' }} transition-all text-sm font-medium">
                    <i class="fas fa-clipboard-check w-5 text-center"></i>
                    <span class="ml-3">Approvals</span>
                </a>
                <a href="{{ route('admin.students.index') }}" @click="sidebarOpen = false" class="nav-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.students.*') ? 'bg-gradient-to-r from-[#B91C1C] to-[#7F1D1D] text-white shadow-md' : 'text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white' }} transition-all text-sm font-medium">
                    <i class="fas fa-user-graduate w-5 text-center"></i>
                    <span class="ml-3">Students</span>
                </a>
                <a href="{{ route('admin.payout-events.index') }}" @click="sidebarOpen = false" class="nav-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.payout-events.*') ? 'bg-gradient-to-r from-[#B91C1C] to-[#7F1D1D] text-white shadow-md' : 'text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white' }} transition-all text-sm font-medium">
                    <i class="fas fa-calendar-check w-5 text-center"></i>
                    <span class="ml-3">Payout Events</span>
                </a>
                <a href="{{ route('admin.announcements.index') }}" @click="sidebarOpen = false" class="nav-item flex items-center px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.announcements.*') ? 'bg-gradient-to-r from-[#B91C1C] to-[#7F1D1D] text-white shadow-md' : 'text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white' }} transition-all text-sm font-medium">
                    <i class="fas fa-bullhorn w-5 text-center"></i>
                    <span class="ml-3">Announcements</span>
                </a>
                <a href="#" @click="sidebarOpen = false" class="nav-item flex items-center px-3 py-2.5 rounded-lg text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white transition-all text-sm font-medium">
                    <i class="fas fa-envelope w-5 text-center"></i>
                    <span class="ml-3">Messages</span>
                </a>
                <a href="#" @click="sidebarOpen = false" class="nav-item flex items-center px-3 py-2.5 rounded-lg text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white transition-all text-sm font-medium">
                    <i class="fas fa-chart-bar w-5 text-center"></i>
                    <span class="ml-3">Reports</span>
                </a>
                <a href="#" @click="sidebarOpen = false" class="nav-item flex items-center px-3 py-2.5 rounded-lg text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white transition-all text-sm font-medium">
                    <i class="fas fa-cog w-5 text-center"></i>
                    <span class="ml-3">Settings</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-[#374151]/50 bg-[#111827]/30">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-full flex items-center justify-center shadow-sm">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#9CA3AF]">Administrator</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-3 py-2 bg-[#374151]/50 hover:bg-[#B91C1C] rounded-lg text-xs font-medium transition-all duration-250 ease">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Sidebar Overlay for Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-[#E5E5E5]">
                <div class="px-4 lg:px-6 py-3 flex items-center justify-between">
                    <!-- Left: Mobile Menu & Page Title -->
                    <div class="flex items-center space-x-3">
                        <!-- Mobile Menu Button -->
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden w-10 h-10 bg-[#F5F5F5] hover:bg-[#FEE2E2] rounded-xl flex items-center justify-center transition-all duration-250 ease">
                            <i class="fas fa-bars text-[#525252]"></i>
                        </button>
                        <div class="hidden sm:flex items-center space-x-3">
                            <div class="w-1 h-8 bg-gradient-to-b from-[#B91C1C] to-[#7F1D1D] rounded-full"></div>
                            <h2 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                        </div>
                        <!-- Mobile Title -->
                        <h2 class="text-lg font-semibold text-gray-800 sm:hidden">@yield('header', 'Dashboard')</h2>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex items-center space-x-3">
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

                        <!-- User Dropdown -->
                        <div class="relative">
                            <button class="flex items-center space-x-2 px-3 py-2 bg-[#F5F5F5] hover:bg-[#FEE2E2] rounded-xl transition-all duration-250 ease group">
                                <div class="w-8 h-8 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="hidden sm:block text-sm font-medium text-gray-700 group-hover:text-[#B91C1C]">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-[#A3A3A3]"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
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

    @stack('scripts')
</body>
</html>
