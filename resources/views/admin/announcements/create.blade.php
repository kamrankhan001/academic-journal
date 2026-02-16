@extends('layouts.admin')

@section('title', 'Create Announcement - Admin')
@section('page-title', 'Create Announcement')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.announcements.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Announcements</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Create</li>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
        <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Error Messages -->
            @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-lg mb-6">
                    <h4 class="text-sm font-medium text-red-800 mb-2">Please fix the following errors:</h4>
                    <ul class="list-disc list-inside text-xs text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                       placeholder="e.g., System Maintenance Notice"
                       required>
            </div>

            <!-- Message -->
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message <span class="text-red-500">*</span></label>
                <textarea id="message" 
                          name="message" 
                          rows="6"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                          placeholder="Write your announcement message here..."
                          required>{{ old('message') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type <span class="text-red-500">*</span></label>
                    <select name="type" 
                            id="type"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                        <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>Info (General)</option>
                        <option value="success" {{ old('type') == 'success' ? 'selected' : '' }}>Success</option>
                        <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>Warning</option>
                        <option value="danger" {{ old('type') == 'danger' ? 'selected' : '' }}>Danger/Urgent</option>
                    </select>
                </div>

                <!-- Target Roles -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target Audience <span class="text-red-500">*</span></label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="target_roles[]" value="all" class="rounded border-gray-300 text-[#86662c] focus:ring-[#86662c]" 
                                {{ in_array('all', old('target_roles', [])) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">All Users</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="target_roles[]" value="author" class="rounded border-gray-300 text-[#86662c] focus:ring-[#86662c]"
                                {{ in_array('author', old('target_roles', [])) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Authors Only</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="target_roles[]" value="admin" class="rounded border-gray-300 text-[#86662c] focus:ring-[#86662c]"
                                {{ in_array('admin', old('target_roles', [])) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Admins Only</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Action (Optional) -->
            <div class="border-t border-gray-200 pt-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Action Button (Optional)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="action_text" class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                        <input type="text" 
                               id="action_text" 
                               name="action_text" 
                               value="{{ old('action_text') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                               placeholder="e.g., Learn More">
                    </div>
                    <div>
                        <label for="action_url" class="block text-sm font-medium text-gray-700 mb-2">Button URL</label>
                        <input type="url" 
                               id="action_url" 
                               name="action_url" 
                               value="{{ old('action_url') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                               placeholder="https://example.com">
                    </div>
                </div>
            </div>

            <!-- Schedule -->
            <div class="border-t border-gray-200 pt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">Schedule for (Optional)</label>
                        <input type="datetime-local" 
                               id="scheduled_at" 
                               name="scheduled_at" 
                               value="{{ old('scheduled_at') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                        <p class="text-xs text-gray-500 mt-1">Leave empty to save as draft</p>
                    </div>
                    <div class="flex items-center">
                        <label class="flex items-center">
                            <input type="checkbox" name="send_now" value="1" class="rounded border-gray-300 text-[#86662c] focus:ring-[#86662c]">
                            <span class="ml-2 text-sm text-gray-700">Send immediately</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.announcements.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                    <i class="fa-regular fa-floppy-disk mr-2"></i>
                    Create Announcement
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>

    // Handle "All Users" checkbox
    const allCheckbox = document.querySelector('input[value="all"]');
    const roleCheckboxes = document.querySelectorAll('input[name="target_roles[]"]:not([value="all"])');

    if (allCheckbox) {
        allCheckbox.addEventListener('change', function() {
            roleCheckboxes.forEach(cb => {
                cb.checked = !this.checked;
                cb.disabled = this.checked;
            });
        });
    }
</script>
@endpush