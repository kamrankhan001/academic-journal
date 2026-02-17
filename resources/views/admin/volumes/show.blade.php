@extends('layouts.admin')

@section('title', $volume->title . ' - Volume Details')
@section('page-title', 'Volume Details')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.volumes.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Volumes</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Volume {{ $volume->volume_number }}</li>
@endsection

@section('content')
    <div class="w-full space-y-6">
        <!-- Header Actions -->
        <div class="flex justify-end items-center space-x-3">
            <a href="{{ route('admin.volumes.edit', $volume) }}" 
               class="px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                <i class="fa-regular fa-pen-to-square mr-2"></i>
                Edit Volume
            </a>
            @if($volume->status !== 'published')
                <form action="{{ route('admin.volumes.publish', $volume) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                            onclick="return confirm('Are you sure you want to publish this volume?')">
                        <i class="fa-regular fa-circle-check mr-2"></i>
                        Publish Volume
                    </button>
                </form>
            @endif
        </div>

        <!-- Volume Info Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Main Info Card -->
            <div class="lg:col-span-3 bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Volume Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-start space-x-6">
                        <!-- Cover Image -->
                        <div class="shrink-0 w-48">
                            @if($volume->cover_image)
                                <img src="{{ $volume->cover_image_url }}" 
                                     alt="{{ $volume->title }}"
                                     class="w-full rounded-lg shadow-md">
                            @else
                                <div class="w-full aspect-3/4 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-book-open text-gray-300 text-5xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Details -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $volume->title }}</h1>
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1 text-xs rounded-full bg-[#86662c]/10 text-[#86662c] font-medium">
                                        Volume {{ $volume->volume_number }}
                                    </span>
                                    {!! $volume->status_badge !!}
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Year</p>
                                    <p class="text-base font-medium text-gray-800">{{ $volume->year }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Published Date</p>
                                    <p class="text-base font-medium text-gray-800">
                                        {{ $volume->published_at ? $volume->published_at->format('F d, Y') : 'Not published yet' }}
                                    </p>
                                </div>
                            </div>

                            @if($volume->description)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Description</p>
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $volume->description }}</p>
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
                        <p class="text-3xl font-bold text-blue-600">{{ $volume->issues_count }}</p>
                        <p class="text-sm text-gray-600">Total Issues</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-3xl font-bold text-green-600">{{ $volume->journals_count }}</p>
                        <p class="text-sm text-gray-600">Published Articles</p>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <p class="text-3xl font-bold text-purple-600">
                            {{ $volume->issues->where('status', 'published')->count() }}
                        </p>
                        <p class="text-sm text-gray-600">Published Issues</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Issues List -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Issues in this Volume</h3>
                <a href="{{ route('admin.issues.create', ['volume_id' => $volume->id]) }}" 
                   class="px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors text-sm">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Add New Issue
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Issue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Articles</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Publication Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($volume->issues as $issue)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        @if($issue->cover_image)
                                            <div class="shrink-0 w-10 h-10 rounded-lg overflow-hidden">
                                                <img src="{{ $issue->cover_image_url }}" 
                                                     alt="{{ $issue->title }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="shrink-0 w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                                <i class="fa-regular fa-file-lines text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $issue->title }}</p>
                                            <p class="text-xs text-gray-500">{{ Str::limit($issue->description, 50) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800">Issue {{ $issue->issue_number }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($issue->issue_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($issue->status === 'published')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Published</span>
                                    @elseif($issue->status === 'in_progress')
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Planned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $issue->journals_count }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $issue->publication_date ? $issue->publication_date->format('M d, Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.issues.show', $issue) }}" 
                                           class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                           title="View">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.issues.edit', $issue) }}" 
                                           class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                           title="Edit">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-regular fa-file-lines text-gray-300 text-4xl mb-4"></i>
                                        <p class="text-gray-500 mb-2">No issues found in this volume</p>
                                        <a href="{{ route('admin.issues.create', ['volume_id' => $volume->id]) }}" 
                                           class="text-sm text-[#86662c] hover:text-[#6b4f23]">
                                            Create your first issue
                                        </a>
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