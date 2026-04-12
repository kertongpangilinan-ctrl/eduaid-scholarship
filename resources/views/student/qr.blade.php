<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View QR Code - EduAid</title>
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
        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite;
        }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(220, 38, 38, 0.3); }
            50% { box-shadow: 0 0 40px rgba(220, 38, 38, 0.6); }
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
                    <a href="{{ route('student.qr') }}" class="text-red-600 font-medium transition-colors text-sm">QR CODE</a>
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
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">View QR Code</h1>
            <p class="text-gray-600">Display your scholarship QR code for attendance and verification</p>
        </div>

        @if($qrCode)
        <!-- QR Code Display -->
        <div class="max-w-2xl mx-auto slide-in">
            <div class="glass-card rounded-3xl p-8 hover-lift">
                <div class="text-center">
                    <div class="w-72 h-72 mx-auto mb-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl flex items-center justify-center border-4 border-gray-200 shadow-inner pulse-glow">
                        @if($qrCode->qr_image_path)
                        <img src="{{ asset('storage/' . $qrCode->qr_image_path) }}" alt="QR Code" class="w-64 h-64 object-contain">
                        @else
                        <div class="text-center">
                            <i class="fas fa-qrcode text-gray-300 text-7xl mb-2"></i>
                            <p class="text-gray-400 text-sm">QR Code Image</p>
                        </div>
                        @endif
                    </div>
                    
                    <div class="space-y-3 mb-8">
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-gray-600 text-sm"><strong>QR Code Value:</strong> <code class="bg-white px-3 py-1.5 rounded-xl border border-gray-200">{{ $qrCode->qr_code_value }}</code></p>
                        </div>
                        <div class="flex justify-center">
                            <span class="inline-flex items-center px-6 py-2 rounded-full text-sm font-bold
                                @if($qrCode->status === 'active') bg-gradient-to-r from-green-500 to-green-600 text-white
                                @elseif($qrCode->status === 'used') bg-gradient-to-r from-gray-500 to-gray-600 text-white
                                @elseif($qrCode->status === 'expired') bg-gradient-to-r from-red-500 to-red-600 text-white
                                @endif">
                                {{ ucfirst($qrCode->status) }}
                            </span>
                        </div>
                        @if($qrCode->expires_at)
                        <p class="text-gray-600"><strong>Expires:</strong> {{ $qrCode->expires_at->format('F d, Y - g:i A') }}</p>
                        @endif
                        @if($qrCode->used_at)
                        <p class="text-gray-600"><strong>Used:</strong> {{ $qrCode->used_at->format('F d, Y - g:i A') }}</p>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button onclick="window.print()" class="px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl font-bold hover:from-red-700 hover:to-red-800 transition-all shadow-xl">
                            <i class="fas fa-print mr-2"></i>Print QR Code
                        </button>
                        <button onclick="downloadQR()" class="px-8 py-4 border-2 border-red-600 text-red-600 rounded-2xl font-bold hover:bg-red-50 transition-all">
                            <i class="fas fa-download mr-2"></i>Download QR Code
                        </button>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="glass-card rounded-3xl p-6 mt-6 slide-in">
                <h3 class="font-bold text-blue-800 mb-4 flex items-center text-lg">
                    <i class="fas fa-info-circle mr-2"></i>
                    How to Use Your QR Code
                </h3>
                <ul class="space-y-3 text-blue-700">
                    <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-3"></i>Show this QR code when attending scholarship events or activities</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-3"></i>Keep your QR code secure and do not share with others</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-3"></i>Print a copy if you need it for offline use</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-3"></i>Contact admin if your QR code is lost or compromised</li>
                </ul>
            </div>
        </div>
        @else
        <!-- No QR Code Found -->
        <div class="max-w-2xl mx-auto slide-in">
            @if(auth()->user()->qr_code)
            <!-- Show QR Code if user has one -->
            <div class="glass-card rounded-3xl p-8 slide-in hover-lift">
                <div class="text-center">
                    <div class="bg-white rounded-2xl p-8 inline-block mb-6 border-2 border-gray-200 shadow-lg">
                        <img id="userQRCodeImage" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ auth()->user()->qr_code }}" alt="QR Code" class="w-64 h-64">
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Your QR Code</h2>
                    
                    <div class="space-y-3 mb-8">
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-gray-600 text-sm"><strong>QR Code Value:</strong> <code class="bg-white px-3 py-1.5 rounded-xl border border-gray-200">{{ auth()->user()->qr_code }}</code></p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button onclick="window.print()" class="px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl font-bold hover:from-red-700 hover:to-red-800 transition-all shadow-xl">
                            <i class="fas fa-print mr-2"></i>Print QR Code
                        </button>
                        <button onclick="downloadUserQR()" class="px-8 py-4 border-2 border-red-600 text-red-600 rounded-2xl font-bold hover:bg-red-50 transition-all">
                            <i class="fas fa-download mr-2"></i>Download QR Code
                        </button>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="glass-card rounded-3xl p-6 mt-6 slide-in">
                    <h3 class="font-bold text-blue-800 mb-4 flex items-center text-lg">
                        <i class="fas fa-info-circle mr-2"></i>
                        How to Use Your QR Code
                    </h3>
                    <ul class="space-y-3 text-blue-700">
                        <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-3"></i>Show this QR code when attending payout events</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-3"></i>Keep your QR code secure and do not share with others</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-3"></i>Print a copy if you need it for offline use</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-3"></i>Contact admin if your QR code is lost or compromised</li>
                    </ul>
                </div>
            </div>
            @else
            <!-- No QR Code -->
            <div class="glass-card rounded-3xl p-12 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-qrcode text-gray-400 text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">No QR Code Available</h2>
                <p class="text-gray-600 mb-6">
                    @if($application && $application->status === 'approved')
                    Your QR code will be generated once you are assigned to a batch.
                    @elseif($application && $application->status === 'pending')
                    Your QR code will be available after your application is approved.
                    @else
                    Please complete your application to receive a QR code.
                    @endif
                </p>
                <a href="{{ route('student.progress') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl font-bold hover:from-red-700 hover:to-red-800 transition-all shadow-xl">
                    <i class="fas fa-chart-line mr-2"></i>
                    Check Application Status
                </a>
            </div>
            @endif
        </div>
        @endif
    </div>

    <script>
        function downloadQR() {
            const qrImage = document.querySelector('img[src*="storage"]');
            if (qrImage) {
                const link = document.createElement('a');
                link.href = qrImage.src;
                link.download = 'scholarship-qr-code.png';
                link.click();
            } else {
                alert('QR code image not available for download');
            }
        }

        function downloadUserQR() {
            const qrCodeImage = document.getElementById('userQRCodeImage');
            const qrCode = "{{ auth()->user()->qr_code }}";
            
            if (qrCodeImage) {
                const link = document.createElement('a');
                link.href = qrCodeImage.src;
                link.download = `QR-Code-${qrCode}.png`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    </script>
</body>
</html>
