@extends('layouts.admin')

@section('title', 'Create Tag - Admin')
@section('page-title', 'Create New Tag')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.tags.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Tags</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Create</li>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
        <form action="{{ route('admin.tags.store') }}" method="POST" class="space-y-6">
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

            <!-- Tag Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tag Name <span class="text-red-500">*</span></label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('name') border-red-500 @enderror"
                       placeholder="Enter tag name (e.g., Artificial Intelligence, Data Science)"
                       required
                       autofocus>
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">The slug will be automatically generated from the name.</p>
            </div>

            <!-- Preview -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Preview</h4>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 bg-[#86662c] text-white text-sm rounded-full" id="preview-tag">
                        {{ old('name') ?: 'Tag Name' }}
                    </span>
                    <code class="text-xs bg-gray-200 px-2 py-1 rounded text-gray-600" id="preview-slug">
                        {{ old('name') ? Str::slug(old('name')) : 'tag-name' }}
                    </code>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.tags.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                    <i class="fa-regular fa-floppy-disk mr-2"></i>
                    Create Tag
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    const nameInput = document.getElementById('name');
    const previewTag = document.getElementById('preview-tag');
    const previewSlug = document.getElementById('preview-slug');

    nameInput.addEventListener('input', function() {
        const name = this.value.trim() || 'Tag Name';
        previewTag.textContent = name;
        
        // Generate slug
        const slug = name.toLowerCase()
            .replace(/[^\w\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(/--+/g, '-') // Replace multiple - with single -
            .trim();
        previewSlug.textContent = slug || 'tag-name';
    });
</script>
@endpush