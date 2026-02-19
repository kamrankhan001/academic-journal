@extends('layouts.guest')

@section('title', 'Home - Journal of Medical and Surgical Allied')

@section('content')
    <!-- Hero Section -->
    <div class="bg-linear-to-br from-[#86662c] to-[#6b4f23] text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6 leading-tight">
                    Journal of Medical and Surgical Allied
                </h1>
                <p class="text-lg md:text-xl text-white/90 mb-10 leading-relaxed max-w-3xl mx-auto">
                    A peer-reviewed, open-access scholarly journal dedicated to advancing multidisciplinary research 
                    and promoting high-quality academic communication.
                </p>
                
                <!-- Quick Action Buttons -->
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('author.index') }}" class="px-6 py-3 bg-white text-[#86662c] rounded-lg font-semibold hover:bg-gray-100 transition-colors shadow-lg">
                        Submit Manuscript
                    </a>
                    <a href="{{ route('author.journals.index') }}" class="px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/30 text-white rounded-lg font-semibold hover:bg-white/20 transition-colors">
                        Track Submission
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Curved Separator -->
        <div class="relative h-16">
            <svg class="absolute bottom-0 w-full h-16 text-gray-50 fill-current" preserveAspectRatio="none" viewBox="0 0 1440 74">
                <path d="M0,0 C480,74 960,74 1440,0 L1440,74 L0,74 Z"></path>
            </svg>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div>
                    <div class="text-2xl font-bold text-[#86662c]">{{ $stats['articles'] }}+</div>
                    <div class="text-sm text-gray-600">Published Articles</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-[#86662c]">{{ $stats['authors'] }}+</div>
                    <div class="text-sm text-gray-600">Registered Authors</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-[#86662c]">{{ $stats['reviewers'] }}+</div>
                    <div class="text-sm text-gray-600">Active Reviewers</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-[#86662c]">{{ $stats['countries'] }}+</div>
                    <div class="text-sm text-gray-600">Countries</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Publications Section -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Latest Publications</h2>
                <p class="text-gray-600 mt-1">Recent articles published in our journal</p>
            </div>
            <a href="{{ route('journals') }}" class="text-[#86662c] hover:text-[#6b4f23] font-medium flex items-center">
                View All Publications
                <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>

        <!-- Latest Journals from Database -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($latestJournals as $journal)
                <article class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            @if($journal->tags->isNotEmpty())
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                    {{ $journal->tags->first()->name }}
                                </span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                    Research Article
                                </span>
                            @endif
                            <span class="text-xs text-gray-500">
                                <i class="fa-regular fa-calendar mr-1"></i>
                                {{ $journal->published_at ? $journal->published_at->format('M d, Y') : $journal->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-800 mb-2 hover:text-[#86662c] line-clamp-2">
                            <a href="{{ route('journal.show', $journal->slug) }}">{{ $journal->title }}</a>
                        </h3>
                        
                        <div class="flex items-center mb-3">
                            <div class="flex -space-x-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($journal->author->name) }}&background=86662c&color=fff&size=28" 
                                     class="w-7 h-7 rounded-full border-2 border-white"
                                     alt="{{ $journal->author->name }}">
                                @foreach($journal->coAuthors->take(2) as $coAuthor)
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($coAuthor->name) }}&background=6b7280&color=fff&size=28" 
                                         class="w-7 h-7 rounded-full border-2 border-white"
                                         alt="{{ $coAuthor->name }}">
                                @endforeach
                            </div>
                            <span class="text-xs text-gray-600 ml-2 line-clamp-1">
                                {{ $journal->author->name }} et al.
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ $journal->abstract ?? Str::limit(strip_tags($journal->content), 150) }}
                        </p>
                        
                        @if($journal->tags->count() > 0)
                            <div class="flex flex-wrap gap-1 mb-4">
                                @foreach($journal->tags->take(3) as $tag)
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <div class="flex items-center space-x-3 text-xs text-gray-500">
                                <span><i class="fa-regular fa-eye mr-1"></i>{{ number_format($journal->views_count) }}</span>
                                @if($journal->manuscript)
                                    <a href="{{ $journal->manuscript_url }}" target="_blank" class="text-green-600 hover:text-green-700">
                                        <i class="fa-regular fa-file-pdf mr-1"></i>PDF
                                    </a>
                                @endif
                            </div>
                            <a href="{{ route('journal.show', $journal->slug) }}" class="text-[#86662c] hover:text-[#6b4f23] text-sm font-medium">
                                Read More <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <!-- Fallback static content if no journals exist -->
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">No published journals yet. Check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Key Information Grid -->
    <div class="bg-gray-50 py-12 border-t border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- APC Card -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#86662c]/10 rounded-lg flex items-center justify-center mb-4">
                        <i class="fa-regular fa-credit-card text-[#86662c] text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Article Processing Charges</h3>
                    <p class="text-sm text-gray-600 mb-3">No fee for initial submission. Fee applies only after acceptance.</p>
                    <div class="space-y-1 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fa-solid fa-check text-green-600 mr-2 text-xs"></i>
                            <span>Peer review management</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fa-solid fa-check text-green-600 mr-2 text-xs"></i>
                            <span>Copyediting & typesetting</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fa-solid fa-check text-green-600 mr-2 text-xs"></i>
                            <span>DOI assignment & archiving</span>
                        </div>
                    </div>
                    <a href="{{ route('journal-policies') }}" class="inline-block mt-4 text-[#86662c] hover:text-[#6b4f23] text-sm font-medium">
                        Learn more about APC
                        <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>

                <!-- Indexing Card -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#86662c]/10 rounded-lg flex items-center justify-center mb-4">
                        <i class="fa-solid fa-magnifying-glass-chart text-[#86662c] text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Indexing & Abstracting</h3>
                    <p class="text-sm text-gray-600 mb-3">Maximizing visibility through major indexing services.</p>
                    <div class="space-y-1 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fa-regular fa-circle-check text-green-600 mr-2 text-xs"></i>
                            <span>Search engine indexing</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fa-regular fa-circle-check text-green-600 mr-2 text-xs"></i>
                            <span>Academic database applications</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fa-regular fa-circle-check text-green-600 mr-2 text-xs"></i>
                            <span>Institutional repository inclusion</span>
                        </div>
                    </div>
                    <a href="{{ route('journal-policies') }}" class="inline-block mt-4 text-[#86662c] hover:text-[#6b4f23] text-sm font-medium">
                        View indexing services
                        <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>

                <!-- Author Benefits Card -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-[#86662c]/10 rounded-lg flex items-center justify-center mb-4">
                        <i class="fa-solid fa-user-pen text-[#86662c] text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Author Benefits</h3>
                    <p class="text-sm text-gray-600 mb-3">Everything you need to publish your research.</p>
                    <div class="space-y-1 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fa-regular fa-id-card text-[#86662c] mr-2 text-xs"></i>
                            <span>Track submission status</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fa-regular fa-id-card text-[#86662c] mr-2 text-xs"></i>
                            <span>Update profile information</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fa-regular fa-id-card text-[#86662c] mr-2 text-xs"></i>
                            <span>Register as reviewer</span>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-[#86662c] text-white text-sm rounded-lg hover:bg-[#6b4f23] transition-colors">
                            Register Now
                        </a>
                        <a href="{{ route('login') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-50 transition-colors">
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Journal Resources Section -->
    <div class="relative min-h-screen bg-linear-to-br from-gray-50 to-white py-16 overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-[#86662c]/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#86662c]/5 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 min-h-screen flex items-center">
            <div class="w-full">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <span class="inline-block px-4 py-1 bg-[#86662c]/10 text-[#86662c] rounded-full text-sm font-medium mb-4">
                        <i class="fa-solid fa-circle-nodes mr-2"></i>Journal Resources
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Explore Our Journal</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Discover past issues and learn how to submit your research</p>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    
                    <!-- Left Column - Issues Showcase -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-12 h-12 bg-[#86662c] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-[#86662c]/20">
                                <i class="fa-solid fa-layer-group text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">Recent Issues</h3>
                                <p class="text-gray-600">Browse our latest publications</p>
                            </div>
                        </div>

                        <!-- Interactive Timeline with Dynamic Issues -->
                        <div class="relative">
                            <!-- Timeline Line -->
                            <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-linear-to-b from-[#86662c] via-[#86662c]/50 to-transparent"></div>
                            
                            <!-- Issue Items -->
                            <div class="space-y-6 relative">
                                @forelse($recentIssues as $index => $issue)
                                    <div class="group relative flex items-start gap-6 pl-14">
                                        <div class="absolute left-0 w-12 h-12 {{ $index === 0 ? 'bg-[#86662c]' : 'bg-gray-200 group-hover:bg-[#86662c]' }} rounded-2xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-all duration-300 z-10">
                                            <i class="fa-solid fa-book-open text-lg"></i>
                                        </div>
                                        <div class="flex-1 bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-xl transition-all duration-300 group-hover:translate-x-2">
                                            <div class="flex items-center justify-between mb-3">
                                                @if($index === 0)
                                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                                        <i class="fa-solid fa-fire mr-1"></i>Current Issue
                                                    </span>
                                                @endif
                                                <span class="text-sm text-gray-500 {{ $index === 0 ? '' : 'ml-auto' }}">
                                                    <i class="fa-regular fa-calendar mr-1"></i>
                                                    {{ $issue->publication_date ? $issue->publication_date->format('F Y') : $issue->created_at->format('F Y') }}
                                                </span>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-800 mb-2">
                                                Volume {{ $issue->volume->volume_number ?? 'N/A' }}, Issue {{ $issue->issue_number }}
                                            </h4>
                                            <p class="text-gray-600 mb-4">{{ $issue->title }}</p>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500">
                                                    <i class="fa-regular fa-file-lines mr-1"></i>{{ $issue->journals_count ?? 0 }} articles
                                                </span>
                                                <a href="{{ route('issue.show', $issue->id) }}" class="text-[#86662c] hover:text-[#6b4f23] font-medium inline-flex items-center group/link">
                                                    Browse Issue 
                                                    <i class="fa-solid fa-arrow-right ml-2 group-hover/link:translate-x-1 transition-transform"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12">
                                        <p class="text-gray-500">No published issues yet. Check back soon!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="mt-8 text-center">
                            <a href="{{ route('issues') }}" class="inline-flex items-center px-6 py-3 bg-[#86662c] text-white rounded-xl hover:bg-[#6b4f23] transition-all duration-300 shadow-lg hover:shadow-xl group">
                                <span>View All Issues</span>
                                <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Right Column - Submission Process (Static) -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-12 h-12 bg-[#86662c] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-[#86662c]/20">
                                <i class="fa-regular fa-pen-to-square text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">Submission Process</h3>
                                <p class="text-gray-600">Three simple steps to publish your research</p>
                            </div>
                        </div>

                        <!-- Process Steps as Interactive Cards (Static) -->
                        <div class="space-y-4">
                            <!-- Step 1 -->
                            <div class="group bg-white rounded-2xl p-6 border border-gray-200 hover:border-[#86662c] hover:shadow-xl transition-all duration-300">
                                <div class="flex items-start gap-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 bg-[#86662c] text-white rounded-xl flex items-center justify-center font-bold text-lg group-hover:scale-110 transition-transform duration-300">1</div>
                                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-lg font-bold text-gray-800">Register / Login</h4>
                                            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                                                <i class="fa-regular fa-clock mr-1"></i>5 min
                                            </span>
                                        </div>
                                        <p class="text-gray-600 mb-3">Create your author account or login to access the submission portal.</p>
                                        <div class="flex items-center gap-3 text-sm">
                                            <span class="text-gray-500">
                                                <i class="fa-regular fa-circle-check text-green-500 mr-1"></i>Free registration
                                            </span>
                                            <span class="text-gray-500">
                                                <i class="fa-regular fa-lock-keyhole mr-1"></i>Secure
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="group bg-white rounded-2xl p-6 border border-gray-200 hover:border-[#86662c] hover:shadow-xl transition-all duration-300">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-gray-200 text-gray-600 rounded-xl flex items-center justify-center font-bold text-lg group-hover:bg-[#86662c] group-hover:text-white transition-all duration-300">2</div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-lg font-bold text-gray-800">Submit Manuscript</h4>
                                            <span class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded-full">
                                                <i class="fa-regular fa-id-card mr-1"></i>Tracking ID
                                            </span>
                                        </div>
                                        <p class="text-gray-600 mb-3">Upload your manuscript and supporting documents through our secure system.</p>
                                        <div class="flex items-center gap-3 text-sm">
                                            <span class="text-gray-500">
                                                <i class="fa-regular fa-file-pdf text-red-500 mr-1"></i>PDF, DOCX
                                            </span>
                                            <span class="text-gray-500">
                                                <i class="fa-solid fa-cloud-arrow-up mr-1"></i>Up to 10MB
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="group bg-white rounded-2xl p-6 border border-gray-200 hover:border-[#86662c] hover:shadow-xl transition-all duration-300">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-gray-200 text-gray-600 rounded-xl flex items-center justify-center font-bold text-lg group-hover:bg-[#86662c] group-hover:text-white transition-all duration-300">3</div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-lg font-bold text-gray-800">Track Progress</h4>
                                            <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">
                                                <i class="fa-solid fa-chart-line mr-1"></i>Real-time
                                            </span>
                                        </div>
                                        <p class="text-gray-600 mb-3">Monitor your manuscript status through the peer review process.</p>
                                        <div class="flex items-center gap-3 text-sm">
                                            <span class="text-gray-500">
                                                <i class="fa-regular fa-bell mr-1"></i>Email notifications
                                            </span>
                                            <span class="text-gray-500">
                                                <i class="fa-regular fa-clock mr-1"></i>2-4 weeks review
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-8 bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-6 text-white">
                            <h4 class="text-lg font-bold mb-2">Ready to get started?</h4>
                            <p class="text-white/90 text-sm mb-4">Join thousands of researchers who have published with us</p>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('register') }}" class="flex-1 px-4 py-3 bg-white text-[#86662c] rounded-xl hover:bg-gray-100 transition-colors text-center font-medium inline-flex items-center justify-center gap-2">
                                    Register Now
                                </a>
                                <a href="{{ route('login') }}" class="flex-1 px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/30 text-white rounded-xl hover:bg-white/20 transition-colors text-center font-medium inline-flex items-center justify-center gap-2">
                                    Login
                                </a>
                            </div>
                            <p class="text-xs text-white/70 text-center mt-3">
                                <i class="fa-regular fa-circle-check mr-1"></i>
                                No submission fees • Instant tracking ID • Secure platform
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-[#86662c] py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Ready to submit your research?</h2>
            <p class="text-white/90 mb-8 max-w-2xl mx-auto">Join our community of researchers and contribute to advancing medical and surgical knowledge.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('author.index') }}" class="px-6 py-3 bg-white text-[#86662c] rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Submit Manuscript
                </a>
                <a href="{{ route('register', ['role' => 'reviewer']) }}" class="px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/30 text-white rounded-lg font-semibold hover:bg-white/20 transition-colors">
                    Become a Reviewer
                </a>
            </div>
        </div>
    </div>
@endsection