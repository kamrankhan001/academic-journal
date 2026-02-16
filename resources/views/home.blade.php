@extends('layouts.guest')

@section('title', 'Home - Academic Journal')

@section('content')
    <!-- Breadcrumbs -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="/" class="hover:text-[#86662c]">Home</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800">Latest Publications</span>
        </div>
    </div>

    <!-- Main Content with Sidebar -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content - Journal List (Left side) -->
            <div class="lg:w-2/3">
                <!-- Section Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                        @if(request('search'))
                            Search Results: "{{ request('search') }}"
                        @elseif(request('tag'))
                            Journals Tagged: "{{ $popularTags->firstWhere('id', request('tag'))?->name }}"
                        @elseif(request('month') && request('year'))
                            Journals from {{ \Carbon\Carbon::create(request('year'), request('month'), 1)->format('F Y') }}
                        @else
                            Latest Published Journals
                        @endif
                    </h1>
                    <a href="{{ route('archives') }}" class="text-[#86662c] hover:text-[#6b4f23] font-medium flex items-center text-sm">
                        View All Archives
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Search Results Info -->
                @if(request('search') && $journals->total() > 0)
                    <p class="text-sm text-gray-600 mb-4">Found {{ $journals->total() }} journals matching your search</p>
                @endif

                <!-- Journal List -->
                <div class="space-y-6">
                    @forelse($journals as $journal)
                        <article class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow">
                            <div class="flex flex-col md:flex-row md:items-start gap-4">
                                <!-- Journal Content -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2 flex-wrap">
                                        <span class="text-xs text-gray-500">
                                            <i class="fa-regular fa-calendar mr-1"></i>
                                            {{ $journal->published_at ? $journal->published_at->format('M d, Y') : 'Not published' }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            <i class="fa-regular fa-clock mr-1"></i>
                                            {{ ceil(str_word_count(strip_tags($journal->content)) / 200) }} min read
                                        </span>
                                        @if($journal->files()->where('file_type', 'manuscript')->exists())
                                            <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                                <i class="fa-regular fa-file-pdf mr-1"></i>PDF Available
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <h2 class="text-xl font-bold text-gray-800 mb-2 hover:text-[#86662c]">
                                        <a href="{{ route('journal.show', $journal->slug) }}">{{ $journal->title }}</a>
                                    </h2>
                                    
                                    <div class="flex items-center mb-3 flex-wrap">
                                        <div class="flex -space-x-2">
                                            @if($journal->author)
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($journal->author->name) }}&background=86662c&color=fff&size=32" 
                                                     class="w-7 h-7 rounded-full border-2 border-white"
                                                     alt="{{ $journal->author->name }}">
                                            @endif
                                            @foreach($journal->coAuthors->take(2) as $coAuthor)
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($coAuthor->name) }}&background=86662c&color=fff&size=32" 
                                                     class="w-7 h-7 rounded-full border-2 border-white"
                                                     alt="{{ $coAuthor->name }}">
                                            @endforeach
                                        </div>
                                        <span class="text-sm text-gray-600 ml-2">
                                            {{ $journal->author->name }}
                                            @if($journal->coAuthors->count() > 0)
                                                , {{ $journal->coAuthors->take(2)->pluck('name')->implode(', ') }}
                                                @if($journal->coAuthors->count() > 2)
                                                    +{{ $journal->coAuthors->count() - 2 }} more
                                                @endif
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-600 mb-3 line-clamp-3">
                                        {{ $journal->abstract ?: strip_tags(substr($journal->content, 0, 200)) . '...' }}
                                    </p>
                                    
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        @foreach($journal->tags as $tag)
                                            <a href="{{ route('home', ['tag' => $tag->id]) }}" 
                                               class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded hover:bg-[#86662c] hover:text-white transition-colors">
                                                <i class="fa-solid fa-tag mr-1"></i>{{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                    
                                    <div class="flex items-center justify-between pt-2">
                                        <div class="flex items-center space-x-4 text-xs text-gray-500">
                                            <span><i class="fa-regular fa-eye mr-1"></i>{{ number_format($journal->views_count) }} views</span>
                                        </div>
                                        <a href="{{ route('journal.show', $journal->slug) }}" 
                                           class="text-[#86662c] hover:text-[#6b4f23] text-sm font-medium">
                                            Read Full Journal <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                            <i class="fa-regular fa-newspaper text-5xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Journals Found</h3>
                            <p class="text-gray-500">No published journals match your criteria.</p>
                            @if(request('search') || request('tag') || request('month'))
                                <a href="{{ route('home') }}" class="inline-block mt-4 px-6 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                                    View All Journals
                                </a>
                            @endif
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($journals->hasPages())
                    <div class="flex justify-center mt-10">
                        <nav class="flex items-center space-x-2">
                            {{-- Previous Page Link --}}
                            @if($journals->onFirstPage())
                                <span class="px-3 py-2 rounded-lg border border-gray-300 text-gray-300 cursor-not-allowed">
                                    <i class="fa-solid fa-chevron-left text-sm"></i>
                                </span>
                            @else
                                <a href="{{ $journals->previousPageUrl() }}" 
                                   class="px-3 py-2 rounded-lg border border-gray-300 text-gray-500 hover:bg-[#86662c] hover:text-white hover:border-[#86662c] transition-colors">
                                    <i class="fa-solid fa-chevron-left text-sm"></i>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach($journals->getUrlRange(1, $journals->lastPage()) as $page => $url)
                                @if($page == $journals->currentPage())
                                    <span class="px-4 py-2 rounded-lg bg-[#86662c] text-white border border-[#86662c]">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" 
                                       class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-[#86662c] hover:text-white hover:border-[#86662c] transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if($journals->hasMorePages())
                                <a href="{{ $journals->nextPageUrl() }}" 
                                   class="px-3 py-2 rounded-lg border border-gray-300 text-gray-500 hover:bg-[#86662c] hover:text-white hover:border-[#86662c] transition-colors">
                                    <i class="fa-solid fa-chevron-right text-sm"></i>
                                </a>
                            @else
                                <span class="px-3 py-2 rounded-lg border border-gray-300 text-gray-300 cursor-not-allowed">
                                    <i class="fa-solid fa-chevron-right text-sm"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>

            <!-- Sidebar (Right side) -->
            <aside class="lg:w-1/3">
                <!-- Search Widget -->
                <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Search Journals</h3>
                    <form action="{{ route('home') }}" method="GET">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Search by keyword..." 
                                   value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </form>
                </div>

                <!-- Popular Tags Widget -->
                <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Popular Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($popularTags as $tag)
                            @php
                                $isActive = request('tag_slug') == $tag->slug;
                            @endphp
                            <a href="{{ route('home', ['tag_slug' => $tag->slug]) }}" 
                            class="px-3 py-1.5 text-sm rounded-full transition-colors 
                                    {{ $isActive 
                                        ? 'bg-[#86662c] text-white' 
                                        : 'bg-gray-100 text-gray-700 hover:bg-[#86662c] hover:text-white' 
                                    }}">
                                {{ $tag->name }}
                                <span class="text-xs ml-1 {{ $isActive ? 'text-white/80' : 'text-gray-500' }}">({{ $tag->journals_count }})</span>
                            </a>
                        @empty
                            <p class="text-sm text-gray-500">No tags available</p>
                        @endforelse
                    </div>
                </div>

                <!-- Archive Widget -->
                <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Archive</h3>
                    <ul class="space-y-2">
                        @forelse($archives as $archive)
                            <li>
                                <a href="{{ route('home', ['month' => $archive['month'], 'year' => $archive['year']]) }}" 
                                   class="flex items-center justify-between text-gray-700 hover:text-[#86662c] py-1 {{ request('month') == $archive['month'] && request('year') == $archive['year'] ? 'text-[#86662c] font-medium' : '' }}">
                                    <span>
                                        <i class="fa-regular fa-calendar mr-2 text-gray-400"></i>
                                        {{ $archive['month_name'] }} {{ $archive['year'] }}
                                    </span>
                                    <span class="text-xs bg-gray-100 px-2 py-1 rounded-full">{{ $archive['total'] }} journals</span>
                                </a>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">No archived journals</li>
                        @endforelse
                    </ul>
                    <div class="mt-4 pt-2">
                        <a href="{{ route('archives') }}" class="text-[#86662c] hover:text-[#6b4f23] text-sm font-medium flex items-center">
                            View Full Archive
                            <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Recent Journals Widget -->
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Recent Journals</h3>
                    <div class="space-y-4">
                        @forelse($recentJournals as $recent)
                            <div class="flex items-start gap-3">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                    @php
                                        $icons = ['flask', 'atom', 'leaf', 'brain', 'microscope', 'dna', 'chart-line', 'calculator'];
                                        $randomIcon = $icons[array_rand($icons)];
                                    @endphp
                                    <i class="fa-solid fa-{{ $randomIcon }} text-[#86662c] text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800 hover:text-[#86662c] line-clamp-2">
                                        <a href="{{ route('journal.show', $recent->slug) }}">{{ $recent->title }}</a>
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        {{ $recent->published_at ? $recent->published_at->format('M d, Y') : 'Not published' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No recent journals</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection