@extends('layouts.guest')

@section('title', 'All Issues - Academic Journal')

@section('content')
    <!-- Breadcrumbs -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="/" class="hover:text-[#86662c]">Home</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800">All Issues</span>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                        @if(request('search'))
                            Search Results: "{{ request('search') }}"
                        @else
                            All Journal Issues
                        @endif
                    </h1>
                </div>

                <!-- Issues Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($issues as $issue)
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                            @if($issue->cover_image)
                                <a href="{{ route('issue.show', $issue->id) }}" class="block h-48 overflow-hidden bg-gray-100">
                                    <img src="{{ $issue->cover_image_url }}" 
                                         alt="{{ $issue->title }}"
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </a>
                            @else
                                <a href="{{ route('issue.show', $issue->id) }}" class="block h-48 bg-linear-to-br from-[#86662c]/10 to-[#6b4f23]/10 flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fa-regular fa-newspaper text-5xl text-[#86662c]/30 mb-2"></i>
                                        <p class="text-sm text-gray-400">Vol {{ $issue->volume->volume_number }} • Issue {{ $issue->issue_number }}</p>
                                    </div>
                                </a>
                            @endif
                            
                            <div class="p-5">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                                        Vol {{ $issue->volume->volume_number }} • Issue {{ $issue->issue_number }}
                                    </span>
                                    @if($issue->issue_type === 'special')
                                        <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">
                                            Special Issue
                                        </span>
                                    @endif
                                </div>
                                
                                <h3 class="text-lg font-bold text-gray-800 mb-2 hover:text-[#86662c]">
                                    <a href="{{ route('issue.show', $issue->id) }}">{{ $issue->title }}</a>
                                </h3>
                                
                                @if($issue->description)
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $issue->description }}</p>
                                @endif
                                
                                <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fa-regular fa-calendar mr-1"></i>
                                        {{ $issue->publication_date ? $issue->publication_date->format('M d, Y') : 'Not published' }}
                                    </div>
                                    <a href="{{ route('issue.show', $issue->id) }}" 
                                       class="text-sm text-[#86662c] hover:text-[#6b4f23] font-medium">
                                        View Issue <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 bg-white rounded-lg border border-gray-200 p-12 text-center">
                            <i class="fa-regular fa-newspaper text-5xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Issues Found</h3>
                            <p class="text-gray-500">No published issues match your criteria.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($issues->hasPages())
                    <div class="flex justify-center mt-10">
                        {{ $issues->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="lg:w-1/3">
                <!-- Search Widget -->
                <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Search Issues</h3>
                    <form action="{{ route('issues') }}" method="GET">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Search issues..." 
                                   value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </form>
                </div>

                <!-- Filter by Volume -->
                <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Filter by Volume</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('issues') }}" 
                               class="flex items-center justify-between text-gray-700 hover:text-[#86662c] py-1 {{ !request('volume') ? 'text-[#86662c] font-medium' : '' }}">
                                <span>All Volumes</span>
                            </a>
                        </li>
                        @foreach($volumes as $volume)
                            <li>
                                <a href="{{ route('issues', ['volume' => $volume->volume_number]) }}" 
                                   class="flex items-center justify-between text-gray-700 hover:text-[#86662c] py-1 {{ request('volume') == $volume->volume_number ? 'text-[#86662c] font-medium' : '' }}">
                                    <span>Volume {{ $volume->volume_number }}: {{ $volume->title }}</span>
                                    <span class="text-xs bg-gray-100 px-2 py-1 rounded-full">{{ $volume->year }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Archive by Year -->
                <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Archive by Year</h3>
                    <ul class="space-y-2">
                        @forelse($years as $year)
                            <li>
                                <a href="{{ route('issues', ['year' => $year]) }}" 
                                   class="flex items-center justify-between text-gray-700 hover:text-[#86662c] py-1 {{ request('year') == $year ? 'text-[#86662c] font-medium' : '' }}">
                                    <span>{{ $year }}</span>
                                </a>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">No archives available</li>
                        @endforelse
                    </ul>
                </div>

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
                                        <a href="{{ route('issue.show', $recent->id) }}">{{ $recent->title }}</a>
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