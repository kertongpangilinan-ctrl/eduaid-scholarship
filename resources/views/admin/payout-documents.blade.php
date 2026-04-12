@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Payout Documents</h1>
            <p class="text-gray-600 mt-2">Review and approve student documents for {{ $payoutEvent->event_name }}</p>
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

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Submitted Documents</h2>
            </div>
            
            @if($documents->count() > 0)
                <!-- Mobile Card Layout -->
                <div class="md:hidden p-4 grid grid-cols-1 gap-4">
                    @foreach($documents as $document)
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                    <span class="text-white text-sm font-bold">{{ substr($document->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-gray-800">{{ $document->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $document->user->email }}</div>
                                </div>
                                @if($document->status == 'pending')
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($document->status == 'approved')
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                @elseif($document->status == 'rejected')
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <span class="text-xs text-gray-500">Submitted:</span>
                                <p class="text-xs text-gray-800">{{ $document->submitted_at ? $document->submitted_at->format('M d, Y H:i') : 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <span class="text-xs text-gray-500">Documents:</span>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @if($document->cor_path)
                                        <a href="{{ asset('storage/' . $document->cor_path) }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-900 bg-blue-50 px-2 py-1 rounded">COR</a>
                                    @endif
                                    @if($document->coe_path)
                                        <a href="{{ asset('storage/' . $document->coe_path) }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-900 bg-blue-50 px-2 py-1 rounded">COE</a>
                                    @endif
                                    @if($document->cog_path)
                                        <a href="{{ asset('storage/' . $document->cog_path) }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-900 bg-blue-50 px-2 py-1 rounded">COG</a>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 pt-3 border-t border-gray-200">
                                @if($document->status == 'pending')
                                    <button onclick="approveDocument({{ $document->document_id }})" class="flex-1 px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                                        Approve
                                    </button>
                                    <button onclick="showRejectForm({{ $document->document_id }})" class="flex-1 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                        Reject
                                    </button>
                                @elseif($document->status == 'approved')
                                    <span class="flex-1 text-center text-xs text-gray-500">Already Approved</span>
                                @else
                                    <span class="flex-1 text-center text-xs text-gray-500">Rejected: {{ $document->admin_notes }}</span>
                                @endif
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documents</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($documents as $document)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $document->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $document->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $document->submitted_at ? $document->submitted_at->format('F d, Y H:i') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="space-y-1">
                                            @if($document->cor_path)
                                                <a href="{{ asset('storage/' . $document->cor_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm">View COR</a>
                                            @endif
                                            @if($document->coe_path)
                                                <a href="{{ asset('storage/' . $document->coe_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm">View COE</a>
                                            @endif
                                            @if($document->cog_path)
                                                <a href="{{ asset('storage/' . $document->cog_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm">View COG</a>
                                            @endif
                                        </div>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($document->status == 'pending')
                                            <button onclick="approveDocument({{ $document->document_id }})" class="text-green-600 hover:text-green-900 mr-3">Approve</button>
                                            <button onclick="showRejectForm({{ $document->document_id }})" class="text-red-600 hover:text-red-900">Reject</button>
                                        @elseif($document->status == 'approved')
                                            <span class="text-gray-500">Already Approved</span>
                                        @else
                                            <span class="text-gray-500">Rejected: {{ $document->admin_notes }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-4 text-center text-gray-500">
                    No documents submitted yet.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Reject Document</h3>
        </div>
        <div class="px-6 py-4">
            <form id="rejectForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" value="POST">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection</label>
                    <textarea name="admin_notes" required rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="Enter reason for rejection"></textarea>
                </div>
                <div class="mt-4 flex justify-end space-x-3">
                    <button type="button" onclick="hideRejectModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveDocument(documentId) {
    if (confirm('Are you sure you want to approve this document?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/payout-events/documents/' + documentId + '/approve';
        form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
        document.body.appendChild(form);
        form.submit();
    }
}

function showRejectForm(documentId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = '/admin/payout-events/documents/' + documentId + '/reject';
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function hideRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection
