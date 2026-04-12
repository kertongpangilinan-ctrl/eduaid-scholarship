<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - EduAid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, .logo, .nav-links {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Advanced UI/UX Techniques */
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
        
        .step-indicator {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .step-indicator::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            padding: 2px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .step-indicator.active {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.3);
        }
        
        .step-indicator.active::before {
            opacity: 1;
            animation: pulse 2s infinite;
        }
        
        .step-indicator.completed {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            transform: scale(1.05);
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .input-group {
            position: relative;
        }
        
        .input-field {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .input-field:focus {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
        }
        
        .input-field:focus + .input-label {
            color: #3b82f6;
            transform: translateY(-25px) scale(0.85);
        }
        
        .floating-label {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
            color: #9ca3af;
            background: white;
            padding: 0 4px;
            font-size: 14px;
            z-index: 10;
            margin-top: -10px;
        }
        
        .input-field:not(:placeholder-shown) + .floating-label,
        .input-field:focus + .floating-label,
        select.input-field + .floating-label {
            top: 0;
            transform: translateY(-50%) scale(0.85);
            color: #3b82f6;
        }
        
        .input-field {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            height: 40px;
        }
        
        .input-field:focus {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.15);
            border-color: #dc2626;
        }
        
        select.input-field:focus + .floating-label {
            color: #dc2626;
        }
        
        .validation-feedback {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideInUp 0.3s ease;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .password-strength-bar {
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }
        
        .password-strength-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .input-valid {
            border-color: #10b981 !important;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }
        
        .input-invalid {
            border-color: #ef4444 !important;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%) !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
            animation: shake 0.5s ease;
        }
        
        .checking {
            border-color: #f59e0b !important;
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%) !important;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1) !important;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .form-section {
            animation: fadeInUp 0.6s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .progress-line {
            background: linear-gradient(90deg, #dc2626, #b91c1c);
            height: 2px;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 10px;
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
        
        .tooltip {
            position: relative;
        }
        
        .tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            margin-bottom: 8px;
        }
        
        .tooltip:hover::after {
            opacity: 1;
        }
        
        .skeleton {
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* Blob animations */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        
        .animate-blob {
            animation: blob 7s infinite;
        }
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        /* Section icon styling */
        .section-icon {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }
        
        /* Form card styling */
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-red-50 via-white to-red-50 py-6 sm:py-10">
    <!-- Decorative Background Elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-20 left-10 w-64 h-64 bg-red-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-red-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-1/2 w-96 h-96 bg-red-100 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="container mx-auto px-4 max-w-3xl lg:max-w-4xl relative z-10">
        <!-- Enhanced Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-br from-red-600 via-red-700 to-red-800 rounded-2xl flex items-center justify-center shadow-2xl transform hover:scale-105 transition-transform duration-300">
                    <i class="fas fa-graduation-cap text-white text-3xl"></i>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2 bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-red-800">Scholarship Application</h1>
            <p class="text-gray-600 font-medium">Mayor Sherry Ann Bolisay Scholarship Program</p>
            <div class="mt-4 flex justify-center gap-2">
                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                    <i class="fas fa-star mr-1"></i>General Tinio, Nueva Ecija
                </span>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                    <i class="fas fa-calendar mr-1"></i>2024-2025
                </span>
            </div>
        </div>

        <!-- Enhanced Progress Steps -->
        <div class="mb-8 bg-white/80 backdrop-blur-sm rounded-2xl p-4 shadow-lg border border-red-100">
            <div class="flex items-center justify-between relative">
                @for($i = 1; $i <= 7; $i++)
                    <div class="flex flex-col items-center relative z-10 group">
                        <div class="step-indicator w-12 h-12 rounded-xl flex items-center justify-center font-bold text-sm mb-2 {{ $i == 1 ? 'active' : '' }} shadow-md transition-all duration-300 group-hover:scale-110" data-step="{{ $i }}">
                            @if($i == 1)
                                <i class="fas fa-user-circle"></i>
                            @elseif($i == 2)
                                <i class="fas fa-id-card"></i>
                            @elseif($i == 3)
                                <i class="fas fa-home"></i>
                            @elseif($i == 4)
                                <i class="fas fa-users"></i>
                            @elseif($i == 5)
                                <i class="fas fa-graduation-cap"></i>
                            @elseif($i == 6)
                                <i class="fas fa-file-upload"></i>
                            @else
                                <i class="fas fa-check-circle"></i>
                            @endif
                        </div>
                        <p class="text-xs font-semibold text-gray-600 hidden sm:block transition-colors duration-300">
                            {{ ['Account', 'Personal', 'Address', 'Family', 'Education', 'Documents', 'Review'][$i-1] }}
                        </p>
                    </div>
                    @if($i < 7)
                        <div class="flex-1 h-1 bg-gradient-to-r from-red-200 to-red-300 mx-2 rounded-full">
                            <div class="progress-line-fill h-full bg-gradient-to-r from-red-500 to-red-600 rounded-full transition-all duration-500" style="width: {{ $i == 1 ? '0%' : '100%' }}"></div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>

        <!-- Registration Form -->
        <div class="glassmorphism rounded-2xl shadow-2xl border border-white/20 hover-lift">
            @if ($errors->any())
                <div class="m-4 p-3 bg-red-50 border border-red-200 rounded-lg backdrop-blur-sm">
                    <div class="text-red-600 text-sm font-medium">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registrationForm">
                @csrf
                <input type="hidden" name="current_step" id="currentStepInput" value="{{ $currentStep ?? 1 }}">
                
                <!-- Step 1: Account Information -->
                <div class="step-content p-5" data-step="1">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-red-100">
                        <div class="w-10 h-10 section-icon rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-circle text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Account Information</h2>
                            <p class="text-sm text-gray-500">Create your secure login credentials</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <!-- Username Field -->
                        <div>
                            <div class="input-group relative">
                                <input type="text" name="username" id="username" required minlength="6"
                                    class="w-full px-3 py-1.5 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                    value="{{ old('username') }}" placeholder=" ">
                                <label class="floating-label">Username *</label>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i id="username-icon" class="fas fa-circle text-gray-300 text-sm"></i>
                                </div>
                            </div>
                            <div id="username-feedback" class="validation-feedback text-xs mt-1"></div>
                            <p class="text-xs text-gray-500 mt-1">6-20 characters, alphanumeric</p>
                        </div>
                        
                        <!-- Password Field -->
                        <div>
                            <div class="input-group relative">
                                <input type="password" name="password" id="password" required
                                    class="w-full px-3 py-1.5 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                    value="{{ old('password') }}" placeholder=" ">
                                <label class="floating-label">Password *</label>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i id="password-icon" class="fas fa-circle text-gray-300 text-sm"></i>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-gray-500">Password Strength</span>
                                    <span id="strength-text" class="text-xs font-medium"></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="strength-bar" class="password-strength-bar h-2 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">8+ characters with uppercase, lowercase, and number</p>
                        </div>
                        
                        <!-- Confirm Password Field -->
                        <div>
                            <div class="input-group relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="w-full px-3 py-1.5 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                    value="{{ old('password_confirmation') }}" placeholder=" ">
                                <label class="floating-label">Confirm Password *</label>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i id="confirm-icon" class="fas fa-circle text-gray-300 text-sm"></i>
                                </div>
                            </div>
                            <div id="confirm-feedback" class="validation-feedback text-xs mt-1"></div>
                        </div>
                        
                        <!-- Email Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <div class="input-group relative">
                                    <input type="email" name="email" id="email" required
                                        class="w-full px-3 py-1.5 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                        value="{{ old('email') }}" placeholder=" ">
                                    <label class="floating-label">Email Address *</label>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i id="email-icon" class="fas fa-circle text-gray-300 text-sm"></i>
                                    </div>
                                </div>
                                <div id="email-feedback" class="validation-feedback text-xs mt-1"></div>
                                <div id="email-verified-badge" class="text-xs mt-1 hidden">
                                    <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                    <span class="text-green-600 font-medium">Email verified</span>
                                </div>
                            </div>
                            <div class="flex items-center h-[40px]">
                                <button type="button" id="sendOtpBtn" onclick="sendOtp()"
                                    class="w-full px-4 py-1.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all text-sm font-medium btn-primary tooltip"
                                    data-tooltip="Send verification code to your email">
                                    <i class="fas fa-shield-alt mr-2"></i>Verify Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Personal Information -->
                <div class="step-content p-5 hidden form-section" data-step="2">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-red-100">
                        <div class="w-10 h-10 section-icon rounded-xl flex items-center justify-center">
                            <i class="fas fa-id-card text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Personal Information</h2>
                            <p class="text-sm text-gray-500">Tell us about yourself</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        <div class="input-group relative">
                            <input type="text" name="last_name" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                value="{{ old('last_name') }}" placeholder=" ">
                                <label class="floating-label">Last Name *</label>
                        </div>
                        <div class="input-group relative">
                            <input type="text" name="first_name" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                value="{{ old('first_name') }}" placeholder=" ">
                                <label class="floating-label">First Name *</label>
                        </div>
                        <div class="input-group relative">
                            <input type="text" name="middle_name"
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                value="{{ old('middle_name') }}" placeholder=" ">
                                <label class="floating-label">Middle Name</label>
                        </div>
                        <div class="input-group relative">
                            <select name="extension_name"
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field">
                                <option value="">Select Extension</option>
                                <option value="None" {{ old('extension_name') == 'None' ? 'selected' : '' }}>None</option>
                                <option value="Jr." {{ old('extension_name') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                <option value="Sr." {{ old('extension_name') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                <option value="II" {{ old('extension_name') == 'II' ? 'selected' : '' }}>II</option>
                                <option value="III" {{ old('extension_name') == 'III' ? 'selected' : '' }}>III</option>
                                <option value="IV" {{ old('extension_name') == 'IV' ? 'selected' : '' }}>IV</option>
                                <option value="V" {{ old('extension_name') == 'V' ? 'selected' : '' }}>V</option>
                                <option value="VI" {{ old('extension_name') == 'VI' ? 'selected' : '' }}>VI</option>
                            </select>
                            <label class="floating-label">Extension Name</label>
                        </div>
                        <div class="input-group relative">
                            <select name="gender" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            <label class="floating-label">Gender *</label>
                        </div>
                        <div class="input-group relative">
                            <input type="date" name="date_of_birth" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                value="{{ old('date_of_birth') }}">
                            <label class="floating-label">Birth Date *</label>
                        </div>
                        <div class="input-group relative">
                            <select name="civil_status" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field">
                                <option value="">Select Civil Status</option>
                                <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                            </select>
                            <label class="floating-label">Civil Status *</label>
                        </div>
                        <div class="input-group relative">
                            <input type="text" name="contact_number" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                value="{{ old('contact_number') }}" placeholder=" ">
                            <label class="floating-label">Contact Number *</label>
                            <p class="text-xs text-gray-500 mt-1">Format: 09XXXXXXXXX</p>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Address Information -->
                <div class="step-content p-5 hidden form-section" data-step="3">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-red-100">
                        <div class="w-10 h-10 section-icon rounded-xl flex items-center justify-center">
                            <i class="fas fa-home text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Address Information</h2>
                            <p class="text-sm text-gray-500">Your current residence details</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div class="input-group relative">
                            <input type="text" name="house_unit_number" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field capitalize-first"
                                value="{{ old('house_unit_number') }}" placeholder=" ">
                                <label class="floating-label">House/Unit Number *</label>
                        </div>
                        <div class="input-group relative">
                            <input type="text" name="street_name" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field capitalize-first"
                                value="{{ old('street_name') }}" placeholder=" ">
                                <label class="floating-label">Street Name *</label>
                        </div>
                        <div class="input-group relative">
                            <input type="text" name="barangay" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field capitalize-first"
                                value="{{ old('barangay') }}" placeholder=" ">
                                <label class="floating-label">Barangay *</label>
                        </div>
                        <div class="input-group relative">
                            <input type="text" name="municipality_city" value="General Tinio" readonly
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg bg-gray-50 transition-all text-sm input-field" placeholder=" ">
                            <label class="floating-label bg-gray-50">Municipality/City</label>
                        </div>
                        <div class="input-group relative">
                            <input type="text" name="province" value="Nueva Ecija" readonly
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg bg-gray-50 transition-all text-sm input-field" placeholder=" ">
                            <label class="floating-label bg-gray-50">Province</label>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Family Information -->
                <div class="step-content p-5 hidden form-section" data-step="4">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-red-100">
                        <div class="w-10 h-10 section-icon rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Family Information</h2>
                            <p class="text-sm text-gray-500">Details about your parents/guardians</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div class="input-group relative">
                            <input type="text" name="father_name" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field capitalize-first"
                                value="{{ old('father_name') }}" placeholder=" ">
                                <label class="floating-label">Father's Name *</label>
                        </div>
                        <div class="input-group relative">
                            <input type="text" name="mother_name" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field capitalize-first"
                                value="{{ old('mother_name') }}" placeholder=" ">
                                <label class="floating-label">Mother's Name *</label>
                        </div>
                        <div class="input-group relative">
                            <input type="text" name="father_occupation"
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field capitalize-first"
                                value="{{ old('father_occupation') }}" placeholder=" ">
                                <label class="floating-label">Father's Occupation</label>
                        </div>
                        <div class="input-group relative">
                            <input type="text" name="mother_occupation"
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field capitalize-first"
                                value="{{ old('mother_occupation') }}" placeholder=" ">
                                <label class="floating-label">Mother's Occupation</label>
                        </div>
                        <div class="input-group relative">
                            <input type="number" name="father_salary" step="0.01"
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                value="{{ old('father_salary') }}" placeholder=" ">
                                <label class="floating-label">Father's Monthly Salary</label>
                        </div>
                        <div class="input-group relative">
                            <input type="number" name="mother_salary" step="0.01"
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                value="{{ old('mother_salary') }}" placeholder=" ">
                                <label class="floating-label">Mother's Monthly Salary</label>
                        </div>
                        <div class="input-group relative">
                            <input type="date" name="father_birth_date"
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                value="{{ old('father_birth_date') }}">
                            <label class="floating-label">Father's Birth Date</label>
                        </div>
                        <div class="input-group relative">
                            <input type="date" name="mother_birth_date"
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field"
                                value="{{ old('mother_birth_date') }}">
                            <label class="floating-label">Mother's Birth Date</label>
                        </div>
                    </div>

                    <!-- Siblings Section -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 bg-gradient-to-br from-red-600 to-red-700 rounded-lg flex items-center justify-center">
                                <i class="fas fa-child text-white text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Siblings Information</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div class="input-group relative">
                                <select name="number_of_siblings" id="number_of_siblings"
                                    class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field">
                                    <option value=""> </option>
                                    @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('number_of_siblings') == $i ? 'selected' : '' }}>{{ $i }} Sibling{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                                <label class="floating-label">Number of Siblings</label>
                            </div>
                        </div>

                        <!-- Siblings Forms Container (Scrollable) -->
                        <div id="siblings_container" class="mt-4 max-h-96 overflow-y-auto space-y-4 border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <p class="text-sm text-gray-500 text-center py-4" id="no_siblings_message">
                                Select number of siblings to add their information
                            </p>
                        </div>

                        <!-- Add Sibling Button -->
                        <div class="mt-4">
                            <button type="button" onclick="addSibling()"
                                class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all text-sm font-medium shadow-md">
                                <i class="fas fa-plus mr-2"></i>Add Sibling
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Educational Information -->
                <div class="step-content p-5 hidden form-section" data-step="5">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-red-100">
                        <div class="w-10 h-10 section-icon rounded-xl flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Educational Information</h2>
                            <p class="text-sm text-gray-500">Your current academic details</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div class="input-group relative">
                            <select name="education_level" id="education_level" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field">
                                <option value=""> </option>
                                <option value="Incoming First Year College" {{ old('education_level') == 'Incoming First Year College' ? 'selected' : '' }}>Incoming First Year College</option>
                                <option value="College" {{ old('education_level') == 'College' ? 'selected' : '' }}>College</option>
                            </select>
                            <label class="floating-label">Education Level *</label>
                        </div>
                        <div class="input-group relative">
                            <input type="text" name="school_name" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field capitalize-first"
                                value="{{ old('school_name') }}" placeholder=" ">
                            <label class="floating-label">School Name *</label>
                        </div>
                        <div class="input-group relative">
                            <select name="semester_type" id="semester_type" required
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field">
                                <option value=""> </option>
                                <option value="2 Semesters" {{ old('semester_type') == '2 Semesters' ? 'selected' : '' }}>2 Semesters</option>
                                <option value="3 Semesters" {{ old('semester_type') == '3 Semesters' ? 'selected' : '' }}>3 Semesters</option>
                            </select>
                            <label class="floating-label">Semester Type *</label>
                        </div>
                        <div id="year_level_container" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Year Level</label>
                                <select name="year_level" id="year_level"
                                    class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field">
                                    <option value="">Select Year Level</option>
                                    <option value="1st Year" {{ old('year_level') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                                    <option value="2nd Year" {{ old('year_level') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                    <option value="3rd Year" {{ old('year_level') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                    <option value="4th Year" {{ old('year_level') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                                </select>
                            </div>
                            <div id="current_semester_container" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Semester *</label>
                                <select name="current_semester" id="current_semester"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500">
                                    <option value="">Select Current Semester</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Incoming First Year College Additional Fields -->
                    <div id="incoming_first_year_fields" class="mt-6 p-6 bg-blue-50 rounded-lg border border-blue-200 hidden">
                        <h3 class="text-lg font-semibold text-blue-800 mb-4">
                            <i class="fas fa-graduation-cap mr-2"></i>Senior High School Information
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">11-Digit LRN *</label>
                                <input type="text" name="lrn" maxlength="11" pattern="[0-9]{11}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                                    value="{{ old('lrn') }}" placeholder="Enter your 11-digit LRN">
                                <p class="text-xs text-gray-500 mt-1">Learner Reference Number (11 digits)</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Senior High Strand *</label>
                                <select name="shs_strand" id="shs_strand" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500">
                                    <option value="">Select Strand</option>
                                    <option value="STEM" {{ old('shs_strand') == 'STEM' ? 'selected' : '' }}>STEM (Science, Technology, Engineering, Mathematics)</option>
                                    <option value="ABM" {{ old('shs_strand') == 'ABM' ? 'selected' : '' }}>ABM (Accountancy, Business, Management)</option>
                                    <option value="HUMSS" {{ old('shs_strand') == 'HUMSS' ? 'selected' : '' }}>HUMSS (Humanities and Social Sciences)</option>
                                    <option value="GAS" {{ old('shs_strand') == 'GAS' ? 'selected' : '' }}>GAS (General Academic Strand)</option>
                                    <option value="TVL" {{ old('shs_strand') == 'TVL' ? 'selected' : '' }}>TVL (Technical-Vocational Livelihood)</option>
                                    <option value="SPORTS" {{ old('shs_strand') == 'SPORTS' ? 'selected' : '' }}>SPORTS</option>
                                    <option value="ARTS & DESIGN" {{ old('shs_strand') == 'ARTS & DESIGN' ? 'selected' : '' }}>ARTS & DESIGN</option>
                                    <option value="Other" {{ old('shs_strand') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div id="shs_strand_other_container" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Please specify your strand *</label>
                                <input type="text" name="shs_strand_other"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 capitalize-first"
                                    value="{{ old('shs_strand_other') }}" placeholder="Enter your strand">
                            </div>
                        </div>
                    </div>

                    <!-- College Additional Fields -->
                    <div id="college_fields" class="mt-6 p-6 bg-green-50 rounded-lg border border-green-200 hidden">
                        <h3 class="text-lg font-semibold text-green-800 mb-4">
                            <i class="fas fa-id-card mr-2"></i>School ID Information
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">School ID Type *</label>
                                <select name="school_id_type" id="school_id_type" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500">
                                    <option value="">Select ID Type</option>
                                    <option value="Current School ID" {{ old('school_id_type') == 'Current School ID' ? 'selected' : '' }}>Current School ID</option>
                                    <option value="Certificate of Registration (COR)" {{ old('school_id_type') == 'Certificate of Registration (COR)' ? 'selected' : '' }}>Certificate of Registration (COR)</option>
                                    <option value="Certificate of Enrollment (COE)" {{ old('school_id_type') == 'Certificate of Enrollment (COE)' ? 'selected' : '' }}>Certificate of Enrollment (COE)</option>
                                    <option value="Registration Form" {{ old('school_id_type') == 'Registration Form' ? 'selected' : '' }}>Registration Form</option>
                                    <option value="Official Receipt" {{ old('school_id_type') == 'Official Receipt' ? 'selected' : '' }}>Official Receipt</option>
                                    <option value="Other" {{ old('school_id_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">School ID Number *</label>
                                <input type="text" name="school_id_number" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                                    value="{{ old('school_id_number') }}" placeholder="Enter your complete school ID number">
                                <p class="text-xs text-gray-500 mt-1">Enter your complete school ID number</p>
                            </div>
                            <div id="school_id_type_other_container" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Please specify ID type *</label>
                                <input type="text" name="school_id_type_other"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 capitalize-first"
                                    value="{{ old('school_id_type_other') }}" placeholder="Enter ID type">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 6: Document Upload -->
                <div class="step-content p-8 hidden" data-step="6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Document Upload</h2>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                            <div>
                                <p class="text-sm text-blue-800 font-medium">File Selection Notice</p>
                                <p class="text-xs text-blue-700 mt-1">Your selected file names will be saved. If you navigate away and return, you'll see which files you previously selected, but you'll need to re-select them before submitting.</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Proof of Residency * (JPG/PNG only, max 2MB)</label>
                            <input type="file" name="proof_of_residency" accept=".jpg,.jpeg,.png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                                data-file-name="proof_of_residency">
                            <div id="proof_of_residency_filename" class="text-sm text-green-600 mt-1 hidden">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span class="filename"></span>
                            </div>
                            <div id="proof_of_residency_upload_feedback" class="text-sm mt-1 hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">2x2 Picture * (JPG/PNG only, max 1MB)</label>
                            <input type="file" name="picture_2x2" accept=".jpg,.jpeg,.png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                                data-file-name="picture_2x2">
                            <div id="picture_2x2_filename" class="text-sm text-green-600 mt-1 hidden">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span class="filename"></span>
                            </div>
                            <div id="picture_2x2_upload_feedback" class="text-sm mt-1 hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">School ID Front * (JPG/PNG only, max 2MB)</label>
                            <input type="file" name="school_id_front" accept=".jpg,.jpeg,.png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                                data-file-name="school_id_front">
                            <div id="school_id_front_filename" class="text-sm text-green-600 mt-1 hidden">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span class="filename"></span>
                            </div>
                            <div id="school_id_front_upload_feedback" class="text-sm mt-1 hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">School ID Back * (JPG/PNG only, max 2MB)</label>
                            <input type="file" name="school_id_back" accept=".jpg,.jpeg,.png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                                data-file-name="school_id_back">
                            <div id="school_id_back_filename" class="text-sm text-green-600 mt-1 hidden">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span class="filename"></span>
                            </div>
                            <div id="school_id_back_upload_feedback" class="text-sm mt-1 hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Letter of Intent * (JPG/PNG only, max 2MB)</label>
                            <input type="file" name="letter_of_intent" accept=".jpg,.jpeg,.png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                                data-file-name="letter_of_intent">
                            <div id="letter_of_intent_filename" class="text-sm text-green-600 mt-1 hidden">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span class="filename"></span>
                            </div>
                            <div id="letter_of_intent_upload_feedback" class="text-sm mt-1 hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Recent Grades * (JPG/PNG only, max 2MB)</label>
                            <input type="file" name="recent_grades" accept=".jpg,.jpeg,.png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                                data-file-name="recent_grades">
                            <div id="recent_grades_filename" class="text-sm text-green-600 mt-1 hidden">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span class="filename"></span>
                            </div>
                            <div id="recent_grades_upload_feedback" class="text-sm mt-1 hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Signature * (JPG/PNG only, max 1MB)</label>
                            <input type="file" name="signature" accept=".jpg,.jpeg,.png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                                data-file-name="signature">
                            <div id="signature_filename" class="text-sm text-green-600 mt-1 hidden">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span class="filename"></span>
                            </div>
                            <div id="signature_upload_feedback" class="text-sm mt-1 hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">COR/COE * (JPG/PNG only, max 2MB)</label>
                            <input type="file" name="cor_coe" accept=".jpg,.jpeg,.png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                                data-file-name="cor_coe">
                            <div id="cor_coe_filename" class="text-sm text-green-600 mt-1 hidden">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span class="filename"></span>
                            </div>
                            <div id="cor_coe_upload_feedback" class="text-sm mt-1 hidden"></div>
                        </div>
                    </div>
                </div>

                <!-- Step 7: Privacy Agreement and Submit -->
                <div class="step-content p-8 hidden" data-step="7">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Privacy Agreement and Submit</h2>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                        <h3 class="font-semibold text-blue-800 mb-4">
                            <i class="fas fa-shield-alt mr-2"></i>Privacy Rules and Regulations
                        </h3>
                        <div class="space-y-3 text-sm text-blue-700">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mt-0.5 mr-3"></i>
                                <p>I understand that my personal information will be collected and processed in accordance with the Data Privacy Act of 2012.</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mt-0.5 mr-3"></i>
                                <p>I consent to the use of my information for the purpose of my scholarship application and verification.</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mt-0.5 mr-3"></i>
                                <p>I acknowledge that providing false information may result in immediate disqualification and legal action.</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mt-0.5 mr-3"></i>
                                <p>I understand that all submitted documents become the property of the scholarship program.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-yellow-600 mt-0.5 mr-3"></i>
                            <div>
                                <p class="text-sm text-yellow-700">
                                    After submission, you will receive a reference number that you can use to track your application status.
                                    This reference number will also be sent to your email address.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" name="terms_agreed" value="1" {{ old('terms_agreed') ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1">
                            <span class="ml-3 text-sm text-gray-700">
                                <strong>I have read and agree to the Privacy Rules and Regulations.</strong> I certify that all information provided is true and correct. I understand that false information may result in disqualification.
                            </span>
                        </label>
                    </div>

                    <div class="text-center">
                        <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Application
                        </button>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center p-6 border-t border-gray-200">
                    <button type="button" id="prevBtn" 
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors hidden">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Previous
                    </button>
                    <button type="button" id="nextBtn" 
                        class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all ml-auto">
                        Next
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <button onclick="clearFormData(); location.reload();" 
                    class="text-gray-600 hover:text-red-600 text-sm font-medium transition-colors">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Clear Form Data
                </button>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-red-600 text-sm font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Home
                </a>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                <i class="fas fa-info-circle mr-1"></i>
                Your form data is automatically saved and will be restored if you reload the page
            </p>
        </div>
    </div>

    <!-- OTP Verification Modal -->
    <div id="otpModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-shield-alt mr-2"></i>Email Verification
                    </h3>
                    <button onclick="closeOtpModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-blue-600 text-2xl"></i>
                    </div>
                    <p class="text-gray-600 text-sm">Enter the 6-digit OTP sent to your email address</p>
                    <p class="text-blue-600 font-medium text-sm mt-1" id="otpEmailDisplay"></p>
                </div>
                
                <!-- OTP Input -->
                <div class="flex justify-center gap-2 mb-6">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" data-index="0">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" data-index="1">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" data-index="2">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" data-index="3">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" data-index="4">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" data-index="5">
                </div>
                
                <!-- Timer -->
                <div class="text-center mb-4">
                    <p id="otpTimer" class="text-gray-500 text-sm"></p>
                    <button id="resendOtpBtn" onclick="resendOtp()" class="text-blue-600 hover:text-blue-700 text-sm font-medium hidden">
                        <i class="fas fa-redo mr-1"></i>Resend OTP
                    </button>
                </div>
                
                <!-- Error/Success Message -->
                <div id="otpMessage" class="text-center text-sm mb-4 hidden"></div>
                
                <!-- Verify Button -->
                <button onclick="verifyOtp()" id="verifyOtpBtn"
                    class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all font-medium">
                    <i class="fas fa-check-circle mr-2"></i>Verify OTP
                </button>
            </div>
        </div>
    </div>

    <!-- Reference Number Modal -->
    <div id="referenceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-check-circle mr-2"></i>Application Submitted
                    </h3>
                    <button onclick="closeReferenceModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-paper-plane text-green-600 text-2xl"></i>
                    </div>
                    <p class="text-gray-600 text-sm">Your application has been submitted successfully!</p>
                    <p class="text-gray-500 text-xs mt-2">A confirmation email with your reference number has been sent to your email address.</p>
                </div>
                
                <!-- Reference Number Display -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Reference Number</label>
                    <div class="flex items-center gap-2">
                        <input type="text" id="referenceNumberDisplay" readonly
                            class="flex-1 px-4 py-3 bg-white border-2 border-gray-300 rounded-lg text-lg font-bold text-gray-800 focus:outline-none"
                            value="">
                        <button onclick="copyReferenceNumber()" 
                            class="px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Save this reference number to track your application status
                    </p>
                </div>
                
                <!-- Batch Info -->
                <div id="batchInfo" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-users text-blue-600 mt-0.5 mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-blue-800">Your Batch</p>
                            <p id="batchIdDisplay" class="text-xs text-blue-700 mt-1"></p>
                        </div>
                    </div>
                </div>
                
                <!-- Application Status -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-clock text-yellow-600 mt-0.5 mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Application Status: Pending</p>
                            <p class="text-xs text-yellow-700 mt-1">Your application is under review. You will receive an email notification once approved.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Track Application Link -->
                <a href="{{ route('track-application') }}" 
                    class="block w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all font-medium text-center">
                    <i class="fas fa-search mr-2"></i>Track Application Status
                </a>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-exclamation-circle mr-2"></i>Registration Error
                    </h3>
                    <button onclick="closeErrorModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                    </div>
                    <p class="text-gray-600 text-sm">There was an error submitting your application. Please review the errors below and try again.</p>
                </div>
                
                <!-- Error Message Display -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p id="errorMessage" class="text-sm text-red-700"></p>
                </div>
                
                <!-- Close Button -->
                <button onclick="closeErrorModal()" 
                    class="block w-full px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all font-medium text-center">
                    <i class="fas fa-times mr-2"></i>Close
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 7;
        let usernameTimeout, emailTimeout;

        // Form data persistence functions
        function saveFormData() {
            const formData = {
                step: currentStep,
                data: {},
                fileNames: {},
                fileData: {},
                isEmailVerified: isEmailVerified,
                siblings: []
            };
            
            // Save all form inputs except files
            document.querySelectorAll('#registrationForm input, #registrationForm select, #registrationForm textarea').forEach(input => {
                if (input.type !== 'file') {
                    formData.data[input.name] = input.value;
                }
            });
            
            // Save siblings data
            const siblingForms = document.querySelectorAll('.sibling-form');
            siblingForms.forEach(form => {
                const index = form.getAttribute('data-sibling-index');
                const nameInput = form.querySelector('input[name*="[name]"]');
                const genderSelect = form.querySelector('select[name*="[gender]"]');
                const birthDateInput = form.querySelector('input[name*="[birth_date]"]');
                const occupationSelect = form.querySelector('select[name*="[occupation]"]');
                
                if (nameInput || genderSelect || birthDateInput || occupationSelect) {
                    formData.siblings.push({
                        index: index,
                        name: nameInput ? nameInput.value : '',
                        gender: genderSelect ? genderSelect.value : '',
                        birth_date: birthDateInput ? birthDateInput.value : '',
                        occupation: occupationSelect ? occupationSelect.value : ''
                    });
                }
            });
            
            // Save file data temporarily
            document.querySelectorAll('#registrationForm input[type="file"]').forEach(input => {
                const fileName = input.getAttribute('data-file-name');
                if (fileName && input.files.length > 0) {
                    const file = input.files[0];
                    formData.fileNames[fileName] = file.name;
                    
                    // Read file as base64 and save
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        formData.fileData[fileName] = {
                            name: file.name,
                            size: file.size,
                            type: file.type,
                            data: e.target.result
                        };
                        localStorage.setItem('registrationFormData', JSON.stringify(formData));
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            // Save without waiting for file reading (for non-file changes)
            if (Object.keys(formData.fileData).length === 0) {
                localStorage.setItem('registrationFormData', JSON.stringify(formData));
            }
        }

        function loadFormData() {
            const savedData = localStorage.getItem('registrationFormData');
            if (savedData) {
                try {
                    const formData = JSON.parse(savedData);
                    
                    // Restore current step
                    currentStep = formData.step || 1;
                    
                    // Restore email verification status
                    if (formData.isEmailVerified) {
                        isEmailVerified = formData.isEmailVerified;
                        document.getElementById('email-verified-badge').classList.remove('hidden');
                        document.getElementById('sendOtpBtn').textContent = 'Verified ✓';
                        document.getElementById('sendOtpBtn').disabled = true;
                        document.getElementById('sendOtpBtn').classList.add('opacity-50', 'cursor-not-allowed');
                    }
                    
                    // Restore input values
                    if (formData.data) {
                        Object.keys(formData.data).forEach(name => {
                            const input = document.querySelector(`[name="${name}"]`);
                            if (input) {
                                input.value = formData.data[name];
                                
                                // Trigger validation for specific fields
                                if (name === 'username') {
                                    validateUsername(input.value);
                                } else if (name === 'email') {
                                    validateEmail(input.value);
                                } else if (name === 'password') {
                                    validatePassword(input.value);
                                } else if (name === 'password_confirmation') {
                                    validatePasswordMatch();
                                }
                            }
                        });
                    }
                    
                    // Restore siblings data
                    if (formData.siblings && formData.siblings.length > 0) {
                        siblingCount = formData.siblings.length;
                        const dropdown = document.getElementById('number_of_siblings');
                        if (dropdown) {
                            dropdown.value = siblingCount;
                        }
                        
                        // Generate sibling forms
                        generateSiblingsForms(siblingCount);
                        
                        // Populate sibling form data
                        formData.siblings.forEach(siblingData => {
                            const form = document.querySelector(`[data-sibling-index="${siblingData.index}"]`);
                            if (form) {
                                const nameInput = form.querySelector('input[name*="[name]"]');
                                const genderSelect = form.querySelector('select[name*="[gender]"]');
                                const birthDateInput = form.querySelector('input[name*="[birth_date]"]');
                                const occupationSelect = form.querySelector('select[name*="[occupation]"]');
                                
                                if (nameInput) nameInput.value = siblingData.name || '';
                                if (genderSelect) genderSelect.value = siblingData.gender || '';
                                if (birthDateInput) birthDateInput.value = siblingData.birth_date || '';
                                if (occupationSelect) occupationSelect.value = siblingData.occupation || '';
                            }
                        });
                    }
                    
                    // Restore file names display and recreate file objects
                    if (formData.fileNames) {
                        Object.keys(formData.fileNames).forEach(fileName => {
                            const filenameDiv = document.getElementById(`${fileName}_filename`);
                            if (filenameDiv && formData.fileNames[fileName]) {
                                filenameDiv.querySelector('.filename').textContent = formData.fileNames[fileName];
                                filenameDiv.classList.remove('hidden');
                            }
                        });
                    }
                    
                    // Restore actual file objects from base64 data
                    if (formData.fileData) {
                        Object.keys(formData.fileData).forEach(fileName => {
                            const fileData = formData.fileData[fileName];
                            const input = document.querySelector(`[data-file-name="${fileName}"]`);
                            
                            if (input && fileData && fileData.data) {
                                // Convert base64 back to File object
                                fetch(fileData.data)
                                    .then(res => res.blob())
                                    .then(blob => {
                                        const file = new File([blob], fileData.name, {
                                            type: fileData.type,
                                            lastModified: Date.now()
                                        });
                                        
                                        // Create a new DataTransfer to set the file
                                        const dataTransfer = new DataTransfer();
                                        dataTransfer.items.add(file);
                                        input.files = dataTransfer.files;
                                        
                                        // Trigger change event to update UI
                                        const event = new Event('change', { bubbles: true });
                                        input.dispatchEvent(event);
                                    })
                                    .catch(error => {
                                        console.error('Error restoring file:', fileName, error);
                                    });
                            }
                        });
                    }
                    
                    // Restore current semester value after options are populated
                    if (formData.data && formData.data.current_semester) {
                        setTimeout(() => {
                            const currentSemesterInput = document.querySelector('select[name="current_semester"]');
                            if (currentSemesterInput) {
                                currentSemesterInput.value = formData.data.current_semester;
                            }
                        }, 100); // Small delay to ensure options are populated
                    }
                } catch (error) {
                    console.error('Error loading form data:', error);
                }
            }
        }

        function clearFormData() {
            localStorage.removeItem('registrationFormData');
        }

        // OTP Verification Variables
        let otpTimerInterval;
        let isEmailVerified = false;

        // Send OTP
        function sendOtp() {
            const email = document.getElementById('email').value;
            
            if (!email || !email.includes('@')) {
                alert('Please enter a valid email address first.');
                return;
            }
            
            // Validate email format first
            const emailValid = validateEmail(email);
            if (!emailValid) {
                alert('Please fix email validation errors first.');
                return;
            }
            
            // Disable button and show loading
            const btn = document.getElementById('sendOtpBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
            
            // Generate reference number for this session
            const referenceNumber = 'REG-' + Date.now();
            
            // Send OTP to server
            fetch('/api/send-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    email: email,
                    reference_number: referenceNumber
                })
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-shield-alt mr-2"></i>Verify Email';
                
                if (data.success) {
                    // Show modal
                    document.getElementById('otpModal').classList.remove('hidden');
                    document.getElementById('otpModal').classList.add('flex');
                    document.getElementById('otpEmailDisplay').textContent = email;
                    document.getElementById('otpMessage').classList.add('hidden');
                    
                    // Clear OTP inputs
                    document.querySelectorAll('.otp-input').forEach(input => {
                        input.value = '';
                    });
                    
                    // Store reference number for verification
                    document.getElementById('otpModal').dataset.referenceNumber = referenceNumber;
                    
                    // Start timer (10 minutes as per backend)
                    startOtpTimer(10 * 60);
                } else {
                    alert(data.message || 'Failed to send OTP. Please try again.');
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-shield-alt mr-2"></i>Verify Email';
                console.error('Error sending OTP:', error);
                alert('Failed to send OTP. Please check your connection and try again.');
            });
        }

        // Close OTP Modal
        function closeOtpModal() {
            document.getElementById('otpModal').classList.add('hidden');
            document.getElementById('otpModal').classList.remove('flex');
            clearInterval(otpTimerInterval);
        }

        // Start OTP Timer
        function startOtpTimer(seconds) {
            let remaining = seconds;
            const timerDisplay = document.getElementById('otpTimer');
            const resendBtn = document.getElementById('resendOtpBtn');
            
            clearInterval(otpTimerInterval);
            resendBtn.classList.add('hidden');
            
            otpTimerInterval = setInterval(() => {
                const minutes = Math.floor(remaining / 60);
                const secs = remaining % 60;
                timerDisplay.textContent = `OTP expires in ${minutes}:${secs.toString().padStart(2, '0')}`;
                
                if (remaining <= 0) {
                    clearInterval(otpTimerInterval);
                    timerDisplay.textContent = 'OTP has expired';
                    resendBtn.classList.remove('hidden');
                }
                
                remaining--;
            }, 1000);
        }

        // Resend OTP
        function resendOtp() {
            const email = document.getElementById('email').value;
            const referenceNumber = 'REG-' + Date.now();
            
            // Disable resend button
            const resendBtn = document.getElementById('resendOtpBtn');
            resendBtn.disabled = true;
            resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Sending...';
            
            fetch('/api/send-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    email: email,
                    reference_number: referenceNumber
                })
            })
            .then(response => response.json())
            .then(data => {
                resendBtn.disabled = false;
                resendBtn.innerHTML = '<i class="fas fa-redo mr-1"></i>Resend OTP';
                
                if (data.success) {
                    // Clear OTP inputs
                    document.querySelectorAll('.otp-input').forEach(input => {
                        input.value = '';
                    });
                    
                    // Store new reference number
                    document.getElementById('otpModal').dataset.referenceNumber = referenceNumber;
                    
                    document.getElementById('otpMessage').classList.add('hidden');
                    startOtpTimer(10 * 60);
                    
                    alert('OTP resent successfully!');
                } else {
                    alert(data.message || 'Failed to resend OTP. Please try again.');
                }
            })
            .catch(error => {
                resendBtn.disabled = false;
                resendBtn.innerHTML = '<i class="fas fa-redo mr-1"></i>Resend OTP';
                console.error('Error resending OTP:', error);
                alert('Failed to resend OTP. Please check your connection and try again.');
            });
        }

        // Verify OTP
        function verifyOtp() {
            let enteredOtp = '';
            document.querySelectorAll('.otp-input').forEach(input => {
                enteredOtp += input.value;
            });
            
            if (enteredOtp.length !== 6) {
                showOtpMessage('Please enter all 6 digits', 'error');
                return;
            }
            
            const email = document.getElementById('email').value;
            const referenceNumber = document.getElementById('otpModal').dataset.referenceNumber;
            
            // Disable verify button
            const verifyBtn = document.getElementById('verifyOtpBtn');
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Verifying...';
            
            fetch('/api/verify-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    email: email,
                    otp_code: enteredOtp,
                    reference_number: referenceNumber
                })
            })
            .then(response => response.json())
            .then(data => {
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Verify OTP';
                
                if (data.success) {
                    isEmailVerified = true;
                    showOtpMessage('Email verified successfully!', 'success');
                    
                    // Show verified badge
                    document.getElementById('email-verified-badge').classList.remove('hidden');
                    document.getElementById('sendOtpBtn').textContent = 'Verified ✓';
                    document.getElementById('sendOtpBtn').disabled = true;
                    document.getElementById('sendOtpBtn').classList.add('opacity-50', 'cursor-not-allowed');
                    
                    // Save verification status
                    autoSave();
                    
                    // Close modal after success
                    setTimeout(() => {
                        closeOtpModal();
                    }, 1500);
                } else {
                    showOtpMessage(data.message || 'Invalid OTP. Please try again.', 'error');
                    
                    // Clear OTP inputs
                    document.querySelectorAll('.otp-input').forEach(input => {
                        input.value = '';
                    });
                    document.querySelector('.otp-input').focus();
                }
            })
            .catch(error => {
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Verify OTP';
                console.error('Error verifying OTP:', error);
                showOtpMessage('Failed to verify OTP. Please check your connection and try again.', 'error');
            });
        }

        // Show OTP Message
        function showOtpMessage(message, type) {
            const messageDiv = document.getElementById('otpMessage');
            messageDiv.textContent = message;
            messageDiv.classList.remove('hidden');
            
            if (type === 'error') {
                messageDiv.classList.add('text-red-600');
                messageDiv.classList.remove('text-green-600');
            } else {
                messageDiv.classList.add('text-green-600');
                messageDiv.classList.remove('text-red-600');
            }
        }

        // Setup OTP Input Auto-focus
        function setupOtpInputs() {
            const otpInputs = document.querySelectorAll('.otp-input');
            
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');
                    
                    if (this.value.length === 1) {
                        // Move to next input
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    }
                });
                
                input.addEventListener('keydown', function(e) {
                    // Handle backspace
                    if (e.key === 'Backspace' && this.value === '') {
                        if (index > 0) {
                            otpInputs[index - 1].focus();
                        }
                    }
                });
                
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').slice(0, 6);
                    const digits = pastedData.replace(/[^0-9]/g, '');
                    
                    digits.split('').forEach((digit, i) => {
                        if (i < otpInputs.length) {
                            otpInputs[i].value = digit;
                        }
                    });
                    
                    if (digits.length > 0 && digits.length < otpInputs.length) {
                        otpInputs[digits.length].focus();
                    }
                });
            });
        }

        // Reference Modal Functions
        function showReferenceModal(referenceNumber, batchId = null) {
            document.getElementById('referenceNumberDisplay').value = referenceNumber;
            if (batchId) {
                document.getElementById('batchIdDisplay').textContent = 'Batch ' + batchId;
                document.getElementById('batchInfo').classList.remove('hidden');
            } else {
                document.getElementById('batchInfo').classList.add('hidden');
            }
            document.getElementById('referenceModal').classList.remove('hidden');
            document.getElementById('referenceModal').classList.add('flex');
        }

        function closeReferenceModal() {
            document.getElementById('referenceModal').classList.add('hidden');
            document.getElementById('referenceModal').classList.remove('flex');
        }

        function copyReferenceNumber() {
            const refNumber = document.getElementById('referenceNumberDisplay').value;
            navigator.clipboard.writeText(refNumber).then(() => {
                // Show copied feedback
                const copyBtn = document.querySelector('#referenceModal button[onclick="copyReferenceNumber()"]');
                const originalHTML = copyBtn.innerHTML;
                copyBtn.innerHTML = '<i class="fas fa-check"></i>';
                copyBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                copyBtn.classList.add('bg-green-600');
                
                setTimeout(() => {
                    copyBtn.innerHTML = originalHTML;
                    copyBtn.classList.remove('bg-green-600');
                    copyBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }, 2000);
            });
        }

        function showErrorModal(errors) {
            const errorModal = document.getElementById('errorModal');
            const errorMessage = document.getElementById('errorMessage');
            
            if (typeof errors === 'object') {
                let errorText = '';
                for (const field in errors) {
                    errorText += `<strong>${field}:</strong> ${Array.isArray(errors[field]) ? errors[field].join(', ') : errors[field]}<br>`;
                }
                errorMessage.innerHTML = errorText;
            } else {
                errorMessage.textContent = errors;
            }
            
            errorModal.classList.remove('hidden');
            errorModal.classList.add('flex');
        }

        function closeErrorModal() {
            const errorModal = document.getElementById('errorModal');
            errorModal.classList.add('hidden');
            errorModal.classList.remove('flex');
        }

        // Auto-save form data
        function autoSave() {
            saveFormData();
        }

        // Conditional form display based on education level
        function updateEducationFields() {
            const educationLevel = document.getElementById('education_level').value;
            const incomingFields = document.getElementById('incoming_first_year_fields');
            const collegeFields = document.getElementById('college_fields');
            const yearLevelContainer = document.getElementById('year_level_container');
            const yearLevelInput = document.querySelector('select[name="year_level"]');
            const currentSemesterContainer = document.getElementById('current_semester_container');
            
            // Hide all conditional fields first
            incomingFields.classList.add('hidden');
            collegeFields.classList.add('hidden');
            
            // Remove required attribute from conditional fields
            document.querySelectorAll('#incoming_first_year_fields input, #incoming_first_year_fields select').forEach(field => {
                field.removeAttribute('required');
            });
            document.querySelectorAll('#college_fields input, #college_fields select').forEach(field => {
                field.removeAttribute('required');
            });
            
            if (educationLevel === 'Incoming First Year College') {
                // Show incoming first year fields
                incomingFields.classList.remove('hidden');
                // Show year level container but hide year level (show only current semester)
                yearLevelContainer.style.display = 'block';
                yearLevelInput.parentElement.style.display = 'none';
                currentSemesterContainer.classList.remove('hidden');
                yearLevelInput.removeAttribute('required');
                // Add required to incoming fields
                document.querySelector('input[name="lrn"]').setAttribute('required', '');
                document.querySelector('select[name="shs_strand"]').setAttribute('required', '');
                
                // Setup other options and semester type after fields are visible
                setTimeout(() => {
                    setupOtherOptions();
                    setupSemesterType();
                }, 50);
            } else if (educationLevel === 'College') {
                // Show college fields
                collegeFields.classList.remove('hidden');
                // Show year level container with both year level and current semester
                yearLevelContainer.style.display = 'block';
                yearLevelInput.parentElement.style.display = 'block';
                yearLevelInput.setAttribute('required', '');
                // Add required to college fields
                document.querySelector('select[name="school_id_type"]').setAttribute('required', '');
                document.querySelector('input[name="school_id_number"]').setAttribute('required', '');
                
                // Setup other options and semester type after fields are visible
                setTimeout(() => {
                    setupOtherOptions();
                    setupSemesterType();
                }, 50);
            } else {
                // Hide year level if no selection
                yearLevelContainer.style.display = 'block';
                yearLevelInput.parentElement.style.display = 'block';
                currentSemesterContainer.classList.add('hidden');
                yearLevelInput.removeAttribute('required');
            }
        }

        // Auto-capitalization function
        function capitalizeFirstLetter(input) {
            if (!input.value) return;
            
            // Split by spaces and capitalize each word
            const words = input.value.toLowerCase().split(' ');
            const capitalizedWords = words.map(word => {
                if (word.length === 0) return '';
                return word.charAt(0).toUpperCase() + word.slice(1);
            });
            
            input.value = capitalizedWords.join(' ');
        }

        // Add auto-capitalization to applicable fields
        function setupAutoCapitalization() {
            const fieldsToCapitalize = document.querySelectorAll('.capitalize-first');
            fieldsToCapitalize.forEach(field => {
                field.addEventListener('blur', function() {
                    capitalizeFirstLetter(this);
                });
                field.addEventListener('input', function() {
                    // Also capitalize on input for better UX
                    const cursorPos = this.selectionStart;
                    capitalizeFirstLetter(this);
                    // Restore cursor position
                    this.setSelectionRange(cursorPos, cursorPos);
                });
            });
        }

        // Handle "Other" options for dropdowns
        function setupOtherOptions() {
            // SHS Strand Other option
            function setupShsStrandOther() {
                const shsStrandSelect = document.getElementById('shs_strand');
                const shsStrandOtherContainer = document.getElementById('shs_strand_other_container');
                const shsStrandOtherInput = document.querySelector('input[name="shs_strand_other"]');
                
                if (shsStrandSelect && shsStrandOtherContainer && shsStrandOtherInput) {
                    shsStrandSelect.addEventListener('change', function() {
                        if (this.value === 'Other') {
                            shsStrandOtherContainer.classList.remove('hidden');
                            shsStrandOtherInput.setAttribute('required', '');
                        } else {
                            shsStrandOtherContainer.classList.add('hidden');
                            shsStrandOtherInput.removeAttribute('required');
                            shsStrandOtherInput.value = '';
                        }
                        autoSave();
                    });
                    
                    // Initialize based on current value
                    if (shsStrandSelect.value === 'Other') {
                        shsStrandOtherContainer.classList.remove('hidden');
                        shsStrandOtherInput.setAttribute('required', '');
                    }
                }
            }
            
            // School ID Type Other option
            function setupSchoolIdTypeOther() {
                const schoolIdTypeSelect = document.getElementById('school_id_type');
                const schoolIdTypeOtherContainer = document.getElementById('school_id_type_other_container');
                const schoolIdTypeOtherInput = document.querySelector('input[name="school_id_type_other"]');
                
                if (schoolIdTypeSelect && schoolIdTypeOtherContainer && schoolIdTypeOtherInput) {
                    schoolIdTypeSelect.addEventListener('change', function() {
                        if (this.value === 'Other') {
                            schoolIdTypeOtherContainer.classList.remove('hidden');
                            schoolIdTypeOtherInput.setAttribute('required', '');
                        } else {
                            schoolIdTypeOtherContainer.classList.add('hidden');
                            schoolIdTypeOtherInput.removeAttribute('required');
                            schoolIdTypeOtherInput.value = '';
                        }
                        autoSave();
                    });
                    
                    // Initialize based on current value
                    if (schoolIdTypeSelect.value === 'Other') {
                        schoolIdTypeOtherContainer.classList.remove('hidden');
                        schoolIdTypeOtherInput.setAttribute('required', '');
                    }
                }
            }
            
            // Initialize both setups
            setupShsStrandOther();
            setupSchoolIdTypeOther();
            
            // Also setup when education level changes (since fields might become visible)
            const educationLevelSelect = document.getElementById('education_level');
            if (educationLevelSelect) {
                educationLevelSelect.addEventListener('change', function() {
                    setTimeout(() => {
                        setupShsStrandOther();
                        setupSchoolIdTypeOther();
                        setupSemesterType();
                    }, 100); // Small delay to ensure DOM is updated
                });
            }
        }

        // Handle semester type and current semester
        function setupSemesterType() {
            const semesterTypeSelect = document.getElementById('semester_type');
            const currentSemesterContainer = document.getElementById('current_semester_container');
            const currentSemesterSelect = document.getElementById('current_semester');
            const educationLevelSelect = document.getElementById('education_level');
            
            if (semesterTypeSelect && currentSemesterContainer && currentSemesterSelect) {
                function updateCurrentSemesterOptions() {
                    const semesterType = semesterTypeSelect.value;
                    const educationLevel = educationLevelSelect.value;
                    
                    // Clear existing options
                    currentSemesterSelect.innerHTML = '<option value="">Select Current Semester</option>';
                    
                    if (semesterType === '2 Semesters') {
                        // Show container and add 2 semester options
                        currentSemesterContainer.classList.remove('hidden');
                        currentSemesterSelect.innerHTML += `
                            <option value="1st Semester" {{ old('current_semester') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                            <option value="2nd Semester" {{ old('current_semester') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                        `;
                        currentSemesterSelect.setAttribute('required', '');
                    } else if (semesterType === '3 Semesters') {
                        // Show container and add 3 semester options
                        currentSemesterContainer.classList.remove('hidden');
                        currentSemesterSelect.innerHTML += `
                            <option value="1st Semester" {{ old('current_semester') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                            <option value="2nd Semester" {{ old('current_semester') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                            <option value="3rd Semester" {{ old('current_semester') == '3rd Semester' ? 'selected' : '' }}>3rd Semester</option>
                        `;
                        currentSemesterSelect.setAttribute('required', '');
                    } else {
                        // Hide container if no semester type selected
                        currentSemesterContainer.classList.add('hidden');
                        currentSemesterSelect.removeAttribute('required');
                    }
                }
                
                // Add change event listener
                semesterTypeSelect.addEventListener('change', function() {
                    updateCurrentSemesterOptions();
                    autoSave();
                });
                
                // Initialize based on current value
                updateCurrentSemesterOptions();
            }
        }

        // Real-time validation functions
        function validateUsername(username) {
            const feedback = document.getElementById('username-feedback');
            const icon = document.getElementById('username-icon');
            const input = document.getElementById('username');
            
            if (username.length < 6) {
                updateValidation(input, icon, feedback, 'Username must be at least 6 characters', 'invalid', 'fa-times-circle', 'text-red-500');
                return false;
            }
            
            if (username.length > 20) {
                updateValidation(input, icon, feedback, 'Username must be less than 20 characters', 'invalid', 'fa-times-circle', 'text-red-500');
                return false;
            }
            
            if (!/^[a-zA-Z0-9]+$/.test(username)) {
                updateValidation(input, icon, feedback, 'Username must contain only letters and numbers', 'invalid', 'fa-times-circle', 'text-red-500');
                return false;
            }
            
            // Show checking state
            updateValidation(input, icon, feedback, 'Checking availability...', 'checking', 'fa-spinner fa-spin', 'text-yellow-500');
            
            // Fast API call with reduced delay and fallback
            clearTimeout(usernameTimeout);
            usernameTimeout = setTimeout(() => {
                // Set a timeout for the fetch request
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 5000);
                
                fetch(`/api/validate/username?username=${encodeURIComponent(username)}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    signal: controller.signal
                })
                    .then(response => {
                        clearTimeout(timeoutId);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.valid) {
                            updateValidation(input, icon, feedback, data.message, 'valid', 'fa-check-circle', 'text-green-500');
                        } else {
                            updateValidation(input, icon, feedback, data.message, 'invalid', 'fa-times-circle', 'text-red-500');
                        }
                    })
                    .catch(error => {
                        clearTimeout(timeoutId);
                        console.error('Username validation error:', error);
                        // Fallback to client-side validation
                        if (username.length >= 6 && username.length <= 20 && /^[a-zA-Z0-9]+$/.test(username)) {
                            updateValidation(input, icon, feedback, 'Username format is valid', 'valid', 'fa-check-circle', 'text-green-500');
                        } else {
                            updateValidation(input, icon, feedback, 'Invalid username format', 'invalid', 'fa-times-circle', 'text-red-500');
                        }
                    });
            }, 300);
            
            return true;
        }

        function validateEmail(email) {
            const feedback = document.getElementById('email-feedback');
            const icon = document.getElementById('email-icon');
            const input = document.getElementById('email');
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!email) {
                updateValidation(input, icon, feedback, '', '', 'fa-circle', 'text-gray-300');
                return false;
            }
            
            if (!emailRegex.test(email)) {
                updateValidation(input, icon, feedback, 'Invalid email format', 'invalid', 'fa-times-circle', 'text-red-500');
                return false;
            }
            
            // Show checking state
            updateValidation(input, icon, feedback, 'Checking availability...', 'checking', 'fa-spinner fa-spin', 'text-yellow-500');
            
            // Fast API call with reduced delay and fallback
            clearTimeout(emailTimeout);
            emailTimeout = setTimeout(() => {
                // Set a timeout for the fetch request
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 5000);
                
                fetch(`/api/validate/email?email=${encodeURIComponent(email)}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    signal: controller.signal
                })
                    .then(response => {
                        clearTimeout(timeoutId);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.valid) {
                            updateValidation(input, icon, feedback, data.message, 'valid', 'fa-check-circle', 'text-green-500');
                        } else {
                            updateValidation(input, icon, feedback, data.message, 'invalid', 'fa-times-circle', 'text-red-500');
                        }
                    })
                    .catch(error => {
                        clearTimeout(timeoutId);
                        console.error('Email validation error:', error);
                        // Fallback to client-side validation
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (emailRegex.test(email)) {
                            updateValidation(input, icon, feedback, 'Email format is valid', 'valid', 'fa-check-circle', 'text-green-500');
                        } else {
                            updateValidation(input, icon, feedback, 'Invalid email format', 'invalid', 'fa-times-circle', 'text-red-500');
                        }
                    });
            }, 300);
            
            return true;
        }

        function validatePassword(password) {
            const feedback = document.getElementById('strength-text');
            const icon = document.getElementById('password-icon');
            const input = document.getElementById('password');
            const strengthBar = document.getElementById('strength-bar');
            
            if (!password) {
                updateValidation(input, icon, '', '', '', 'fa-circle', 'text-gray-300');
                strengthBar.style.width = '0%';
                feedback.textContent = '';
                return false;
            }
            
            let strength = 0;
            let strengthText = '';
            let strengthColor = '';
            
            // Check length
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 10;
            
            // Check for lowercase
            if (/[a-z]/.test(password)) strength += 15;
            
            // Check for uppercase
            if (/[A-Z]/.test(password)) strength += 15;
            
            // Check for numbers
            if (/[0-9]/.test(password)) strength += 15;
            
            // Check for special characters
            if (/[^a-zA-Z0-9]/.test(password)) strength += 20;
            
            // Determine strength level
            if (strength <= 30) {
                strengthText = 'Weak';
                strengthColor = 'bg-red-500';
                feedback.className = 'text-xs font-medium text-red-500';
            } else if (strength <= 60) {
                strengthText = 'Medium';
                strengthColor = 'bg-yellow-500';
                feedback.className = 'text-xs font-medium text-yellow-500';
            } else {
                strengthText = 'Strong';
                strengthColor = 'bg-green-500';
                feedback.className = 'text-xs font-medium text-green-500';
            }
            
            // Update UI
            strengthBar.style.width = strength + '%';
            strengthBar.className = 'password-strength-bar h-2 rounded-full ' + strengthColor;
            feedback.textContent = strengthText;
            
            // Update icon
            if (strength <= 30) {
                icon.className = 'fas fa-exclamation-circle text-red-500 text-sm';
            } else if (strength <= 60) {
                icon.className = 'fas fa-exclamation-triangle text-yellow-500 text-sm';
            } else {
                icon.className = 'fas fa-check-circle text-green-500 text-sm';
            }
            
            return strength >= 50;
        }

        function validatePasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const feedback = document.getElementById('confirm-feedback');
            const icon = document.getElementById('confirm-icon');
            const input = document.getElementById('password_confirmation');
            
            if (!confirmPassword) {
                updateValidation(input, icon, '', '', '', 'fa-circle', 'text-gray-300');
                return false;
            }
            
            if (password !== confirmPassword) {
                updateValidation(input, icon, feedback, 'Passwords do not match', 'invalid', 'fa-times-circle', 'text-red-500');
                return false;
            }
            
            updateValidation(input, icon, feedback, 'Passwords match!', 'valid', 'fa-check-circle', 'text-green-500');
            return true;
        }

        function updateValidation(input, icon, feedback, message, state, iconClass, textClass) {
            // Remove all validation classes
            input.classList.remove('input-valid', 'input-invalid', 'checking');

            if (state === 'valid') {
                input.classList.add('input-valid');
                icon.className = iconClass + ' ' + textClass;
                feedback.className = 'validation-feedback text-xs mt-1 ' + textClass;
            } else if (state === 'invalid') {
                input.classList.add('input-invalid');
                icon.className = iconClass + ' ' + textClass;
                feedback.className = 'validation-feedback text-xs mt-1 ' + textClass;
            } else if (state === 'checking') {
                input.classList.add('checking');
                icon.className = iconClass + ' ' + textClass;
                feedback.className = 'validation-feedback text-xs mt-1 ' + textClass;
            }

            feedback.textContent = message;
        }

        // Siblings functionality
        let siblingCount = 0;

        function createSiblingForm(index) {
            const form = document.createElement('div');
            form.className = 'bg-white p-4 rounded-lg border border-gray-200 sibling-form';
            form.setAttribute('data-sibling-index', index);
            form.innerHTML = `
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-semibold text-gray-800">Sibling ${index}</h4>
                    <button type="button" onclick="removeSibling(${index})" class="text-red-500 hover:text-red-700 text-sm">
                        <i class="fas fa-times"></i> Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="input-group relative">
                        <input type="text" name="siblings[${index}][name]"
                            class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field capitalize-first"
                            placeholder=" ">
                        <label class="floating-label">Full Name</label>
                    </div>
                    <div class="input-group relative">
                        <select name="siblings[${index}][gender]"
                            class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field">
                            <option value=""> </option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <label class="floating-label">Gender</label>
                    </div>
                    <div class="input-group relative">
                        <input type="date" name="siblings[${index}][birth_date]"
                            class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field">
                        <label class="floating-label">Birth Date</label>
                    </div>
                    <div class="input-group relative">
                        <select name="siblings[${index}][occupation]"
                            class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 transition-all text-sm input-field">
                            <option value=""> </option>
                            <option value="Student">Student</option>
                            <option value="Employed">Employed</option>
                            <option value="Unemployed">Unemployed</option>
                            <option value="Self-employed">Self-employed</option>
                            <option value="Other">Other</option>
                        </select>
                        <label class="floating-label">Occupation</label>
                    </div>
                </div>
            `;
            
            // Add auto-save listeners to sibling inputs
            form.querySelectorAll('input, select').forEach(input => {
                input.addEventListener('input', autoSave);
                input.addEventListener('change', autoSave);
            });
            
            return form;
        }

        function generateSiblingsForms(count) {
            const container = document.getElementById('siblings_container');
            const noMessage = document.getElementById('no_siblings_message');

            // Remove all existing sibling forms
            const existingForms = container.querySelectorAll('.sibling-form');
            existingForms.forEach(form => form.remove());

            if (count === 0) {
                if (!container.contains(noMessage)) {
                    container.appendChild(noMessage);
                }
                noMessage.classList.remove('hidden');
                return;
            }

            noMessage.classList.add('hidden');

            for (let i = 1; i <= count; i++) {
                const form = createSiblingForm(i);
                container.appendChild(form);
            }
        }

        function addSibling() {
            if (siblingCount >= 10) {
                alert('Maximum of 10 siblings allowed.');
                return;
            }

            siblingCount++;

            const container = document.getElementById('siblings_container');
            const noMessage = document.getElementById('no_siblings_message');

            if (siblingCount === 1) {
                noMessage.classList.add('hidden');
            }

            const form = createSiblingForm(siblingCount);
            container.appendChild(form);

            updateDropdown();

            // Scroll to the newly added form
            container.scrollTop = container.scrollHeight;
            
            // Auto-save after adding sibling
            autoSave();
        }

        function removeSibling(index) {
            const form = document.querySelector(`[data-sibling-index="${index}"]`);
            if (form) {
                form.remove();
                siblingCount--;

                // Re-index remaining forms
                reindexSiblingsForms();

                updateDropdown();

                // Show no siblings message if count is 0
                if (siblingCount === 0) {
                    const container = document.getElementById('siblings_container');
                    const noMessage = document.getElementById('no_siblings_message');
                    container.appendChild(noMessage);
                    noMessage.classList.remove('hidden');
                }
                
                // Auto-save after removing sibling
                autoSave();
            }
        }

        function reindexSiblingsForms() {
            const container = document.getElementById('siblings_container');
            const forms = container.querySelectorAll('.sibling-form');

            forms.forEach((form, index) => {
                const newIndex = index + 1;
                form.setAttribute('data-sibling-index', newIndex);
                form.querySelector('h4').textContent = `Sibling ${newIndex}`;
                form.querySelector('button').setAttribute('onclick', `removeSibling(${newIndex})`);

                // Update input names
                const nameInput = form.querySelector('input[name*="[name]"]');
                if (nameInput) {
                    nameInput.setAttribute('name', `siblings[${newIndex}][name]`);
                }

                const genderSelect = form.querySelector('select[name*="[gender]"]');
                if (genderSelect) {
                    genderSelect.setAttribute('name', `siblings[${newIndex}][gender]`);
                }

                const birthDateInput = form.querySelector('input[name*="[birth_date]"]');
                if (birthDateInput) {
                    birthDateInput.setAttribute('name', `siblings[${newIndex}][birth_date]`);
                }

                const occupationSelect = form.querySelector('select[name*="[occupation]"]');
                if (occupationSelect) {
                    occupationSelect.setAttribute('name', `siblings[${newIndex}][occupation]`);
                }
            });
        }

        function updateDropdown() {
            const dropdown = document.getElementById('number_of_siblings');
            dropdown.value = siblingCount > 0 ? siblingCount : '';
        }

        function showStep(step) {
            // Hide all steps
            document.querySelectorAll('.step-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show current step
            document.querySelector(`.step-content[data-step="${step}"]`).classList.remove('hidden');
            
            // Update step indicators
            document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
                indicator.classList.remove('active', 'completed');
                if (index + 1 < step) {
                    indicator.classList.add('completed');
                } else if (index + 1 === step) {
                    indicator.classList.add('active');
                }
            });
            
            // Update navigation buttons
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            if (step === 1) {
                prevBtn.classList.add('hidden');
            } else {
                prevBtn.classList.remove('hidden');
            }
            
            if (step === totalSteps) {
                nextBtn.classList.add('hidden');
            } else {
                nextBtn.classList.remove('hidden');
            }
        }

        function nextStep() {
            if (currentStep < totalSteps) {
                // Validate current step before proceeding
                const currentStepElement = document.querySelector(`.step-content[data-step="${currentStep}"]`);
                const requiredFields = currentStepElement.querySelectorAll('[required]');
                let isValid = true;
                let hasEmptyFields = false;
                
                // Check for empty required fields
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        hasEmptyFields = true;
                        field.classList.add('border-red-500');
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });
                
                if (hasEmptyFields) {
                    alert('Please fill in all required fields before proceeding.');
                    return;
                }
                
                // Special validation for Step 1 (account info)
                if (currentStep === 1) {
                    const usernameInput = document.getElementById('username');
                    const emailInput = document.getElementById('email');
                    const passwordInput = document.getElementById('password');
                    const confirmInput = document.getElementById('password_confirmation');
                    
                    // Check if any field has invalid validation state
                    if (usernameInput.classList.contains('input-invalid') || 
                        emailInput.classList.contains('input-invalid') || 
                        passwordInput.classList.contains('input-invalid') || 
                        confirmInput.classList.contains('input-invalid')) {
                        alert('Please fix validation errors before proceeding.');
                        return;
                    }
                    
                    // Check if email is verified
                    if (!isEmailVerified) {
                        alert('Please verify your email address by clicking the "Send OTP" button and entering the verification code.');
                        return;
                    }
                }
                
                currentStep++;
                showStep(currentStep);
                document.getElementById('currentStepInput').value = currentStep;
                saveFormData(); // Auto-save when changing steps
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
                document.getElementById('currentStepInput').value = currentStep;
                saveFormData(); // Auto-save when changing steps
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Restore current step from server-side variable (if set by validation error)
            const serverCurrentStep = document.getElementById('currentStepInput');
            if (serverCurrentStep && serverCurrentStep.value) {
                currentStep = parseInt(serverCurrentStep.value);
            }
            
            // Load saved form data first
            loadFormData();
            showStep(currentStep);
            
            document.getElementById('nextBtn').addEventListener('click', nextStep);
            document.getElementById('prevBtn').addEventListener('click', prevStep);
            
            // Setup education level change listener
            const educationLevelSelect = document.getElementById('education_level');
            if (educationLevelSelect) {
                educationLevelSelect.addEventListener('change', function() {
                    updateEducationFields();
                    autoSave();
                });
                // Initialize fields based on current selection
                updateEducationFields();
            }
            
            // Setup auto-capitalization
            setupAutoCapitalization();
            
            // Setup OTP inputs
            setupOtpInputs();
            
            // Setup other options functionality
            setupOtherOptions();
            
            // Setup semester type functionality
            setupSemesterType();

            // Setup siblings dropdown functionality
            const siblingsDropdown = document.getElementById('number_of_siblings');
            if (siblingsDropdown) {
                siblingsDropdown.addEventListener('change', function() {
                    const selectedCount = parseInt(this.value);
                    if (!isNaN(selectedCount)) {
                        siblingCount = selectedCount;
                        generateSiblingsForms(siblingCount);
                        autoSave();
                    }
                });
            }

            // Real-time validation event listeners with auto-save
            document.getElementById('username').addEventListener('input', function(e) {
                validateUsername(e.target.value);
                autoSave();
            });
            
            document.getElementById('email').addEventListener('input', function(e) {
                validateEmail(e.target.value);
                autoSave();
            });
            
            document.getElementById('password').addEventListener('input', function(e) {
                validatePassword(e.target.value);
                // Also revalidate confirm password if it has value
                if (document.getElementById('password_confirmation').value) {
                    validatePasswordMatch();
                }
                autoSave();
            });
            
            document.getElementById('password_confirmation').addEventListener('input', function() {
                validatePasswordMatch();
                autoSave();
            });
            
            // Add auto-save to all other form inputs
            document.querySelectorAll('#registrationForm input, #registrationForm select, #registrationForm textarea').forEach(input => {
                if (input.type !== 'file' && input.id !== 'username' && input.id !== 'email' && 
                    input.id !== 'password' && input.id !== 'password_confirmation') {
                    input.addEventListener('input', autoSave);
                    input.addEventListener('change', autoSave);
                }
                
                // Handle file input changes with enhanced persistence
                if (input.type === 'file') {
                    input.addEventListener('change', function() {
                        const fileName = this.getAttribute('data-file-name');
                        const filenameDiv = document.getElementById(`${fileName}_filename`);
                        
                        if (fileName && filenameDiv) {
                            if (this.files.length > 0) {
                                filenameDiv.querySelector('.filename').textContent = this.files[0].name;
                                filenameDiv.classList.remove('hidden');
                                
                                // Show upload success feedback
                                const uploadFeedback = document.getElementById(`${fileName}_upload_feedback`);
                                if (uploadFeedback) {
                                    uploadFeedback.innerHTML = '<i class="fas fa-check-circle text-green-500 mr-1"></i><span class="text-green-600">File uploaded successfully</span>';
                                    uploadFeedback.classList.remove('hidden');
                                    
                                    // Hide feedback after 3 seconds
                                    setTimeout(() => {
                                        uploadFeedback.classList.add('hidden');
                                    }, 3000);
                                }
                            } else {
                                filenameDiv.classList.add('hidden');
                            }
                        }
                        
                        // Trigger auto-save to persist file data
                        autoSave();
                    });
                }
            });
            
            // Handle form submission with AJAX
            document.getElementById('registrationForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const form = this;
                const formData = new FormData(form);
                const submitButton = form.querySelector('button[type="submit"]');
                
                // Show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
                
                fetch('{{ route("register") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success modal with reference number
                        showReferenceModal(data.reference_number, data.batch_id);
                        
                        // Clear form data
                        clearFormData();
                        form.reset();
                        
                        // Clear siblings forms and reset siblings count
                        const siblingsContainer = document.getElementById('siblings_container');
                        if (siblingsContainer) {
                            const siblingForms = siblingsContainer.querySelectorAll('.sibling-form');
                            siblingForms.forEach(form => form.remove());
                            siblingCount = 0;
                            
                            const dropdown = document.getElementById('number_of_siblings');
                            if (dropdown) {
                                dropdown.value = '';
                            }
                            
                            const noMessage = document.getElementById('no_siblings_message');
                            if (noMessage) {
                                siblingsContainer.appendChild(noMessage);
                                noMessage.classList.remove('hidden');
                            }
                        }
                        
                        // Clear validation feedback
                        document.querySelectorAll('.validation-feedback').forEach(el => {
                            el.textContent = '';
                            el.className = 'validation-feedback text-xs mt-1';
                        });
                        
                        // Reset validation icons
                        document.querySelectorAll('.fa-check-circle, .fa-times-circle, .fa-exclamation-circle, .fa-exclamation-triangle').forEach(icon => {
                            icon.className = 'fas fa-circle text-gray-300 text-sm';
                        });
                        
                        // Reset input field classes
                        document.querySelectorAll('.input-valid, .input-invalid, .checking').forEach(input => {
                            input.classList.remove('input-valid', 'input-invalid', 'checking');
                        });
                        
                        // Reset step indicators
                        document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
                            indicator.classList.remove('active', 'completed');
                            if (index === 0) {
                                indicator.classList.add('active');
                            }
                        });
                        
                        // Go back to first step
                        showStep(1);
                        
                        // Redirect to home page after showing modal
                        setTimeout(() => {
                            window.location.href = '{{ route("home") }}';
                        }, 5000);
                    } else {
                        // Show error modal with validation errors
                        showErrorModal(data.errors || 'An error occurred during registration');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorModal('An error occurred during registration. Please try again.');
                })
                .finally(() => {
                    // Reset submit button
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Submit Application';
                });
            });
            
            // Show notification that data was restored
            const savedData = localStorage.getItem('registrationFormData');
            if (savedData) {
                // showNotification('Form data restored from previous session');
            }
        });
    </script>
</body>
</html>
