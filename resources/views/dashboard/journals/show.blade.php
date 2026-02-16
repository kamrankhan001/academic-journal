@extends('layouts.dashboard')

@section('title', $journal->title . ' - Academic Journal')
@section('page-title', 'Journal Details')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    <span class="text-gray-600">Journals</span>
    <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    <span class="text-gray-800">View</span>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
            @if($journal->status == 'draft')
                <a href="{{ route('author.journals.edit', $journal) }}" class="px-4 py-2 bg-[#86662c] text-white rounded-lg text-sm font-medium hover:bg-[#6b4f23] transition-colors">
                    <i class="fa-regular fa-pen-to-square mr-2"></i>
                    Edit Journal
                </a>
                <form action="{{ route('author.journals.submit', $journal) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors" onclick="return confirm('Submit this journal for review?')">
                        <i class="fa-regular fa-paper-plane mr-2"></i>
                        Submit for Review
                    </button>
                </form>
            @endif
            <a href="{{ route('author.journals.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>

        <!-- Status Bar -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-500">Status:</span>
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
                    <span class="px-3 py-1 {{ $color }} text-xs font-medium rounded-full">
                        {{ ucfirst(str_replace('_', ' ', $journal->status)) }}
                    </span>
                </div>
                <div class="flex items-center space-x-6 text-sm">
                    <div>
                        <span class="text-gray-500">Views:</span>
                        <span class="ml-1 font-medium text-gray-800">{{ $journal->views_count }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Submitted:</span>
                        <span class="ml-1 font-medium text-gray-800">{{ $journal->submitted_at ? $journal->submitted_at->format('M d, Y') : 'Not submitted' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Journal Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title and Abstract -->
                <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $journal->title }}</h1>
                    
                    @if($journal->abstract)
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">Abstract</h2>
                            <div class="prose max-w-none">
                                <p class="text-gray-600">{{ $journal->abstract }}</p>
                            </div>
                        </div>
                    @endif

                    @if($journal->content)
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">Content</h2>
                            <div class="prose max-w-none bg-gray-50 p-4 rounded-lg border border-gray-200">
                                {!! $journal->content !!}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Tags -->
                @if($journal->tags->count() > 0)
                    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">Tags</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($journal->tags as $tag)
                                <span class="px-3 py-1 bg-[#86662c]/10 text-[#86662c] text-xs rounded-full">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Metadata and Files -->
            <div class="space-y-6">
                <!-- Authors Card -->
                <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Authors</h2>
                    
                    <!-- Main Author -->
                    <div class="mb-4 pb-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($journal->author->name) }}&background=86662c&color=fff&size=40" 
                                 class="w-10 h-10 rounded-full"
                                 alt="{{ $journal->author->name }}">
                            <div>
                                <p class="font-medium text-gray-800">{{ $journal->author->name }}</p>
                                <p class="text-xs text-gray-500">Main Author • {{ $journal->author->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Co-Authors -->
                    @if($journal->coAuthors->count() > 0)
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Co-Authors</h3>
                        <div class="space-y-3">
                            @foreach($journal->coAuthors as $coAuthor)
                                <div class="flex items-start space-x-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($coAuthor->name) }}&background=6b4f23&color=fff&size=32" 
                                         class="w-8 h-8 rounded-full"
                                         alt="{{ $coAuthor->name }}">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $coAuthor->name }}</p>
                                        @if($coAuthor->email)
                                            <p class="text-xs text-gray-500">{{ $coAuthor->email }}</p>
                                        @endif
                                        @if($coAuthor->institution)
                                            <p class="text-xs text-gray-500">{{ $coAuthor->institution }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Files Card -->
                @if($journal->files->count() > 0)
                    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Files</h2>
                        
                        @php
                            $manuscript = $journal->manuscript;
                            $coverImage = $journal->coverImage;
                            $supplementary = $journal->supplementaryFiles;
                        @endphp

                        @if($manuscript)
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Manuscript</h3>
                                <a href="{{ asset('storage/'.$manuscript->file_path) }}" target="_blank" 
                                   class="flex items-center justify-between p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <i class="fa-regular fa-file-pdf text-red-600 text-xl"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $manuscript->original_name }}</p>
                                            <p class="text-xs text-gray-500">{{ round($manuscript->file_size / 1024, 2) }} KB</p>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-download text-gray-400"></i>
                                </a>
                            </div>
                        @endif

                        @if($coverImage)
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Cover Image</h3>
                                <div class="relative group">
                                    <img src="{{ asset('storage/'.$coverImage->file_path) }}" 
                                         alt="Cover Image" 
                                         class="w-full h-32 object-cover rounded-lg">
                                    <a href="{{ asset('storage/'.$coverImage->file_path) }}" target="_blank"
                                       class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white rounded-lg">
                                        <i class="fa-regular fa-eye mr-2"></i> View Full Size
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($supplementary->count() > 0)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Supplementary Files</h3>
                                <div class="space-y-2">
                                    @foreach($supplementary as $file)
                                        <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank"
                                           class="flex items-center justify-between p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                            <div class="flex items-center space-x-3">
                                                <i class="fa-regular fa-file text-gray-500"></i>
                                                <div>
                                                    <p class="text-sm text-gray-700">{{ $file->original_name }}</p>
                                                    <p class="text-xs text-gray-500">{{ round($file->file_size / 1024, 2) }} KB</p>
                                                </div>
                                            </div>
                                            <i class="fa-solid fa-download text-xs text-gray-400"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Dates Card -->
                <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Timeline</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Created:</span>
                            <span class="text-gray-800 font-medium">{{ $journal->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Last Updated:</span>
                            <span class="text-gray-800 font-medium">{{ $journal->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        @if($journal->submitted_at)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Submitted:</span>
                                <span class="text-gray-800 font-medium">{{ $journal->submitted_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif
                        @if($journal->published_at)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Published:</span>
                                <span class="text-gray-800 font-medium">{{ $journal->published_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection