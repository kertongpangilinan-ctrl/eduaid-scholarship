@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="card p-5 hover:shadow-lg transition-all duration-250 ease">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Students</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_students'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-user-graduate text-white text-lg"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-[#10B981]">
                <i class="fas fa-arrow-up mr-1"></i>
                <span class="font-medium">Active</span>
            </div>
        </div>

        <div class="card p-5 hover:shadow-lg transition-all duration-250 ease">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['pending_applications'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-[#F59E0B] to-[#D97706] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-clock text-white text-lg"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-[#F59E0B]">
                <i class="fas fa-hourglass-half mr-1"></i>
                <span class="font-medium">Awaiting Review</span>
            </div>
        </div>

        <div class="card p-5 hover:shadow-lg transition-all duration-250 ease">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Approved</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['approved_applications'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-[#10B981] to-[#059669] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-check-circle text-white text-lg"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-[#10B981]">
                <i class="fas fa-check mr-1"></i>
                <span class="font-medium">Completed</span>
            </div>
        </div>

        <div class="card p-5 hover:shadow-lg transition-all duration-250 ease">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Rejected</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['rejected_applications'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-[#EF4444] to-[#DC2626] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-times-circle text-white text-lg"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-[#EF4444]">
                <i class="fas fa-times mr-1"></i>
                <span class="font-medium">Declined</span>
            </div>
        </div>

        <div class="card p-5 hover:shadow-lg transition-all duration-250 ease">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Payout Events</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['payout_events'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-[#3B82F6] to-[#2563EB] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-calendar-check text-white text-lg"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-[#3B82F6]">
                <i class="fas fa-calendar mr-1"></i>
                <span class="font-medium">Active Events</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Quick Actions</h3>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-5 gap-4">
            <a href="{{ route('admin.approvals.index') }}" class="flex items-center p-4 bg-gradient-to-br from-[#FEE2E2] to-[#FECACA] hover:from-[#FECACA] hover:to-[#FCA5A5] rounded-xl border border-[#FEE2E2] transition-all duration-250 ease hover:shadow-md">
                <div class="w-11 h-11 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-clipboard-check text-white"></i>
                </div>
                <div class="ml-3">
                    <p class="font-semibold text-gray-800 text-sm">Review</p>
                    <p class="text-xs text-gray-600">{{ $stats['pending_applications'] }} pending</p>
                </div>
            </a>

            <a href="{{ route('admin.students.index') }}" class="flex items-center p-4 bg-gradient-to-br from-[#D1FAE5] to-[#A7F3D0] hover:from-[#A7F3D0] hover:to-[#6EE7B7] rounded-xl border border-[#D1FAE5] transition-all duration-250 ease hover:shadow-md">
                <div class="w-11 h-11 bg-gradient-to-br from-[#10B981] to-[#059669] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-user-plus text-white"></i>
                </div>
                <div class="ml-3">
                    <p class="font-semibold text-gray-800 text-sm">Students</p>
                    <p class="text-xs text-gray-600">{{ $stats['total_students'] }} total</p>
                </div>
            </a>

            <a href="{{ route('admin.announcements.index') }}" class="flex items-center p-4 bg-gradient-to-br from-[#DBEAFE] to-[#BFDBFE] hover:from-[#BFDBFE] hover:to-[#93C5FD] rounded-xl border border-[#DBEAFE] transition-all duration-250 ease hover:shadow-md">
                <div class="w-11 h-11 bg-gradient-to-br from-[#3B82F6] to-[#2563EB] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-bullhorn text-white"></i>
                </div>
                <div class="ml-3">
                    <p class="font-semibold text-gray-800 text-sm">Announce</p>
                    <p class="text-xs text-gray-600">Post updates</p>
                </div>
            </a>

            <a href="{{ route('admin.payout-events.index') }}" class="flex items-center p-4 bg-gradient-to-br from-[#FEF3C7] to-[#FDE68A] hover:from-[#FDE68A] hover:to-[#FCD34D] rounded-xl border border-[#FEF3C7] transition-all duration-250 ease hover:shadow-md">
                <div class="w-11 h-11 bg-gradient-to-br from-[#F59E0B] to-[#D97706] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-calendar-check text-white"></i>
                </div>
                <div class="ml-3">
                    <p class="font-semibold text-gray-800 text-sm">Payouts</p>
                    <p class="text-xs text-gray-600">Manage events</p>
                </div>
            </a>

            <a href="#" class="flex items-center p-4 bg-gradient-to-br from-[#F3F4F6] to-[#E5E7EB] hover:from-[#E5E7EB] hover:to-[#D1D5DB] rounded-xl border border-[#F3F4F6] transition-all duration-250 ease hover:shadow-md">
                <div class="w-11 h-11 bg-gradient-to-br from-[#4B5563] to-[#374151] rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-chart-pie text-white"></i>
                </div>
                <div class="ml-3">
                    <p class="font-semibold text-gray-800 text-sm">Reports</p>
                    <p class="text-xs text-gray-600">View analytics</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide flex items-center">
                <i class="fas fa-clipboard-list text-[#B91C1C] mr-2"></i>
                Recent Applications
            </h3>
            <a href="{{ route('admin.approvals.index') }}" class="text-xs font-medium text-[#B91C1C] hover:text-[#7F1D1D] transition-colors">
                View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="table-container rounded-none border-0 shadow-none">
            @if($recentApplications->count() > 0)
                <!-- Mobile Card Layout -->
                <div class="md:hidden p-4 grid grid-cols-1 gap-4">
                    @foreach($recentApplications as $application)
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-full flex items-center justify-center mr-3 shadow-md">
                                    <span class="text-white text-sm font-bold">{{ substr($application->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <span class="text-sm font-semibold text-gray-800">{{ $application->user->name }}</span>
                                    <span class="text-xs text-gray-500 font-mono block">{{ $application->reference_number }}</span>
                                </div>
                                <a href="{{ route('admin.approvals.show', $application) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#B91C1C] bg-[#FEE2E2] hover:bg-[#FECACA] rounded-lg transition-colors">
                                    <i class="fas fa-eye mr-1"></i>View
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
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-[#FEF3C7] text-[#D97706]">Pending</span>
                                        @elseif($application->status === 'approved')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-[#D1FAE5] text-[#059669]">Approved</span>
                                        @elseif($application->status === 'rejected')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-[#FEE2E2] text-[#DC2626]">Rejected</span>
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
                            <tr class="bg-[#F5F5F5] text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <th class="px-6 py-3">Reference</th>
                                <th class="px-6 py-3">Applicant</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Submission Date</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E5E5E5]">
                            @foreach($recentApplications as $application)
                                <tr class="hover:bg-[#F5F5F5] transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-mono text-gray-800 bg-[#F5F5F5] px-2 py-1 rounded">{{ $application->reference_number }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-br from-[#B91C1C] to-[#7F1D1D] rounded-full flex items-center justify-center mr-3">
                                                <span class="text-white text-xs font-bold">{{ substr($application->user->name, 0, 1) }}</span>
                                            </div>
                                            <span class="text-sm font-medium text-gray-800">{{ $application->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $application->user->email }}</td>
                                    <td class="px-6 py-4">
                                        @if($application->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#FEF3C7] text-[#D97706]">
                                                <span class="w-1.5 h-1.5 bg-[#F59E0B] rounded-full mr-1.5"></span>
                                                Pending
                                            </span>
                                        @elseif($application->status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#D1FAE5] text-[#059669]">
                                                <span class="w-1.5 h-1.5 bg-[#10B981] rounded-full mr-1.5"></span>
                                                Approved
                                            </span>
                                        @elseif($application->status === 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#FEE2E2] text-[#DC2626]">
                                                <span class="w-1.5 h-1.5 bg-[#EF4444] rounded-full mr-1.5"></span>
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $application->submission_date ? $application->submission_date->format('M d, Y') : 'N/A' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.approvals.show', $application) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#B91C1C] bg-[#FEE2E2] hover:bg-[#FECACA] rounded-lg transition-colors">
                                            <i class="fas fa-eye mr-1.5"></i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-[#F5F5F5] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-[#A3A3A3] text-2xl"></i>
                    </div>
                    <p class="text-[#525252] font-medium">No applications yet</p>
                    <p class="text-[#A3A3A3] text-sm mt-1">Applications will appear here once submitted</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
