@extends('layouts.admin')

@section('title', 'Announcements')

@section('header', 'Announcements')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Manage Announcements</h3>
            <p class="text-sm text-gray-500">Create and manage public announcements for the carousel</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg font-medium hover:from-red-700 hover:to-red-800 transition-all shadow-md hover:shadow-lg">
            <i class="fas fa-plus mr-2"></i>
            New Announcement
        </a>
    </div>

    <!-- Announcements List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        @if($announcements->count() > 0)
            <!-- Mobile Card Layout -->
            <div class="md:hidden p-4 grid grid-cols-1 gap-4">
                @foreach($announcements as $announcement)
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-200 shadow-sm">
                        <div class="flex items-start mb-3">
                            @if($announcement->image_path)
                                <div class="w-16 h-16 rounded-lg overflow-hidden mr-3 flex-shrink-0">
                                    <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="Announcement" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-gray-800 text-sm">{{ $announcement->title }}</div>
                                <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit($announcement->content, 80) }}</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs mb-3">
                            <div>
                                <span class="text-gray-500">Type:</span>
                                <p class="mt-0.5">
                                    @if($announcement->announcement_type === 'general')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">General</span>
                                    @elseif($announcement->announcement_type === 'scholarship')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Scholarship</span>
                                    @elseif($announcement->announcement_type === 'payout')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Payout</span>
                                    @elseif($announcement->announcement_type === 'event')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Event</span>
                                    @elseif($announcement->announcement_type === 'deadline')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Deadline</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $announcement->announcement_type }}</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-500">Status:</span>
                                <p class="mt-0.5">
                                    @if($announcement->is_pinned)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800"><i class="fas fa-thumbtack mr-1"></i>Pinned</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-500">Published:</span>
                                <p class="text-gray-800">{{ $announcement->published_at ? $announcement->published_at->format('M d, Y') : '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            @if($announcement->link_url)
                                <a href="{{ $announcement->link_url }}" target="_blank" class="text-xs text-red-600 hover:text-red-700"><i class="fas fa-external-link-alt mr-1"></i>Link</a>
                            @else
                                <span></span>
                            @endif
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.announcements.edit', $announcement) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
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
                            <th class="px-6 py-3">Title</th>
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Published</th>
                            <th class="px-6 py-3">Image</th>
                            <th class="px-6 py-3">Link</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($announcements as $announcement)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $announcement->title }}</div>
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($announcement->content, 80) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($announcement->announcement_type === 'general')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            General
                                        </span>
                                    @elseif($announcement->announcement_type === 'scholarship')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Scholarship
                                        </span>
                                    @elseif($announcement->announcement_type === 'payout')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Payout
                                        </span>
                                    @elseif($announcement->announcement_type === 'event')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Event
                                        </span>
                                    @elseif($announcement->announcement_type === 'deadline')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Deadline
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $announcement->announcement_type }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($announcement->is_pinned)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            <i class="fas fa-thumbtack mr-1"></i>
                                            Pinned
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $announcement->published_at ? $announcement->published_at->format('M d, Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($announcement->image_path)
                                        <div class="w-12 h-12 rounded-lg overflow-hidden">
                                            <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="Announcement" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">No image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($announcement->link_url)
                                        <a href="{{ $announcement->link_url }}" target="_blank" class="text-red-600 hover:text-red-700 text-xs">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.announcements.edit', $announcement) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                                <i class="fas fa-trash mr-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $announcements->links() }}
                </div>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bullhorn text-gray-400 text-2xl"></i>
                </div>
                <p class="text-gray-500 font-medium">No announcements yet</p>
                <p class="text-gray-400 text-sm mt-1">Create your first announcement to get started</p>
            </div>
        @endif
    </div>
</div>
@endsection
