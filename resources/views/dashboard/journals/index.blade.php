@extends('layouts.dashboard')

@section('title', 'My Journals - Academic Journal')
@section('page-title', 'My Journals')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    <span class="text-gray-600">My Journals</span>
@endsection

@section('content')
    <!-- Add New Journal Button -->
    <div class="mb-6 flex justify-end">
        <a href="{{ route('author.journals.create') }}" class="inline-flex items-center px-4 py-2 bg-[#86662c] text-white rounded-lg text-sm font-medium hover:bg-[#6b4f23] transition-colors">
            <i class="fa-solid fa-plus mr-2"></i>
            Submit New Journal
        </a>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('author.journals.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by journal title..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
            </div>
            <div class="md:w-48">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="md:w-48">
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="">Sort By</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                Apply Filters
            </button>
        </form>
    </div>

    <!-- Submissions Table -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        @if($journals->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left py-4 px-6 text-xs font-medium text-gray-500 uppercase">Journal Title</th>
                            <th class="text-left py-4 px-6 text-xs font-medium text-gray-500 uppercase">Submission Date</th>
                            <th class="text-left py-4 px-6 text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="text-left py-4 px-6 text-xs font-medium text-gray-500 uppercase">Last Updated</th>
                            <th class="text-left py-4 px-6 text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($journals as $journal)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $journal->title }}</p>
                                        @if($journal->coAuthors->count() > 0)
                                            <p class="text-xs text-gray-500 mt-1">
                                                Co-authors: {{ $journal->coAuthors->pluck('name')->implode(', ') }}
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-600">{{ $journal->created_at->format('M d, Y') }}</td>
                                <td class="py-4 px-6">
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
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-600">{{ $journal->updated_at->format('M d, Y') }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('author.journals.show', $journal) }}" class="text-gray-400 hover:text-[#86662c] transition-colors" title="View">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        @if($journal->status == 'draft')
                                            <a href="{{ route('author.journals.edit', $journal) }}" class="text-gray-400 hover:text-[#86662c] transition-colors" title="Edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('author.journals.destroy', $journal) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this journal? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Delete">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        Showing {{ $journals->firstItem() }} to {{ $journals->lastItem() }} of {{ $journals->total() }} entries
                    </p>
                    <div class="flex items-center space-x-2">
                        {{ $journals->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-regular fa-file-lines text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">No submissions yet</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">You haven't submitted any journals yet. Start sharing your research with the academic community.</p>
                <a href="{{ route('author.journals.create') }}" class="inline-flex items-center px-4 py-2 bg-[#86662c] text-white rounded-lg text-sm font-medium hover:bg-[#6b4f23] transition-colors">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Submit Your First Journal
                </a>
            </div>
        @endif
    </div>
@endsection