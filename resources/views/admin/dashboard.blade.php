@extends('layouts.admin')

@section('title', 'Dashboard - Admin')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="flex items-center text-gray-800">Dashboard</li>
@endsection

@section('content')
    <!-- Quick Stats - Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_users'] }}</p>
                    <p class="text-xs text-green-600 mt-2">
                        <i class="fa-solid fa-arrow-up mr-1"></i>
                        {{ $stats['recent_users'] ?? 0 }} new this week
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-xs">
                <span class="text-gray-500">Authors: {{ $stats['total_authors'] }}</span>
                <span class="text-gray-500">Reviewers: {{ $stats['total_reviewers'] }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Journals</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_journals'] }}</p>
                    <p class="text-xs text-green-600 mt-2">
                        <i class="fa-solid fa-arrow-up mr-1"></i>
                        {{ $stats['recent_journals'] ?? 0 }} new this week
                    </p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-file-lines text-amber-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-xs">
                <span class="text-gray-500">Published: {{ $stats['published_journals'] }}</span>
                <span class="text-gray-500">Pending: {{ $stats['pending_journals'] }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Under Review</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['under_review_journals'] }}</p>
                    <p class="text-xs text-amber-600 mt-2">
                        <i class="fa-regular fa-clock mr-1"></i>
                        Awaiting review
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-eye text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-xs">
                <span class="text-gray-500">Revision: {{ $stats['revision_required_journals'] }}</span>
                <span class="text-gray-500">Rejected: {{ $stats['rejected_journals'] }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Tags & Countries</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_tags'] }}</p>
                    <p class="text-xs text-gray-600 mt-2">
                        <i class="fa-regular fa-flag mr-1"></i>
                        {{ $stats['total_countries'] }} countries
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-tags text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-xs">
                <span class="text-gray-500">Active tags</span>
                <span class="text-gray-500">Global reach</span>
            </div>
        </div>
    </div>

    <!-- Quick Stats - Row 2 (Volume, Issues, Reviewers, Assignments) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Volumes</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_volumes'] }}</p>
                    <p class="text-xs text-green-600 mt-2">
                        <i class="fa-solid fa-book-open mr-1"></i>
                        {{ $stats['published_volumes'] }} published
                    </p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-book-open text-indigo-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.volumes.index') }}" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">
                    Manage Volumes <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Issues</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_issues'] }}</p>
                    <p class="text-xs text-green-600 mt-2">
                        <i class="fa-solid fa-newspaper mr-1"></i>
                        {{ $stats['published_issues'] }} published
                    </p>
                </div>
                <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-newspaper text-cyan-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.issues.index') }}" class="text-xs text-cyan-600 hover:text-cyan-700 font-medium">
                    Manage Issues <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Reviewers</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_reviewer_profiles'] }}</p>
                    <p class="text-xs mt-2">
                        <span class="text-green-600"><i class="fa-regular fa-circle-check mr-1"></i>{{ $stats['active_reviewers'] }} active</span>
                        <span class="text-yellow-600 ml-2"><i class="fa-regular fa-clock mr-1"></i>{{ $stats['pending_reviewers'] }} pending</span>
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.reviewers.index') }}" class="text-xs text-purple-600 hover:text-purple-700 font-medium">
                    Manage Reviewers <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Assignments</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_assignments'] }}</p>
                    <p class="text-xs mt-2">
                        <span class="text-yellow-600"><i class="fa-regular fa-clock mr-1"></i>{{ $stats['pending_assignments'] }} pending</span>
                        <span class="text-green-600 ml-2"><i class="fa-regular fa-circle-check mr-1"></i>{{ $stats['completed_assignments'] }} completed</span>
                    </p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.assignments.index') }}" class="text-xs text-amber-600 hover:text-amber-700 font-medium">
                    View Assignments <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Mini Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-linear-to-r from-purple-50 to-purple-100 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-purple-600 font-medium">Overdue Reviews</p>
                    <p class="text-2xl font-bold text-purple-700">{{ $stats['overdue_assignments'] }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-200 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-clock text-purple-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-linear-to-r from-green-50 to-green-100 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-green-600 font-medium">Published Volumes</p>
                    <p class="text-2xl font-bold text-green-700">{{ $stats['published_volumes'] }}</p>
                </div>
                <div class="w-10 h-10 bg-green-200 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-book-open text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-linear-to-r from-cyan-50 to-cyan-100 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-cyan-600 font-medium">Published Issues</p>
                    <p class="text-2xl font-bold text-cyan-700">{{ $stats['published_issues'] }}</p>
                </div>
                <div class="w-10 h-10 bg-cyan-200 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-newspaper text-cyan-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-linear-to-r from-amber-50 to-amber-100 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-amber-600 font-medium">Active Reviewers</p>
                    <p class="text-2xl font-bold text-amber-700">{{ $stats['active_reviewers'] }}</p>
                </div>
                <div class="w-10 h-10 bg-amber-200 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Journals by Month Chart -->
        <div class="lg:col-span-1 bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Journals by Month</h3>
            <div class="h-64 relative">
                <canvas id="journalsMiniChart"></canvas>
            </div>
        </div>

        <!-- Journals by Status Chart -->
        <div class="lg:col-span-1 bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Journals by Status</h3>
            <div class="h-64 relative">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Assignments by Status Chart -->
        <div class="lg:col-span-1 bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Assignments by Status</h3>
            <div class="h-64 relative">
                <canvas id="assignmentsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Second Row - Top Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Top Authors -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Authors</h3>
            <div class="space-y-4">
                @forelse($topAuthors as $author)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center">
                                @if($author->profile && $author->profile->avatar)
                                    <img src="{{ asset('storage/' . $author->profile->avatar) }}" 
                                         alt="{{ $author->name }}"
                                         class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <span class="text-amber-700 text-xs font-bold">
                                        {{ strtoupper(substr($author->name, 0, 2)) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ Str::limit($author->name, 20) }}</p>
                                <p class="text-xs text-gray-500">{{ $author->journals_count }} journals</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.show', $author->id) }}" 
                           class="text-amber-600 hover:text-amber-700 text-xs">
                            View
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No authors yet</p>
                @endforelse
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.users.index', ['role' => 'author']) }}" 
                   class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                    View All Authors <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Top Reviewers -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Reviewers</h3>
            <div class="space-y-4">
                @forelse($topReviewers as $reviewer)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                                <span class="text-purple-700 text-xs font-bold">
                                    {{ strtoupper(substr($reviewer->user->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ Str::limit($reviewer->user->name, 20) }}</p>
                                <p class="text-xs text-gray-500">{{ $reviewer->review_assignments_count }} assignments</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.reviewers.show', $reviewer->id) }}" 
                           class="text-purple-600 hover:text-purple-700 text-xs">
                            View
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No reviewers yet</p>
                @endforelse
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.reviewers.index') }}" 
                   class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                    View All Reviewers <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Popular Tags -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Popular Tags</h3>
            <div class="space-y-3">
                @forelse($popularTags as $tag)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-tag text-amber-500 text-xs"></i>
                            <span class="text-sm text-gray-700">{{ $tag->name }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                {{ $tag->journals_count }} journals
                            </span>
                            <a href="{{ route('admin.tags.show', $tag->id) }}" 
                               class="text-amber-600 hover:text-amber-700 text-xs">
                                View
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No tags yet</p>
                @endforelse
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.tags.index') }}" 
                   class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                    Manage Tags <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Items Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Volumes -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Recent Volumes</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentVolumes as $volume)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <a href="{{ route('admin.volumes.show', $volume->id) }}" 
                                   class="text-sm font-medium text-gray-800 hover:text-indigo-600">
                                    {{ $volume->title }}
                                </a>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs text-gray-500">
                                        Volume {{ $volume->volume_number }} • {{ $volume->year }}
                                    </span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">
                                        {{ $volume->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                @if($volume->status === 'published')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Published</span>
                                @elseif($volume->status === 'in_progress')
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">In Progress</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">Planned</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <i class="fa-solid fa-book-open text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No volumes yet</p>
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <a href="{{ route('admin.volumes.index') }}" 
                   class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    View All Volumes <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Recent Issues -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Recent Issues</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentIssues as $issue)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <a href="{{ route('admin.issues.show', $issue->id) }}" 
                                   class="text-sm font-medium text-gray-800 hover:text-cyan-600">
                                    {{ $issue->title }}
                                </a>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs text-gray-500">
                                        Vol {{ $issue->volume->volume_number ?? 'N/A' }} • Issue {{ $issue->issue_number }}
                                    </span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">
                                        {{ $issue->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                @if($issue->status === 'published')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Published</span>
                                @elseif($issue->status === 'in_progress')
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">In Progress</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">Planned</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <i class="fa-solid fa-newspaper text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No issues yet</p>
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <a href="{{ route('admin.issues.index') }}" 
                   class="text-sm text-cyan-600 hover:text-cyan-700 font-medium">
                    View All Issues <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Journals and Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Journals -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Recent Journals</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentJournals as $journal)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <a href="{{ route('admin.journals.show', $journal->id) }}" 
                                   class="text-sm font-medium text-gray-800 hover:text-amber-700">
                                    {{ Str::limit($journal->title, 60) }}
                                </a>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs text-gray-500">
                                        By {{ $journal->author->name }}
                                    </span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">
                                        {{ $journal->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                @if($journal->tags->count() > 0)
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach($journal->tags->take(3) as $tag)
                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                        @if($journal->tags->count() > 3)
                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full">
                                                +{{ $journal->tags->count() - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                @php
                                    $statusColors = [
                                        'draft' => 'bg-gray-100 text-gray-700',
                                        'submitted' => 'bg-yellow-100 text-yellow-700',
                                        'under_review' => 'bg-purple-100 text-purple-700',
                                        'published' => 'bg-green-100 text-green-700',
                                        'revision_required' => 'bg-orange-100 text-orange-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusColor = $statusColors[$journal->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full {{ $statusColor }}">
                                    {{ str_replace('_', ' ', ucfirst($journal->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <i class="fa-regular fa-file-lines text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No journals yet</p>
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <a href="{{ route('admin.journals.index') }}" 
                   class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                    View All Journals <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Recent Activities</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentActivities as $activity)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start space-x-3">
                            <div class="shrink-0">
                                <div class="w-8 h-8 rounded-full bg-{{ $activity->color }}-100 flex items-center justify-center">
                                    <i class="{{ $activity->icon }} text-{{ $activity->color }}-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">{{ $activity->user }}</span>
                                    {{ $activity->action }}
                                    <span class="font-medium">{{ Str::limit($activity->subject, 30) }}</span>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">{{ $activity->time->diffForHumans() }}</p>
                            </div>
                            @if($activity->link)
                                <a href="{{ $activity->link }}" class="text-amber-600 hover:text-amber-700 text-xs">
                                    View
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <i class="fa-regular fa-clock text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No recent activities</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('styles')
<!-- Chart.js CSS -->
<style>
    .chart-period-btn.active {
        background-color: #86662c;
        color: white;
    }
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Journals by Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($journalsByStatus)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($journalsByStatus)) !!},
                    backgroundColor: [
                        '#10b981', // published - green
                        '#f59e0b', // pending - amber
                        '#8b5cf6', // under review - purple
                        '#f97316', // revision - orange
                        '#ef4444', // rejected - red
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                cutout: '70%',
            }
        });

        // Assignments by Status Chart
        const assignmentsCtx = document.getElementById('assignmentsChart').getContext('2d');
        new Chart(assignmentsCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($assignmentsByStatus)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($assignmentsByStatus)) !!},
                    backgroundColor: [
                        '#f59e0b', // pending - amber
                        '#8b5cf6', // in progress - purple
                        '#10b981', // completed - green
                        '#6b7280', // declined - gray
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                cutout: '70%',
            }
        });

        // Journals Mini Chart
        const journalsMiniCtx = document.getElementById('journalsMiniChart').getContext('2d');
        new Chart(journalsMiniCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Journals',
                    data: {!! json_encode($journalsByMonth) !!},
                    borderColor: '#86662c',
                    backgroundColor: 'rgba(134, 102, 44, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#86662c',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });

        // Auto-refresh quick stats every 5 minutes
        setInterval(function() {
            fetch('{{ route("admin.quick-stats") }}')
                .then(response => response.json())
                .then(data => {
                    console.log('Stats refreshed:', data);
                });
        }, 300000); // 5 minutes
    });
</script>
@endpush