@extends('layouts.reviewer')

@section('title', 'Submit Review')
@section('page-title', 'Submit Your Review')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    <a href="{{ route('reviewer.assignments.index') }}" class="text-gray-500 hover:text-[#86662c]">My Reviews</a>
    <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    <span class="text-gray-800">Submit Review</span>
@endsection

@section('content')
    <div>
        <!-- Article Summary -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden mb-6">
            <div class="p-4 bg-gray-50 border-b border-gray-200">
                <h3 class="font-medium text-gray-700">Article Information</h3>
            </div>
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $assignment->journal->title }}</h2>
                <p class="text-sm text-gray-600 mb-4">{{ Str::limit($assignment->journal->abstract, 200) }}</p>
                
                @if($assignment->due_date)
                    <div class="flex items-center text-sm {{ $assignment->due_date->isPast() ? 'text-red-600' : 'text-gray-500' }}">
                        <i class="fa-regular fa-calendar mr-2"></i>
                        <span>Due: {{ $assignment->due_date->format('F d, Y') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Review Form -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-4 bg-gray-50 border-b border-gray-200">
                <h3 class="font-medium text-gray-700">Review Form</h3>
            </div>
            
            <form action="{{ route('reviewer.assignments.submit', $assignment) }}" method="POST" class="p-6">
                @csrf
                
                <!-- Recommendation -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Recommendation <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="recommendation" value="accept" class="mr-2 text-[#86662c] focus:ring-[#86662c]" required>
                            <span class="text-sm">Accept</span>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="recommendation" value="minor_revisions" class="mr-2 text-[#86662c] focus:ring-[#86662c]" required>
                            <span class="text-sm">Minor Revisions</span>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="recommendation" value="major_revisions" class="mr-2 text-[#86662c] focus:ring-[#86662c]" required>
                            <span class="text-sm">Major Revisions</span>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="recommendation" value="reject" class="mr-2 text-[#86662c] focus:ring-[#86662c]" required>
                            <span class="text-sm">Reject</span>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="recommendation" value="resubmit" class="mr-2 text-[#86662c] focus:ring-[#86662c]" required>
                            <span class="text-sm">Resubmit</span>
                        </label>
                    </div>
                    @error('recommendation')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Scores -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="originality_score" class="block text-sm font-medium text-gray-700 mb-2">
                            Originality <span class="text-red-500">*</span>
                        </label>
                        <select id="originality_score" name="originality_score" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                required>
                            <option value="">Select score</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('originality_score') == $i ? 'selected' : '' }}>
                                    {{ $i }} - {{ $i === 1 ? 'Poor' : ($i === 2 ? 'Fair' : ($i === 3 ? 'Good' : ($i === 4 ? 'Very Good' : 'Excellent'))) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div>
                        <label for="methodology_score" class="block text-sm font-medium text-gray-700 mb-2">
                            Methodology <span class="text-red-500">*</span>
                        </label>
                        <select id="methodology_score" name="methodology_score" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                required>
                            <option value="">Select score</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('methodology_score') == $i ? 'selected' : '' }}>
                                    {{ $i }} - {{ $i === 1 ? 'Poor' : ($i === 2 ? 'Fair' : ($i === 3 ? 'Good' : ($i === 4 ? 'Very Good' : 'Excellent'))) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div>
                        <label for="presentation_score" class="block text-sm font-medium text-gray-700 mb-2">
                            Presentation <span class="text-red-500">*</span>
                        </label>
                        <select id="presentation_score" name="presentation_score" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                required>
                            <option value="">Select score</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('presentation_score') == $i ? 'selected' : '' }}>
                                    {{ $i }} - {{ $i === 1 ? 'Poor' : ($i === 2 ? 'Fair' : ($i === 3 ? 'Good' : ($i === 4 ? 'Very Good' : 'Excellent'))) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div>
                        <label for="overall_score" class="block text-sm font-medium text-gray-700 mb-2">
                            Overall Assessment <span class="text-red-500">*</span>
                        </label>
                        <select id="overall_score" name="overall_score" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                required>
                            <option value="">Select score</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('overall_score') == $i ? 'selected' : '' }}>
                                    {{ $i }} - {{ $i === 1 ? 'Poor' : ($i === 2 ? 'Fair' : ($i === 3 ? 'Good' : ($i === 4 ? 'Very Good' : 'Excellent'))) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Comments to Author -->
                <div class="mb-6">
                    <label for="comments_to_author" class="block text-sm font-medium text-gray-700 mb-2">
                        Comments to Author <span class="text-red-500">*</span>
                    </label>
                    <textarea id="comments_to_author" name="comments_to_author" rows="6"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                        placeholder="Provide constructive feedback to the author..."
                        required>{{ old('comments_to_author') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">These comments will be shared with the author.</p>
                    @error('comments_to_author')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comments to Editor (Confidential) -->
                <div class="mb-6">
                    <label for="comments_to_editor" class="block text-sm font-medium text-gray-700 mb-2">
                        Confidential Comments to Editor
                    </label>
                    <textarea id="comments_to_editor" name="comments_to_editor" rows="4"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                        placeholder="Any confidential comments for the editor...">{{ old('comments_to_editor') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">These comments will NOT be shared with the author.</p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('reviewer.assignments.show', $assignment) }}" 
                       class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                        <i class="fa-regular fa-paper-plane mr-2"></i>
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection