<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - EduAid</title>
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
                    <a href="/about" class="text-gray-700 hover:text-red-600 font-medium transition-all duration-300 hover:scale-105 transform hover:-translate-y-0.5 relative group">
                        ABOUT
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="/requirements" class="text-gray-700 hover:text-red-600 font-medium transition-all duration-300 hover:scale-105 transform hover:-translate-y-0.5 relative group">
                        REQUIREMENTS
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="/faq" class="text-gray-700 hover:text-red-600 font-medium transition-all duration-300 hover:scale-105 transform hover:-translate-y-0.5 relative group">
                        FAQ
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="/contact" class="text-red-600 font-medium transition-all duration-300 hover:scale-105 transform hover:-translate-y-0.5 relative group">
                        CONTACT
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600"></span>
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
                <a href="/about" class="block py-2 px-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">ABOUT</a>
                <a href="/requirements" class="block py-2 px-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">REQUIREMENTS</a>
                <a href="/faq" class="block py-2 px-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">FAQ</a>
                <a href="/contact" class="block py-2 px-3 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">CONTACT</a>
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

    <!-- ========== CONTACT PAGE ========== -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-red-600 font-semibold text-sm uppercase tracking-wider">Get in Touch</span>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mt-2">Contact Us</h1>
                <div class="w-24 h-1 bg-gradient-to-r from-red-600 to-red-800 mx-auto mt-4 rounded-full"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                    Have questions? We're here to help. Reach out to us through any of the channels below.
                </p>
            </div>
            
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Contact Information -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Office Address</h3>
                                <p class="text-gray-600">Municipal Hall<br>General Tinio, Nueva Ecija<br>Philippines</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-phone text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Phone Number</h3>
                                <p class="text-gray-600">+63 (0) 9123-456-789</p>
                                <p class="text-sm text-gray-500 mt-1">Monday to Friday, 8:00 AM - 5:00 PM</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-envelope text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Email Address</h3>
                                <p class="text-gray-600">scholarship@generaltinio.gov.ph</p>
                                <p class="text-sm text-gray-500 mt-1">We'll respond within 24-48 hours</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-clock text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Office Hours</h3>
                                <p class="text-gray-600">Monday - Friday: 8:00 AM - 5:00 PM</p>
                                <p class="text-gray-600">Saturday: 8:00 AM - 12:00 PM</p>
                                <p class="text-sm text-gray-500 mt-1">Closed on Sundays and Holidays</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Send us a Message</h2>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" placeholder="Enter your full name">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" placeholder="Enter your email">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" placeholder="What is this about?">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" placeholder="Type your message here..."></textarea>
                        </div>
                        
                        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg">
                            Send Message
                            <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Map Section -->
            <div class="mt-12 bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Find Us on the Map</h2>
                <div class="w-full h-96 rounded-xl overflow-hidden">
                    <iframe 
                        src="https://www.google.com/maps?q=General+Tinio+Municipal+Hall+Nueva+Ecija&output=embed"
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="mt-4 text-center">
                    <a href="https://maps.app.goo.gl/PVpNR7KV8VoH9deSA" target="_blank" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg font-medium hover:from-red-700 hover:to-red-800 transition-all shadow-md hover:shadow-lg">
                        <i class="fas fa-directions mr-2"></i>
                        Get Directions
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
