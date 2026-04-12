<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduAid - Mayor Sherry Ann Bolisay Scholarship Program</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        :root {
            /* Primary Reds */
            --red-primary: #dc2626;
            --red-dark: #b91c1c;
            --red-darker: #991b1b;
            --red-light: #ef4444;
            --red-lighter: #fca5a5;
            --red-soft: #fef2f2;
            
            /* Accent Colors */
            --gold: #fbbf24;
            --gold-dark: #f59e0b;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-800: #1f2937;
            
            /* Gradients */
            --gradient-red: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            --gradient-red-gold: linear-gradient(135deg, #dc2626 0%, #f59e0b 100%);
            --gradient-soft: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
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
        .floating-animation { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .slide-in { animation: slideIn 0.5s ease-out; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* 3D Static Image Hero Container */
        .hero-3d-container {
            position: relative;
            width: 100%;
            height: 550px;
            display: flex;
            justify-content: center;
            align-items: center;
            perspective: 1500px;
            overflow: hidden;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 30%, #991b1b 70%, #dc2626 100%);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        /* Red Gradient Overlay */
        .hero-3d-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 70% 70%, rgba(251, 191, 36, 0.1) 0%, transparent 50%);
            z-index: 1;
        }

        /* Floating Hearts Background */
        .hearts-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            overflow: hidden;
        }

        .heart {
            position: absolute;
            font-size: 20px;
            color: rgba(255, 255, 255, 0.3);
            animation: floatHeart 8s infinite ease-in;
            user-select: none;
        }

        .heart:nth-child(1) { left: 10%; animation-duration: 6s; animation-delay: 0s; font-size: 25px; }
        .heart:nth-child(2) { left: 20%; animation-duration: 8s; animation-delay: 1s; font-size: 18px; }
        .heart:nth-child(3) { left: 35%; animation-duration: 7s; animation-delay: 2s; font-size: 22px; }
        .heart:nth-child(4) { left: 50%; animation-duration: 9s; animation-delay: 0s; font-size: 20px; }
        .heart:nth-child(5) { left: 65%; animation-duration: 6s; animation-delay: 3s; font-size: 24px; }
        .heart:nth-child(6) { left: 75%; animation-duration: 8s; animation-delay: 1.5s; font-size: 19px; }
        .heart:nth-child(7) { left: 85%; animation-duration: 7s; animation-delay: 2.5s; font-size: 21px; }
        .heart:nth-child(8) { left: 95%; animation-duration: 10s; animation-delay: 0.5s; font-size: 23px; }

        @keyframes floatHeart {
            0% {
                bottom: -50px;
                transform: translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.8;
            }
            90% {
                opacity: 0.8;
            }
            100% {
                bottom: 100vh;
                transform: translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Light Rays Effect */
        .light-rays {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 600px;
            height: 600px;
            transform: translate(-50%, -50%);
            z-index: 1;
            opacity: 0.3;
        }

        .light-ray {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 2px;
            height: 300px;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8), transparent);
            transform-origin: center top;
        }

        .light-ray:nth-child(1) { transform: translate(-50%, -50%) rotate(0deg); }
        .light-ray:nth-child(2) { transform: translate(-50%, -50%) rotate(45deg); }
        .light-ray:nth-child(3) { transform: translate(-50%, -50%) rotate(90deg); }
        .light-ray:nth-child(4) { transform: translate(-50%, -50%) rotate(135deg); }
        .light-ray:nth-child(5) { transform: translate(-50%, -50%) rotate(180deg); }
        .light-ray:nth-child(6) { transform: translate(-50%, -50%) rotate(225deg); }
        .light-ray:nth-child(7) { transform: translate(-50%, -50%) rotate(270deg); }
        .light-ray:nth-child(8) { transform: translate(-50%, -50%) rotate(315deg); }

        /* Background Bubbles Animation */
        .bg-bubbles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            bottom: -100px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: rise 10s infinite ease-in;
        }

        .bubble:nth-child(1) { left: 10%; width: 40px; height: 40px; animation-duration: 8s; }
        .bubble:nth-child(2) { left: 20%; width: 20px; height: 20px; animation-duration: 5s; animation-delay: 1s; }
        .bubble:nth-child(3) { left: 35%; width: 50px; height: 50px; animation-duration: 12s; animation-delay: 2s; }
        .bubble:nth-child(4) { left: 50%; width: 30px; height: 30px; animation-duration: 6s; animation-delay: 0s; }
        .bubble:nth-child(5) { left: 65%; width: 45px; height: 45px; animation-duration: 9s; animation-delay: 3s; }
        .bubble:nth-child(6) { left: 75%; width: 25px; height: 25px; animation-duration: 7s; animation-delay: 1.5s; }
        .bubble:nth-child(7) { left: 85%; width: 35px; height: 35px; animation-duration: 11s; animation-delay: 2.5s; }
        .bubble:nth-child(8) { left: 95%; width: 55px; height: 55px; animation-duration: 13s; animation-delay: 0.5s; }
        .bubble:nth-child(9) { left: 15%; width: 15px; height: 15px; animation-duration: 4s; animation-delay: 4s; }
        .bubble:nth-child(10) { left: 55%; width: 60px; height: 60px; animation-duration: 14s; animation-delay: 1s; }

        @keyframes rise {
            0% {
                bottom: -100px;
                transform: translateX(0);
            }
            50% {
                transform: translateX(100px);
            }
            100% {
                bottom: 1080px;
                transform: translateX(-200px);
            }
        }

        /* 3D Card */
        .hero-3d-card {
            position: relative;
            width: 400px;
            height: 480px;
            transform-style: preserve-3d;
            transition: transform 0.05s linear;
            cursor: pointer;
            z-index: 10;
            animation: float 4s ease-in-out infinite;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.08));
            backdrop-filter: blur(15px);
            border: 3px solid rgba(251, 191, 36, 0.4);
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.3);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        .hero-3d-card:hover {
            animation-play-state: paused;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 17px;
            box-shadow: 0 25px 50px -20px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            border: 3px solid rgba(251, 191, 36, 0.4);
        }

        /* Glossy Overlay */
        .glossy-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 17px;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.25) 0%,
                rgba(255, 255, 255, 0) 50%,
                rgba(255, 255, 255, 0.1) 100%
            );
            pointer-events: none;
            z-index: 2;
        }

        /* Border Glow */
        .border-glow {
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border-radius: 20px;
            background: linear-gradient(135deg, #ff6b6b, #ffd700, #ff6b6b, #ffd700, #ff6b6b);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 0;
            animation: borderGlow 3s ease-in-out infinite;
        }

        @keyframes borderGlow {
            0%, 100% { 
                background: linear-gradient(135deg, #ff6b6b, #ffd700, #ff6b6b, #ffd700, #ff6b6b);
                opacity: 0.3;
            }
            50% { 
                background: linear-gradient(135deg, #ffd700, #ff6b6b, #ffd700, #ff6b6b, #ffd700);
                opacity: 0.5;
            }
        }

        .hero-3d-card:hover .border-glow {
            opacity: 0.5;
        }

        /* Shadow */
        .hero-shadow {
            position: absolute;
            bottom: -40px;
            left: 8%;
            width: 84%;
            height: 40px;
            background: radial-gradient(ellipse, rgba(220, 38, 38, 0.7) 0%, rgba(220, 38, 38, 0) 70%);
            filter: blur(12px);
            border-radius: 50%;
            transition: all 0.3s ease;
            z-index: 0;
        }

        .hero-3d-card:hover .hero-shadow {
            width: 95%;
            left: 2.5%;
            bottom: -50px;
            opacity: 0.8;
            background: radial-gradient(ellipse, rgba(251, 191, 36, 0.9) 0%, rgba(251, 191, 36, 0) 70%);
        }

        /* Caption */
        .hero-caption {
            position: absolute;
            bottom: -80px;
            left: 0;
            right: 0;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6);
            opacity: 0;
            transform: translateY(25px);
            transition: all 0.4s ease;
            z-index: 10;
        }

        .hero-3d-card:hover .hero-caption {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-caption h2 {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            font-family: 'Poppins', sans-serif;
            color: #ffd700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        }

        .hero-caption p {
            font-size: 1rem;
            opacity: 0.95;
            font-family: 'Inter', sans-serif;
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        .caption-line {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #ffd700, transparent);
            margin: 10px auto 0;
            border-radius: 2px;
        }

        /* Stats Badge */
        .stats-badge {
            position: absolute;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.9), rgba(185, 28, 28, 0.9));
            backdrop-filter: blur(15px);
            border-radius: 50px;
            padding: 12px 24px;
            display: flex;
            gap: 20px;
            z-index: 20;
            border: 2px solid rgba(251, 191, 36, 0.4);
            box-shadow: 0 8px 32px rgba(220, 38, 38, 0.3);
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat-number {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ffd700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .stat-label {
            font-size: 0.7rem;
            color: white;
            opacity: 0.9;
            font-weight: 500;
        }

        /* Glassmorphism Styles */
        .glassmorphism {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .micro-interaction {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(220, 38, 38, 0.3);
        }
        
        .stat-divider {
            width: 1px;
            height: 30px;
            background: rgba(251, 191, 36, 0.3);
        }

        /* Placeholder Image */
        .placeholder-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #2d5a7a, #1a3a4a);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .placeholder-image::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .placeholder-icon {
            font-size: 80px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .placeholder-image h3 {
            font-size: 24px;
            margin-bottom: 10px;
            font-family: 'Poppins', sans-serif;
            position: relative;
            z-index: 1;
        }

        .placeholder-image p {
            font-size: 16px;
            opacity: 0.8;
            position: relative;
            z-index: 1;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .hero-3d-card {
                width: 280px;
                height: 360px;
            }
            
            .hero-caption h2 {
                font-size: 1rem;
            }
            
            .hero-caption p {
                font-size: 0.7rem;
            }
            
            .stats-badge {
                bottom: 20px;
                right: 20px;
                padding: 8px 16px;
            }
            
            .stat-number {
                font-size: 0.9rem;
            }
            
            .stat-label {
                font-size: 0.6rem;
            }
        }

        @media (max-width: 480px) {
            .hero-3d-card {
                width: 240px;
                height: 310px;
            }
            
            .stats-badge {
                bottom: 10px;
                right: 10px;
                padding: 6px 12px;
                gap: 10px;
            }
            
            .stat-number {
                font-size: 0.8rem;
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-red-50 via-white to-red-50">
    
    <!-- ========== NAVBAR ========== -->
    <nav class="glassmorphism shadow-2xl sticky top-0 z-50 border-b border-white/20">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3 micro-interaction">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-800 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300">
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
                    <a href="/register" class="px-5 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg font-medium btn-primary hover:-translate-y-0.5 transform">
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
                <a href="/contact" class="block py-2 px-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">CONTACT</a>
                <div class="flex space-x-3 pt-2 border-t border-gray-100 mt-2">
                    <a href="/login" class="flex-1 px-4 py-2 text-center text-red-600 border border-red-600 rounded-lg hover:bg-red-50 transition-all duration-300 font-medium hover:-translate-y-0.5 transform">
                        LOGIN
                    </a>
                    <a href="/register" class="flex-1 px-4 py-2 text-center bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 font-medium btn-primary hover:-translate-y-0.5 transform">
                        REGISTER
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ========== HERO SECTION WITH 3D STATIC IMAGE ========== -->
    <section class="relative overflow-hidden min-h-screen">
        <!-- Background Image with Low Opacity -->
        <div class="absolute inset-0 -z-20 h-screen overflow-hidden">
            <img src="{{ asset('images/Untitled design.png') }}" alt="Background" class="w-full h-full object-cover opacity-100">
        </div>

        <!-- Background Decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-100 rounded-full filter blur-3xl opacity-30 -z-10"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-yellow-100 rounded-full filter blur-3xl opacity-30 -z-10"></div>

        <div class="container mx-auto px-4 py-12 md:py-20 min-h-screen flex items-center">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12 w-full">
                
                <!-- Left Content -->
                <div class="flex-1 text-center lg:text-left">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 bg-red-100 rounded-full px-4 py-2 mb-6">
                        <span class="w-2 h-2 bg-red-600 rounded-full animate-pulse"></span>
                        <span class="text-red-600 font-medium text-sm">Mayor Sherry Ann Bolisay Scholarship Program</span>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                        <span class="text-gray-800">Invest in</span>
                        <span class="bg-gradient-to-r from-red-600 to-red-800 bg-clip-text text-transparent"> Education</span>
                        <br>
                        <span class="text-gray-800">Build Future</span>
                    </h1>
                    
                    <!-- Description -->
                    <p class="text-gray-600 text-lg mb-8 max-w-xl mx-auto lg:mx-0">
                        Empowering students from General Tinio through quality education. 
                        Apply now for Mayor Sherry Ann Bolisay Scholarship Program.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="/register" class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group">
                            Apply Now
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        
                        <button onclick="showTrackModal()" class="px-8 py-3 border-2 border-red-600 text-red-600 rounded-xl font-semibold hover:bg-red-50 transition-all duration-300 flex items-center justify-center gap-2">
                            Track Application
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <!-- main -->
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 max-w-md mx-auto lg:mx-0 bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">456</div>
                            <div class="text-xs text-gray-500">Active Scholars</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">2.5M</div>
                            <div class="text-xs text-gray-500">Total Payout (₱)</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">100+</div>
                            <div class="text-xs text-gray-500">Graduates</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Mayor Image with 3D Effect -->
                <div class="flex-1 flex justify-center items-center relative hidden lg:flex">
                    <div class="relative w-[800px] h-[450px]">
                        <!-- Background blur effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-red-400 to-red-600 rounded-3xl blur-3xl opacity-30 transform rotate-3"></div>
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-blue-600 rounded-3xl blur-3xl opacity-20 transform -rotate-3"></div>

                        <!-- 3D Card Container -->
                        <div class="relative w-full h-full">
                            <!-- Card with 3D effect -->
                            <div class="absolute inset-0 bg-white rounded-3xl shadow-2xl transform rotate-y-12 rotate-x-6"
                                 style="transform-style: preserve-3d; perspective: 1000px;">
                                <!-- Image container -->
                                <div class="w-full h-full rounded-3xl overflow-hidden relative transform translate-z-10"
                                     style="transform-style: preserve-3d;">
                                    <!-- Image -->
                                    <img src="{{ asset('images/mayor-sherry-ann.jpg') }}" 
                                         alt="Mayor Sherry Ann" 
                                         class="w-full h-full object-contain bg-white">
                                    
                                    <!-- Gradient overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                                    
                                    <!-- Text overlay -->
                                    <div class="absolute bottom-0 left-0 right-0 p-6">
                                        <h3 class="text-white text-xl font-bold mb-1">Mayor Sherry Ann</h3>
                                        <p class="text-white/80 text-sm">General Tinio, Nueva Ecija</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Decorative elements -->
                            <div class="absolute -top-4 -right-4 w-20 h-20 bg-red-500 rounded-full opacity-20 blur-xl"></div>
                            <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-blue-500 rounded-full opacity-20 blur-xl"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== ANNOUNCEMENT CAROUSEL ========== -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-red-600 font-semibold text-sm uppercase tracking-wider">Latest Updates</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Announcements</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-red-600 to-red-800 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <!-- Carousel -->
            <div class="relative max-w-7xl mx-auto">
                <div id="announcementCarousel" class="relative overflow-hidden rounded-2xl shadow-2xl bg-gradient-to-br from-red-50 to-red-100" style="height: 600px;">
                    <div class="carousel-track flex transition-transform duration-500 ease-in-out h-full">
                        <!-- Carousel items will be populated dynamically -->
                    </div>
                    
                    <!-- Navigation Arrows -->
                    <button onclick="prevSlide()" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-red-600 p-4 transition-all hover:scale-110 z-10">
                        <i class="fas fa-chevron-left text-3xl"></i>
                    </button>
                    <button onclick="nextSlide()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-red-600 p-4 transition-all hover:scale-110 z-10">
                        <i class="fas fa-chevron-right text-3xl"></i>
                    </button>
                    
                    <!-- Indicators -->
                    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3 z-10" id="carouselIndicators">
                        <!-- Indicators will be populated dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== HOW IT WORKS SECTION ========== -->
    <section class="py-16 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-red-600 font-semibold text-sm uppercase tracking-wider">Simple Process</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">How to Apply</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-red-600 to-red-800 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform">
                            <span class="text-white text-2xl font-bold">1</span>
                        </div>
                        <div class="hidden md:block absolute top-10 left-[calc(50%+40px)] w-full h-0.5 bg-red-200"></div>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Register Account</h3>
                    <p class="text-sm text-gray-500">Create your account and fill out application form</p>
                </div>
                
                <div class="text-center group">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform">
                            <span class="text-white text-2xl font-bold">2</span>
                        </div>
                        <div class="hidden md:block absolute top-10 left-[calc(50%+40px)] w-full h-0.5 bg-red-200"></div>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Submit Requirements</h3>
                    <p class="text-sm text-gray-500">Upload all required documents</p>
                </div>
                
                <div class="text-center group">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform">
                            <span class="text-white text-2xl font-bold">3</span>
                        </div>
                        <div class="hidden md:block absolute top-10 left-[calc(50%+40px)] w-full h-0.5 bg-red-200"></div>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Wait for Verification</h3>
                    <p class="text-sm text-gray-500">Admin reviews your application</p>
                </div>
                
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-white text-2xl font-bold">4</span>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Start as Scholar</h3>
                    <p class="text-sm text-gray-500">Receive approval and access your dashboard</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Track Application Modal -->
    <div id="trackModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-search mr-2"></i>Track Application
                    </h3>
                    <button onclick="closeTrackModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Enter Reference Number</label>
                    <input type="text" id="trackReferenceNumber" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        placeholder="Enter your reference number (e.g., REG-123456789)">
                    <div id="trackMessage" class="hidden text-sm mt-2"></div>
                </div>
                
                <div id="trackResult" class="hidden mb-6">
                    <!-- Results will be displayed here -->
                </div>
                
                <div class="flex gap-3">
                    <button onclick="trackApplication()" id="trackBtn"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all font-medium">
                        <i class="fas fa-search mr-2"></i>Track Status
                    </button>
                    <button onclick="closeTrackModal()" 
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== FOOTER ========== -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">E</span>
                        </div>
                        <h3 class="text-xl font-bold">EduAid</h3>
                    </div>
                    <p class="text-gray-400 text-sm">Mayor Sherry Ann Bolisay Scholarship Program</p>
                    <p class="text-gray-400 text-sm mt-2">General Tinio, Nueva Ecija</p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/" class="hover:text-red-400">Home</a></li>
                        <li><a href="/about" class="hover:text-red-400">About</a></li>
                        <li><a href="/requirements" class="hover:text-red-400">Requirements</a></li>
                        <li><a href="/faq" class="hover:text-red-400">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/contact" class="hover:text-red-400">Contact Us</a></li>
                        <li><a href="#" onclick="showTrackModal()" class="hover:text-red-400">Track Application</a></li>
                        <li><a href="/terms" class="hover:text-red-400">Terms & Conditions</a></li>
                        <li><a href="/privacy" class="hover:text-red-400">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Connect With Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.949.2-4.358 2.618-6.78 6.98-6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 00221.4-11.877c0-.213-.005-.425-.015-.637A9.936 9.936 0 0024 4.555z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} EduAid - Mayor Sherry Ann Bolisay Scholarship Program. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // 3D Static Image Effect
        let card = null;
        let isHovering = false;
        let rotationX = 0;
        let rotationY = 0;

        function init3DEffect() {
            card = document.getElementById('hero3dCard');
            if (!card) return;

            // Add mouse move listener
            window.addEventListener('mousemove', handleMouseMove);
            window.addEventListener('mouseleave', resetRotation);
        }

        function handleMouseMove(event) {
            if (!card || !isHovering) return;
            
            const rect = card.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            
            const relativeX = (event.clientX - centerX) / (rect.width / 2);
            const relativeY = (event.clientY - centerY) / (rect.height / 2);
            
            const maxRotate = 12;
            const rotateY = relativeX * maxRotate;
            const rotateX = -relativeY * maxRotate;
            
            card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        }

        function resetRotation() {
            if (!card) return;
            card.style.transform = 'rotateX(0deg) rotateY(0deg) scale(1)';
            isHovering = false;
        }

        function onCardHover() {
            isHovering = true;
        }

        function onCardLeave() {
            resetRotation();
        }

        function handleImageError() {
            // Fallback to placeholder if image not found
            const img = document.getElementById('heroImage');
            if (img) {
                img.style.display = 'none';
                
                // Create placeholder
                const placeholder = document.createElement('div');
                placeholder.className = 'placeholder-image';
                placeholder.innerHTML = `
                    <div class="placeholder-icon">👩‍⚖️</div>
                    <h3>Mayor Sherry Ann Bolisay</h3>
                    <p>"Serbisyong may Puso para sa Edukasyon"</p>
                `;
                
                img.parentNode.appendChild(placeholder);
            }
        }

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Track application
        function trackApplication() {
            const ref = document.getElementById('trackingRef').value;
            if (ref) {
                window.location.href = `/application-status/${ref}`;
            }
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            init3DEffect();
            
            // Add hover listeners to card
            const cardElement = document.getElementById('hero3dCard');
            if (cardElement) {
                cardElement.addEventListener('mouseenter', onCardHover);
                cardElement.addEventListener('mouseleave', onCardLeave);
            }
        });

        // Track Application Modal
        function showTrackModal() {
            document.getElementById('trackModal').classList.remove('hidden');
            document.getElementById('trackModal').classList.add('flex');
        }

        function closeTrackModal() {
            document.getElementById('trackModal').classList.add('hidden');
            document.getElementById('trackModal').classList.remove('flex');
        }

        // Carousel functionality
        let currentSlide = 0;
        let slides = [];
        let autoSlideInterval;

        function initCarousel(announcements) {
            slides = announcements;
            const track = document.querySelector('.carousel-track');
            const indicators = document.getElementById('carouselIndicators');
            
            if (slides.length === 0) {
                track.innerHTML = '<div class="w-full p-8 text-center text-gray-500">No announcements available</div>';
                return;
            }
            
            // Build carousel items
            track.innerHTML = slides.map((slide, index) => `
                <div class="carousel-slide min-w-full h-full ${slide.link_url ? 'cursor-pointer' : ''}" ${slide.link_url ? `onclick="window.open('${slide.link_url}', '_blank')"` : ''}>
                    ${slide.image ? `
                        <div class="relative h-full">
                            <img src="${slide.image}" alt="${slide.title}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent flex flex-col justify-end p-8 md:p-12">
                                <h3 class="text-2xl md:text-4xl font-bold text-white mb-4">${slide.title}</h3>
                                <p class="text-white/90 text-lg mb-2 max-w-2xl">${slide.content}</p>
                                <p class="text-white/70 text-sm">${slide.date}</p>
                                ${slide.link_url ? `
                                    <div class="mt-4">
                                        <span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg text-white text-sm hover:bg-white/30 transition-all">
                                            <i class="fas fa-external-link-alt mr-2"></i>Click to learn more
                                        </span>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    ` : `
                        <div class="h-full flex items-center justify-center p-8 md:p-12">
                            <div class="text-center">
                                <h3 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">${slide.title}</h3>
                                <p class="text-gray-600 text-lg mb-2 max-w-2xl mx-auto">${slide.content}</p>
                                <p class="text-gray-500 text-sm">${slide.date}</p>
                                ${slide.link_url ? `
                                    <div class="mt-4">
                                        <a href="${slide.link_url}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition-all">
                                            <i class="fas fa-external-link-alt mr-2"></i>Learn More
                                        </a>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `}
                </div>
            `).join('');
            
            // Build indicators
            indicators.innerHTML = slides.map((_, index) => `
                <button onclick="goToSlide(${index})" class="carousel-indicator w-3 h-3 rounded-full transition-all ${index === 0 ? 'bg-red-600' : 'bg-white/50'}"></button>
            `).join('');
            
            // Start auto-slide
            startAutoSlide();
        }

        function nextSlide() {
            goToSlide((currentSlide + 1) % slides.length);
        }

        function prevSlide() {
            goToSlide((currentSlide - 1 + slides.length) % slides.length);
        }

        function goToSlide(index) {
            currentSlide = index;
            const track = document.querySelector('.carousel-track');
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update indicators
            document.querySelectorAll('.carousel-indicator').forEach((indicator, i) => {
                indicator.className = `carousel-indicator w-3 h-3 rounded-full transition-all ${i === currentSlide ? 'bg-red-600' : 'bg-white/50'}`;
            });
            
            // Reset auto-slide timer
            resetAutoSlide();
        }

        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 5000);
        }

        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        // Load announcements from API
        function loadAnnouncements() {
            fetch('/api/announcements/public')
                .then(response => response.json())
                .then(data => {
                    initCarousel(data);
                })
                .catch(error => {
                    console.error('Error loading announcements:', error);
                    initCarousel([]);
                });
        }

        // Initialize carousel on page load
        document.addEventListener('DOMContentLoaded', loadAnnouncements);

        function trackApplication() {
            const referenceNumber = document.getElementById('trackReferenceNumber').value.trim();
            
            if (!referenceNumber) {
                showTrackMessage('Please enter your reference number', 'error');
                return;
            }
            
            // Show loading state
            const trackBtn = document.getElementById('trackBtn');
            trackBtn.disabled = true;
            trackBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Tracking...';
            
            // Make API call to track application
            fetch(`/api/track-application/${referenceNumber}`)
                .then(response => response.json())
                .then(data => {
                    trackBtn.disabled = false;
                    trackBtn.innerHTML = '<i class="fas fa-search mr-2"></i>Track Status';
                    
                    if (data.success) {
                        showApplicationResult(data.application);
                    } else {
                        showTrackMessage(data.message || 'Application not found', 'error');
                    }
                })
                .catch(error => {
                    trackBtn.disabled = false;
                    trackBtn.innerHTML = '<i class="fas fa-search mr-2"></i>Track Status';
                    console.error('Error tracking application:', error);
                    showTrackMessage('Failed to track application. Please try again.', 'error');
                });
        }

        function showTrackMessage(message, type) {
            const messageDiv = document.getElementById('trackMessage');
            messageDiv.textContent = message;
            messageDiv.classList.remove('hidden');
            
            if (type === 'error') {
                messageDiv.classList.add('text-red-600');
                messageDiv.classList.remove('text-green-600');
            } else {
                messageDiv.classList.add('text-green-600');
                messageDiv.classList.remove('text-red-600');
            }
            
            // Hide message after 5 seconds
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 5000);
        }

        function showApplicationResult(application) {
            const resultDiv = document.getElementById('trackResult');
            const statusColor = {
                'pending': 'text-yellow-600',
                'approved': 'text-green-600',
                'rejected': 'text-red-600'
            };
            const statusIcon = {
                'pending': 'fa-clock',
                'approved': 'fa-check-circle',
                'rejected': 'fa-times-circle'
            };
            const statusBg = {
                'pending': 'bg-yellow-50 border-yellow-200',
                'approved': 'bg-green-50 border-green-200',
                'rejected': 'bg-red-50 border-red-200'
            };
            const statusText = {
                'pending': 'text-yellow-800',
                'approved': 'text-green-800',
                'rejected': 'text-red-800'
            };
            
            resultDiv.innerHTML = `
                <div class="${statusBg[application.status] || 'bg-green-50 border-green-200'} border rounded-lg p-4">
                    <h4 class="font-semibold ${statusText[application.status] || 'text-green-800'} mb-3">
                        <i class="fas ${statusIcon[application.status] || 'fa-check-circle'} mr-2"></i>Application Found
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Reference Number:</span>
                            <span class="font-medium">${application.reference_number}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Name:</span>
                            <span class="font-medium">${application.name}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium">${application.email}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium ${statusColor[application.status] || 'text-gray-600'}">
                                ${application.status.toUpperCase()}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Submitted:</span>
                            <span class="font-medium">${application.submission_date}</span>
                        </div>
                        ${application.approved_date ? `
                        <div class="flex justify-between">
                            <span class="text-gray-600">Approved:</span>
                            <span class="font-medium">${application.approved_date}</span>
                        </div>
                        ` : ''}
                    </div>
                </div>
            `;
            resultDiv.classList.remove('hidden');
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            window.removeEventListener('mousemove', handleMouseMove);
            window.removeEventListener('mouseleave', resetRotation);
        });
    </script>
</body>
</html>
