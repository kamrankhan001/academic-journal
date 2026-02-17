@extends('layouts.admin')

@section('title', 'Assignment Details - Admin')
@section('page-title', 'Assignment Details')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.assignments.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Assignments</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Details</li>
@endsection

@section('content')
    <div class="w-full space-y-6">
        <!-- Header Actions -->
        <div class="flex justify-end items-center space-x-3">
            @if(in_array($assignment->status, ['accepted', 'in_progress']))
                <form action="{{ route('admin.assignments.remind', $assignment) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors"
                            onclick="return confirm('Send reminder to this reviewer?')">
                        <i class="fa-regular fa-bell mr-2"></i>
                        Send Reminder
                    </button>
                </form>
            @endif
            @if($assignment->status !== 'completed')
                <form action="{{ route('admin.assignments.destroy', $assignment) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                            onclick="return confirm('Are you sure you want to delete this assignment?')">
                        <i class="fa-regular fa-trash-can mr-2"></i>
                        Delete Assignment
                    </button>
                </form>
            @endif
        </div>

        <!-- Assignment Info -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Assignment Information</h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Status Badge -->
                    <div>
                        @if($assignment->status === 'pending')
                            <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @elseif($assignment->status === 'accepted')
                            <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">Accepted</span>
                        @elseif($assignment->status === 'in_progress')
                            <span class="px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-800">In Progress</span>
                        @elseif($assignment->status === 'completed')
                            <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">Completed</span>
                        @elseif($assignment->status === 'declined')
                            <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">Declined</span>
                        @endif
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Assigned Date</p>
                            <p class="text-sm font-medium text-gray-800">{{ $assignment->assigned_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Due Date</p>
                            <p class="text-sm font-medium {{ $assignment->is_overdue ? 'text-red-600' : 'text-gray-800' }}">
                                {{ $assignment->due_date ? $assignment->due_date->format('F d, Y') : 'Not set' }}
                                @if($assignment->is_overdue)
                                    <span class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">Overdue</span>
                                @endif
                            </p>
                        </div>
                        @if($assignment->responded_at)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Responded At</p>
                            <p class="text-sm font-medium text-gray-800">{{ $assignment->responded_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        @endif
                        @if($assignment->completed_at)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Completed At</p>
                            <p class="text-sm font-medium text-gray-800">{{ $assignment->completed_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Notes -->
                    @if($assignment->notes)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Assignment Notes</p>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-700">{{ $assignment->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Decline Reason -->
                    @if($assignment->decline_reason)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Decline Reason</p>
                        <div class="p-4 bg-red-50 rounded-lg">
                            <p class="text-sm text-red-700">{{ $assignment->decline_reason }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stats Card -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Article Info -->
                <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Article</h3>
                    </div>
                    <div class="p-6">
                        <h4 class="font-medium text-gray-800 mb-2">{{ $assignment->journal->title }}</h4>
                        <p class="text-sm text-gray-600 mb-4">by {{ $assignment->journal->author->name }}</p>
                        <a href="{{ route('admin.journals.show', $assignment->journal) }}" 
                           class="text-sm text-[#86662c] hover:underline">
                            View Article <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Reviewer Info -->
                <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Reviewer</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-[#86662c]/10 flex items-center justify-center">
                                <span class="text-[#86662c] font-bold">
                                    {{ strtoupper(substr($assignment->reviewer->user->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $assignment->reviewer->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $assignment->reviewer->institution }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.reviewers.show', $assignment->reviewer) }}" 
                           class="text-sm text-[#86662c] hover:underline">
                            View Reviewer Profile <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Details (if completed) -->
        @if($assignment->status === 'completed')
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Review Details</h3>
            </div>
            <div class="p-6 space-y-6">
                <!-- Scores -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <p class="text-xs text-gray-500 mb-1">Originality</p>
                        <p class="text-2xl font-bold text-[#86662c]">{{ $assignment->originality_score }}/5</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <p class="text-xs text-gray-500 mb-1">Methodology</p>
                        <p class="text-2xl font-bold text-[#86662c]">{{ $assignment->methodology_score }}/5</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <p class="text-xs text-gray-500 mb-1">Presentation</p>
                        <p class="text-2xl font-bold text-[#86662c]">{{ $assignment->presentation_score }}/5</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <p class="text-xs text-gray-500 mb-1">Overall</p>
                        <p class="text-2xl font-bold text-[#86662c]">{{ $assignment->overall_score }}/5</p>
                    </div>
                </div>

                <!-- Recommendation -->
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

                <!-- Comments to Author -->
                <div>
                    <p class="text-xs text-gray-500 mb-1">Comments to Author</p>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-700">{{ $assignment->comments_to_author }}</p>
                    </div>
                </div>

                <!-- Comments to Editor -->
                @if($assignment->comments_to_editor)
                <div>
                    <p class="text-xs text-gray-500 mb-1">Confidential Comments to Editor</p>
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-700">{{ $assignment->comments_to_editor }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
@endsection