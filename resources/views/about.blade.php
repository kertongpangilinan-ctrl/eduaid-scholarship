<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - EduAid</title>
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
        .glassmorphism {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-red-50 via-white to-red-50">
    
    <!-- ========== NAVBAR ========== -->
    <nav class="glassmorphism shadow-2xl sticky top-0 z-50 border-b border-white/20">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-800 rounded-full flex items-center justify-center shadow-lg">
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
                    <a href="/" class="text-gray-700 hover:text-red-600 font-medium transition-all duration-300 hover:scale-105 transform hover:-translate-y-0.5 relative group">
                        HOME
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="/about" class="text-red-600 font-medium transition-all duration-300 hover:scale-105 transform hover:-translate-y-0.5 relative group">
                        ABOUT
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600"></span>
                    </a>
                    <a href="/requirements" class="text-gray-700 hover:text-red-600 font-medium transition-all duration-300 hover:scale-105 transform hover:-translate-y-0.5 relative group">
                        REQUIREMENTS
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="/faq" class="text-gray-700 hover:text-red-600 font-medium transition-all duration-300 hover:scale-105 transform hover:-translate-y-0.5 relative group">
                        FAQ
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="/contact" class="text-gray-700 hover:text-red-600 font-medium transition-all duration-300 hover:scale-105 transform hover:-translate-y-0.5 relative group">
                        CONTACT
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex space-x-3">
                    <a href="/login" class="px-5 py-2 text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition-all duration-300 shadow-sm hover:shadow-md font-medium hover:-translate-y-0.5 transform">
                        LOGIN
                    </a>
                    <a href="/register" class="px-5 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg font-medium hover:-translate-y-0.5 transform">
                        REGISTER
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-all duration-300 hover:scale-110 transform">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden mt-4 pb-3 space-y-2 border-t border-gray-100 pt-4">
                <a href="/" class="block py-2 px-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">HOME</a>
                <a href="/about" class="block py-2 px-3 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">ABOUT</a>
                <a href="/requirements" class="block py-2 px-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">REQUIREMENTS</a>
                <a href="/faq" class="block py-2 px-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">FAQ</a>
                <a href="/contact" class="block py-2 px-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">CONTACT</a>
                <div class="flex space-x-3 pt-2 border-t border-gray-100 mt-2">
                    <a href="/login" class="flex-1 px-4 py-2 text-center text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition-all duration-300 font-medium hover:-translate-y-0.5 transform">
                        LOGIN
                    </a>
                    <a href="/register" class="flex-1 px-4 py-2 text-center bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 font-medium hover:-translate-y-0.5 transform">
                        REGISTER
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ========== ABOUT PAGE ========== -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-red-600 font-semibold text-sm uppercase tracking-wider">Our Story</span>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mt-2">About Us</h1>
                <div class="w-24 h-1 bg-gradient-to-r from-red-600 to-red-800 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="max-w-4xl mx-auto">
                <!-- Mission -->
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mr-4">
                            <i class="fas fa-bullseye text-red-600 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Our Mission</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        To provide financial assistance and educational support to deserving students from General Tinio, Nueva Ecija, enabling them to pursue their academic dreams and build a brighter future for themselves and their families.
                    </p>
                </div>
                
                <!-- Vision -->
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mr-4">
                            <i class="fas fa-eye text-red-600 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Our Vision</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        To become a beacon of hope for students in General Tinio, creating a community where education is accessible to all and where every scholar has the opportunity to achieve their full potential and contribute to the development of our municipality.
                    </p>
                </div>
                
                <!-- About Mayor -->
                <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-2xl shadow-lg p-8 mb-8">
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="w-32 h-32 bg-gradient-to-br from-red-600 to-red-800 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-user-tie text-white text-5xl"></i>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Mayor Sherry Ann Bolisay</h2>
                            <p class="text-red-600 font-medium mb-4">Mayor, General Tinio, Nueva Ecija</p>
                            <p class="text-gray-600 leading-relaxed">
                                The scholarship program was established to support the youth of General Tinio in their pursuit of higher education. Through this initiative, we aim to alleviate the financial burden on families and empower our students to become future leaders and contributors to our community's growth and development.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Key Features -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-graduation-cap text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Academic Support</h3>
                        <p class="text-sm text-gray-600">Financial assistance for tuition and school expenses</p>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Community Building</h3>
                        <p class="text-sm text-gray-600">Fostering a supportive scholar community</p>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-chart-line text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Future Leaders</h3>
                        <p class="text-sm text-gray-600">Developing tomorrow's leaders today</p>
                    </div>
                </div>
                
                <!-- CTA -->
                <div class="text-center">
                    <a href="/register" class="inline-block px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                        Apply for Scholarship
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
