@extends('layouts.reviewer')

@section('title', 'Profile - Academic Journal')
@section('page-title', 'Profile Settings')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    <span class="text-gray-800">Profile Settings</span>
@endsection

@section('content')
    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm text-green-600">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            @foreach($errors->all() as $error)
                <p class="text-sm text-red-600">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Photo Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Profile Photo</h3>

                <div class="text-center">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 rounded-full border-4 border-gray-200 overflow-hidden mx-auto">
                            <img id="profilePreview"
                                src="{{ $reviewer && $reviewer->avatar ? asset('storage/' . $reviewer->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=86662c&color=fff&size=120' }}"
                                class="w-full h-full object-cover" alt="{{ $user->name }}">
                        </div>
                        <label for="avatarUpload"
                            class="absolute bottom-0 right-0 w-8 h-8 bg-[#86662c] text-white rounded-full flex items-center justify-center hover:bg-[#6b4f23] transition-colors cursor-pointer">
                            <i class="fa-solid fa-camera text-sm"></i>
                        </label>
                        <input type="file" id="avatarUpload" name="avatar" form="profileForm"
                            accept="image/jpeg,image/png,image/jpg" class="hidden">
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Upload a new photo (JPG, PNG, max 2MB)</p>
                </div>

                <!-- Account Info Summary -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <i class="fa-regular fa-calendar text-[#86662c]"></i>
                            <div>
                                <p class="text-xs text-gray-500">Member since</p>
                                <p class="text-sm font-medium text-gray-800">{{ $user->created_at->format('F Y') }}</p>
                            </div>
                        </div>
                        @if($reviewer && $reviewer->status)
                            <div class="flex items-center space-x-3 mt-2">
                                <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Status</p>
                                    <p class="text-sm font-medium">
                                        @if($reviewer->status === 'active')
                                            <span class="text-green-600">Active</span>
                                        @elseif($reviewer->status === 'pending')
                                            <span class="text-yellow-600">Pending Approval</span>
                                        @else
                                            <span class="text-gray-600">{{ ucfirst($reviewer->status) }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if(!$reviewer)
                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-xs text-yellow-700">
                            <i class="fa-solid fa-circle-info mr-1"></i>
                            Your profile will be reviewed by an admin before you can start reviewing.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Profile Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Reviewer Information Form -->
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Reviewer Information</h3>

                <form id="profileForm" method="POST" action="{{ route('reviewer.profile.update') }}" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name (editable) -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full pl-10 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('name') border-red-500 @enderror"
                                required>
                        </div>
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email (read-only) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" value="{{ $user->email }}"
                                class="w-full pl-10 px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
                                readonly>
                        </div>
                    </div>

                    <!-- Academic Degree and ORCID in grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Academic Degree -->
                        <div>
                            <label for="academic_degree" class="block text-sm font-medium text-gray-700 mb-2">
                                Academic Degree
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-graduation-cap text-gray-400"></i>
                                </div>
                                <select id="academic_degree" name="academic_degree"
                                    class="w-full pl-10 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none appearance-none bg-white">
                                    <option value="">Select Degree</option>
                                    <option value="PhD" {{ old('academic_degree', $reviewer->academic_degree ?? '') == 'PhD' ? 'selected' : '' }}>PhD</option>
                                    <option value="MD" {{ old('academic_degree', $reviewer->academic_degree ?? '') == 'MD' ? 'selected' : '' }}>MD</option>
                                    <option value="MBBS" {{ old('academic_degree', $reviewer->academic_degree ?? '') == 'MBBS' ? 'selected' : '' }}>MBBS</option>
                                    <option value="MSc" {{ old('academic_degree', $reviewer->academic_degree ?? '') == 'MSc' ? 'selected' : '' }}>MSc</option>
                                    <option value="MPH" {{ old('academic_degree', $reviewer->academic_degree ?? '') == 'MPH' ? 'selected' : '' }}>MPH</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- ORCID iD -->
                        <div>
                            <label for="orcid_id" class="block text-sm font-medium text-gray-700 mb-2">
                                ORCID iD
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-brands fa-orcid text-gray-400"></i>
                                </div>
                                <input type="text" id="orcid_id" name="orcid_id"
                                    value="{{ old('orcid_id', $reviewer->orcid_id ?? '') }}"
                                    placeholder="0000-0002-1825-0097"
                                    class="w-full pl-10 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Format: XXXX-XXXX-XXXX-XXXX</p>
                        </div>
                    </div>

                    <!-- Institution and Department in grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Institution -->
                        <div>
                            <label for="institution" class="block text-sm font-medium text-gray-700 mb-2">
                                Institution <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-building-columns text-gray-400"></i>
                                </div>
                                <input type="text" id="institution" name="institution"
                                    value="{{ old('institution', $reviewer->institution ?? '') }}"
                                    placeholder="e.g., Harvard Medical School"
                                    class="w-full pl-10 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('institution') border-red-500 @enderror"
                                    required>
                            </div>
                            @error('institution')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 mb-2">
                                Department
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-building text-gray-400"></i>
                                </div>
                                <input type="text" id="department" name="department"
                                    value="{{ old('department', $reviewer->department ?? '') }}"
                                    placeholder="e.g., Department of Surgery"
                                    class="w-full pl-10 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                            Country <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-globe text-gray-400"></i>
                            </div>
                            <select id="country" name="country"
                                class="w-full pl-10 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none appearance-none bg-white @error('country') border-red-500 @enderror"
                                required>
                                <option value="">Select Country</option>
                                @foreach($countries as $id => $name)
                                    <option value="{{ $id }}" {{ old('country', $reviewer->country ?? '') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                            </div>
                        </div>
                        @error('country')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expertise Areas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Areas of Expertise <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-3 bg-gray-50 rounded-lg">
                            @php
                                $expertiseOptions = [
                                    'General Surgery',
                                    'Cardiothoracic Surgery',
                                    'Neurosurgery',
                                    'Orthopedic Surgery',
                                    'Pediatric Surgery',
                                    'Plastic Surgery',
                                    'Vascular Surgery',
                                    'Surgical Oncology',
                                    'Trauma Surgery',
                                    'Transplant Surgery',
                                    'Anesthesiology',
                                    'Internal Medicine',
                                    'Cardiology',
                                    'Neurology',
                                    'Pediatrics',
                                    'Radiology',
                                    'Pathology',
                                    'Emergency Medicine',
                                    'Critical Care',
                                    'Clinical Research',
                                    'Medical Education',
                                    'Public Health'
                                ];
                                $selectedAreas = old('expertise_areas', $reviewer->expertise_areas ?? []);
                            @endphp
                            
                            @foreach($expertiseOptions as $option)
                                <label class="flex items-center space-x-2 text-sm text-gray-700">
                                    <input type="checkbox" name="expertise_areas[]" value="{{ $option }}"
                                        {{ in_array($option, (array)$selectedAreas) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-[#86662c] focus:ring-[#86662c]">
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('expertise_areas')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                            Biography
                        </label>
                        <textarea id="bio" name="bio" rows="4"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('bio') border-red-500 @enderror"
                            placeholder="Tell us about your research interests and expertise...">{{ old('bio', $reviewer->bio ?? '') }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('reviewer.profile') }}"
                            class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                            Save
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Form -->
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h3>

                <form id="passwordForm" method="POST" action="{{ route('author.password.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current
                            Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="current_password" name="current_password"
                                class="w-full pl-10 pr-10 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('current_password') border-red-500 @enderror"
                                required>
                            <button type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#86662c]"
                                onclick="togglePassword('current_password', 'toggleCurrentIcon')">
                                <i class="fa-regular fa-eye" id="toggleCurrentIcon"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="new_password" name="new_password"
                                class="w-full pl-10 pr-10 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('new_password') border-red-500 @enderror"
                                required>
                            <button type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#86662c]"
                                onclick="togglePassword('new_password', 'toggleNewIcon')">
                                <i class="fa-regular fa-eye" id="toggleNewIcon"></i>
                            </button>
                        </div>
                        @error('new_password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm
                            New Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="w-full pl-10 pr-10 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                required>
                            <button type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#86662c]"
                                onclick="togglePassword('new_password_confirmation', 'toggleConfirmIcon')">
                                <i class="fa-regular fa-eye" id="toggleConfirmIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-2">
                        <button type="reset"
                            class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Clear
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    // Make togglePassword function global (outside DOMContentLoaded)
    window.togglePassword = function (inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);

        if (passwordInput && toggleIcon) {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        // Image upload preview
        const avatarUpload = document.getElementById('avatarUpload');
        if (avatarUpload) {
            avatarUpload.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (2MB max)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size must be less than 2MB');
                        this.value = '';
                        return;
                    }

                    // Validate file type
                    if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                        alert('Only JPG and PNG files are allowed');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = document.getElementById('profilePreview');
                        if (preview) {
                            preview.src = e.target.result;
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>