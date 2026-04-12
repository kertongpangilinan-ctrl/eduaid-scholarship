<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - EduAid</title>
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
                    <a href="{{ route('student.announcements') }}" class="text-red-600 font-medium transition-colors text-sm">ANNOUNCEMENT</a>
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
            <div id="mobileMenu" class="hidden md:hidden mt-4 pb-4 border-t border-gray-200">
                <div class="flex flex-col space-y-3 pt-4">
                    <a href="{{ route('student.dashboard') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm py-2">DASHBOARD</a>
                    <a href="{{ route('student.announcements') }}" class="text-red-600 font-medium transition-colors text-sm py-2">ANNOUNCEMENTS</a>
                    <a href="{{ route('student.payout') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm py-2">PAYOUT</a>
                    <a href="{{ route('student.messages') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm py-2">MESSAGE</a>
                    <a href="{{ route('student.support') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm py-2">SUPPORT</a>
                    <a href="{{ route('student.profile') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm py-2">PROFILE</a>
                    <div class="relative" x-data="notifications">
                        <button @click="open = !open" class="flex items-center py-2 text-gray-700 hover:text-red-600 text-sm font-medium">
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
                        <button type="submit" class="text-left text-red-600 font-medium transition-colors text-sm py-2">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
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
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Announcements</h1>
            <p class="text-gray-600">Stay updated with the latest news and updates</p>
        </div>

        <!-- Search & Filter -->
        <div class="glass-card rounded-3xl p-6 mb-8 slide-in">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search announcements..." 
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all">
                    </div>
                </div>
                
                <!-- Filter -->
                <div class="md:w-64">
                    <select name="type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all bg-white">
                        <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                        <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>General</option>
                        <option value="scholarship" {{ request('type') == 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                        <option value="payout" {{ request('type') == 'payout' ? 'selected' : '' }}>Payout</option>
                        <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Event</option>
                        <option value="deadline" {{ request('type') == 'deadline' ? 'selected' : '' }}>Deadline</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Priority Announcements Carousel -->
        @if($priorityAnnouncements->count() > 0)
        <div class="mb-8 slide-in">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-star text-yellow-500 mr-2"></i>
                Priority Announcements
            </h2>
            <div class="relative">
                <!-- Carousel Container -->
                <div id="priorityCarousel" class="overflow-hidden rounded-2xl">
                    <div id="priorityCarouselInner" class="flex transition-transform duration-500 ease-in-out">
                        @foreach($priorityAnnouncements as $announcement)
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
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/20 backdrop-blur-sm text-white">
                                        {{ ucfirst($announcement->announcement_type) }}
                                    </span>
                                </div>
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
                @if($priorityAnnouncements->count() > 1)
                <button onclick="prevPrioritySlide()" class="absolute left-2 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-100 transition-colors z-10">
                    <i class="fas fa-chevron-left text-gray-700"></i>
                </button>
                <button onclick="nextPrioritySlide()" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-100 transition-colors z-10">
                    <i class="fas fa-chevron-right text-gray-700"></i>
                </button>
                
                <!-- Carousel Indicators -->
                <div class="flex justify-center mt-4 space-x-2">
                    @foreach($priorityAnnouncements as $index => $announcement)
                    <button onclick="goToPrioritySlide({{ $index }})" class="priority-carousel-indicator w-2 h-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-[#B91C1C] w-6' : 'bg-gray-300' }}"></button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Regular Announcements -->
        <div class="slide-in">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-newspaper text-red-600 mr-2"></i>
                All Announcements
            </h2>
            @if($announcements->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($announcements as $announcement)
                <div class="glass-card rounded-2xl p-5 hover-lift cursor-pointer relative group" onclick="window.location.href='{{ route('student.announcement.show', $announcement->announcement_id) }}'">
                    <div class="flex items-start justify-between mb-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                            @if($announcement->announcement_type == 'general') bg-gray-100 text-gray-800
                            @elseif($announcement->announcement_type == 'scholarship') bg-red-100 text-red-800
                            @elseif($announcement->announcement_type == 'payout') bg-green-100 text-green-800
                            @elseif($announcement->announcement_type == 'event') bg-blue-100 text-blue-800
                            @elseif($announcement->announcement_type == 'deadline') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($announcement->announcement_type) }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $announcement->published_at->format('M d, Y') }}</span>
                    </div>
                    @if($announcement->image_path)
                    <div class="h-32 bg-cover bg-center rounded-xl mb-3" style="background-image: url('{{ asset('storage/' . $announcement->image_path) }}')"></div>
                    @endif
                    <h3 class="text-base font-bold text-gray-800 mb-2 line-clamp-2">{{ $announcement->title }}</h3>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ Str::limit($announcement->content, 80) }}</p>
                    <div class="flex items-center justify-between">
                        @if($announcement->when_info || $announcement->where_info)
                        <div class="flex items-center space-x-2 text-xs text-gray-500">
                            @if($announcement->when_info)
                            <span class="flex items-center"><i class="fas fa-clock mr-1"></i>{{ Str::limit($announcement->when_info, 15) }}</span>
                            @endif
                            @if($announcement->where_info)
                            <span class="flex items-center"><i class="fas fa-map-marker-alt mr-1"></i>{{ Str::limit($announcement->where_info, 15) }}</span>
                            @endif
                        </div>
                        @endif
                        <i class="fas fa-arrow-right text-red-600 group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($announcements->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $announcements->links() }}
            </div>
            @endif
            @else
            <div class="glass-card rounded-3xl p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                </div>
                <p class="text-gray-500 font-bold text-lg">No announcements found</p>
                <p class="text-gray-400 text-sm mt-1">Check back later for updates</p>
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

        // Auto-submit search on enter
        document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                window.location.href = '?search=' + this.value + '&type=' + document.querySelector('select[name="type"]').value;
            }
        });
        
        // Auto-submit filter on change
        document.querySelector('select[name="type"]').addEventListener('change', function() {
            window.location.href = '?search=' + document.querySelector('input[name="search"]').value + '&type=' + this.value;
        });

        // Priority carousel functions
        let currentPrioritySlide = 0;
        const totalPrioritySlides = {{ $priorityAnnouncements->count() }};

        function showPrioritySlide(index) {
            const carouselInner = document.getElementById('priorityCarouselInner');
            if (!carouselInner) return;
            
            currentPrioritySlide = index;
            if (currentPrioritySlide >= totalPrioritySlides) currentPrioritySlide = 0;
            if (currentPrioritySlide < 0) currentPrioritySlide = totalPrioritySlides - 1;
            
            carouselInner.style.transform = `translateX(-${currentPrioritySlide * 100}%)`;
            
            // Update indicators
            const indicators = document.querySelectorAll('.priority-carousel-indicator');
            indicators.forEach((indicator, i) => {
                if (i === currentPrioritySlide) {
                    indicator.classList.remove('bg-gray-300', 'w-2');
                    indicator.classList.add('bg-[#B91C1C]', 'w-6');
                } else {
                    indicator.classList.remove('bg-[#B91C1C]', 'w-6');
                    indicator.classList.add('bg-gray-300', 'w-2');
                }
            });
        }

        function nextPrioritySlide() {
            showPrioritySlide(currentPrioritySlide + 1);
        }

        function prevPrioritySlide() {
            showPrioritySlide(currentPrioritySlide - 1);
        }

        function goToPrioritySlide(index) {
            showPrioritySlide(index);
        }

        // Auto-advance priority carousel every 5 seconds
        if (totalPrioritySlides > 1) {
            setInterval(nextPrioritySlide, 5000);
        }
    </script>
</body>
</html>
