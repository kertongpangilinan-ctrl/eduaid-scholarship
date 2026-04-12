@extends('layouts.admin')

@section('title', 'Students')

@section('header', 'Students')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium mb-1">Total Students</p>
                    <p class="text-3xl font-bold">{{ $students->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Active</p>
                    <p class="text-3xl font-bold">{{ $students->where('account_status', 'active')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium mb-1">Pending</p>
                    <p class="text-3xl font-bold">{{ $students->where('account_status', 'pending_admin_approval')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-400 to-red-500 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium mb-1">Inactive</p>
                    <p class="text-3xl font-bold">{{ $students->where('account_status', 'inactive')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-times text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.students.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or username..." class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all">
            </div>
            <div class="w-full md:w-48">
                <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all">
                    <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pending_admin_approval" {{ request('status') === 'pending_admin_approval' ? 'selected' : '' }}>Pending Approval</option>
                </select>
            </div>
            <div class="w-full md:w-48">
                <select name="batch" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all">
                    <option value="all" {{ request('batch') === 'all' || !request('batch') ? 'selected' : '' }}>All Batches</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch }}" {{ request('batch') == $batch ? 'selected' : '' }}>Batch {{ $batch }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all shadow-md font-medium">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
            @if(request('search') || request('status') || request('batch'))
                <a href="{{ route('admin.students.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-medium">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide flex items-center">
                <i class="fas fa-list-ul text-red-600 mr-2"></i>
                Student List
            </h3>
        </div>
        
        <!-- Mobile Card Layout -->
        <div class="md:hidden p-4 grid grid-cols-1 gap-4">
            @if($students->count() > 0)
                @foreach($students as $student)
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-200 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                <span class="text-white text-lg font-bold">{{ substr($student->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-800 block">{{ $student->name }}</span>
                                <p class="text-xs text-gray-500">{{ $student->username }}</p>
                            </div>
                            <a href="{{ route('admin.students.show', $student->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 rounded-lg transition-all shadow-md">
                                <i class="fas fa-eye mr-1"></i>
                                View
                            </a>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="text-gray-500">Email:</span>
                                <p class="text-gray-800 truncate">{{ $student->email }}</p>
                            </div>
                            <div>
                                <span class="text-gray-500">Status:</span>
                                <p class="mt-0.5">
                                    @if($student->account_status === 'active')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @elseif($student->account_status === 'inactive')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @elseif($student->account_status === 'pending_admin_approval')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                            {{ ucfirst(str_replace('_', ' ', $student->account_status)) }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-500">Batch:</span>
                                <p class="mt-0.5">
                                    @if($student->currentApplication && $student->currentApplication->batch_id)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                            Batch {{ $student->currentApplication->batch_id }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">None</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-500">Missed:</span>
                                <p class="mt-0.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ $student->consecutive_missed_payouts >= 3 ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $student->consecutive_missed_payouts ?? 0 }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-500">QR Code:</span>
                                <p class="mt-0.5">
                                    @if($student->qr_code)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            <i class="fas fa-qrcode mr-1"></i>
                                            {{ substr($student->qr_code, 0, 15) }}...
                                        </span>
                                    @else
                                        <span class="text-gray-400">None</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-user-slash text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">No students found</p>
                    <p class="text-gray-400 text-sm mt-1">Try adjusting your search or filter criteria</p>
                </div>
            @endif
        </div>

        <!-- Desktop Table Layout -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="px-6 py-4">Student</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Batch</th>
                        <th class="px-6 py-4">Missed Payouts</th>
                        <th class="px-6 py-4">QR Code</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @if($students->count() > 0)
                        @foreach($students as $student)
                            <tr class="hover:bg-red-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mr-4 shadow-md">
                                            <span class="text-white text-lg font-bold">{{ substr($student->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-gray-800 block">{{ $student->name }}</span>
                                            <p class="text-xs text-gray-500">{{ $student->username }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $student->email }}</td>
                                <td class="px-6 py-4">
                                    @if($student->account_status === 'active')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-800 shadow-sm">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                            Active
                                        </span>
                                    @elseif($student->account_status === 'inactive')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800 shadow-sm">
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                            Inactive
                                        </span>
                                    @elseif($student->account_status === 'pending_admin_approval')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 shadow-sm">
                                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 shadow-sm">
                                            {{ ucfirst(str_replace('_', ' ', $student->account_status)) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($student->currentApplication && $student->currentApplication->batch_id)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                            <i class="fas fa-users mr-1"></i>
                                            Batch {{ $student->currentApplication->batch_id }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                            <i class="fas fa-minus mr-1"></i>
                                            None
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $student->consecutive_missed_payouts >= 3 ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $student->consecutive_missed_payouts ?? 0 }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($student->qr_code)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            <i class="fas fa-qrcode mr-1"></i>
                                            {{ substr($student->qr_code, 0, 10) }}...
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                            <i class="fas fa-times mr-1"></i>
                                            None
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="inline-flex items-center px-4 py-2 text-xs font-bold text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 rounded-xl transition-all shadow-md">
                                        <i class="fas fa-eye mr-1.5"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-user-slash text-gray-400 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">No students found</p>
                                    <p class="text-gray-400 text-sm mt-1">Try adjusting your search or filter criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
