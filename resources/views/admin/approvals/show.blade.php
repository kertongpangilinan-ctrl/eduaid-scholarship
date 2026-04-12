@extends('layouts.admin')

@section('title', 'Application Details')

@section('header', 'Application Details')

@section('content')
<div class="space-y-6">
    <!-- Application Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-file-alt text-white text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $application->reference_number }}</h2>
                    <p class="text-sm text-gray-500 mt-1">Submitted {{ $application->submission_date ? $application->submission_date->format('F d, Y') : 'N/A' }}</p>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold 
                    @if($application->status === 'pending') bg-amber-100 text-amber-800 border border-amber-200
                    @elseif($application->status === 'approved') bg-emerald-100 text-emerald-800 border border-emerald-200
                    @elseif($application->status === 'rejected') bg-red-100 text-red-800 border border-red-200
                    @else bg-gray-100 text-gray-800 border border-gray-200
                    @endif">
                    <span class="w-2.5 h-2.5 rounded-full mr-2
                        @if($application->status === 'pending') bg-amber-500
                        @elseif($application->status === 'approved') bg-emerald-500
                        @elseif($application->status === 'rejected') bg-red-500
                        @else bg-gray-500
                        @endif"></span>
                    {{ ucfirst($application->status) }}
                </span>
            </div>
        </div>

        @if($application->status === 'pending')
            <div class="flex items-center space-x-3 pt-4 border-t border-gray-100">
                <button onclick="document.getElementById('approve-modal').classList.remove('hidden')" 
                    class="inline-flex items-center px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-check mr-2"></i>
                    <span class="font-medium">Approve</span>
                </button>
                <button onclick="document.getElementById('reject-modal').classList.remove('hidden')" 
                    class="inline-flex items-center px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-times mr-2"></i>
                    <span class="font-medium">Reject</span>
                </button>
                <a href="{{ route('admin.approvals.index') }}" 
                    class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span class="font-medium">Back to List</span>
                </a>
            </div>
        @else
            <div class="flex items-center space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.approvals.index') }}" 
                    class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span class="font-medium">Back to List</span>
                </a>
            </div>
        @endif
    </div>

    <!-- COMPLETE REGISTRATION INFORMATION -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- 1. PERSONAL INFORMATION (Complete) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 lg:col-span-2">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-red-50 to-white">
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide flex items-center">
                    <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    Personal Information
                </h3>
            </div>
            <div class="p-6">
                @if($application->user->personalInfo)
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Full Name -->
                        <div class="md:col-span-4 bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Complete Name</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $application->user->personalInfo->last_name ?? '' }}, {{ $application->user->personalInfo->first_name ?? '' }} {{ $application->user->personalInfo->middle_name ?? '' }} {{ $application->user->personalInfo->extension_name ?? '' }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Gender</p>
                            <p class="text-sm font-semibold text-gray-800">{{ ucfirst($application->user->personalInfo->gender ?? 'N/A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Date of Birth</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $application->user->personalInfo->date_of_birth ? $application->user->personalInfo->date_of_birth->format('F d, Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Civil Status</p>
                            <p class="text-sm font-semibold text-gray-800">{{ ucfirst($application->user->personalInfo->civil_status ?? 'N/A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Contact Number</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $application->user->personalInfo->contact_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-user-slash text-gray-400"></i>
                        </div>
                        <p class="text-gray-500">No personal information submitted</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- 2. ADDRESS INFORMATION -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide flex items-center">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-white"></i>
                    </div>
                    Address Information
                </h3>
            </div>
            <div class="p-6">
                @if($application->user->addressInfo)
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Complete Address</p>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $application->user->addressInfo->house_unit_number ?? '' }} {{ $application->user->addressInfo->street_name ?? '' }}, 
                                Brgy. {{ $application->user->addressInfo->barangay ?? '' }}, 
                                {{ $application->user->addressInfo->municipality_city ?? '' }}, 
                                {{ $application->user->addressInfo->province ?? '' }}
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">House/Unit #</p>
                                <p class="text-sm font-medium text-gray-800">{{ $application->user->addressInfo->house_unit_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Street</p>
                                <p class="text-sm font-medium text-gray-800">{{ $application->user->addressInfo->street_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Barangay</p>
                                <p class="text-sm font-medium text-gray-800">{{ $application->user->addressInfo->barangay ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">City/Municipality</p>
                                <p class="text-sm font-medium text-gray-800">{{ $application->user->addressInfo->municipality_city ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-map-marked-alt text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 text-sm">No address information submitted</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- 3. FAMILY BACKGROUND -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-white">
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide flex items-center">
                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    Family Background
                </h3>
            </div>
            <div class="p-6">
                @if($application->user->familyInfo)
                    <div class="space-y-6">
                        <!-- Father's Info -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-emerald-600 uppercase tracking-wide mb-3 font-semibold flex items-center">
                                <i class="fas fa-male mr-2"></i>Father's Information
                            </p>
                            <div class="space-y-2">
                                <p class="text-sm"><span class="text-gray-500">Name:</span> <span class="font-semibold text-gray-800">{{ $application->user->familyInfo->father_name ?? 'N/A' }}</span></p>
                                <p class="text-sm"><span class="text-gray-500">Occupation:</span> <span class="font-medium text-gray-800">{{ $application->user->familyInfo->father_occupation ?? 'N/A' }}</span></p>
                                <p class="text-sm"><span class="text-gray-500">Monthly Salary:</span> <span class="font-medium text-gray-800">{{ $application->user->familyInfo->father_salary ? '₱' . number_format($application->user->familyInfo->father_salary, 2) : 'N/A' }}</span></p>
                                <p class="text-sm"><span class="text-gray-500">Birth Date:</span> <span class="font-medium text-gray-800">{{ $application->user->familyInfo->father_birth_date ? $application->user->familyInfo->father_birth_date->format('M d, Y') : 'N/A' }}</span></p>
                            </div>
                        </div>

                        <!-- Mother's Info -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs text-emerald-600 uppercase tracking-wide mb-3 font-semibold flex items-center">
                                <i class="fas fa-female mr-2"></i>Mother's Information
                            </p>
                            <div class="space-y-2">
                                <p class="text-sm"><span class="text-gray-500">Name:</span> <span class="font-semibold text-gray-800">{{ $application->user->familyInfo->mother_name ?? 'N/A' }}</span></p>
                                <p class="text-sm"><span class="text-gray-500">Occupation:</span> <span class="font-medium text-gray-800">{{ $application->user->familyInfo->mother_occupation ?? 'N/A' }}</span></p>
                                <p class="text-sm"><span class="text-gray-500">Monthly Salary:</span> <span class="font-medium text-gray-800">{{ $application->user->familyInfo->mother_salary ? '₱' . number_format($application->user->familyInfo->mother_salary, 2) : 'N/A' }}</span></p>
                                <p class="text-sm"><span class="text-gray-500">Birth Date:</span> <span class="font-medium text-gray-800">{{ $application->user->familyInfo->mother_birth_date ? $application->user->familyInfo->mother_birth_date->format('M d, Y') : 'N/A' }}</span></p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-home text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 text-sm">No family information submitted</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- 4. SIBLINGS INFORMATION -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-white">
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide flex items-center">
                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-child text-white"></i>
                    </div>
                    Siblings Information
                </h3>
            </div>
            <div class="p-6">
                @if($application->user->familyInfo && $application->user->familyInfo->siblings && $application->user->familyInfo->siblings->count() > 0)
                    <div class="space-y-3">
                        <div class="bg-purple-50 rounded-lg p-3 mb-4">
                            <p class="text-xs text-purple-600 uppercase tracking-wide">Total Siblings</p>
                            <p class="text-xl font-bold text-purple-800">{{ $application->user->familyInfo->total_siblings ?? $application->user->familyInfo->siblings->count() }}</p>
                        </div>
                        @foreach($application->user->familyInfo->siblings as $index => $sibling)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                <p class="text-xs text-purple-600 uppercase tracking-wide mb-2 font-semibold">Sibling {{ $index + 1 }}</p>
                                <div class="space-y-1">
                                    <p class="text-sm"><span class="text-gray-500">Name:</span> <span class="font-semibold text-gray-800">{{ $sibling->name ?? 'N/A' }}</span></p>
                                    <p class="text-sm"><span class="text-gray-500">Gender:</span> <span class="font-medium text-gray-800">{{ $sibling->gender ?? 'N/A' }}</span></p>
                                    <p class="text-sm"><span class="text-gray-500">Birth Date:</span> <span class="font-medium text-gray-800">{{ $sibling->birth_date ? $sibling->birth_date->format('M d, Y') : 'N/A' }}</span></p>
                                    <p class="text-sm"><span class="text-gray-500">Occupation:</span> <span class="font-medium text-gray-800">{{ $sibling->occupation ?? 'N/A' }}</span></p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-user-friends text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 text-sm">No siblings information submitted</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- 5. EDUCATIONAL BACKGROUND -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-white">
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide flex items-center">
                    <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    Educational Background
                </h3>
            </div>
            <div class="p-6">
                @if($application->user->educationalInfo)
                    <div class="space-y-4">
                        <div class="bg-amber-50 rounded-lg p-4">
                            <p class="text-xs text-amber-600 uppercase tracking-wide mb-1">Current School</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $application->user->educationalInfo->school_name ?? 'N/A' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Education Level</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $application->user->educationalInfo->education_level ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Year Level</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $application->user->educationalInfo->year_level ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Semester Type</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $application->user->educationalInfo->semester_type ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Current Semester</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $application->user->educationalInfo->current_semester ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Learner Reference Number (LRN)</p>
                            <p class="text-sm font-medium text-gray-800">{{ $application->user->educationalInfo->lrn ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">SHS Strand</p>
                            <p class="text-sm font-medium text-gray-800">{{ $application->user->educationalInfo->shs_strand ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">School ID Type</p>
                            <p class="text-sm font-medium text-gray-800">{{ $application->user->educationalInfo->school_id_type ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">School ID Number</p>
                            <p class="text-sm font-medium text-gray-800">{{ $application->user->educationalInfo->school_id_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-school text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 text-sm">No educational information submitted</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- 6. SUBMITTED DOCUMENTS -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 lg:col-span-2">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-red-50 to-white">
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide flex items-center">
                    <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-folder-open text-white"></i>
                    </div>
                    Submitted Documents ({{ $application->user->documents ? $application->user->documents->count() : 0 }})
                </h3>
            </div>
            <div class="p-6">
                @if($application->user->documents && $application->user->documents->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($application->user->documents as $document)
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:shadow-md transition-all">
                                <div class="flex items-start space-x-3">
                                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-file-alt text-red-500 text-lg"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate mb-1">{{ str_replace('_', ' ', ucfirst($document->document_type)) }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mb-2
                                            @if($document->verification_status === 'verified') bg-emerald-100 text-emerald-700
                                            @elseif($document->verification_status === 'rejected') bg-red-100 text-red-700
                                            @else bg-amber-100 text-amber-700
                                            @endif">
                                            {{ ucfirst($document->verification_status) }}
                                        </span>
                                        <div class="flex items-center space-x-2 mt-2">
                                            <button onclick="showDocumentModal('{{ asset('storage/' . $document->file_path) }}', '{{ str_replace('_', ' ', ucfirst($document->document_type)) }}')" 
                                                class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-medium transition-colors">
                                                <i class="fas fa-eye mr-1.5"></i>View
                                            </button>
                                            <a href="{{ asset('storage/' . $document->file_path) }}" download 
                                                class="inline-flex items-center px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-xs font-medium transition-colors">
                                                <i class="fas fa-download mr-1.5"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-folder-open text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No documents submitted</p>
                        <p class="text-gray-400 text-sm mt-1">Applicant has not uploaded any documents yet</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- 7. APPLICANT ACCOUNT INFORMATION -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 lg:col-span-2">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-slate-50 to-white">
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide flex items-center">
                    <div class="w-8 h-8 bg-slate-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-id-badge text-white"></i>
                    </div>
                    Account Information
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-xl">{{ substr($application->user->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-lg font-semibold text-gray-800">{{ $application->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $application->user->email }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Username</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $application->user->username ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Email Verified</p>
                        <p class="text-sm font-semibold {{ $application->user->email_verified_at ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $application->user->email_verified_at ? 'Yes' : 'Pending' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Account Status</p>
                        <p class="text-sm font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $application->user->account_status)) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Reference Number</p>
                        <p class="text-sm font-mono font-semibold text-gray-800">{{ $application->reference_number }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approve-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        <div class="px-6 py-4 bg-emerald-500">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                Approve Application
            </h3>
        </div>
        <form action="{{ route('admin.approvals.approve', $application) }}" method="POST" class="p-6">
            @csrf
            <p class="text-gray-600 mb-4">Are you sure you want to approve this application? The applicant will receive an email with their login credentials.</p>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes (Optional)</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Add any notes about this approval..."></textarea>
            </div>
            <div class="flex items-center justify-end space-x-3">
                <button type="button" onclick="document.getElementById('approve-modal').classList.add('hidden')" 
                    class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-colors shadow-md">
                    Confirm Approval
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        <div class="px-6 py-4 bg-red-500">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-times-circle mr-2"></i>
                Reject Application
            </h3>
        </div>
        <form action="{{ route('admin.approvals.reject', $application) }}" method="POST" class="p-6">
            @csrf
            <p class="text-gray-600 mb-4">Are you sure you want to reject this application? Please provide a reason for the rejection.</p>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Enter the reason for rejection..."></textarea>
            </div>
            <div class="flex items-center justify-end space-x-3">
                <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" 
                    class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors shadow-md">
                    Confirm Rejection
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Document Viewer Modal -->
<div id="document-modal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
        <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-between">
            <h3 id="document-modal-title" class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-file-image mr-2"></i>
                <span>Document Viewer</span>
            </h3>
            <button onclick="closeDocumentModal()" class="text-white hover:text-gray-200 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6 flex-1 overflow-auto bg-gray-50 flex items-center justify-center">
            <img id="document-modal-image" src="" alt="Document" class="max-w-full max-h-[70vh] rounded-lg shadow-lg">
        </div>
        <div class="px-6 py-4 bg-gray-100 border-t border-gray-200 flex items-center justify-between">
            <span class="text-sm text-gray-600" id="document-modal-filename"></span>
            <div class="flex items-center space-x-3">
                <a id="document-modal-download" href="" download 
                    class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-download mr-2"></i>Download
                </a>
                <button onclick="closeDocumentModal()" 
                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showDocumentModal(imageUrl, documentName) {
        document.getElementById('document-modal-image').src = imageUrl;
        document.getElementById('document-modal-download').href = imageUrl;
        document.getElementById('document-modal-title').querySelector('span').textContent = documentName;
        document.getElementById('document-modal-filename').textContent = imageUrl.split('/').pop();
        document.getElementById('document-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDocumentModal() {
        document.getElementById('document-modal').classList.add('hidden');
        document.getElementById('document-modal-image').src = '';
        document.body.style.overflow = '';
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDocumentModal();
        }
    });

    // Close modal on click outside
    document.getElementById('document-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDocumentModal();
        }
    });
</script>
@endsection
