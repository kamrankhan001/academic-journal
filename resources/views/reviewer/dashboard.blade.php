@extends('layouts.reviewer')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    <span class="text-gray-800">Dashboard</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text-white/90">Here's an overview of your reviewing activity and pending assignments.</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Pending Invitations -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pending Invitations</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_invitations'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            @if($stats['pending_invitations'] > 0)
                <a href="{{ route('reviewer.assignments.index') }}?filter=pending" class="mt-4 text-sm text-[#86662c] hover:text-[#6b4f23] flex items-center">
                    Review invitations <i class="fa-regular fa-arrow-right ml-1"></i>
                </a>
            @endif
        </div>

        <!-- Accepted Reviews -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">In Progress</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['accepted_reviews'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-pen-to-square text-blue-600 text-xl"></i>
                </div>
            </div>
            @if($stats['accepted_reviews'] > 0)
                <a href="{{ route('reviewer.assignments.index') }}?filter=in_progress" class="mt-4 text-sm text-[#86662c] hover:text-[#6b4f23] flex items-center">
                    Continue reviewing <i class="fa-regular fa-arrow-right ml-1"></i>
                </a>
            @endif
        </div>

        <!-- Completed Reviews -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Completed</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['completed_reviews'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-circle-check text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="mt-4 text-sm text-gray-500">Total reviews submitted</p>
        </div>

        <!-- Overdue Reviews -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Overdue</p>
                    <p class="text-2xl font-bold {{ $stats['overdue_reviews'] > 0 ? 'text-red-600' : 'text-gray-800' }}">
                        {{ $stats['overdue_reviews'] }}
                    </p>
                </div>
                <div class="w-12 h-12 {{ $stats['overdue_reviews'] > 0 ? 'bg-red-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-clock text-{{ $stats['overdue_reviews'] > 0 ? 'red' : 'gray' }}-600 text-xl"></i>
                </div>
            </div>
            @if($stats['overdue_reviews'] > 0)
                <p class="mt-4 text-sm text-red-600">Please submit as soon as possible</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Assignments -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="font-semibold text-gray-800">Recent Review Assignments</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentAssignments as $assignment)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-800 mb-1">
                                    {{ $assignment->journal->title }}
                                </h4>
                                <p class="text-xs text-gray-500 mb-2">
                                    Assigned: {{ $assignment->assigned_at->format('M d, Y') }}
                                    @if($assignment->due_date)
                                        | Due: {{ $assignment->due_date->format('M d, Y') }}
                                    @endif
                                </p>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($assignment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($assignment->status === 'accepted') bg-blue-100 text-blue-800
                                        @elseif($assignment->status === 'in_progress') bg-purple-100 text-purple-800
                                        @elseif($assignment->status === 'completed') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ str_replace('_', ' ', ucfirst($assignment->status)) }}
                                    </span>
                                </div>
                            </div>
                            @if($assignment->status === 'pending')
                                <a href="{{ route('reviewer.assignments.show', $assignment) }}" 
                                   class="ml-4 text-sm text-[#86662c] hover:text-[#6b4f23]">
                                    Respond <i class="fa-regular fa-arrow-right ml-1"></i>
                                </a>
                            @elseif(in_array($assignment->status, ['accepted', 'in_progress']))
                                <a href="{{ route('reviewer.assignments.review', $assignment) }}" 
                                   class="ml-4 text-sm text-[#86662c] hover:text-[#6b4f23]">
                                    Continue <i class="fa-regular fa-arrow-right ml-1"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        <i class="fa-regular fa-file-lines text-4xl mb-2 opacity-50"></i>
                        <p>No review assignments yet</p>
                    </div>
                @endforelse
            </div>
            <div class="p-4 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('reviewer.assignments.index') }}" 
                   class="text-sm text-[#86662c] hover:text-[#6b4f23] flex items-center justify-center">
                    View All Assignments
                </a>
            </div>
        </div>

        <!-- Side Panel -->
        <div class="space-y-6">
            <!-- Reviewer Stats -->
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Your Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Reviews:</span>
                        <span class="font-medium text-gray-800">{{ $reviewer->review_count }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Average Rating:</span>
                        <span class="font-medium text-gray-800">
                            @if($reviewer->average_rating)
                                {{ number_format($reviewer->average_rating, 1) }}/5
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Member Since:</span>
                        <span class="font-medium text-gray-800">{{ $reviewer->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Expertise Areas -->
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Expertise Areas</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($reviewer->expertise_areas ?? [] as $area)
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">
                            {{ $area }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="bg-[#86662c]/5 rounded-xl p-6 border border-[#86662c]/10">
                <h3 class="font-semibold text-gray-800 mb-2">Reviewer Tips</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <i class="fa-regular fa-circle-check text-[#86662c] mt-1 mr-2 text-xs"></i>
                        <span>Provide constructive feedback</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fa-regular fa-circle-check text-[#86662c] mt-1 mr-2 text-xs"></i>
                        <span>Be specific about improvements</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fa-regular fa-circle-check text-[#86662c] mt-1 mr-2 text-xs"></i>
                        <span>Submit reviews before the due date</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Any dashboard specific JavaScript
</script>
@endpush