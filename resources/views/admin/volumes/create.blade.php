@extends('layouts.admin')

@section('title', 'Create Volume - Admin')
@section('page-title', 'Create New Volume')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.volumes.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Volumes</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Create</li>
@endsection

@section('content')
    <div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Volume Information</h3>
            </div>

            <form action="{{ route('admin.volumes.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Volume Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           placeholder="e.g., Volume 1: Inaugural Edition"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('title') border-red-500 @enderror"
                           required>
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Volume Number and Year -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="volume_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Volume Number <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="volume_number" 
                               name="volume_number" 
                               value="{{ old('volume_number') }}"
                               placeholder="e.g., 1"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('volume_number') border-red-500 @enderror"
                               required>
                        @error('volume_number')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                            Year <span class="text-red-500">*</span>
                        </label>
                        <select id="year" 
                                name="year" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('year') border-red-500 @enderror"
                                required>
                            <option value="">Select Year</option>
                            @for($y = date('Y'); $y >= 2000; $y--)
                                <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        @error('year')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-6">
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
                              placeholder="Enter volume description...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Buttons -->
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.volumes.index') }}" 
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
    // Image preview
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