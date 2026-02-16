@extends('layouts.admin')

@section('title', 'Edit Tag - Admin')
@section('page-title', 'Edit Tag')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.tags.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Tags</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Edit</li>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
        <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

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
                       value="{{ old('name', $tag->name) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('name') border-red-500 @enderror"
                       placeholder="Enter tag name"
                       required>
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Slug (Read-only) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Slug</label>
                <code class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-600">
                    {{ $tag->slug }}
                </code>
                <p class="text-xs text-gray-500 mt-1">The slug will be automatically updated when you change the name.</p>
            </div>

            <!-- Preview -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Preview</h4>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 bg-[#86662c] text-white text-sm rounded-full" id="preview-tag">
                        {{ old('name', $tag->name) }}
                    </span>
                    <code class="text-xs bg-gray-200 px-2 py-1 rounded text-gray-600" id="preview-slug">
                        {{ old('name') ? Str::slug(old('name')) : $tag->slug }}
                    </code>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="text-sm font-medium text-blue-800 mb-2">Tag Statistics</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-blue-600">Journals Count</p>
                        <p class="text-lg font-semibold text-blue-800">{{ $tag->journals_count ?? $tag->journals()->count() }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-blue-600">Created</p>
                        <p class="text-sm text-blue-800">{{ $tag->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.tags.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                    <i class="fa-regular fa-floppy-disk mr-2"></i>
                    Update Tag
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
        const name = this.value.trim() || '{{ $tag->name }}';
        previewTag.textContent = name;
        
        // Generate slug
        const slug = name.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/--+/g, '-')
            .trim();
        previewSlug.textContent = slug || '{{ $tag->slug }}';
    });
</script>
@endpush