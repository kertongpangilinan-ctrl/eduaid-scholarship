<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Application - EduAid</title>
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
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-red-600 to-red-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="logo text-2xl font-bold text-white">
                        <i class="fas fa-graduation-cap mr-2"></i>EduAid
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="nav-links text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-home mr-1"></i>Home
                    </a>
                    <a href="{{ route('login') }}" class="nav-links bg-white text-red-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                        <i class="fas fa-sign-in-alt mr-1"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <h1 class="text-3xl font-bold text-white">
                    <i class="fas fa-search mr-3"></i>Track Your Application
                </h1>
                <p class="text-blue-100 mt-2">Enter your reference number to check your application status</p>
            </div>

            <!-- Search Form -->
            <div class="p-8">
                <form action="{{ route('track-application') }}" method="GET" class="mb-8">
                    <div class="flex gap-4">
                        <input type="text" name="reference" required
                            class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter your reference number (e.g., SCHOLAR-2025-12345)">
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all font-medium">
                            <i class="fas fa-search mr-2"></i>Track
                        </button>
                    </div>
                </form>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mt-0.5 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-green-800">Success</p>
                                <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-600 mt-0.5 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-red-800">Error</p>
                                <p class="text-sm text-red-700 mt-1">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($application))
                    <!-- Application Details -->
                    <div class="border-t border-gray-200 pt-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Application Details</h2>
                        
                        <!-- Status Card -->
                        <div class="mb-6">
                            @if($application->status === 'pending')
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-yellow-800">Application Status: Pending</h3>
                                            <p class="text-sm text-yellow-700 mt-1">Your application is under review by our admin team.</p>
                                            <p class="text-xs text-yellow-600 mt-2">Submitted: {{ $application->submission_date->format('F j, Y - g:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($application->status === 'approved')
                                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-green-800">Application Status: Approved</h3>
                                            <p class="text-sm text-green-700 mt-1">Congratulations! Your application has been approved.</p>
                                            <p class="text-xs text-green-600 mt-2">Approved: {{ $application->approved_date ? $application->approved_date->format('F j, Y - g:i A') : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($application->status === 'rejected')
                                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-red-800">Application Status: Rejected</h3>
                                            <p class="text-sm text-red-700 mt-1">Unfortunately, your application was not approved.</p>
                                            <p class="text-xs text-red-600 mt-2">Reviewed: {{ $application->reviewed_date ? $application->reviewed_date->format('F j, Y - g:i A') : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Information Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-500 mb-1">Reference Number</p>
                                <p class="font-semibold text-gray-800">{{ $application->reference_number }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-500 mb-1">Applicant Name</p>
                                <p class="font-semibold text-gray-800">{{ $application->user->name }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-500 mb-1">Email Address</p>
                                <p class="font-semibold text-gray-800">{{ $application->user->email }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-500 mb-1">Submission Date</p>
                                <p class="font-semibold text-gray-800">{{ $application->submission_date->format('F j, Y') }}</p>
                            </div>
                        </div>

                        @if($application->status === 'pending')
                            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-blue-800">What happens next?</p>
                                        <p class="text-sm text-blue-700 mt-1">Our admin team is reviewing your application. You will receive an email notification once a decision has been made. This process typically takes 3-5 business days.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Home
            </a>
        </div>
    </div>
</body>
</html>
