@extends('layouts.admin')

@section('title', 'Edit Reviewer - Admin')
@section('page-title', 'Edit Reviewer')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.reviewers.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Reviewers</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Edit</li>
@endsection

@section('content')
    <div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Edit Reviewer: {{ $reviewer->user->name }}</h3>
                <p class="text-sm text-gray-500 mt-1">Update reviewer information and status</p>
            </div>

            <form action="{{ route('admin.reviewers.update', $reviewer) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $reviewer->user->name) }}"
                           placeholder="Dr. John Smith"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (read-only) -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input type="email" 
                           id="email" 
                           value="{{ $reviewer->user->email }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
                           readonly>
                    <p class="text-xs text-gray-500 mt-1">Email cannot be changed. Create a new reviewer if needed.</p>
                </div>

                <!-- Academic Degree and ORCID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="academic_degree" class="block text-sm font-medium text-gray-700 mb-2">
                            Academic Degree
                        </label>
                        <select id="academic_degree" name="academic_degree"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                            <option value="">Select Degree</option>
                            <option value="PhD" {{ old('academic_degree', $reviewer->academic_degree) == 'PhD' ? 'selected' : '' }}>PhD</option>
                            <option value="MD" {{ old('academic_degree', $reviewer->academic_degree) == 'MD' ? 'selected' : '' }}>MD</option>
                            <option value="MBBS" {{ old('academic_degree', $reviewer->academic_degree) == 'MBBS' ? 'selected' : '' }}>MBBS</option>
                            <option value="MSc" {{ old('academic_degree', $reviewer->academic_degree) == 'MSc' ? 'selected' : '' }}>MSc</option>
                            <option value="MPH" {{ old('academic_degree', $reviewer->academic_degree) == 'MPH' ? 'selected' : '' }}>MPH</option>
                        </select>
                    </div>

                    <div>
                        <label for="orcid_id" class="block text-sm font-medium text-gray-700 mb-2">
                            ORCID iD
                        </label>
                        <input type="text" 
                               id="orcid_id" 
                               name="orcid_id" 
                               value="{{ old('orcid_id', $reviewer->orcid_id) }}"
                               placeholder="0000-0002-1825-0097"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                        <p class="text-xs text-gray-500 mt-1">Format: XXXX-XXXX-XXXX-XXXX</p>
                        @error('orcid_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Institution and Department -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="institution" class="block text-sm font-medium text-gray-700 mb-2">
                            Institution <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="institution" 
                               name="institution" 
                               value="{{ old('institution', $reviewer->institution) }}"
                               placeholder="e.g., Harvard Medical School"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('institution') border-red-500 @enderror"
                               required>
                        @error('institution')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700 mb-2">
                            Department
                        </label>
                        <input type="text" 
                               id="department" 
                               name="department" 
                               value="{{ old('department', $reviewer->department) }}"
                               placeholder="e.g., Department of Surgery"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    </div>
                </div>

                <!-- Country -->
                <div class="mb-6">
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                        Country <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="country" 
                           name="country" 
                           value="{{ old('country', $reviewer->country) }}"
                           placeholder="e.g., United States"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('country') border-red-500 @enderror"
                           required>
                    @error('country')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expertise Areas -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Areas of Expertise <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-gray-50 rounded-lg max-h-80 overflow-y-auto">
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

                <!-- Status -->
                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" 
                            name="status" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                            required>
                        <option value="active" {{ old('status', $reviewer->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ old('status', $reviewer->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="inactive" {{ old('status', $reviewer->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div class="mb-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                        Biography
                    </label>
                    <textarea id="bio" 
                              name="bio" 
                              rows="5"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                              placeholder="Tell us about the reviewer's background and expertise...">{{ old('bio', $reviewer->bio) }}</textarea>
                </div>

                <!-- Statistics Summary -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Reviewer Statistics</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <p class="text-lg font-bold text-[#86662c]">{{ $reviewer->review_count }}</p>
                            <p class="text-xs text-gray-500">Total Reviews</p>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-bold text-[#86662c]">
                                {{ $reviewer->reviewAssignments()->where('status', 'completed')->count() }}
                            </p>
                            <p class="text-xs text-gray-500">Completed</p>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-bold text-[#86662c]">
                                {{ $reviewer->reviewAssignments()->where('status', 'pending')->count() }}
                            </p>
                            <p class="text-xs text-gray-500">Pending</p>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-bold text-[#86662c]">
                                {{ $reviewer->average_rating ? number_format($reviewer->average_rating, 1) : 'N/A' }}
                            </p>
                            <p class="text-xs text-gray-500">Avg. Rating</p>
                        </div>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.reviewers.index') }}" 
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