<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - EduAid</title>
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
                    <a href="{{ route('student.messages') }}" class="text-red-600 font-medium transition-colors text-sm">MESSAGE</a>
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
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Messages</h1>
                <p class="text-gray-600">View your inbox and send messages</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col md:flex-row gap-4 mb-6 slide-in">
            <a href="{{ route('student.messages.compose') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl font-bold hover:from-red-700 hover:to-red-800 transition-all shadow-xl">
                <i class="fas fa-pen mr-2"></i>
                Compose Message
            </a>
            <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-white border-2 border-gray-200 text-gray-700 rounded-2xl font-bold hover:bg-gray-50 transition-all">
                <i class="fas fa-users mr-2"></i>
                Group Chat
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="glass-card rounded-2xl p-6 mb-6 slide-in">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" placeholder="Search messages..." class="w-full px-4 py-3 pl-12 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <select class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all bg-white">
                    <option value="all">All Messages</option>
                    <option value="unread">Unread</option>
                    <option value="read">Read</option>
                    <option value="admin">From Admin</option>
                </select>
                <select class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all bg-white">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                </select>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex gap-2 mb-6 slide-in">
            <button class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-medium transition-all">
                <i class="fas fa-inbox mr-2"></i>Inbox
            </button>
            <button class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-all">
                <i class="fas fa-paper-plane mr-2"></i>Sent
            </button>
            <button class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-all">
                <i class="fas fa-star mr-2"></i>Starred
            </button>
            <button class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-all">
                <i class="fas fa-archive mr-2"></i>Archived
            </button>
            <button class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-all">
                <i class="fas fa-trash mr-2"></i>Trash
            </button>
        </div>

        <!-- Messages List -->
            @if($messages->count() > 0)
            <div class="glass-card rounded-3xl slide-in hover-lift">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-inbox text-red-600 mr-2"></i>
                        Inbox ({{ $messages->count() }})
                    </h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($messages as $message)
                    <div class="p-6 hover:bg-gradient-to-r from-gray-50 to-gray-100 transition-colors cursor-pointer
                        @if(!$message->is_read) bg-gradient-to-r from-blue-50 to-blue-100 @endif">
                        <div class="flex items-start space-x-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <span class="text-white font-bold text-xl">{{ substr($message->sender->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
                                    <div class="flex items-center space-x-3">
                                        <h3 class="font-bold text-gray-800 text-lg">{{ $message->sender->name }}</h3>
                                        @if($message->sender->role === 'admin')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-red-500 to-red-600 text-white">
                                            Admin
                                        </span>
                                        @endif
                                        @if(!$message->is_read)
                                        <span class="w-3 h-3 bg-blue-600 rounded-full animate-pulse"></span>
                                        @endif
                                    </div>
                                    <span class="text-sm text-gray-500 font-medium">{{ $message->created_at->format('M d, Y - g:i A') }}</span>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-2">{{ $message->subject }}</h4>
                                <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($message->message, 100) }}</p>
                                <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-100">
                                    <button class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg text-sm font-medium hover:from-red-700 hover:to-red-800 transition-all">
                                        <i class="fas fa-reply mr-1"></i>Reply
                                    </button>
                                    <button class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-all">
                                        <i class="fas fa-star mr-1"></i>Star
                                    </button>
                                    <button class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-all">
                                        <i class="fas fa-archive mr-1"></i>Archive
                                    </button>
                                    <button class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-all">
                                        <i class="fas fa-check mr-1"></i>Mark Read
                                    </button>
                                    <button class="px-4 py-2 bg-white border border-red-200 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition-all">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($messages->hasPages())
                <div class="p-6 border-t border-gray-200">
                    {{ $messages->links() }}
                </div>
                @endif
            </div>
            @else
            <!-- No Messages -->
            <div class="glass-card rounded-3xl p-12 text-center slide-in">
                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-inbox text-gray-400 text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">No Messages</h2>
                <p class="text-gray-600 mb-6">You haven't received any messages yet.</p>
                <a href="{{ route('student.messages.compose') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl font-bold hover:from-red-700 hover:to-red-800 transition-all shadow-xl">
                    <i class="fas fa-pen mr-2"></i>
                    Send First Message
                </a>
            </div>
            @endif
        </div>

        <!-- Admin Profile Modal -->
        <div id="profileModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white">Admin Profile</h3>
                    <button onclick="closeProfileModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="profileContent" class="p-6">
                    <!-- Profile content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.querySelector('input[placeholder="Search messages..."]').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const messages = document.querySelectorAll('.divide-y > div');
            messages.forEach(message => {
                const text = message.textContent.toLowerCase();
                message.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // Filter functionality
        document.querySelector('select:first-of-type').addEventListener('change', function(e) {
            const filter = e.target.value;
            const messages = document.querySelectorAll('.divide-y > div');
            messages.forEach(message => {
                if (filter === 'all') {
                    message.style.display = 'block';
                } else if (filter === 'unread') {
                    message.style.display = message.classList.contains('bg-gradient-to-r') ? 'block' : 'none';
                } else if (filter === 'read') {
                    message.style.display = !message.classList.contains('bg-gradient-to-r') ? 'block' : 'none';
                } else if (filter === 'admin') {
                    message.style.display = message.textContent.includes('Admin') ? 'block' : 'none';
                }
            });
        });

        // Navigation tabs
        const tabs = document.querySelectorAll('.flex.gap-2 button');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => {
                    t.classList.remove('bg-gradient-to-r', 'from-red-600', 'to-red-700', 'text-white');
                    t.classList.add('bg-white', 'border', 'border-gray-200', 'text-gray-700');
                });
                this.classList.remove('bg-white', 'border', 'border-gray-200', 'text-gray-700');
                this.classList.add('bg-gradient-to-r', 'from-red-600', 'to-red-700', 'text-white');
            });
        });

        // Action buttons
        document.querySelectorAll('.divide-y button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const action = this.textContent.trim();
                const messageRow = this.closest('.divide-y > div');
                
                if (action === 'Delete') {
                    if (confirm('Are you sure you want to delete this message?')) {
                        messageRow.style.display = 'none';
                        alert('Message deleted successfully');
                    }
                } else if (action === 'Mark Read') {
                    messageRow.classList.remove('bg-gradient-to-r', 'from-blue-50', 'to-blue-100');
                    this.textContent = 'Mark Unread';
                    this.innerHTML = '<i class="fas fa-envelope mr-1"></i>Mark Unread';
                } else if (action === 'Mark Unread') {
                    messageRow.classList.add('bg-gradient-to-r', 'from-blue-50', 'to-blue-100');
                    this.textContent = 'Mark Read';
                    this.innerHTML = '<i class="fas fa-check mr-1"></i>Mark Read';
                } else if (action === 'Star') {
                    this.classList.toggle('text-yellow-500');
                    this.classList.toggle('border-yellow-500');
                    alert('Message starred');
                } else if (action === 'Archive') {
                    messageRow.style.display = 'none';
                    alert('Message archived');
                } else if (action === 'Reply') {
                    alert('Reply functionality - This will open a reply modal');
                }
            });
        });

        function showProfileModal(userId) {
            // Load admin profile via AJAX
            fetch(`/api/user-profile/${userId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('profileContent').innerHTML = `
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-red-600 to-red-800 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-white font-bold text-2xl">${data.name.charAt(0)}</span>
                            </div>
                            <h4 class="font-bold text-gray-800">${data.name}</h4>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                Admin
                            </span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Username</span>
                                <span class="text-sm font-medium text-gray-800">${data.username}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Email</span>
                                <span class="text-sm font-medium text-gray-800">${data.email}</span>
                            </div>
                        </div>
                    `;
                    document.getElementById('profileModal').classList.remove('hidden');
                    document.getElementById('profileModal').classList.add('flex');
                });
        }

        function closeProfileModal() {
            document.getElementById('profileModal').classList.add('hidden');
            document.getElementById('profileModal').classList.remove('flex');
        }
    </script>
</body>
</html>
