@extends('layouts.admin')

@section('title', 'Student Details')

@section('header', 'Student Details')

@section('content')
<div class="space-y-6">
    <div class="flex items-center space-x-4 mb-6">
        <a href="{{ route('admin.students.index') }}" class="text-red-600 hover:text-red-700">
            ← Back to Students
        </a>
    </div>

    <!-- Student Info -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Student Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Name</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $student->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Username</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $student->username }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Email</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $student->email }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Status</p>
                    <p class="text-lg font-semibold">
                        @if($student->account_status === 'active')
                            <span class="text-green-600">Active</span>
                        @elseif($student->account_status === 'inactive')
                            <span class="text-red-600">Inactive</span>
                        @elseif($student->account_status === 'pending_admin_approval')
                            <span class="text-yellow-600">Pending</span>
                        @else
                            <span class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $student->account_status)) }}</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Batch ID</p>
                    <p class="text-lg font-semibold text-gray-900">N/A</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Consecutive Missed Payouts</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $student->consecutive_missed_payouts ?? 0 }}</p>
                </div>
                @if($student->qr_code)
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">QR Code</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $student->qr_code }}</p>
                </div>
                @endif
            </div>
            
            <div class="mt-6 pt-6 border-t border-gray-200">
                <form action="{{ route('admin.students.update-status', $student->id) }}" method="POST">
                    @csrf
                    <div class="flex items-center space-x-4">
                        <label class="text-sm font-medium text-gray-700">Update Status:</label>
                        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="active" {{ $student->account_status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $student->account_status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="pending_admin_approval" {{ $student->account_status === 'pending_admin_approval' ? 'selected' : '' }}>Pending Approval</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payout History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Payout History</h3>
        </div>
        <div class="p-6">
            @if($payoutHistory->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <th class="px-4 py-3">Event</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Claimed At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($payoutHistory as $history)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-800">{{ $history->payout->event_name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    @if($history->status == 'claimed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Claimed</span>
                                    @elseif($history->status == 'missed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Missed</span>
                                    @elseif($history->status == 'late')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $history->claimed_at ? $history->claimed_at->format('F d, Y H:i') : 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 text-center py-4">No payout history</p>
            @endif
        </div>
    </div>

    <!-- Submitted Documents -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Submitted Documents</h3>
        </div>
        <div class="p-6">
            @if($payoutDocuments->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <th class="px-4 py-3">Event</th>
                            <th class="px-4 py-3">Submitted Date</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Admin Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($payoutDocuments as $document)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-800">{{ $document->payout->event_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $document->submitted_at ? $document->submitted_at->format('F d, Y') : 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    @if($document->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($document->status == 'approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    @elseif($document->status == 'rejected')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $document->admin_notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 text-center py-4">No documents submitted</p>
            @endif
        </div>
    </div>
</div>
@endsection
