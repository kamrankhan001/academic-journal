@extends('layouts.admin')

@section('title', 'Create User - Admin')
@section('page-title', 'Create New User')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Users</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Create</li>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Account Information</h3>
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('name') border-red-500 @enderror"
                               placeholder="Enter full name"
                               required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('email') border-red-500 @enderror"
                               placeholder="user@example.com"
                               required>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('password') border-red-500 @enderror"
                               placeholder="Minimum 8 characters"
                               required>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                               placeholder="Re-enter password"
                               required>
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">User Role <span class="text-red-500">*</span></label>
                        <select name="role" 
                                id="role"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('role') border-red-500 @enderror"
                                required>
                            <option value="">Select role</option>
                            <option value="author" {{ old('role') == 'author' ? 'selected' : '' }}>Author</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <!-- Email Verified -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="email_verified" 
                               name="email_verified" 
                               value="1"
                               {{ old('email_verified') ? 'checked' : '' }}
                               class="h-4 w-4 text-[#86662c] focus:ring-[#86662c] border-gray-300 rounded">
                        <label for="email_verified" class="ml-2 block text-sm text-gray-700">
                            Mark email as verified
                        </label>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Profile Information</h3>
                    
                    <!-- Avatar -->
                    <div>
                        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">Profile Avatar</label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-[#86662c] transition-colors" id="avatar-dropzone">
                            <input type="file" 
                                   id="avatar" 
                                   name="avatar" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="text-center" id="avatar-placeholder">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400 mb-1"></i>
                                <p class="text-sm text-gray-600">Click to upload avatar</p>
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF (max. 2MB)</p>
                            </div>
                            <div class="hidden" id="avatar-selected">
                                <div class="flex items-center justify-center space-x-2 text-green-600">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span class="text-sm" id="avatar-filename"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Institution -->
                    <div>
                        <label for="institution" class="block text-sm font-medium text-gray-700 mb-2">Institution/Organization</label>
                        <input type="text" 
                               id="institution" 
                               name="institution" 
                               value="{{ old('institution') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                               placeholder="e.g., University Name">
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country_id" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                        <select name="country_id" 
                                id="country_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                            <option value="">Select country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Biography</label>
                        <textarea id="bio" 
                                  name="bio" 
                                  rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                  placeholder="Brief biography or research interests">{{ old('bio') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                    <i class="fa-regular fa-floppy-disk mr-2"></i>
                    Create User
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    // Avatar upload preview
    const avatarInput = document.getElementById('avatar');
    const avatarPlaceholder = document.getElementById('avatar-placeholder');
    const avatarSelected = document.getElementById('avatar-selected');
    const avatarFilename = document.getElementById('avatar-filename');

    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                avatarPlaceholder.classList.add('hidden');
                avatarSelected.classList.remove('hidden');
                avatarFilename.textContent = file.name;
            } else {
                avatarPlaceholder.classList.remove('hidden');
                avatarSelected.classList.add('hidden');
            }
        });
    }
</script>
@endpush