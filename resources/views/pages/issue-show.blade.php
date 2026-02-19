@extends('layouts.guest')

@section('title', $issue->title . ' - Academic Journal')

@section('content')
    <!-- Breadcrumbs -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="/" class="hover:text-[#86662c]">Home</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <a href="{{ route('issues') }}" class="hover:text-[#86662c]">Issues</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800">Volume {{ $issue->volume->volume_number }}, Issue {{ $issue->issue_number }}</span>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <!-- Issue Header -->
                <div class="bg-white rounded-lg border border-gray-200 p-8 mb-6">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-full">
                            Volume {{ $issue->volume->volume_number }} • Issue {{ $issue->issue_number }}
                        </span>
                        @if($issue->issue_type === 'special')
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 text-sm rounded-full">
                                Special Issue
                            </span>
                        @endif
                        @if($issue->issue_type === 'supplement')
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 text-sm rounded-full">
                                Supplement
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl font-bold text-gray-800 mb-3">{{ $issue->title }}</h1>

                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fa-regular fa-calendar mr-2"></i>
                        Published: {{ $issue->publication_date ? $issue->publication_date->format('F d, Y') : 'Not published' }}
                    </div>

                    @if($issue->description)
                        <div class="prose max-w-none text-gray-600 mb-4">
                            {{ $issue->description }}
                        </div>
                    @endif

                    @if($issue->volume->description)
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2">About Volume {{ $issue->volume->volume_number }}</h3>
                            <p class="text-sm text-gray-600">{{ $issue->volume->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- Articles in this Issue -->
                <div class="bg-white rounded-lg border border-gray-200 p-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">
                        Articles in this Issue ({{ $issue->journals->count() }})
                    </h2>

                    @if($issue->journals->count() > 0)
                        <div class="space-y-6">
                            @foreach($issue->journals as $index => $journal)
                                <article class="{{ !$loop->last ? 'pb-6 border-b border-gray-200' : '' }}">
                                    <div class="flex items-start gap-4">
                                        <!-- Article Number -->
                                        <div class="w-8 h-8 bg-[#86662c]/10 rounded-full flex items-center justify-center shrink-0 mt-1">
                                            <span class="text-[#86662c] font-bold text-sm">{{ $index + 1 }}</span>
                                        </div>

                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-gray-800 mb-2 hover:text-[#86662c]">
                                                <a href="{{ route('journal.show', $journal->slug) }}">{{ $journal->title }}</a>
                                            </h3>

                                            <!-- Authors -->
                                            <div class="flex items-center mb-2">
                                                <div class="flex -space-x-2">
                                                    @if($journal->author)
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($journal->author->name) }}&background=86662c&color=fff&size=28" 
                                                             class="w-6 h-6 rounded-full border-2 border-white"
                                                             alt="{{ $journal->author->name }}">
                                                    @endif
                                                    @foreach($journal->coAuthors->take(2) as $coAuthor)
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($coAuthor->name) }}&background=6b7280&color=fff&size=28" 
                                                             class="w-6 h-6 rounded-full border-2 border-white"
                                                             alt="{{ $coAuthor->name }}">
                                                    @endforeach
                                                </div>
                                                <span class="text-xs text-gray-600 ml-2">
                                                    {{ $journal->author->name }}
                                                    @if($journal->coAuthors->count() > 0)
                                                        et al.
                                                    @endif
                                                </span>
                                            </div>

                                            <!-- Abstract -->
                                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                                                {{ $journal->abstract ?: strip_tags(substr($journal->content, 0, 150)) . '...' }}
                                            </p>

                                            <!-- Tags and Pages -->
                                            <div class="flex items-center justify-between">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($journal->tags->take(3) as $tag)
                                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded">
                                                            {{ $tag->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                                @if($journal->page_start && $journal->page_end)
                                                    <span class="text-xs text-gray-500">
                                                        Pages: {{ $journal->page_start }}-{{ $journal->page_end }}
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex items-center justify-between mt-3">
                                                <div class="flex items-center space-x-3 text-xs text-gray-500">
                                                    <span><i class="fa-regular fa-eye mr-1"></i>{{ number_format($journal->views_count) }} views</span>
                                                    @if($journal->manuscript)
                                                        <a href="{{ $journal->manuscript_url }}" target="_blank" class="text-green-600 hover:text-green-700">
                                                            <i class="fa-regular fa-file-pdf mr-1"></i>PDF
                                                        </a>
                                                    @endif
                                                </div>
                                                <a href="{{ route('journal.show', $journal->slug) }}" 
                                                   class="text-sm text-[#86662c] hover:text-[#6b4f23] font-medium">
                                                    Read Article <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fa-regular fa-file-lines text-5xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">No articles published in this issue yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="lg:w-1/3">
                <!-- Cover Image -->
                @if($issue->cover_image)
                    <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Cover Image</h3>
                        <div class="relative rounded-lg overflow-hidden border border-gray-200">
                            <img src="{{ $issue->cover_image_url }}" 
                                 alt="{{ $issue->title }} - Cover Image"
                                 class="w-full h-auto object-cover">
                        </div>
                    </div>
                @endif

                <!-- Issue Details -->
                <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Issue Details</h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Volume:</span>
                            <span class="font-medium text-gray-800">Volume {{ $issue->volume->volume_number }}</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Issue:</span>
                            <span class="font-medium text-gray-800">{{ $issue->issue_number }}</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium text-gray-800 capitalize">{{ $issue->issue_type }}</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Published:</span>
                            <span class="font-medium text-gray-800">{{ $issue->publication_date?->format('M d, Y') }}</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Articles:</span>
                            <span class="font-medium text-gray-800">{{ $issue->journals->count() }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Other Issues from this Volume -->
                @if($otherIssues->count() > 0)
                    <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Other Issues in Volume {{ $issue->volume->volume_number }}</h3>
                        <div class="space-y-3">
                            @foreach($otherIssues as $other)
                                <a href="{{ route('issues.show', $other->id) }}" class="block hover:bg-gray-50 p-2 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center shrink-0">
                                            <i class="fa-regular fa-newspaper text-[#86662c]"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-800">Issue {{ $other->issue_number }}</h4>
                                            <p class="text-xs text-gray-500">{{ $other->title }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Recent Issues -->
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Recent Issues</h3>
                    <div class="space-y-4">
                        @forelse($recentIssues as $recent)
                            <div class="flex items-start gap-3">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center shrink-0 overflow-hidden">
                                    @if($recent->cover_image)
                                        <img src="{{ $recent->cover_image_url }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-regular fa-newspaper text-[#86662c] text-xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800 hover:text-[#86662c] line-clamp-2">
                                        <a href="{{ route('issues.show', $recent->id) }}">{{ $recent->title }}</a>
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        Vol {{ $recent->volume->volume_number }} • {{ $recent->publication_date?->format('M Y') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No recent issues</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection