@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Payout History</h1>
            <p class="text-gray-600 mt-2">Payout history for {{ $payoutEvent->event_name }}</p>
        </div>

        <div class="mb-4">
            <a href="{{ route('admin.payout-events.index') }}" class="text-red-600 hover:text-red-900">
                ← Back to Payout Events
            </a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Payout Records ({{ $history->count() }})</h2>
            </div>
            
            @if($history->count() > 0)
                <!-- Mobile Card Layout -->
                <div class="md:hidden p-4 grid grid-cols-1 gap-4">
                    @foreach($history as $record)
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                    <span class="text-white text-sm font-bold">{{ substr($record->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-gray-800">{{ $record->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $record->user->email }}</div>
                                </div>
                                @if($record->status == 'claimed')
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Claimed</span>
                                @elseif($record->status == 'missed')
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Missed</span>
                                @elseif($record->status == 'late')
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late</span>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div>
                                    <span class="text-gray-500">Claimed At:</span>
                                    <p class="text-gray-800">{{ $record->claimed_at ? $record->claimed_at->format('M d, Y H:i') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Amount:</span>
                                    <p class="text-gray-800 font-semibold">{{ $record->amount ? '₱' . number_format($record->amount, 2) : 'N/A' }}</p>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Claimed At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($history as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $record->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $record->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($record->status == 'claimed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Claimed</span>
                                        @elseif($record->status == 'missed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Missed</span>
                                        @elseif($record->status == 'late')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $record->claimed_at ? $record->claimed_at->format('F d, Y H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $record->amount ? '₱' . number_format($record->amount, 2) : 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-4 text-center text-gray-500">
                    No payout records yet.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
