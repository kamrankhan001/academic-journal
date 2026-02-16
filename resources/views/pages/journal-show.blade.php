@extends('layouts.guest')

@section('title', $journal->title . ' - Academic Journal')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <div class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
            <a href="/" class="hover:text-[#86662c]">Home</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <a href="{{ route('home') }}" class="hover:text-[#86662c]">Journals</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800">{{ Str::limit($journal->title, 50) }}</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <article class="bg-white rounded-lg border border-gray-200 p-8">
                    <!-- Journal Header -->
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-sm text-gray-500">
                                <i class="fa-regular fa-calendar mr-1"></i>
                                Published: {{ $journal->published_at->format('F d, Y') }}
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="fa-regular fa-clock mr-1"></i>
                                {{ ceil(str_word_count(strip_tags($journal->content)) / 200) }} min read
                            </span>
                        </div>

                        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $journal->title }}</h1>

                        <!-- Authors -->
                        <div class="flex items-center mb-4">
                            <div class="flex -space-x-2 mr-3">
                                <img src="{{ $journal->author->profile && $journal->author->profile->avatar ? asset('storage/' . $journal->author->profile->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($journal->author->name) . '&background=86662c&color=fff&size=40' }}"
                                    class="w-10 h-10 rounded-full border-2 border-white object-cover">
                                @foreach($journal->coAuthors as $coAuthor)
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($coAuthor->name) }}&background=86662c&color=fff&size=40"
                                        class="w-10 h-10 rounded-full border-2 border-white">
                                @endforeach
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $journal->author->name }}</p>
                                @if($journal->coAuthors->count() > 0)
                                    <p class="text-xs text-gray-500">with
                                        {{ $journal->coAuthors->pluck('name')->implode(', ') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2">
                            @foreach($journal->tags as $tag)
                                <a href="{{ route('home', ['tag_slug' => $tag->slug]) }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full hover:bg-[#86662c] hover:text-white transition-colors">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Abstract -->
                    @if($journal->abstract)
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">Abstract</h2>
                            <p class="text-gray-700">{{ $journal->abstract }}</p>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="prose max-w-none mb-8">
                        {!! $journal->content !!}
                    </div>

                    <!-- Metrics -->
                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                            <span><i class="fa-regular fa-eye mr-2"></i>{{ number_format($journal->views_count) }}
                                views</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <aside class="lg:w-1/3">
                <!-- Cover Image in Sidebar -->
                @if($journal->coverImage)
                    <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Cover Image</h3>
                        <div class="relative rounded-lg overflow-hidden border border-gray-200">
                            <img src="{{ $journal->coverImage->url }}" 
                                 alt="{{ $journal->title }} - Cover Image"
                                 class="w-full h-auto object-cover">
                            <a href="{{ $journal->coverImage->url }}" 
                               target="_blank"
                               class="absolute top-2 right-2 bg-white/90 hover:bg-white text-gray-700 hover:text-[#86662c] p-2 rounded-full shadow-md transition-colors"
                               title="View full image">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fa-regular fa-image mr-1"></i>
                            {{ $journal->coverImage->original_name }} ({{ $journal->coverImage->size_for_humans }})
                        </p>
                    </div>
                @endif

                <!-- Manuscript PDF in Sidebar -->
                @if($journal->manuscript)
                    <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Manuscript PDF</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <i class="fa-regular fa-file-pdf text-red-500 text-2xl"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $journal->manuscript->original_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $journal->manuscript->size_for_humans }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="{{ $journal->manuscript->url }}" 
                               target="_blank"
                               class="w-full inline-block text-center px-4 py-2 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-50 transition-colors">
                               Download PDF
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Supplementary Files in Sidebar -->
                @if($journal->files->where('file_type', '!=', 'manuscript')->where('file_type', '!=', 'cover_image')->count() > 0)
                    <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Supplementary Files</h3>
                        <div class="space-y-3">
                            @foreach($journal->files->where('file_type', '!=', 'manuscript')->where('file_type', '!=', 'cover_image') as $file)
                                <div class="bg-gray-50 rounded-lg p-3 hover:bg-gray-100 transition-colors">
                                    <a href="{{ $file->url }}" target="_blank" class="block">
                                        <div class="flex items-start space-x-3">
                                            @php
                                                $icon = 'fa-regular fa-file';
                                                $iconColor = 'text-gray-500';
                                                
                                                $extension = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));
                                                switch($extension) {
                                                    case 'pdf':
                                                        $icon = 'fa-regular fa-file-pdf';
                                                        $iconColor = 'text-red-500';
                                                        break;
                                                    case 'doc':
                                                    case 'docx':
                                                        $icon = 'fa-regular fa-file-word';
                                                        $iconColor = 'text-blue-500';
                                                        break;
                                                    case 'xls':
                                                    case 'xlsx':
                                                        $icon = 'fa-regular fa-file-excel';
                                                        $iconColor = 'text-green-500';
                                                        break;
                                                    case 'jpg':
                                                    case 'jpeg':
                                                    case 'png':
                                                    case 'gif':
                                                    case 'svg':
                                                        $icon = 'fa-regular fa-image';
                                                        $iconColor = 'text-purple-500';
                                                        break;
                                                    case 'zip':
                                                    case 'rar':
                                                    case '7z':
                                                    case 'tar':
                                                    case 'gz':
                                                        $icon = 'fa-regular fa-file-zipper';
                                                        $iconColor = 'text-amber-500';
                                                        break;
                                                    case 'txt':
                                                        $icon = 'fa-regular fa-file-lines';
                                                        $iconColor = 'text-gray-500';
                                                        break;
                                                    case 'csv':
                                                        $icon = 'fa-regular fa-file-csv';
                                                        $iconColor = 'text-green-600';
                                                        break;
                                                    case 'mp4':
                                                    case 'mov':
                                                    case 'avi':
                                                    case 'wmv':
                                                        $icon = 'fa-regular fa-file-video';
                                                        $iconColor = 'text-pink-500';
                                                        break;
                                                    case 'mp3':
                                                    case 'wav':
                                                    case 'ogg':
                                                        $icon = 'fa-regular fa-file-audio';
                                                        $iconColor = 'text-indigo-500';
                                                        break;
                                                    case 'ppt':
                                                    case 'pptx':
                                                        $icon = 'fa-regular fa-file-powerpoint';
                                                        $iconColor = 'text-orange-500';
                                                        break;
                                                }
                                            @endphp
                                            <i class="{{ $icon }} {{ $iconColor }} text-xl mt-1"></i>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800 truncate">{{ $file->original_name }}</p>
                                                <div class="flex items-center justify-between mt-1">
                                                    <span class="text-xs text-gray-500">{{ $file->size_for_humans }}</span>
                                                    <span class="text-xs px-2 py-0.5 bg-white rounded-full text-gray-600">
                                                        <i class="fa-regular fa-download mr-1"></i> Download
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Related Journals -->
                @if($relatedJournals->count() > 0)
                    <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Related Journals</h3>
                        <div class="space-y-4">
                            @foreach($relatedJournals as $related)
                                <div class="flex items-start gap-3">
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center shrink-0 overflow-hidden">
                                        @if($related->coverImage)
                                            <img src="{{ $related->coverImage->url }}" alt="{{ $related->title }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-regular fa-file-lines text-[#86662c] text-xl"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-800 hover:text-[#86662c] line-clamp-2">
                                            <a href="{{ route('journal.show', $related->slug) }}">{{ $related->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-500">
                                            {{ $related->published_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Citation Info -->
                <div class="bg-white rounded-lg border border-gray-200 p-5">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">How to Cite</h3>

                    <!-- APA Format -->
                    <div class="mb-4">
                        <h4 class="text-xs font-semibold text-gray-500 uppercase mb-2">APA Format</h4>
                        <p id="citation-apa" class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            {{ $journal->author->last_name ?? $journal->author->name }}, {{ $journal->author->first_name ?? '' }}.
                            @if($journal->coAuthors->count() > 0)
                                @foreach($journal->coAuthors as $index => $coAuthor)
                                    @if($index > 0) & @endif
                                    {{ $coAuthor->name }}
                                @endforeach
                            @endif
                            ({{ $journal->published_at->format('Y') }}). {{ $journal->title }}.
                            <em>Academic Journal</em>, {{ $journal->published_at->format('F d, Y') }}.
                        </p>
                    </div>

                    <!-- MLA Format -->
                    <div class="mb-4">
                        <h4 class="text-xs font-semibold text-gray-500 uppercase mb-2">MLA Format</h4>
                        <p id="citation-mla" class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            {{ $journal->author->name }}. "{{ $journal->title }}."
                            <em>Academic Journal</em>, {{ $journal->published_at->format('d M. Y') }}.
                        </p>
                    </div>

                    <!-- Chicago Format -->
                    <div class="mb-4">
                        <h4 class="text-xs font-semibold text-gray-500 uppercase mb-2">Chicago Format</h4>
                        <p id="citation-chicago"
                            class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            {{ $journal->author->name }}. "{{ $journal->title }}."
                            <em>Academic Journal</em> ({{ $journal->published_at->format('Y') }}):
                            {{ $journal->published_at->format('F d, Y') }}.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-4">
                        <button onclick="copyCitation('apa')"
                            class="flex-1 text-xs bg-[#86662c] text-white px-3 py-2 rounded-lg hover:bg-[#6b4f23] transition-colors">
                            <i class="fa-regular fa-copy mr-1"></i> APA
                        </button>
                        <button onclick="copyCitation('mla')"
                            class="flex-1 text-xs bg-[#86662c] text-white px-3 py-2 rounded-lg hover:bg-[#6b4f23] transition-colors">
                            <i class="fa-regular fa-copy mr-1"></i> MLA
                        </button>
                        <button onclick="copyCitation('chicago')"
                            class="flex-1 text-xs bg-[#86662c] text-white px-3 py-2 rounded-lg hover:bg-[#6b4f23] transition-colors">
                            <i class="fa-regular fa-copy mr-1"></i> Chicago
                        </button>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast"
        class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transform transition-transform duration-300 translate-y-full opacity-0 z-50">
        <div class="flex items-center space-x-2">
            <i class="fa-regular fa-circle-check"></i>
            <span id="toast-message">Citation copied to clipboard!</span>
        </div>
    </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {

    // PDF Modal functions
    window.openPdfModal = function(pdfUrl) {
        const modal = document.getElementById('pdfModal');
        const viewer = document.getElementById('pdfViewer');

        if (!modal || !viewer) return;

        viewer.src = pdfUrl + '#toolbar=1';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    window.closePdfModal = function() {
        const modal = document.getElementById('pdfModal');
        const viewer = document.getElementById('pdfViewer');

        if (!modal || !viewer) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex');
        viewer.src = '';
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('pdfModal');
        if (modal && e.target === modal) {
            window.closePdfModal();
        }
    });

    // Copy citation
    window.copyCitation = function (format) {
        const citationElement = document.getElementById(`citation-${format}`);
        if (!citationElement) return;

        const citationText = citationElement.textContent || citationElement.innerText;

        navigator.clipboard.writeText(citationText).then(() => {
            const formatName = format.toUpperCase();
            showToast(`${formatName} citation copied to clipboard!`);
        }).catch(err => {
            console.error('Failed to copy: ', err);
            showToast('Failed to copy. Please try again.');
        });
    };

    // Toast notification
    function showToast(message = 'Citation copied to clipboard!') {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');

        if (!toast || !toastMessage) return;

        toastMessage.textContent = message;
        toast.classList.remove('translate-y-full', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-full', 'opacity-0');
        }, 3000);
    }

    // Legacy function
    window.copyToClipboard = function (button) {
        const text = button.previousElementSibling.textContent;

        navigator.clipboard.writeText(text).then(() => {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fa-regular fa-check mr-1"></i> Copied!';

            setTimeout(() => {
                button.innerHTML = originalText;
            }, 2000);

            showToast('Citation copied to clipboard!');
        });
    }

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

});
</script>


<style>
    /* PDF iframe responsive */
    .pdf-container {
        position: relative;
        width: 100%;
        height: 500px;
    }

    .pdf-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    /* Toast animation */
    #toast {
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    /* Prose enhancements */
    .prose {
        max-width: 100%;
    }

    .prose img {
        border-radius: 0.5rem;
        margin: 1.5rem 0;
    }

    /* Line clamp utilities */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Thumbnail image styling */
    .thumbnail-image {
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    /* Modal animations */
    #pdfModal {
        transition: opacity 0.3s ease;
    }
    
    #pdfModal.flex {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Truncate long filenames */
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>