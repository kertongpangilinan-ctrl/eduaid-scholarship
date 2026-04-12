@extends('layouts.admin')

@section('title', 'Application Approvals')

@section('header', 'Application Approvals')

@section('content')
<div class="space-y-6">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $applications->total() }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-blue-500"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">{{ $applications->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-amber-500"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Approved</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $applications->where('status', 'approved')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Rejected</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $applications->where('status', 'rejected')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-500"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <form action="{{ route('admin.approvals.index') }}" method="GET" class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide flex items-center">
                    <i class="fas fa-clipboard-list text-red-500 mr-2"></i>
                    All Applications
                </h3>
                <div class="flex items-center space-x-2">
                    <!-- Search Bar -->
                    <div class="relative">
                        <input type="text" 
                            id="searchInput"
                            name="search" 
                            value="{{ $search ?? '' }}"
                            placeholder="Search applications..." 
                            class="w-64 pl-10 pr-4 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    </div>
                    <!-- Status Filter -->
                    <select name="status" class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-red-500 focus:border-transparent" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </form>
        </div>
        
        @if($applications->count() > 0)
            <!-- Mobile Card Layout -->
            <div class="md:hidden p-4 grid grid-cols-1 gap-4">
                @foreach($applications as $application)
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-200 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                <span class="text-white text-sm font-bold">{{ substr($application->user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-800 block">{{ $application->user->name }}</span>
                                <span class="text-xs text-gray-500 font-mono">{{ $application->reference_number }}</span>
                            </div>
                            <a href="{{ route('admin.approvals.show', $application) }}" 
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                <i class="fas fa-eye mr-1"></i>
                                View
                            </a>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="text-gray-500">Email:</span>
                                <p class="text-gray-800 truncate">{{ $application->user->email }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Status:</span>
                                <p class="mt-0.5">
                                    @if($application->status === 'pending')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Pending
                                        </span>
                                    @elseif($application->status === 'approved')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            Approved
                                        </span>
                                    @elseif($application->status === 'rejected')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-500">Submitted:</span>
                                <p class="text-gray-800">{{ $application->submission_date ? $application->submission_date->format('M d, Y') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop Table Layout -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <th class="px-6 py-3">Reference</th>
                            <th class="px-6 py-3">Applicant</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Submission Date</th>
                            <th class="px-6 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($applications as $application)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-mono text-gray-800 bg-gray-100 px-2 py-1 rounded">{{ $application->reference_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white text-xs font-bold">{{ substr($application->user->name, 0, 1) }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-800">{{ $application->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $application->user->email }}</td>
                                <td class="px-6 py-4">
                                    @if($application->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></span>
                                            Pending
                                        </span>
                                    @elseif($application->status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                            Approved
                                        </span>
                                    @elseif($application->status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $application->submission_date ? $application->submission_date->format('M d, Y') : 'N/A' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.approvals.show', $application) }}" 
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                        <i class="fas fa-eye mr-1.5"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $applications->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                </div>
                <p class="text-gray-500 font-medium">No applications found</p>
                <p class="text-gray-400 text-sm mt-1">Applications will appear here once submitted</p>
            </div>
        @endif
    </div>
</div>

<script>
    // Real-time search with debounce
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            this.closest('form').submit();
        }, 300); // Wait 300ms after user stops typing
    });
</script>
@endsection
