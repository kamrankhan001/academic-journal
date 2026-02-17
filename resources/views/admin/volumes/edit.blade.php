@extends('layouts.admin')

@section('title', 'Edit Volume - Admin')
@section('page-title', 'Edit Volume')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.volumes.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Volumes</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Edit</li>
@endsection

@section('content')
    <div class="w-full">
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Edit Volume: {{ $volume->title }}</h3>
            </div>

            <form action="{{ route('admin.volumes.update', $volume) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Main Info -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Volume Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $volume->title) }}"
                                   placeholder="e.g., Volume 1: Inaugural Edition"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('title') border-red-500 @enderror"
                                   required>
                            @error('title')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Volume Number and Year -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="volume_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    Volume Number <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       id="volume_number" 
                                       name="volume_number" 
                                       value="{{ old('volume_number', $volume->volume_number) }}"
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
                                        <option value="{{ $y }}" {{ old('year', $volume->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                                @error('year')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('status') border-red-500 @enderror"
                                    required>
                                <option value="">Select Status</option>
                                <option value="planned" {{ old('status', $volume->status) == 'planned' ? 'selected' : '' }}>Planned</option>
                                <option value="in_progress" {{ old('status', $volume->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="published" {{ old('status', $volume->status) == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="6"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('description') border-red-500 @enderror"
                                      placeholder="Enter volume description...">{{ old('description', $volume->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column - Cover Image & Metadata -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Cover Image -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                Cover Image
                            </label>
                            
                            <div class="flex flex-col items-center">
                                <div class="w-full aspect-[3/4] bg-white rounded-lg border-2 border-gray-300 border-dashed overflow-hidden mb-4">
                                    @if($volume->cover_image)
                                        <img id="coverPreview" 
                                             src="{{ $volume->cover_image_url }}" 
                                             class="w-full h-full object-cover"
                                             alt="{{ $volume->title }}">
                                    else
                                        <div id="coverPreview" class="w-full h-full flex items-center justify-center">
                                            <i class="fa-solid fa-image text-gray-300 text-4xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <input type="file" 
                                       id="cover_image" 
                                       name="cover_image" 
                                       accept="image/jpeg,image/png,image/jpg"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#86662c] file:text-white hover:file:bg-[#6b4f23]">
                                <p class="text-xs text-gray-500 mt-2">Recommended: 300x400px. Max 2MB</p>
                                
                                @if($volume->cover_image)
                                    <button type="button" 
                                            onclick="removeCover()"
                                            class="mt-3 text-sm text-red-600 hover:text-red-700">
                                        <i class="fa-regular fa-trash-can mr-1"></i> Remove current cover
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Publishing Info -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-4">Publishing Information</h4>
                            
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500">Created</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $volume->created_at->format('M d, Y \a\t h:i A') }}</p>
                                </div>
                                
                                @if($volume->published_at)
                                    <div>
                                        <p class="text-xs text-gray-500">Published</p>
                                        <p class="text-sm font-medium text-gray-800">{{ $volume->published_at->format('M d, Y \a\t h:i A') }}</p>
                                    </div>
                                @endif
                                
                                <div>
                                    <p class="text-xs text-gray-500">Last Updated</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $volume->updated_at->format('M d, Y \a\t h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 mt-6 border-t border-gray-200">
                    <a href="{{ route('admin.volumes.index') }}" 
                       class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                        Update
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
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.id = 'coverPreview';
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';
                    preview.parentNode.replaceChild(img, preview);
                }
            }
            reader.readAsDataURL(file);
        }
    });

    function removeCover() {
        if (confirm('Are you sure you want to remove the cover image?')) {
            // Create hidden input to mark cover for removal
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_cover';
            input.value = '1';
            document.querySelector('form').appendChild(input);
            
            // Update preview
            const preview = document.getElementById('coverPreview');
            const placeholder = document.createElement('div');
            placeholder.id = 'coverPreview';
            placeholder.className = 'w-full h-full flex items-center justify-center';
            placeholder.innerHTML = '<i class="fa-solid fa-image text-gray-300 text-4xl"></i>';
            preview.parentNode.replaceChild(placeholder, preview);
            
            // Clear file input
            document.getElementById('cover_image').value = '';
        }
    }
</script>
@endpush