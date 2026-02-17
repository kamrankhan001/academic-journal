@extends('layouts.admin')

@section('title', $issue->title . ' - Issue Details')
@section('page-title', 'Issue Details')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.issues.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Issues</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Issue {{ $issue->issue_number }}</li>
@endsection

@section('content')
    <div class="w-full space-y-6">
        <!-- Header Actions -->
        <div class="flex justify-end items-center space-x-3">
            <a href="{{ route('admin.issues.edit', $issue) }}" 
               class="px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                <i class="fa-regular fa-pen-to-square mr-2"></i>
                Edit Issue
            </a>
            @if($issue->status !== 'published')
                <form action="{{ route('admin.issues.publish', $issue) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                            onclick="return confirm('Are you sure you want to publish this issue?')">
                        <i class="fa-regular fa-circle-check mr-2"></i>
                        Publish Issue
                    </button>
                </form>
            @endif
        </div>

        <!-- Issue Info Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Main Info Card -->
            <div class="lg:col-span-3 bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Issue Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-start space-x-6">
                        <!-- Cover Image -->
                        <div class="shrink-0 w-48">
                            @if($issue->cover_image)
                                <img src="{{ $issue->cover_image_url }}" 
                                     alt="{{ $issue->title }}"
                                     class="w-full rounded-lg shadow-md">
                            @else
                                <div class="w-full aspect-3/4 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <i class="fa-regular fa-newspaper text-gray-300 text-5xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Details -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $issue->title }}</h1>
                                <div class="flex items-center space-x-2 flex-wrap gap-2">
                                    <span class="px-3 py-1 text-xs rounded-full bg-[#86662c]/10 text-[#86662c] font-medium">
                                        Volume {{ $issue->volume->volume_number }} / Issue {{ $issue->issue_number }}
                                    </span>
                                    {!! $issue->type_badge !!}
                                    {!! $issue->status_badge !!}
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Volume</p>
                                    <p class="text-base font-medium text-gray-800">
                                        <a href="{{ route('admin.volumes.show', $issue->volume) }}" class="text-[#86662c] hover:underline">
                                            {{ $issue->volume->title }}
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Publication Date</p>
                                    <p class="text-base font-medium text-gray-800">
                                        {{ $issue->publication_date ? $issue->publication_date->format('F d, Y') : 'Not set' }}
                                    </p>
                                </div>
                                @if($issue->published_at)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Published On</p>
                                    <p class="text-base font-medium text-gray-800">{{ $issue->published_at->format('F d, Y') }}</p>
                                </div>
                                @endif
                            </div>

                            @if($issue->description)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Description</p>
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $issue->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="lg:col-span-1 bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Statistics</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <p class="text-3xl font-bold text-blue-600">{{ $issue->journals_count }}</p>
                        <p class="text-sm text-gray-600">Published Articles</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-3xl font-bold text-green-600">
                            {{ $issue->journals->sum('views_count') }}
                        </p>
                        <p class="text-sm text-gray-600">Total Views</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles List -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Articles in this Issue</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Article</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pages</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Published</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($issue->journals as $journal)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-800">{{ $journal->title }}</p>
                                    <p class="text-xs text-gray-500">{{ Str::limit($journal->abstract, 100) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-800">{{ $journal->author->name }}</p>
                                    @if($journal->coAuthors->count() > 0)
                                        <p class="text-xs text-gray-500">+{{ $journal->coAuthors->count() }} co-authors</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    @if($journal->page_start && $journal->page_end)
                                        {{ $journal->page_start }} - {{ $journal->page_end }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $journal->views_count }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $journal->published_at ? $journal->published_at->format('M d, Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.journals.show', $journal) }}" 
                                       class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                       title="View Article">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-regular fa-file-lines text-gray-300 text-4xl mb-4"></i>
                                        <p class="text-gray-500 mb-2">No articles published in this issue yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection