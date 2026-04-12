<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - EduAid</title>
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
                    <a href="{{ route('student.messages') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm">MESSAGE</a>
                    <a href="{{ route('student.support') }}" class="text-red-600 font-medium transition-colors text-sm">SUPPORT</a>
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
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Support Center</h1>
            <p class="text-gray-600">Get help with your scholarship account and report issues</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Report Issue Form -->
            <div class="lg:col-span-2">
                <div class="glass-card rounded-3xl p-8 slide-in hover-lift">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                        Report an Issue
                    </h2>
                    
                    <form action="{{ route('student.support.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Issue Type -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Type of Issue</label>
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="radio" name="report_type" value="profile_error" required class="w-5 h-5 text-red-600 focus:ring-red-500">
                                    <div class="ml-3">
                                        <span class="font-bold text-gray-800">Profile Error</span>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="radio" name="report_type" value="bug" class="w-5 h-5 text-red-600 focus:ring-red-500">
                                    <div class="ml-3">
                                        <span class="font-bold text-gray-800">System Bug</span>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input type="radio" name="report_type" value="concern" class="w-5 h-5 text-red-600 focus:ring-red-500">
                                    <div class="ml-3">
                                        <span class="font-bold text-gray-800">General Concern</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Subject</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="Brief description of the issue" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="5" required placeholder="Please provide detailed information about the issue..." class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Screenshot (Optional)</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-red-500 transition-colors">
                                <input type="file" name="screenshot" accept="image/*" class="hidden" id="screenshotInput" onchange="previewImage(event)">
                                <label for="screenshotInput" class="cursor-pointer">
                                    <div id="uploadPlaceholder">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
                                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF up to 5MB</p>
                                    </div>
                                    <div id="imagePreview" class="hidden">
                                        <img id="previewImg" src="" alt="Preview" class="max-h-48 mx-auto rounded-lg">
                                        <p class="text-sm text-gray-600 mt-2">Click to change</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl font-bold hover:from-red-700 hover:to-red-800 transition-all shadow-xl">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Report
                        </button>
                    </form>
                </div>
            </div>

            <!-- Live Assistant -->
            <div class="lg:col-span-1">
                <div class="glass-card rounded-3xl p-6 slide-in hover-lift sticky top-24">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-headset text-red-600 mr-2"></i>
                        Live Assistant
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="bg-gradient-to-r from-green-50 to-green-100 border-2 border-green-200 rounded-2xl p-4">
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-bold text-green-800">Online</span>
                            </div>
                            <p class="text-sm text-green-700">Connect with an admin for real-time support</p>
                        </div>

                        <a href="{{ route('student.messages.compose') }}" class="block w-full py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl font-bold hover:from-red-700 hover:to-red-800 transition-all shadow-xl text-center">
                            <i class="fas fa-comments mr-2"></i>
                            Start Live Chat
                        </a>

                        <div class="text-center">
                            <p class="text-sm text-gray-500 mb-2">Or contact us directly</p>
                            <div class="space-y-2">
                                <div class="flex items-center justify-center space-x-2 text-gray-600">
                                    <i class="fas fa-envelope"></i>
                                    <span class="text-sm">support@eduaid.ph</span>
                                </div>
                                <div class="flex items-center justify-center space-x-2 text-gray-600">
                                    <i class="fas fa-phone"></i>
                                    <span class="text-sm">+63 912 345 6789</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ -->
                    <div class="mt-6 pt-6 border-t-2 border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-3">Quick FAQ</h3>
                        <div class="space-y-2">
                            <details class="group">
                                <summary class="flex items-center justify-between p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition-colors">
                                    <span class="text-sm font-bold text-gray-700">How to reset password?</span>
                                    <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
                                </summary>
                                <div class="p-3 text-sm text-gray-600">
                                    Go to your profile page and click on "Change Password" to update your password.
                                </div>
                            </details>
                            <details class="group">
                                <summary class="flex items-center justify-between p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition-colors">
                                    <span class="text-sm font-bold text-gray-700">How to check application status?</span>
                                    <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
                                </summary>
                                <div class="p-3 text-sm text-gray-600">
                                    Visit the Progress Tracker page to view your application status and timeline.
                                </div>
                            </details>
                            <details class="group">
                                <summary class="flex items-center justify-between p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition-colors">
                                    <span class="text-sm font-bold text-gray-700">How to view my QR code?</span>
                                    <i class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
                                </summary>
                                <div class="p-3 text-sm text-gray-600">
                                    Click on "View QR" from the dashboard to see your scholarship QR code for attendance.
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('uploadPlaceholder').classList.add('hidden');
                    document.getElementById('imagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
