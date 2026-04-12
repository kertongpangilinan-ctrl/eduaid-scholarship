<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} - EduAid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --red-primary: #dc2626;
            --red-dark: #b91c1c;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, .logo, .nav-links {
            font-family: 'Poppins', sans-serif;
        }
        .bg-red-gradient { background: linear-gradient(135deg, #dc2626, #b91c1c); }
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
        
        <!-- Back Button -->
        <a href="{{ route('student.announcements') }}" class="inline-flex items-center text-gray-600 hover:text-red-600 mb-6 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Announcements
        </a>

        <!-- Announcement Details -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-800 p-8 text-white">
                <div class="flex items-center space-x-3 mb-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                        <i class="fas fa-bullhorn mr-2"></i>
                        {{ ucfirst($announcement->announcement_type) }}
                    </span>
                    <span class="text-sm text-red-100">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $announcement->published_at->format('F d, Y - g:i A') }}
                    </span>
                </div>
                <h1 class="text-3xl font-bold mb-2">{{ $announcement->title }}</h1>
            </div>

            <!-- Content -->
            <div class="p-8">
                @if($announcement->image_path)
                <div class="mb-8">
                    <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="{{ $announcement->title }}" class="w-full max-h-96 object-cover rounded-xl">
                </div>
                @endif

                <div class="prose max-w-none text-gray-700 leading-relaxed mb-8">
                    <p class="whitespace-pre-wrap">{{ $announcement->content }}</p>
                </div>

                @if($announcement->when_info || $announcement->where_info || $announcement->what_info)
                <div class="bg-red-50 rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-gray-800 mb-4">Event Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if($announcement->when_info)
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">When</p>
                                <p class="font-medium text-gray-800">{{ $announcement->when_info }}</p>
                            </div>
                        </div>
                        @endif
                        @if($announcement->where_info)
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Where</p>
                                <p class="font-medium text-gray-800">{{ $announcement->where_info }}</p>
                            </div>
                        </div>
                        @endif
                        @if($announcement->what_info)
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">What</p>
                                <p class="font-medium text-gray-800">{{ $announcement->what_info }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Posted By -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Posted by</p>
                            <p class="font-medium text-gray-800">EduAid Scholarship Team</p>
                        </div>
                    </div>
                    <a href="{{ route('student.announcements') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        View All Announcements
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
