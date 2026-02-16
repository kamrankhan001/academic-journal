@extends('layouts.dashboard')

@section('title', 'Dashboard - Academic Journal')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <span class="text-gray-600">Dashboard</span>
@endsection

@section('content')
    <!-- Welcome Section -->
    <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-xl shadow-soft p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Welcome back, {{ $user->name }}!</h2>
                <p class="text-white/90 text-sm">Track your journal submissions, reviews, and publications from your dashboard.</p>
            </div>
            <a href="{{ route('author.journals.create') }}" class="bg-white text-[#86662c] px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">
                <i class="fa-solid fa-plus mr-2"></i>
                New Submission
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Journals -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-file-lines text-blue-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-gray-800">{{ $totalJournals }}</span>
            </div>
            <h3 class="text-sm font-medium text-gray-500">Total Journals</h3>
            <p class="text-xs text-gray-400 mt-1">All time submissions</p>
        </div>

        <!-- Total Views -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-eye text-green-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-gray-800">{{ $totalViews }}</span>
            </div>
            <h3 class="text-sm font-medium text-gray-500">Total Views</h3>
            <p class="text-xs text-gray-400 mt-1">Across all journals</p>
        </div>

        <!-- In Review -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-clock text-yellow-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-gray-800">{{ $underReviewJournals + $submittedJournals }}</span>
            </div>
            <h3 class="text-sm font-medium text-gray-500">Under Review</h3>
            <p class="text-xs text-gray-400 mt-1">{{ $submittedJournals }} submitted, {{ $underReviewJournals }} reviewing</p>
        </div>

        <!-- Published -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-circle-check text-purple-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-gray-800">{{ $publishedJournals }}</span>
            </div>
            <h3 class="text-sm font-medium text-gray-500">Published</h3>
            <p class="text-xs text-gray-400 mt-1">{{ $acceptedJournals }} accepted, {{ $rejectedJournals }} rejected</p>
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Status Chart -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 lg:col-span-1">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Submission Status</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Draft</span>
                        <span class="font-medium text-gray-800">{{ $draftJournals }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gray-500 h-2 rounded-full" style="width: {{ $totalJournals > 0 ? ($draftJournals / $totalJournals) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Submitted</span>
                        <span class="font-medium text-gray-800">{{ $submittedJournals }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $totalJournals > 0 ? ($submittedJournals / $totalJournals) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Under Review</span>
                        <span class="font-medium text-gray-800">{{ $underReviewJournals }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $totalJournals > 0 ? ($underReviewJournals / $totalJournals) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Accepted</span>
                        <span class="font-medium text-gray-800">{{ $acceptedJournals }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalJournals > 0 ? ($acceptedJournals / $totalJournals) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Rejected</span>
                        <span class="font-medium text-gray-800">{{ $rejectedJournals }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalJournals > 0 ? ($rejectedJournals / $totalJournals) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Published</span>
                        <span class="font-medium text-gray-800">{{ $publishedJournals }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $totalJournals > 0 ? ($publishedJournals / $totalJournals) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Journals</h3>
                <a href="{{ route('author.journals.index') }}" class="text-sm text-[#86662c] hover:text-[#6b4f23]">
                    View All <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($recentJournals->count() > 0)
                <div class="space-y-4">
                    @foreach($recentJournals as $journal)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    @php
                                        $statusColors = [
                                            'draft' => 'bg-gray-100 text-gray-700',
                                            'submitted' => 'bg-blue-100 text-blue-700',
                                            'under_review' => 'bg-yellow-100 text-yellow-700',
                                            'accepted' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            'published' => 'bg-purple-100 text-purple-700'
                                        ];
                                        $color = $statusColors[$journal->status] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="px-2 py-1 {{ $color }} text-xs font-medium rounded-full">
                                        {{ ucfirst(str_replace('_', ' ', $journal->status)) }}
                                    </span>
                                    <h4 class="text-sm font-medium text-gray-800">{{ Str::limit($journal->title, 50) }}</h4>
                                </div>
                                <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500">
                                    <span><i class="fa-regular fa-calendar mr-1"></i> {{ $journal->created_at->format('M d, Y') }}</span>
                                    @if($journal->coAuthors->count() > 0)
                                        <span><i class="fa-regular fa-users mr-1"></i> {{ $journal->coAuthors->count() }} co-author(s)</span>
                                    @endif
                                    <span><i class="fa-regular fa-eye mr-1"></i> {{ $journal->views_count }} views</span>
                                </div>
                            </div>
                            <a href="{{ route('author.journals.show', $journal) }}" class="text-gray-400 hover:text-[#86662c] transition-colors">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-regular fa-file-lines text-2xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 text-sm">No journals yet</p>
                    <a href="{{ route('author.journals.create') }}" class="text-[#86662c] text-sm hover:text-[#6b4f23] mt-2 inline-block">
                        Submit your first journal
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('author.journals.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-[#86662c] hover:bg-[#86662c]/5 transition-colors group">
                <div class="w-10 h-10 bg-[#86662c]/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-[#86662c] group-hover:text-white transition-colors">
                    <i class="fa-solid fa-pen-to-square text-[#86662c] group-hover:text-white"></i>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-800">New Submission</h4>
                    <p class="text-xs text-gray-500">Submit a new journal</p>
                </div>
            </a>

            <a href="{{ route('author.journals.index') }}?status=draft" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-[#86662c] hover:bg-[#86662c]/5 transition-colors group">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-[#86662c] group-hover:text-white transition-colors">
                    <i class="fa-regular fa-file-lines text-gray-600 group-hover:text-white"></i>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-800">Continue Draft</h4>
                    <p class="text-xs text-gray-500">{{ $draftJournals }} draft journals</p>
                </div>
            </a>

            <a href="{{ route('author.profile') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-[#86662c] hover:bg-[#86662c]/5 transition-colors group">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-[#86662c] group-hover:text-white transition-colors">
                    <i class="fa-regular fa-user text-gray-600 group-hover:text-white"></i>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-800">Update Profile</h4>
                    <p class="text-xs text-gray-500">Manage your account</p>
                </div>
            </a>

            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-[#86662c] hover:bg-[#86662c]/5 transition-colors group">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-[#86662c] group-hover:text-white transition-colors">
                    <i class="fa-regular fa-circle-question text-gray-600 group-hover:text-white"></i>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-800">Help & Support</h4>
                    <p class="text-xs text-gray-500">Get assistance</p>
                </div>
            </a>
        </div>
    </div>
@endsection