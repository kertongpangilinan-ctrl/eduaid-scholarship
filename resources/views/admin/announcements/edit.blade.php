@extends('layouts.admin')

@section('title', 'Edit Announcement')

@section('header', 'Edit Announcement')

@section('content')
<div class="space-y-6">
    <div class="flex items-center">
        <a href="{{ route('admin.announcements.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Edit Announcement</h3>
            <p class="text-sm text-gray-500">Update the announcement details</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" placeholder="Enter announcement title">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" placeholder="Enter announcement content">{{ old('content', $announcement->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Announcement Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type <span class="text-red-500">*</span></label>
                    <select name="announcement_type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                        <option value="general" {{ old('announcement_type', $announcement->announcement_type) === 'general' ? 'selected' : '' }}>General (shows in carousel)</option>
                        <option value="scholarship" {{ old('announcement_type', $announcement->announcement_type) === 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                        <option value="payout" {{ old('announcement_type', $announcement->announcement_type) === 'payout' ? 'selected' : '' }}>Payout</option>
                        <option value="event" {{ old('announcement_type', $announcement->announcement_type) === 'event' ? 'selected' : '' }}>Event</option>
                        <option value="deadline" {{ old('announcement_type', $announcement->announcement_type) === 'deadline' ? 'selected' : '' }}>Deadline</option>
                    </select>
                    @error('announcement_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Published At -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Publish Date</label>
                    <input type="date" name="published_at" value="{{ old('published_at', $announcement->published_at ? $announcement->published_at->format('Y-m-d') : now()->format('Y-m-d')) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                    @error('published_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image (optional)</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-red-500 transition-colors">
                        <input type="file" name="image" accept="image/*" class="hidden" id="imageInput" onchange="previewImage(this)">
                        <label for="imageInput" class="cursor-pointer">
                            @if($announcement->image_path)
                                <div id="imagePreview" class="mb-4">
                                    <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="Current image" class="max-h-48 mx-auto rounded-lg">
                                    <p class="text-xs text-gray-500 mt-2">Current image</p>
                                </div>
                            @else
                                <div id="imagePreview" class="hidden mb-4">
                                    <img src="" alt="Preview" class="max-h-48 mx-auto rounded-lg">
                                </div>
                            @endif
                            <div id="imagePlaceholder" @if($announcement->image_path) class="hidden" @endif>
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">Click to upload new image</p>
                                <p class="text-xs text-gray-400">JPG, PNG up to 2MB</p>
                            </div>
                        </label>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link URL -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link URL (optional)</label>
                    <input type="url" name="link_url" value="{{ old('link_url', $announcement->link_url) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" placeholder="https://example.com">
                    <p class="text-xs text-gray-500 mt-1">If provided, the carousel slide will be clickable</p>
                    @error('link_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- When Info -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">When (optional)</label>
                    <input type="text" name="when_info" value="{{ old('when_info', $announcement->when_info) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" placeholder="Date and time">
                    @error('when_info')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Where Info -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Where (optional)</label>
                    <input type="text" name="where_info" value="{{ old('where_info', $announcement->where_info) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" placeholder="Location">
                    @error('where_info')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- What Info -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">What (optional)</label>
                    <input type="text" name="what_info" value="{{ old('what_info', $announcement->what_info) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" placeholder="Event details">
                    @error('what_info')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Pinned -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned', $announcement->is_pinned) ? 'checked' : '' }} class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <span class="ml-2 text-sm text-gray-700">Pin this announcement</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.announcements.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg font-medium hover:from-red-700 hover:to-red-800 transition-all shadow-md hover:shadow-lg">
                    Update Announcement
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('imagePreview').querySelector('img').src = e.target.result;
            document.getElementById('imagePlaceholder').classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
