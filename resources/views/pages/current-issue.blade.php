@extends('layouts.guest')

@section('title', 'Current Issue - Academic Journal')

@section('content')
    <!-- Breadcrumbs -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="/" class="hover:text-[#86662c]">Home</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800">Current Issue</span>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="bg-white rounded-lg border border-gray-200 p-8 mb-6">
            <div class="text-center mb-8">
                <span class="inline-block px-4 py-1 bg-green-100 text-green-700 text-sm rounded-full mb-3">
                    <i class="fa-solid fa-fire mr-1"></i> Current Issue
                </span>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                    Volume {{ $currentIssue->volume->volume_number }}, Issue {{ $currentIssue->issue_number }}
                </h1>
                <p class="text-lg text-gray-600">{{ $currentIssue->title }}</p>
                <p class="text-sm text-gray-500 mt-2">
                    <i class="fa-regular fa-calendar mr-1"></i>
                    Published: {{ $currentIssue->publication_date->format('F d, Y') }}
                </p>
            </div>

            @if($currentIssue->description)
                <div class="max-w-3xl mx-auto text-center text-gray-600 mb-8 p-4 bg-gray-50 rounded-lg">
                    {{ $currentIssue->description }}
                </div>
            @endif

            <div class="border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Articles in this Issue</h2>
                
                <div class="space-y-6">
                    @foreach($currentIssue->journals as $index => $journal)
                        <article class="pb-6 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-[#86662c] rounded-full flex items-center justify-center shrink-0 text-white font-bold">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2 hover:text-[#86662c]">
                                        <a href="{{ route('journal.show', $journal->slug) }}">{{ $journal->title }}</a>
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $journal->author->name }} et al.</p>
                                    <p class="text-gray-600 mb-3">{{ Str::limit($journal->abstract, 200) }}</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2">
                                            @foreach($journal->tags->take(3) as $tag)
                                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                        <a href="{{ route('journal.show', $journal->slug) }}" 
                                           class="text-[#86662c] hover:text-[#6b4f23] text-sm font-medium">
                                            Read More <i class="fa-solid fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection