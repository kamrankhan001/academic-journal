@extends('layouts.admin')

@section('title', 'Journal Details - Admin')
@section('page-title', 'Journal Details')

@section('content')
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $journal->title }}</h1>
                    <div class="flex items-center mt-2 space-x-4">
                        <span class="text-sm text-gray-500">
                            <i class="fa-regular fa-user mr-1"></i>
                            {{ $journal->author->name }}
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fa-regular fa-calendar mr-1"></i>
                            Submitted: {{ $journal->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
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
                    <span class="px-4 py-2 text-sm rounded-full {{ $statusColor }}">
                        {{ str_replace('_', ' ', ucfirst($journal->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <div class="flex flex-wrap items-center gap-3">
                @if($journal->status == 'submitted')
                    <form action="{{ route('admin.journals.under-review', $journal->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fa-regular fa-eye mr-2"></i>
                            Move to Under Review
                        </button>
                    </form>
                    
                    <button onclick="showRevisionModal()" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                        <i class="fa-regular fa-pen-to-square mr-2"></i>
                        Request Revision
                    </button>
                    
                    <button onclick="showRejectModal()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fa-regular fa-circle-xmark mr-2"></i>
                        Reject
                    </button>
                @endif

                @if($journal->status == 'under_review')
                    <form action="{{ route('admin.journals.approve', $journal->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fa-regular fa-circle-check mr-2"></i>
                            Approve & Publish
                        </button>
                    </form>
                    
                    <button onclick="showRevisionModal()" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                        <i class="fa-regular fa-pen-to-square mr-2"></i>
                        Request Revision
                    </button>
                @endif

                @if($journal->status == 'revision_required')
                    <form action="{{ route('admin.journals.under-review', $journal->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fa-regular fa-eye mr-2"></i>
                            Move to Under Review
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.journals.edit', $journal->id) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fa-regular fa-pen-to-square mr-2"></i>
                    Edit Journal
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Abstract -->
            @if($journal->abstract)
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Abstract</h2>
                    <p class="text-gray-600">{{ $journal->abstract }}</p>
                </div>
            @endif

            <!-- Full Content -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Content</h2>
                <div class="prose max-w-none">
                    {!! $journal->content !!}
                </div>
            </div>

            <!-- Tags -->
            @if($journal->tags->count() > 0)
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Tags</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($journal->tags as $tag)
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Co-Authors -->
            @if($journal->coAuthors->count() > 0)
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Co-Authors</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($journal->coAuthors as $coAuthor)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="font-medium text-gray-800">{{ $coAuthor->name }}</p>
                                @if($coAuthor->email)
                                    <p class="text-sm text-gray-500">{{ $coAuthor->email }}</p>
                                @endif
                                @if($coAuthor->institution)
                                    <p class="text-sm text-gray-500">{{ $coAuthor->institution }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Files -->
            @if($journal->files->count() > 0)
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Files</h2>
                    <div class="space-y-2">
                        @foreach($journal->files as $file)
                            <a href="{{ Storage::url($file->file_path) }}" 
                               target="_blank"
                               class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-3">
                                    @if($file->file_type == 'manuscript')
                                        <i class="fa-regular fa-file-pdf text-red-500 text-xl"></i>
                                    @elseif($file->file_type == 'cover_image')
                                        <i class="fa-regular fa-image text-blue-500 text-xl"></i>
                                    @else
                                        <i class="fa-regular fa-file text-gray-500 text-xl"></i>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $file->original_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $file->size_for_humans }}</p>
                                    </div>
                                </div>
                                <span class="text-xs px-2 py-1 bg-white rounded-full text-gray-600">
                                    {{ str_replace('_', ' ', ucfirst($file->file_type)) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Revision Modal -->
    <div id="revisionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Request Revision</h3>
                <form action="{{ route('admin.journals.request-revision', $journal->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Revision Comments</label>
                        <textarea name="comments" rows="5" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                  placeholder="Please provide detailed feedback for the author..."
                                  required></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideRevisionModal()" 
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                            Send Revision Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Reject Journal</h3>
                <form action="{{ route('admin.journals.reject', $journal->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason</label>
                        <textarea name="reason" rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                  placeholder="Please provide the reason for rejection..."
                                  required></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideRejectModal()" 
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Reject Journal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function showRevisionModal() {
        document.getElementById('revisionModal').classList.remove('hidden');
        document.getElementById('revisionModal').classList.add('flex');
    }
    
    function hideRevisionModal() {
        document.getElementById('revisionModal').classList.add('hidden');
        document.getElementById('revisionModal').classList.remove('flex');
    }
    
    function showRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }
    
    function hideRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }
    
    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        const revisionModal = document.getElementById('revisionModal');
        const rejectModal = document.getElementById('rejectModal');
        
        if (event.target === revisionModal) {
            hideRevisionModal();
        }
        if (event.target === rejectModal) {
            hideRejectModal();
        }
    });
</script>
@endpush