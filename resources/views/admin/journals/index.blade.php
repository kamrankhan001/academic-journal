@extends('layouts.admin')

@section('title', 'Journals Management - Admin')
@section('page-title', 'Journals Management')

@section('content')
    <!-- Stats Cards - Now in a single row with flex-wrap for mobile -->
    <div class="flex flex-wrap gap-4 mb-6">
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Total</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Under Review</p>
            <p class="text-2xl font-bold text-purple-600">{{ $stats['under_review'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Published</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['published'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Revision</p>
            <p class="text-2xl font-bold text-orange-600">{{ $stats['revision_required'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Rejected</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.journals.index') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-50">
                <input type="text" 
                       name="search" 
                       placeholder="Search by title or author..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
            </div>
            <div class="w-48">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="all">All Status</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Pending</option>
                    <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="revision_required" {{ request('status') == 'revision_required' ? 'selected' : '' }}>Revision Required</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                <i class="fa-solid fa-filter mr-2"></i>
                Filter
            </button>
            <a href="{{ route('admin.journals.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                Clear
            </a>
        </form>
    </div>

    <!-- Journals Table -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volume/Issue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($journals as $journal)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-600">#{{ $journal->id }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-800">{{ Str::limit($journal->title, 50) }}</div>
                                @if($journal->tags->count() > 0)
                                    <div class="flex gap-1 mt-1">
                                        @foreach($journal->tags->take(2) as $tag)
                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $tag->name }}</span>
                                        @endforeach
                                        @if($journal->tags->count() > 2)
                                            <span class="text-xs text-gray-400">+{{ $journal->tags->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800">{{ $journal->author->name }}</div>
                                <div class="text-xs text-gray-500">{{ $journal->author->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'draft' => 'bg-gray-100 text-gray-700',
                                        'submitted' => 'bg-yellow-100 text-yellow-700',
                                        'under_review' => 'bg-purple-100 text-purple-700',
                                        'published' => 'bg-green-100 text-green-700',
                                        'revision_required' => 'bg-orange-100 text-orange-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusColor = $statusColors[$journal->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-3 py-1 text-xs rounded-full {{ $statusColor }}">
                                    {{ str_replace('_', ' ', ucfirst($journal->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($journal->volume && $journal->issue)
                                    <div class="text-sm text-gray-800">Vol {{ $journal->volume->volume_number }}, Iss {{ $journal->issue->issue_number }}</div>
                                    <div class="text-xs text-gray-500">{{ $journal->volume->year }}</div>
                                @else
                                    <span class="text-xs text-gray-400">Not assigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $journal->created_at->format('M d, Y') }}
                                <div class="text-xs">{{ $journal->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.journals.show', $journal->id) }}" 
                                       class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                       title="View">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.journals.edit', $journal->id) }}" 
                                       class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                       title="Edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <button onclick="deleteJournal({{ $journal->id }})" 
                                            class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Delete">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-regular fa-file-lines text-5xl text-gray-300 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-700 mb-1">No Journals Found</h3>
                                    <p class="text-sm text-gray-500">No journals match your criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($journals->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $journals->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function deleteJournal(id) {
        if (confirm('Are you sure you want to delete this journal? This action cannot be undone.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/journals') }}/${id}`;
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