@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Payout Events</h1>
                <p class="text-gray-600 mt-2">Manage payout events and track attendance</p>
            </div>
            <a href="{{ route('admin.payout-events.create') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                Create Payout Event
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Mobile Card Layout -->
            <div class="md:hidden p-4 grid grid-cols-1 gap-4">
                @foreach($payoutEvents as $event)
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-200 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex-1">
                                <div class="text-sm font-semibold text-gray-800">{{ $event->event_name }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $event->event_date->format('F d, Y') }}</div>
                            </div>
                            @if($event->status == 'upcoming')
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Upcoming</span>
                            @elseif($event->status == 'active')
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @elseif($event->status == 'completed')
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Completed</span>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs mb-3">
                            <div>
                                <span class="text-gray-500">Time:</span>
                                <p class="text-gray-800">{{ $event->event_time ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Location:</span>
                                <p class="text-gray-800 truncate">{{ $event->location ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Documents:</span>
                                <p class="text-gray-800">{{ $event->documents_count ?? 0 }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Attendance:</span>
                                <p class="text-gray-800">{{ $event->attendance_count ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 pt-3 border-t border-gray-200">
                            <a href="{{ route('admin.payout-events.show', $event->event_id) }}" class="flex-1 text-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                View
                            </a>
                            <a href="{{ route('admin.payout-events.documents', $event->event_id) }}" class="flex-1 text-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                Documents
                            </a>
                            <a href="{{ route('admin.payout-events.attendance', $event->event_id) }}" class="flex-1 text-center px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                                Attendance
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop Table Layout -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documents</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attendance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($payoutEvents as $event)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $event->event_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $event->event_date->format('F d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $event->event_time ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $event->location ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($event->status == 'upcoming')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Upcoming</span>
                                    @elseif($event->status == 'active')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    @elseif($event->status == 'completed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Completed</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $event->documents_count ?? 0 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $event->attendance_count ?? 0 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.payout-events.show', $event->event_id) }}" class="text-red-600 hover:text-red-900 mr-3">View</a>
                                    <a href="{{ route('admin.payout-events.documents', $event->event_id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Documents</a>
                                    <a href="{{ route('admin.payout-events.attendance', $event->event_id) }}" class="text-green-600 hover:text-green-900">Attendance</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
