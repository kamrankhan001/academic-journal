@extends('layouts.admin')

@section('title', 'Create Issue - Admin')
@section('page-title', 'Create New Issue')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.issues.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Issues</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Create</li>
@endsection

@section('content')
    <div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Issue Information</h3>
            </div>

            <form action="{{ route('admin.issues.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <!-- Volume Selection -->
                <div class="mb-6">
                    <label for="volume_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Volume <span class="text-red-500">*</span>
                    </label>
                    <select id="volume_id" 
                            name="volume_id" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('volume_id') border-red-500 @enderror"
                            required>
                        <option value="">Select Volume</option>
                        @foreach($volumes as $volume)
                            <option value="{{ $volume->id }}" {{ old('volume_id', $volume->id ?? '') == $volume->id ? 'selected' : '' }}>
                                Volume {{ $volume->volume_number }}: {{ $volume->title }} ({{ $volume->year }})
                            </option>
                        @endforeach
                    </select>
                    @error('volume_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Issue Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           placeholder="e.g., Issue 1: Surgical Innovations"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('title') border-red-500 @enderror"
                           required>
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Issue Number and Type -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="issue_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Issue Number <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="issue_number" 
                               name="issue_number" 
                               value="{{ old('issue_number') }}"
                               placeholder="e.g., 1"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('issue_number') border-red-500 @enderror"
                               required>
                        @error('issue_number')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="issue_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Issue Type <span class="text-red-500">*</span>
                        </label>
                        <select id="issue_type" 
                                name="issue_type" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('issue_type') border-red-500 @enderror"
                                required>
                            <option value="">Select Type</option>
                            <option value="regular" {{ old('issue_type') == 'regular' ? 'selected' : '' }}>Regular</option>
                            <option value="special" {{ old('issue_type') == 'special' ? 'selected' : '' }}>Special</option>
                            <option value="supplement" {{ old('issue_type') == 'supplement' ? 'selected' : '' }}>Supplement</option>
                        </select>
                        @error('issue_type')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status and Publication Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('status') border-red-500 @enderror"
                                required>
                            <option value="">Select Status</option>
                            <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="publication_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Publication Date
                        </label>
                        <input type="date" 
                               id="publication_date" 
                               name="publication_date" 
                               value="{{ old('publication_date') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('publication_date') border-red-500 @enderror">
                        @error('publication_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Cover Image -->
                <div class="mb-6">
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Cover Image
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="file" 
                                   id="cover_image" 
                                   name="cover_image" 
                                   accept="image/jpeg,image/png,image/jpg"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('cover_image') border-red-500 @enderror">
                        </div>
                        <div class="shrink-0">
                            <div id="coverPreview" class="w-20 h-20 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center">
                                <i class="fa-solid fa-image text-gray-400 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Recommended size: 300x400px. Max size: 2MB</p>
                    @error('cover_image')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="5"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('description') border-red-500 @enderror"
                              placeholder="Enter issue description...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Buttons -->
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.issues.index') }}" 
                       class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('cover_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('coverPreview');
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-lg">`;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush