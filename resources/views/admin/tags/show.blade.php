@extends('layouts.admin')

@section('title', 'View Tag - Admin')
@section('page-title', 'View Tag Details')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.tags.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Tags</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">View</li>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Tag Info -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-[#86662c] bg-opacity-10 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-tag text-[#86662c] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $tag->name }}</h3>
                            <code class="text-sm text-gray-500">{{ $tag->slug }}</code>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.tags.edit', $tag->id) }}" 
                           class="px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                            <i class="fa-regular fa-pen-to-square mr-2"></i>
                            Edit Tag
                        </a>
                        <button onclick="deleteTag({{ $tag->id }}, '{{ $tag->name }}')" 
                                class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                            <i class="fa-regular fa-trash-can mr-2"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Journals</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $tag->journals_count }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Created</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $tag->created_at->format('F d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $tag->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Last Updated</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $tag->updated_at->format('F d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $tag->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Journals with this Tag -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Recent Journals with this Tag</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($tag->journals as $journal)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-800">{{ Str::limit($journal->title, 50) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-800">{{ $journal->author->name }}</div>
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
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $journal->published_at ? $journal->published_at->format('M d, Y') : 'Not published' }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.journals.show', $journal->id) }}" 
                                       class="text-[#86662c] hover:text-[#6b4f23] text-sm font-medium">
                                        View Journal
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    No journals found with this tag.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($tag->journals_count > 10)
                <div class="px-6 py-4 border-t border-gray-200">
                    <a href="{{ route('admin.journals.index', ['tag' => $tag->id]) }}" 
                       class="text-[#86662c] hover:text-[#6b4f23] text-sm font-medium">
                        View all {{ $tag->journals_count }} journals →
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function deleteTag(id, name) {
        if (confirm('Are you sure you want to delete the tag "' + name + '"? This action cannot be undone.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/tags') }}/${id}`;
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