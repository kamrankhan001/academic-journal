@extends('layouts.admin')

@section('title', 'Issues Management - Admin')
@section('page-title', 'Issues Management')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Issues</li>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="flex flex-wrap gap-4 mb-6">
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Total Issues</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Published</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['published'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">In Progress</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['in_progress'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Planned</p>
            <p class="text-2xl font-bold text-gray-600">{{ $stats['planned'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Special Issues</p>
            <p class="text-2xl font-bold text-purple-600">{{ $stats['special_issues'] }}</p>
        </div>
    </div>

    <!-- Header with Create Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manage Issues</h2>
            <p class="text-sm text-gray-500 mt-1">Create and manage journal issues</p>
        </div>
        <a href="{{ route('admin.issues.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors shadow-soft">
            <i class="fa-solid fa-plus mr-2"></i>
            Create New Issue
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.issues.index') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-50">
                <input type="text" 
                       name="search" 
                       placeholder="Search by title or issue number..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
            </div>
            <div class="w-48">
                <select name="volume_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="">All Volumes</option>
                    @foreach($volumes as $volume)
                        <option value="{{ $volume->id }}" {{ request('volume_id') == $volume->id ? 'selected' : '' }}>
                            Volume {{ $volume->volume_number }} ({{ $volume->title }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-40">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="all">All Status</option>
                    <option value="planned" {{ request('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="w-40">
                <select name="issue_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="all">All Types</option>
                    <option value="regular" {{ request('issue_type') == 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="special" {{ request('issue_type') == 'special' ? 'selected' : '' }}>Special</option>
                    <option value="supplement" {{ request('issue_type') == 'supplement' ? 'selected' : '' }}>Supplement</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                <i class="fa-solid fa-filter mr-2"></i>
                Filter
            </button>
            <a href="{{ route('admin.issues.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                Clear
            </a>
        </form>
    </div>

    <!-- Issues Table -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Issue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Volume</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Articles</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Publication Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($issues as $issue)
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
                                            <i class="fa-regular fa-newspaper text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $issue->title }}</p>
                                        <p class="text-xs text-gray-500">Issue {{ $issue->issue_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-800">Volume {{ $issue->volume->volume_number }}</p>
                                <p class="text-xs text-gray-500">{{ $issue->volume->year }}</p>
                            </td>
                            <td class="px-6 py-4">{!! $issue->type_badge !!}</td>
                            <td class="px-6 py-4">{!! $issue->status_badge !!}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $issue->journals_count }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if($issue->publication_date)
                                    {{ $issue->publication_date->format('M d, Y') }}
                                @else
                                    -
                                @endif
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
                                    @if($issue->status !== 'published')
                                        <button onclick="publishIssue({{ $issue->id }}, '{{ $issue->title }}')" 
                                                class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                                title="Publish">
                                            <i class="fa-regular fa-circle-check"></i>
                                        </button>
                                    @endif
                                    @if($issue->journals_count === 0)
                                        <button onclick="deleteIssue({{ $issue->id }}, '{{ $issue->title }}')" 
                                                class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-regular fa-newspaper text-5xl text-gray-300 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-700 mb-1">No Issues Found</h3>
                                    <p class="text-sm text-gray-500 mb-4">Get started by creating your first issue.</p>
                                    <a href="{{ route('admin.issues.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                                        <i class="fa-solid fa-plus mr-2"></i>
                                        Create First Issue
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($issues->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $issues->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function publishIssue(id, title) {
        if (confirm('Are you sure you want to publish the issue "' + title + '"?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/issues') }}/${id}/publish`;
            form.innerHTML = `@csrf`;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function deleteIssue(id, title) {
        if (confirm('Are you sure you want to delete the issue "' + title + '"?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/issues') }}/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush