@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Payout Attendance</h1>
            <p class="text-gray-600 mt-2">Scan QR codes to record attendance for {{ $payoutEvent->event_name }}</p>
        </div>

        <div class="mb-4">
            <a href="{{ route('admin.payout-events.index') }}" class="text-red-600 hover:text-red-900">
                ← Back to Payout Events
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                {{ session('info') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- QR Code Scanner -->
            <div class="lg:col-span-2 bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Scan QR Code</h2>
                </div>
                <div class="px-6 py-4">
                    <!-- Camera Scanner -->
                    <div class="mb-4">
                        <div class="relative w-full h-64 bg-gray-900 rounded-lg overflow-hidden mb-4">
                            <video id="video" class="w-full h-full object-cover" playsinline></video>
                            <canvas id="canvas" class="hidden"></canvas>
                            <div id="qr-placeholder" class="absolute inset-0 flex items-center justify-center text-gray-400">
                                <div class="text-center">
                                    <i class="fas fa-camera text-4xl mb-2"></i>
                                    <p>Click "Start Camera" to begin scanning</p>
                                </div>
                            </div>
                            <div id="scan-overlay" class="absolute inset-0 pointer-events-none hidden">
                                <div class="absolute inset-4 border-4 border-green-500 rounded-lg animate-pulse"></div>
                            </div>
                        </div>
                        <div class="flex gap-2 mb-4">
                            <button onclick="startCamera()" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-video mr-2"></i>Start Camera
                            </button>
                            <button onclick="stopCamera()" class="flex-1 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                <i class="fas fa-stop mr-2"></i>Stop Camera
                            </button>
                        </div>
                    </div>

                    <!-- Manual Input -->
                    <form id="attendance-form" action="{{ route('admin.payout-events.scan-qr') }}" method="POST">
                        @csrf
                        <input type="hidden" name="payout_id" value="{{ $payoutEvent->event_id }}">
                        <input type="hidden" id="qr-code-input" name="qr_code" required>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Scanned QR Code</label>
                                <div class="flex gap-2 mb-3">
                                    <input type="text" id="qr-code-display" readonly class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" placeholder="QR code will appear here after scanning">
                                    <button type="button" onclick="validateQRCode()" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        <i class="fas fa-search mr-2"></i>Validate
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Manual Input Fallback -->
                            <div class="border-t pt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Or Enter QR Code Manually</label>
                                <div class="flex gap-2">
                                    <input type="text" id="manual-qr-input" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="Enter QR code manually">
                                    <button type="button" onclick="useManualInput()" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-keyboard mr-2"></i>Use Manual
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Scanning Tips -->
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <h4 class="text-sm font-semibold text-blue-800 mb-2"><i class="fas fa-lightbulb mr-1"></i>Scanning Tips:</h4>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li>• Hold QR code 6-12 inches from camera</li>
                            <li>• Ensure good lighting</li>
                            <li>• Keep QR code steady and level</li>
                            <li>• Use manual input if camera scanning fails</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Student Info Card -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Student Information</h2>
                </div>
                <div class="px-6 py-4">
                    <div id="student-info-placeholder" class="text-center text-gray-400 py-8">
                        <i class="fas fa-user-circle text-4xl mb-2"></i>
                        <p>Scan a QR code to view student information</p>
                    </div>
                    <div id="student-info-content" class="hidden">
                        <div class="text-center mb-4">
                            <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-red-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span id="student-initials" class="text-white text-2xl font-bold"></span>
                            </div>
                            <h3 id="student-name" class="text-xl font-bold text-gray-900"></h3>
                            <p id="student-email" class="text-sm text-gray-500"></p>
                        </div>
                        
                        <div class="space-y-3 mb-4">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">QR Code</p>
                                <p id="student-qr-code" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Batch</p>
                                <p id="student-batch" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Status</p>
                                <span id="student-status" class="text-sm font-semibold"></span>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500 mb-1">Document Status</p>
                                <span id="document-status" class="text-sm font-semibold"></span>
                            </div>
                        </div>
                        
                        <div id="attendance-buttons" class="space-y-2">
                            <button onclick="confirmAttendance()" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
                                <i class="fas fa-check-circle mr-2"></i>Confirm Attendance
                            </button>
                            <button onclick="cancelAttendance()" class="w-full px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                        </div>
                        
                        <div id="already-attended-message" class="hidden">
                            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <span class="font-semibold">Already Attended</span>
                                <p class="text-sm mt-1">This student has already attended this payout event.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Details -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Event Details</h2>
            </div>
                <div class="px-6 py-4">
                    <div class="space-y-2">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Event Name:</span>
                            <p class="text-lg font-semibold text-gray-900">{{ $payoutEvent->event_name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Event Date:</span>
                            <p class="text-lg font-semibold text-gray-900">{{ $payoutEvent->event_date->format('F d, Y') }}</p>
                        </div>
                        @if($payoutEvent->event_time)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Event Time:</span>
                            <p class="text-lg font-semibold text-gray-900">{{ $payoutEvent->event_time }}</p>
                        </div>
                        @endif
                        @if($payoutEvent->location)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Location:</span>
                            <p class="text-lg font-semibold text-gray-900">{{ $payoutEvent->location }}</p>
                        </div>
                        @endif
                        <div>
                            <span class="text-sm font-medium text-gray-500">Status:</span>
                            <p class="text-lg font-semibold text-gray-900">
                                @if($payoutEvent->status == 'upcoming')
                                    <span class="text-blue-600">Upcoming</span>
                                @elseif($payoutEvent->status == 'active')
                                    <span class="text-green-600">Active</span>
                                @elseif($payoutEvent->status == 'completed')
                                    <span class="text-gray-600">Completed</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Records -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Attendance Records ({{ $attendance->count() }})</h2>
            </div>
            
            @if($attendance->count() > 0)
                <!-- Mobile Card Layout -->
                <div class="md:hidden p-4 grid grid-cols-1 gap-4">
                    @foreach($attendance as $record)
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                    <span class="text-white text-sm font-bold">{{ substr($record->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-gray-800">{{ $record->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $record->user->email }}</div>
                                </div>
                                @if($record->attendance_type == 'on_time')
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">On Time</span>
                                @elseif($record->attendance_type == 'late')
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late</span>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div>
                                    <span class="text-gray-500">QR Code:</span>
                                    <p class="text-gray-800 font-mono truncate">{{ $record->qr_code }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Scanned At:</span>
                                    <p class="text-gray-800">{{ $record->scanned_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Desktop Table Layout -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scanned At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($attendance as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $record->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $record->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $record->qr_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($record->attendance_type == 'on_time')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">On Time</span>
                                        @elseif($record->attendance_type == 'late')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $record->scanned_at->format('F d, Y H:i:s') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-4 text-center text-gray-500">
                    No attendance records yet.
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
<script>
    let video = null;
    let canvas = null;
    let context = null;
    let isScanning = false;
    let lastScannedCode = null;
    let lastScanTime = 0;
    let animationFrame = null;

    function startCamera() {
        if (isScanning) {
            alert('Camera is already running');
            return;
        }

        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        context = canvas.getContext('2d');

        // Check if library is loaded
        if (typeof jsQR === 'undefined') {
            alert('QR code library not loaded. Please refresh the page.');
            return;
        }

        document.getElementById('qr-placeholder').style.display = 'none';
        document.getElementById('scan-overlay').classList.remove('hidden');

        // Request camera access
        navigator.mediaDevices.getUserMedia({ 
            video: { facingMode: "environment", width: { ideal: 1280 }, height: { ideal: 720 } } 
        })
        .then(function(stream) {
            video.srcObject = stream;
            video.setAttribute("playsinline", true);
            video.play();
            isScanning = true;
            requestAnimationFrame(tick);
            console.log('Camera started successfully');
        })
        .catch(function(err) {
            console.error('Error starting camera:', err);
            alert('Error starting camera: ' + err + '\n\nMake sure:\n1. Camera permissions are allowed\n2. Camera is not in use by another app\n3. HTTPS is enabled (required for camera access)');
            document.getElementById('qr-placeholder').style.display = 'flex';
            document.getElementById('scan-overlay').classList.add('hidden');
        });
    }

    function tick() {
        if (!isScanning) return;

        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.height = video.videoHeight;
            canvas.width = video.videoWidth;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: "dontInvert",
            });

            if (code) {
                console.log('QR Code detected:', code.data);
                
                // Prevent duplicate scans within 3 seconds
                const now = Date.now();
                if (code.data === lastScannedCode && (now - lastScanTime) < 3000) {
                    console.log('Duplicate scan ignored');
                    animationFrame = requestAnimationFrame(tick);
                    return;
                }
                
                lastScannedCode = code.data;
                lastScanTime = now;
                
                // QR code scanned successfully
                document.getElementById('qr-code-display').value = code.data;
                document.getElementById('qr-code-input').value = code.data;
                
                // Show scanning feedback
                showScanFeedback(code.data);
                
                // Validate QR code and show student info
                validateQRCode();
                
                return;
            }
        }
        
        animationFrame = requestAnimationFrame(tick);
    }

    function stopCamera() {
        if (!isScanning) {
            return;
        }

        isScanning = false;
        
        if (animationFrame) {
            cancelAnimationFrame(animationFrame);
        }
        
        if (video && video.srcObject) {
            const stream = video.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
            video.srcObject = null;
        }
        
        document.getElementById('qr-placeholder').style.display = 'flex';
        document.getElementById('scan-overlay').classList.add('hidden');
        console.log('Camera stopped');
    }

    function showScanFeedback(qrCode) {
        const feedback = document.createElement('div');
        feedback.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-pulse';
        feedback.innerHTML = `<i class="fas fa-check-circle mr-2"></i>QR Code Detected: ${qrCode}`;
        document.body.appendChild(feedback);
        
        setTimeout(() => {
            feedback.remove();
        }, 2000);
    }

    function useManualInput() {
        const manualInput = document.getElementById('manual-qr-input').value;
        if (!manualInput) {
            alert('Please enter a QR code');
            return;
        }
        document.getElementById('qr-code-display').value = manualInput;
        document.getElementById('qr-code-input').value = manualInput;
        validateQRCode();
    }

    function validateQRCode() {
        const qrCode = document.getElementById('qr-code-input').value;
        const payoutId = document.querySelector('input[name="payout_id"]').value;
        
        if (!qrCode) {
            alert('Please scan or enter a QR code first');
            return;
        }
        
        fetch('/admin/payout-events/validate-qr', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                qr_code: qrCode,
                payout_id: payoutId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showStudentInfo(data);
            } else {
                alert(data.message);
                hideStudentInfo();
            }
        })
        .catch(error => {
            console.error('Error validating QR code:', error);
            alert('Error validating QR code: ' + error.message);
        });
    }

    function showStudentInfo(data) {
        document.getElementById('student-info-placeholder').classList.add('hidden');
        document.getElementById('student-info-content').classList.remove('hidden');
        
        // Show student details
        document.getElementById('student-name').textContent = data.user.name;
        document.getElementById('student-email').textContent = data.user.email;
        document.getElementById('student-qr-code').textContent = data.user.qr_code;
        document.getElementById('student-batch').textContent = data.user.batch;
        document.getElementById('student-initials').textContent = data.user.name.charAt(0).toUpperCase();
        
        // Show status
        const statusElement = document.getElementById('student-status');
        if (data.user.status === 'active') {
            statusElement.textContent = 'Active';
            statusElement.className = 'text-sm font-semibold text-green-600';
        } else {
            statusElement.textContent = data.user.status;
            statusElement.className = 'text-sm font-semibold text-red-600';
        }
        
        // Show document status
        const docStatusElement = document.getElementById('document-status');
        if (data.document_approved) {
            docStatusElement.textContent = 'Approved';
            docStatusElement.className = 'text-sm font-semibold text-green-600';
        } else {
            docStatusElement.textContent = 'Not Approved';
            docStatusElement.className = 'text-sm font-semibold text-red-600';
        }
        
        // Show/hide buttons based on attendance status
        if (data.already_attended) {
            document.getElementById('attendance-buttons').classList.add('hidden');
            document.getElementById('already-attended-message').classList.remove('hidden');
        } else {
            document.getElementById('attendance-buttons').classList.remove('hidden');
            document.getElementById('already-attended-message').classList.add('hidden');
        }
    }

    function hideStudentInfo() {
        document.getElementById('student-info-placeholder').classList.remove('hidden');
        document.getElementById('student-info-content').classList.add('hidden');
    }

    function confirmAttendance() {
        const qrCode = document.getElementById('qr-code-input').value;
        const studentName = document.getElementById('student-name').textContent;
        const form = document.getElementById('attendance-form');
        
        if (!qrCode) {
            alert('Please scan or enter a QR code first');
            return;
        }
        
        console.log('Form action:', form.action);
        console.log('QR Code:', qrCode);
        console.log('Payout ID:', document.querySelector('input[name="payout_id"]').value);
        
        if (confirm(`Confirm attendance for ${studentName}?`)) {
            form.submit();
        }
    }

    function cancelAttendance() {
        hideStudentInfo();
        document.getElementById('qr-code-display').value = '';
        document.getElementById('qr-code-input').value = '';
        document.getElementById('manual-qr-input').value = '';
    }

    // Auto-submit after successful scan for mass scanning
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!document.getElementById('qr-code-input').value) {
            e.preventDefault();
            alert('Please scan a QR code first');
            return false;
        }
    });

    // Check if library loaded on page load
    window.addEventListener('load', function() {
        if (typeof jsQR === 'undefined') {
            console.error('jsQR library not loaded');
            alert('QR code library failed to load. Please check your internet connection and refresh the page.');
        }
    });
</script>
@endsection
