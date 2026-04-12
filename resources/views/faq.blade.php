<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - EduAid</title>
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
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            padding: 0 1.5rem;
        }
        .faq-answer.active {
            max-height: 500px;
            padding: 0 1.5rem 1rem 1.5rem;
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
                    <a href="/faq" class="text-red-600 font-medium transition-all duration-300 hover:scale-105 transform hover:-translate-y-0.5 relative group">
                        FAQ
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600"></span>
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
                <a href="/about" class="block py-2 px-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">ABOUT</a>
                <a href="/requirements" class="block py-2 px-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">REQUIREMENTS</a>
                <a href="/faq" class="block py-2 px-3 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 hover:translate-x-1 transform">FAQ</a>
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

    <!-- ========== FAQ PAGE ========== -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-red-600 font-semibold text-sm uppercase tracking-wider">Get Answers</span>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mt-2">Frequently Asked Questions</h1>
                <div class="w-24 h-1 bg-gradient-to-r from-red-600 to-red-800 mx-auto mt-4 rounded-full"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                    Find answers to common questions about the scholarship program
                </p>
            </div>
            
            <div class="max-w-4xl mx-auto space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">Who is eligible for the scholarship?</span>
                        <i class="fas fa-chevron-down text-red-600 transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-gray-600 pt-2">The scholarship is available to students who are residents of General Tinio, Nueva Ecija. You must be enrolled or planning to enroll in college (incoming first year or current college student) and meet the academic requirements specified in the application guidelines.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">What documents do I need to apply?</span>
                        <i class="fas fa-chevron-down text-red-600 transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-gray-600 pt-2">Required documents include: Proof of residency (Barangay Indigency), 2x2 picture, School ID (front and back), Letter of Intent, Recent Grades, Certificate of Registration/Enrollment, and your signature. All documents must be clear and readable, with a maximum file size of 2MB each.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">How do I track my application status?</span>
                        <i class="fas fa-chevron-down text-red-600 transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-gray-600 pt-2">After submitting your application, you will receive a unique reference number. You can use this reference number to track your application status on our website by clicking the "Track Application" button on the home page and entering your reference number.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">When will I receive the scholarship payout?</span>
                        <i class="fas fa-chevron-down text-red-600 transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-gray-600 pt-2">Scholarship payouts are released per semester based on your batch schedule and attendance. You will be notified via email when your payout is released. You can then claim your payout by signing the necessary documents at the designated payout center.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">What happens if I fail to maintain the required grade?</span>
                        <i class="fas fa-chevron-down text-red-600 transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-gray-600 pt-2">Scholars are required to maintain a certain grade point average to remain eligible for the scholarship. Failure to meet the academic requirements may result in scholarship suspension or termination. However, each case is reviewed individually, and you may appeal the decision.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 6 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">Can I apply if I'm already receiving other scholarships?</span>
                        <i class="fas fa-chevron-down text-red-600 transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-gray-600 pt-2">Yes, you can apply even if you're receiving other scholarships. However, you must disclose this information in your application. The scholarship committee will review your case and determine eligibility based on the total financial assistance you're receiving.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 7 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">How do I contact the scholarship office?</span>
                        <i class="fas fa-chevron-down text-red-600 transition-transform flex-shrink-0"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-gray-600 pt-2">You can contact the scholarship office through our contact page, or visit the Municipal Hall of General Tinio, Nueva Ecija. Our office hours are Monday to Friday, 8:00 AM to 5:00 PM. You can also reach us via email or phone for inquiries.</p>
                    </div>
                </div>
            </div>
            
            <!-- CTA -->
            <div class="mt-12 text-center">
                <p class="text-gray-600 mb-4">Still have questions?</p>
                <a href="/contact" class="inline-block px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Contact Us
                    <i class="fas fa-envelope ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
        
        function toggleFaq(button) {
            const answer = button.nextElementSibling;
            const icon = button.querySelector('i');
            
            answer.classList.toggle('active');
            icon.style.transform = answer.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    </script>
</body>
</html>
