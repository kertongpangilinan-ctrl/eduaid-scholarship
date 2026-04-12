<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payout History - EduAid</title>
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
                    <a href="{{ route('student.payout') }}" class="text-red-600 font-medium transition-colors text-sm">PAYOUT</a>
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
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Payout</h1>
            <p class="text-gray-600">Manage your payout documents and view history</p>
        </div>

        <!-- Payout Events for Document Submission -->
        <div class="glass-card rounded-3xl p-6 mb-8 slide-in hover-lift">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-calendar-check text-red-600 mr-2"></i>
                Upcoming Payout Events
            </h2>
            @if($payoutEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($payoutEvents as $event)
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-2xl p-6 border border-red-200 hover-lift">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $event->event_name }}</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    <div class="bg-white rounded-xl p-3">
                                        <p class="text-xs text-gray-500 mb-1">Date</p>
                                        <p class="font-bold text-gray-800">{{ $event->event_date->format('M d, Y') }}</p>
                                    </div>
                                    @if($event->event_time)
                                    <div class="bg-white rounded-xl p-3">
                                        <p class="text-xs text-gray-500 mb-1">Time</p>
                                        <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($event->event_time)->format('g A') }}</p>
                                    </div>
                                    @endif
                                    @if($event->location)
                                    <div class="bg-white rounded-xl p-3">
                                        <p class="text-xs text-gray-500 mb-1">Location</p>
                                        <p class="font-bold text-gray-800">{{ $event->location }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="md:w-auto">
                                @php
                                    $hasSubmitted = \App\Models\PayoutDocument::where('payout_id', $event->event_id)
                                        ->where('user_id', auth()->id())
                                        ->exists();
                                    $isEnded = $event->event_date < now()->toDateString();
                                @endphp
                                @if($hasSubmitted)
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-2"></i>Documents Submitted
                                    </span>
                                @elseif($isEnded)
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gray-100 text-gray-500">
                                        <i class="fas fa-times-circle mr-2"></i>Event Ended
                                    </span>
                                @else
                                    <a href="{{ route('student.payout-documents.create', $event->event_id) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-bold hover:from-red-700 hover:to-red-800 transition-all shadow-lg">
                                        <i class="fas fa-upload mr-2"></i>Submit Documents
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">No upcoming payout events</p>
                    <p class="text-gray-400 text-sm mt-1">Check back later for new payout events</p>
                </div>
            @endif
        </div>

        <!-- Submitted Documents -->
        <div class="glass-card rounded-3xl p-6 mb-8 slide-in hover-lift">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-file-alt text-red-600 mr-2"></i>
                Submitted Documents
            </h2>
            @if($documents->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin Notes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($documents as $document)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $document->payout->event_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $document->payout->event_date->format('F d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $document->submitted_at ? $document->submitted_at->format('F d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($document->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($document->status == 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                        @elseif($document->status == 'rejected')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $document->admin_notes ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 font-medium">No documents submitted yet</p>
                    <p class="text-gray-400 text-sm mt-1">Submit documents for upcoming payout events above</p>
                </div>
            @endif
        </div>

        <!-- Payout History -->
        <div class="glass-card rounded-3xl p-6 slide-in hover-lift">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-history text-red-600 mr-2"></i>
                Payout History
            </h2>
            @if($payouts->count() > 0)
        <!-- Yearly Summary -->
        <div class="glass-card rounded-3xl p-6 mb-8 slide-in hover-lift">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-chart-pie text-red-600 mr-2"></i>
                Yearly Summary
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($payoutsByYear as $year => $yearPayouts)
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-xl">
                    <h3 class="text-3xl font-bold mb-2">{{ $year }}</h3>
                    <p class="text-red-100 text-sm mb-3">{{ $yearPayouts->count() }} payout(s)</p>
                    <p class="text-4xl font-bold">₱{{ number_format($yearPayouts->sum('amount'), 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Payout Details -->
        <div class="glass-card rounded-3xl slide-in hover-lift">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-list text-red-600 mr-2"></i>
                    Payout Details
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($payouts as $payout)
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200 hover-lift">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-money-bill-wave text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-lg">{{ auth()->user()->name }}</h3>
                                        <p class="text-sm text-gray-500">Payout #{{ $payout->payout_id }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="bg-white rounded-xl p-3">
                                        <p class="text-xs text-gray-500 mb-1">Payout Date</p>
                                        <p class="font-bold text-gray-800">{{ $payout->payout_date->format('M d, Y') }}</p>
                                    </div>
                                    <div class="bg-white rounded-xl p-3">
                                        <p class="text-xs text-gray-500 mb-1">Amount</p>
                                        <p class="font-bold text-red-600 text-lg">₱{{ number_format($payout->amount, 2) }}</p>
                                    </div>
                                    <div class="bg-white rounded-xl p-3">
                                        <p class="text-xs text-gray-500 mb-1">Status</p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                            @if($payout->status === 'released') bg-gradient-to-r from-blue-500 to-blue-600 text-white
                                            @elseif($payout->status === 'claimed') bg-gradient-to-r from-green-500 to-green-600 text-white
                                            @elseif($payout->status === 'pending') bg-gradient-to-r from-yellow-500 to-yellow-600 text-white
                                            @elseif($payout->status === 'cancelled') bg-gradient-to-r from-red-500 to-red-600 text-white
                                            @else bg-gray-500 text-white
                                            @endif">
                                            {{ ucfirst($payout->status) }}
                                        </span>
                                    </div>
                                    @if($payout->date_received)
                                    <div class="bg-white rounded-xl p-3">
                                        <p class="text-xs text-gray-500 mb-1">Received</p>
                                        <p class="font-bold text-gray-800">{{ $payout->date_received->format('M d, Y') }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @if($payout->signature_path)
                            <div class="md:w-48 flex-shrink-0">
                                <p class="text-xs text-gray-500 mb-2 font-medium">Signature</p>
                                <div class="bg-white border-2 border-gray-200 rounded-xl p-2">
                                    <img src="{{ asset('storage/' . $payout->signature_path) }}" alt="Signature" class="w-full h-24 object-contain">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($payouts->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $payouts->links() }}
                </div>
                @endif
            </div>
        </div>
        @else
        <!-- No Payouts Found -->
        <div class="glass-card rounded-3xl p-12 text-center slide-in">
            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-money-bill-wave text-gray-400 text-4xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">No Payout Records Found</h2>
            <p class="text-gray-600 mb-6">You haven't received any scholarship payouts yet.</p>
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl p-5 max-w-md mx-auto">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    Payouts are released after your application is approved and you are assigned to a batch.
                </p>
            </div>
        </div>
        @endif
    </div>
</body>
</html>
