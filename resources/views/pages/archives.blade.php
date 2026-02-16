@extends('layouts.guest')

@section('title', 'Journal Archives - Academic Journal')
@section('page-title', 'Journal Archives')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <div class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
            <a href="/" class="hover:text-[#86662c]">Home</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800">Archives</span>
            @if(isset($period) && $period != 'All Archives')
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="text-gray-800">{{ $period }}</span>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                    {{ $period ?? 'Journal Archives' }}
                </h1>

                @if($journals->total() > 0)
                    <p class="text-sm text-gray-600 mb-4">Found {{ $journals->total() }} journals in this archive</p>
                @endif

                <div class="space-y-6">
                    @forelse($journals as $journal)
                        <article class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-xs text-gray-500">
                                    <i class="fa-regular fa-calendar mr-1"></i>
                                    {{ $journal->published_at->format('M d, Y') }}
                                </span>
                            </div>
                            
                            <h2 class="text-xl font-bold text-gray-800 mb-2 hover:text-[#86662c]">
                                <a href="{{ route('journal.show', $journal->slug) }}">{{ $journal->title }}</a>
                            </h2>
                            
                            <p class="text-gray-600 mb-3 line-clamp-2">
                                {{ $journal->abstract ?: strip_tags(substr($journal->content, 0, 150)) . '...' }}
                            </p>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">
                                    By {{ $journal->author->name }}
                                </span>
                                <a href="{{ route('journal.show', $journal->slug) }}" 
                                   class="text-[#86662c] hover:text-[#6b4f23] text-sm font-medium">
                                    Read More <i class="fa-solid fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                            <i class="fa-regular fa-calendar-xmark text-5xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Journals Found</h3>
                            <p class="text-gray-500">No journals available in this archive.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($journals->hasPages())
                    <div class="flex justify-center mt-8">
                        {{ $journals->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="lg:w-1/3">
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Archive Years</h3>
                    <ul class="space-y-2">
                        @foreach($archives->groupBy('year') as $year => $months)
                            <li class="mb-3">
                                <h4 class="font-semibold text-gray-700 mb-2">{{ $year }}</h4>
                                <ul class="ml-4 space-y-1">
                                    @foreach($months as $archive)
                                        <li>
                                            <a href="{{ route('home', ['month' => $archive['month'], 'year' => $archive['year']]) }}" 
                                               class="flex items-center justify-between text-sm text-gray-600 hover:text-[#86662c]">
                                                <span>{{ $archive['month_name'] }}</span>
                                                <span class="text-xs bg-gray-100 px-2 py-0.5 rounded-full">{{ $archive['total'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </div>
@endsection