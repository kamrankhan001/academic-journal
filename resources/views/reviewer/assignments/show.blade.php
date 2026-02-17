@extends('layouts.reviewer')

@section('title', 'Review Details')
@section('page-title', 'Review Assignment Details')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    <a href="{{ route('reviewer.assignments.index') }}" class="text-gray-500 hover:text-[#86662c]">My Reviews</a>
    <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    <span class="text-gray-800">Details</span>
@endsection

@section('content')
    <div>
        <!-- Status Alert -->
        @if($assignment->status === 'pending')
            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fa-regular fa-clock text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            You have been invited to review this manuscript. Please respond to this invitation.
                        </p>
                    </div>
                </div>
            </div>
        @elseif($assignment->due_date && $assignment->due_date->isPast() && $assignment->status !== 'completed')
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fa-regular fa-clock text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            This review is overdue. Please submit your review as soon as possible.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Manuscript Details -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">{{ $assignment->journal->title }}</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Author</p>
                        <p class="text-sm font-medium text-gray-800">{{ $assignment->journal->author->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Submitted</p>
                        <p class="text-sm font-medium text-gray-800">{{ $assignment->journal->submitted_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Assigned Date</p>
                        <p class="text-sm font-medium text-gray-800">{{ $assignment->assigned_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Due Date</p>
                        <p class="text-sm font-medium {{ $assignment->due_date && $assignment->due_date->isPast() && $assignment->status !== 'completed' ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $assignment->due_date ? $assignment->due_date->format('M d, Y') : 'Not set' }}
                        </p>
                    </div>
                </div>

                <!-- Abstract -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Abstract</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600">{{ $assignment->journal->abstract ?? 'No abstract provided' }}</p>
                    </div>
                </div>

                <!-- Files -->
                @if($assignment->journal->files->count() > 0)
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Manuscript Files</h3>
                        <div class="space-y-2">
                            @foreach($assignment->journal->files as $file)
                                <a href="{{ $file->url }}" target="_blank" 
                                   class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center">
                                        <i class="fa-regular fa-file-lines text-[#86662c] mr-3"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">{{ $file->original_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $file->size_for_humans }}</p>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-download text-gray-400"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        @if($assignment->status === 'pending')
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Respond to Invitation</h3>
                
                <div class="flex space-x-3">
                    <form action="{{ route('reviewer.assignments.accept', $assignment) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                            <i class="fa-solid fa-check mr-2"></i> Accept Review
                        </button>
                    </form>
                    
                    <button type="button" 
                            onclick="showDeclineForm()"
                            class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Decline
                    </button>
                </div>

                <!-- Decline Form (Hidden) -->
                <div id="declineForm" class="hidden mt-4">
                    <form action="{{ route('reviewer.assignments.decline', $assignment) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="decline_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                Reason for declining (optional)
                            </label>
                            <textarea id="decline_reason" name="decline_reason" rows="3"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                placeholder="Please let us know why you cannot review this manuscript..."></textarea>
                        </div>
                        <div class="flex space-x-3">
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Confirm Decline
                            </button>
                            <button type="button" 
                                    onclick="hideDeclineForm()"
                                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if(in_array($assignment->status, ['accepted', 'in_progress']))
            <div class="flex justify-end">
                <a href="{{ route('reviewer.assignments.review', $assignment) }}" 
                   class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                    <i class="fa-regular fa-pen-to-square mr-2"></i> Continue Review
                </a>
            </div>
        @endif

        @if($assignment->status === 'completed' && $assignment->comments_to_author)
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Your Review</h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Recommendation</p>
                        <span class="px-3 py-1 text-sm rounded-full 
                            @if($assignment->recommendation === 'accept') bg-green-100 text-green-800
                            @elseif($assignment->recommendation === 'minor_revisions') bg-blue-100 text-blue-800
                            @elseif($assignment->recommendation === 'major_revisions') bg-yellow-100 text-yellow-800
                            @elseif($assignment->recommendation === 'reject') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($assignment->recommendation)) }}
                        </span>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Comments to Author</p>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700">{{ $assignment->comments_to_author }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Originality</p>
                            <p class="text-sm font-medium">{{ $assignment->originality_score }}/5</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Methodology</p>
                            <p class="text-sm font-medium">{{ $assignment->methodology_score }}/5</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Presentation</p>
                            <p class="text-sm font-medium">{{ $assignment->presentation_score }}/5</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Overall</p>
                            <p class="text-sm font-medium">{{ $assignment->overall_score }}/5</p>
                        </div>
                    </div>
                    
                    <p class="text-xs text-gray-400 mt-4">
                        Submitted: {{ $assignment->completed_at->format('M d, Y \a\t h:i A') }}
                    </p>
                </div>
            </div>
        @endif
    </div>
@endsection

<script>
    function showDeclineForm() {
        document.getElementById('declineForm').classList.remove('hidden');
    }
    
    function hideDeclineForm() {
        document.getElementById('declineForm').classList.add('hidden');
    }
</script>