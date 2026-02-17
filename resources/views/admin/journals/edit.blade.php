@extends('layouts.admin')

@section('title', 'Edit Journal - Admin')
@section('page-title', 'Edit Journal')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.journals.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Journals</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Edit</li>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
        <form action="{{ route('admin.journals.update', $journal->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Error Messages -->
            @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-lg mb-6">
                    <h4 class="text-sm font-medium text-red-800 mb-2">Please fix the following errors:</h4>
                    <ul class="list-disc list-inside text-xs text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Basic Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Basic Information</h3>
                
                <!-- Author Selection (Admin Only) -->
                <div>
                    <label for="author_id" class="block text-sm font-medium text-gray-700 mb-2">Author <span class="text-red-500">*</span></label>
                    <select name="author_id" 
                            id="author_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('author_id') border-red-500 @enderror"
                            required>
                        <option value="">Select Author</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ (old('author_id', $journal->author_id) == $author->id) ? 'selected' : '' }}>
                                {{ $author->name }} ({{ $author->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Journal Title <span class="text-red-500">*</span></label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $journal->title) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('title') border-red-500 @enderror"
                           placeholder="Enter the full title of the journal"
                           required>
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" 
                            id="status"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('status') border-red-500 @enderror">
                        <option value="draft" {{ $journal->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="submitted" {{ $journal->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="under_review" {{ $journal->status == 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="published" {{ $journal->status == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="revision_required" {{ $journal->status == 'revision_required' ? 'selected' : '' }}>Revision Required</option>
                        <option value="rejected" {{ $journal->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Revision Comments (shown when revision_required is selected) -->
                <div id="revision-comments-field" class="space-y-4" style="display: {{ $journal->status == 'revision_required' ? 'block' : 'none' }};">
                    <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Revision Request</h3>
                    
                    <div>
                        <label for="revision_comments" class="block text-sm font-medium text-gray-700 mb-2">Revision Comments <span class="text-red-500">*</span></label>
                        <textarea id="revision_comments" 
                                  name="revision_comments" 
                                  rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                  placeholder="Provide detailed feedback to the author about what needs to be revised..."
                                  {{ $journal->status == 'revision_required' ? 'required' : '' }}>{{ old('revision_comments') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">These comments will be sent to the author with the revision request</p>
                    </div>
                </div>

                <!-- Rejection Reason (shown when rejected is selected) -->
                <div id="rejection-reason-field" class="space-y-4" style="display: {{ $journal->status == 'rejected' ? 'block' : 'none' }};">
                    <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Rejection Reason</h3>
                    
                    <div>
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason <span class="text-red-500">*</span></label>
                        <textarea id="rejection_reason" 
                                  name="rejection_reason" 
                                  rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                  placeholder="Explain why the journal is being rejected..."
                                  {{ $journal->status == 'rejected' ? 'required' : '' }}>{{ old('rejection_reason') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">This reason will be sent to the author</p>
                    </div>
                </div>

                <!-- Abstract -->
                <div>
                    <label for="abstract" class="block text-sm font-medium text-gray-700 mb-2">Abstract</label>
                    <textarea id="abstract" 
                              name="abstract" 
                              rows="4"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('abstract') border-red-500 @enderror"
                              placeholder="Provide a brief summary of the research">{{ old('abstract', $journal->abstract) }}</textarea>
                    @error('abstract')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content with Quill Rich Text Editor -->
                <div>
                    <label for="journal_content" class="block text-sm font-medium text-gray-700 mb-2">Full Content <span class="text-red-500">*</span></label>
                    <div id="quill-editor" class="bg-white" style="height: 400px;">
                        {!! old('journal_content', $journal->content) !!}
                    </div>
                    <textarea id="journal_content" 
                              name="journal_content" 
                              class="hidden">{{ old('journal_content', $journal->content) }}</textarea>
                    @error('journal_content')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Volume/Issue Assignment (New Section) -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Volume & Issue Assignment</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Volume Selection -->
                    <div>
                        <label for="volume_id" class="block text-sm font-medium text-gray-700 mb-2">Volume</label>
                        <select name="volume_id" 
                                id="volume_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('volume_id') border-red-500 @enderror">
                            <option value="">Select Volume (Optional)</option>
                            @foreach($volumes as $volume)
                                <option value="{{ $volume->id }}" {{ old('volume_id', $journal->volume_id) == $volume->id ? 'selected' : '' }}>
                                    Volume {{ $volume->volume_number }} - {{ $volume->title }} ({{ $volume->year }})
                                </option>
                            @endforeach
                        </select>
                        @error('volume_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Issue Selection -->
                    <div>
                        <label for="issue_id" class="block text-sm font-medium text-gray-700 mb-2">Issue</label>
                        <select name="issue_id" 
                                id="issue_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('issue_id') border-red-500 @enderror">
                            <option value="">Select Issue (Optional)</option>
                            @foreach($issues as $issue)
                                <option value="{{ $issue->id }}" 
                                        data-volume="{{ $issue->volume_id }}"
                                        {{ old('issue_id', $journal->issue_id) == $issue->id ? 'selected' : '' }}>
                                    Issue {{ $issue->issue_number }} - {{ $issue->title }} ({{ $issue->volume->volume_number ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('issue_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Page Numbers and DOI -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Page Start -->
                    <div>
                        <label for="page_start" class="block text-sm font-medium text-gray-700 mb-2">Page Start</label>
                        <input type="number" 
                            id="page_start" 
                            name="page_start" 
                            value="{{ old('page_start', $journal->page_start) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('page_start') border-red-500 @enderror"
                            placeholder="e.g., 125"
                            min="1">
                        @error('page_start')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Page End -->
                    <div>
                        <label for="page_end" class="block text-sm font-medium text-gray-700 mb-2">Page End</label>
                        <input type="number" 
                            id="page_end" 
                            name="page_end" 
                            value="{{ old('page_end', $journal->page_end) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('page_end') border-red-500 @enderror"
                            placeholder="e.g., 150"
                            min="1">
                        @error('page_end')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- DOI -->
                    <div>
                        <label for="doi" class="block text-sm font-medium text-gray-700 mb-2">DOI</label>
                        <input type="text" 
                            id="doi" 
                            name="doi" 
                            value="{{ old('doi', $journal->doi) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('doi') border-red-500 @enderror"
                            placeholder="10.1000/xyz123">
                        @error('doi')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Current Assignment Info -->
                @if($journal->volume || $journal->issue)
                    <div class="mt-2 p-3 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-700">
                            <i class="fa-regular fa-circle-info mr-1"></i>
                            Currently assigned to: 
                            @if($journal->volume)
                                Volume {{ $journal->volume->volume_number }} ({{ $journal->volume->year }})
                            @endif
                            @if($journal->issue)
                                @if($journal->volume) / @endif
                                Issue {{ $journal->issue->issue_number }}
                            @endif
                            @if($journal->page_start && $journal->page_end)
                                - Pages {{ $journal->page_start }}-{{ $journal->page_end }}
                            @endif
                            @if($journal->doi)
                                - DOI: {{ $journal->doi }}
                            @endif
                        </p>
                    </div>
                @endif
            </div>

            <!-- Tags with Chips Input (Fiverr Style) -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Tags & Keywords</h3>
                
                <div>
                    <label for="tag-input" class="block text-sm font-medium text-gray-700 mb-2">Select Tags</label>
                    <div class="tags-input-container border border-gray-300 rounded-lg p-2 focus-within:ring-2 focus-within:ring-[#86662c] focus-within:border-transparent">
                        <div id="tags-chips" class="flex flex-wrap gap-2 mb-2">
                            <!-- Selected tags will appear here as chips -->
                        </div>
                        <div class="relative">
                            <input type="text" 
                                   id="tag-input" 
                                   class="w-full px-3 py-2 border-0 focus:ring-0 outline-none text-sm"
                                   placeholder="Search or type to add tags..."
                                   autocomplete="off">
                            <div id="tags-suggestions" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                <!-- Tag suggestions will appear here -->
                            </div>
                        </div>
                    </div>
                    <select id="tags-select" name="tags[]" multiple class="hidden">
                        @foreach($tags as $tag)
                            @php
                                $selected = in_array($tag->id, old('tags', $journal->tags->pluck('id')->toArray()));
                            @endphp
                            <option value="{{ $tag->id }}" 
                                    data-name="{{ $tag->name }}" 
                                    {{ $selected ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Search and select multiple tags</p>
                    @error('tags')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Co-Authors -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Co-Authors</h3>
                    <button type="button" id="addCoAuthor" class="text-sm text-[#86662c] hover:text-[#6b4f23] font-medium">
                        <i class="fa-solid fa-plus mr-1"></i> Add Co-Author
                    </button>
                </div>
                
                <div id="coAuthorsContainer" class="space-y-4">
                    @foreach($journal->coAuthors as $index => $coAuthor)
                        <div class="co-author-field bg-gray-50 p-4 rounded-lg relative border border-gray-200">
                            <button type="button" class="remove-co-author absolute top-2 right-2 text-gray-400 hover:text-red-600 transition-colors">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                           name="co_authors[{{ $index }}][name]" 
                                           value="{{ old('co_authors.' . $index . '.name', $coAuthor->name) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none text-sm"
                                           required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" 
                                           name="co_authors[{{ $index }}][email]" 
                                           value="{{ old('co_authors.' . $index . '.email', $coAuthor->email) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Institution</label>
                                    <input type="text" 
                                           name="co_authors[{{ $index }}][institution]" 
                                           value="{{ old('co_authors.' . $index . '.institution', $coAuthor->institution) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">ORCID ID</label>
                                    <input type="text" 
                                           name="co_authors[{{ $index }}][orcid_id]" 
                                           value="{{ old('co_authors.' . $index . '.orcid_id', $coAuthor->orcid_id) }}"
                                           placeholder="0000-0001-2345-6789"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none text-sm">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-500">The main author is set as the corresponding author</p>
            </div>

            <!-- File Uploads -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Files</h3>
                
                <!-- Current Files -->
                @if($journal->files->count() > 0)
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Current Files</h4>
                        <div class="space-y-2">
                            @foreach($journal->files as $file)
                                <div class="flex items-center justify-between py-2 px-3 bg-white rounded-lg border border-gray-200">
                                    <div class="flex items-center space-x-3">
                                        @if($file->file_type == 'manuscript')
                                            <i class="fa-regular fa-file-pdf text-red-500"></i>
                                        @elseif($file->file_type == 'cover_image')
                                            <i class="fa-regular fa-image text-blue-500"></i>
                                        @else
                                            <i class="fa-regular fa-file text-gray-500"></i>
                                        @endif
                                        <span class="text-sm text-gray-700">{{ $file->original_name }}</span>
                                        <span class="text-xs text-gray-500">({{ round($file->file_size / 1024, 2) }} KB)</span>
                                    </div>
                                    <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">{{ str_replace('_', ' ', ucfirst($file->file_type)) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Manuscript PDF (Optional on update) -->
                <div>
                    <label for="manuscript" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload New Manuscript PDF <span class="text-gray-500 text-xs">(Leave empty to keep current)</span>
                    </label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-[#86662c] transition-colors" id="manuscript-dropzone">
                        <input type="file" 
                               id="manuscript" 
                               name="manuscript" 
                               accept=".pdf"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center" id="manuscript-placeholder">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Drop manuscript PDF here or click to browse</p>
                            <p class="text-xs text-gray-500 mt-1">Maximum file size: 10MB</p>
                        </div>
                        <div class="hidden" id="manuscript-selected">
                            <div class="flex items-center justify-center space-x-2 text-green-600">
                                <i class="fa-solid fa-circle-check text-xl"></i>
                                <span class="text-sm font-medium" id="manuscript-filename"></span>
                            </div>
                        </div>
                    </div>
                    @error('manuscript')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image (Optional on update) -->
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload New Cover Image <span class="text-gray-500 text-xs">(Leave empty to keep current)</span>
                    </label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-[#86662c] transition-colors" id="cover-dropzone">
                        <input type="file" 
                               id="cover_image" 
                               name="cover_image" 
                               accept="image/jpeg,image/png,image/jpg"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center" id="cover-placeholder">
                            <i class="fa-solid fa-image text-gray-400"></i>
                            <span class="text-sm text-gray-600 ml-2">Upload cover image (JPG, PNG, max 2MB)</span>
                        </div>
                        <div class="hidden" id="cover-selected">
                            <div class="flex items-center justify-center space-x-2 text-green-600">
                                <i class="fa-solid fa-circle-check"></i>
                                <span class="text-sm" id="cover-filename"></span>
                            </div>
                        </div>
                    </div>
                    @error('cover_image')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Supplementary Files (Optional on update) -->
                <div>
                    <label for="supplementary_files" class="block text-sm font-medium text-gray-700 mb-2">
                        Add More Supplementary Files <span class="text-gray-500 text-xs">(Leave empty to keep current)</span>
                    </label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-[#86662c] transition-colors" id="supplementary-dropzone">
                        <input type="file" 
                               id="supplementary_files" 
                               name="supplementary_files[]" 
                               multiple
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center" id="supplementary-placeholder">
                            <i class="fa-solid fa-folder-open text-gray-400 mb-1"></i>
                            <p class="text-sm text-gray-600">Upload multiple supplementary files</p>
                            <p class="text-xs text-gray-500 mt-1">Maximum file size per file: 10MB</p>
                        </div>
                        <div class="hidden" id="supplementary-selected">
                            <div class="text-center text-green-600">
                                <i class="fa-solid fa-circle-check"></i>
                                <span class="text-sm ml-2" id="supplementary-count"></span>
                            </div>
                        </div>
                    </div>
                    @error('supplementary_files.*')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Admin Notes (For internal use) -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Admin Notes</h3>
                
                <div>
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Internal Notes</label>
                    <textarea id="admin_notes" 
                              name="admin_notes" 
                              rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                              placeholder="Add internal notes about this journal (only visible to admins)">{{ old('admin_notes', $journal->admin_notes ?? '') }}</textarea>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.journals.show', $journal->id) }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                    <i class="fa-regular fa-floppy-disk mr-2"></i>
                    Update Journal
                </button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Quill Custom Styles */
    .ql-container {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        background: white;
        font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        font-size: 16px;
    }
    
    .ql-toolbar {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        background: #f9fafb;
        border-color: #d1d5db !important;
    }
    
    .ql-editor {
        min-height: 350px;
    }
    
    /* Tags Input Styles */
    .tags-input-container {
        transition: all 0.2s ease;
    }
    
    .tag-chip {
        display: inline-flex;
        align-items: center;
        background-color: #86662c;
        color: white;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
        margin: 0.125rem;
        transition: all 0.2s ease;
    }
    
    .tag-chip .remove-tag {
        margin-left: 0.5rem;
        cursor: pointer;
        font-size: 1.1rem;
        line-height: 1;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }
    
    .tag-chip .remove-tag:hover {
        opacity: 1;
    }
    
    .tag-suggestion-item {
        padding: 0.5rem 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }
    
    .tag-suggestion-item:hover {
        background-color: #f3f4f6;
    }
    
    .tag-suggestion-item.selected {
        background-color: #86662c;
        color: white;
    }
    
    .tag-suggestion-item.highlighted {
        background-color: #f3f4f6;
        font-weight: 500;
    }
    
    .tag-suggestion-item .tag-count {
        color: #6b7280;
        font-size: 0.75rem;
        margin-left: 0.5rem;
    }
    
    .tag-suggestion-item.selected .tag-count {
        color: rgba(255, 255, 255, 0.8);
    }
    
    /* File Upload Styles */
    [id$="-dropzone"] {
        transition: all 0.2s ease;
    }
    
    [id$="-dropzone"].border-[#86662c] {
        border-color: #86662c;
    }
    
    [id$="-dropzone"].bg-[#86662c]\/5 {
        background-color: rgba(134, 102, 44, 0.05);
    }

    /* Breadcrumb Styles */
    .breadcrumb-enter {
        opacity: 0;
        transform: translateX(-10px);
    }
    
    .breadcrumb-enter-active {
        opacity: 1;
        transform: translateX(0);
        transition: opacity 0.3s, transform 0.3s;
    }
</style>
@endpush

@push('scripts')
<!-- Quill -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill editor
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            },
            placeholder: 'Write journal content here...',
        });

        const statusSelect = document.getElementById('status');
        const revisionField = document.getElementById('revision-comments-field');
        const rejectionField = document.getElementById('rejection-reason-field');
        const revisionTextarea = document.getElementById('revision_comments');
        const rejectionTextarea = document.getElementById('rejection_reason');

        function toggleStatusFields() {
            const selectedStatus = statusSelect.value;
            
            // Hide both fields first
            if (revisionField) revisionField.style.display = 'none';
            if (rejectionField) rejectionField.style.display = 'none';
            
            // Remove required attributes
            if (revisionTextarea) revisionTextarea.required = false;
            if (rejectionTextarea) rejectionTextarea.required = false;
            
            // Show relevant field based on status
            if (selectedStatus === 'revision_required' && revisionField) {
                revisionField.style.display = 'block';
                if (revisionTextarea) revisionTextarea.required = true;
            } else if (selectedStatus === 'rejected' && rejectionField) {
                rejectionField.style.display = 'block';
                if (rejectionTextarea) rejectionTextarea.required = true;
            }
        }

        // Add event listener to status dropdown
        if (statusSelect) {
            statusSelect.addEventListener('change', toggleStatusFields);
        }

        // Call on page load
        toggleStatusFields();
        
        // Set initial content if exists
        const hiddenContent = document.getElementById('journal_content');
        if (hiddenContent.value) {
            quill.root.innerHTML = hiddenContent.value;
        }
        
        // Update hidden textarea on content change
        quill.on('text-change', function() {
            hiddenContent.value = quill.root.innerHTML;
        });

        // Initialize Tags Chips Input (Fiverr Style)
        const tagInput = document.getElementById('tag-input');
        const tagsChips = document.getElementById('tags-chips');
        const tagsSuggestions = document.getElementById('tags-suggestions');
        const tagsSelect = document.getElementById('tags-select');

        const volumeSelect = document.getElementById('volume_id');
        const issueSelect = document.getElementById('issue_id');

        if (volumeSelect && issueSelect) {
            // Store all issues with their volume data
            const allIssues = Array.from(issueSelect.options).map(option => ({
                value: option.value,
                text: option.text,
                volumeId: option.dataset.volume,
                selected: option.selected
            }));

            function filterIssues() {
                const selectedVolume = volumeSelect.value;
                
                // Clear current options
                issueSelect.innerHTML = '<option value="">Select Issue (Optional)</option>';
                
                // Filter and add matching issues
                allIssues.forEach(issue => {
                    if (issue.value && (!selectedVolume || issue.volumeId === selectedVolume)) {
                        const option = document.createElement('option');
                        option.value = issue.value;
                        option.textContent = issue.text;
                        if (issue.selected && (!selectedVolume || issue.volumeId === selectedVolume)) {
                            option.selected = true;
                        }
                        issueSelect.appendChild(option);
                    }
                });
            }

            volumeSelect.addEventListener('change', filterIssues);
        }
        
        // Get all available tags from the select options
        const availableTags = Array.from(tagsSelect.options).map(option => ({
            id: option.value,
            name: option.dataset.name,
            selected: option.selected
        }));
        
        let selectedTags = availableTags.filter(tag => tag.selected);
        let highlightedIndex = -1;
        
        // Render existing selected tags
        function renderTags() {
            tagsChips.innerHTML = '';
            selectedTags.forEach(tag => {
                const chip = document.createElement('span');
                chip.className = 'tag-chip';
                chip.innerHTML = `${tag.name}<span class="remove-tag" data-id="${tag.id}">&times;</span>`;
                tagsChips.appendChild(chip);
            });
            
            // Update select options
            Array.from(tagsSelect.options).forEach(option => {
                option.selected = selectedTags.some(tag => tag.id === option.value);
            });
        }
        
        // Filter suggestions based on input
        function filterSuggestions(query) {
            const filtered = availableTags.filter(tag => 
                !selectedTags.some(selected => selected.id === tag.id) &&
                tag.name.toLowerCase().includes(query.toLowerCase())
            );
            
            if (filtered.length === 0 || query.length === 0) {
                tagsSuggestions.classList.add('hidden');
                return [];
            }
            
            return filtered.slice(0, 10); // Limit to 10 suggestions
        }
        
        // Render suggestions
        function renderSuggestions(suggestions) {
            if (suggestions.length === 0) {
                tagsSuggestions.classList.add('hidden');
                return;
            }
            
            tagsSuggestions.innerHTML = '';
            suggestions.forEach((tag, index) => {
                const item = document.createElement('div');
                item.className = `tag-suggestion-item ${index === highlightedIndex ? 'highlighted' : ''}`;
                item.dataset.id = tag.id;
                item.dataset.name = tag.name;
                item.innerHTML = `${tag.name}<span class="tag-count">click to add</span>`;
                
                item.addEventListener('click', function() {
                    addTag(tag);
                    tagInput.value = '';
                    tagsSuggestions.classList.add('hidden');
                    tagInput.focus();
                });
                
                tagsSuggestions.appendChild(item);
            });
            
            tagsSuggestions.classList.remove('hidden');
        }
        
        // Add tag
        function addTag(tag) {
            if (!selectedTags.some(t => t.id === tag.id)) {
                selectedTags.push(tag);
                renderTags();
            }
        }
        
        // Remove tag
        function removeTag(tagId) {
            selectedTags = selectedTags.filter(tag => tag.id !== tagId);
            renderTags();
            
            // Show suggestions if input has value
            if (tagInput.value.length > 0) {
                const suggestions = filterSuggestions(tagInput.value);
                renderSuggestions(suggestions);
            }
        }
        
        // Handle tag input
        tagInput.addEventListener('input', function(e) {
            const query = e.target.value;
            highlightedIndex = -1;
            
            if (query.length > 0) {
                const suggestions = filterSuggestions(query);
                renderSuggestions(suggestions);
            } else {
                tagsSuggestions.classList.add('hidden');
            }
        });
        
        // Handle keyboard navigation
        tagInput.addEventListener('keydown', function(e) {
            const suggestions = tagsSuggestions.children;
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (suggestions.length > 0) {
                    highlightedIndex = (highlightedIndex + 1) % suggestions.length;
                    renderSuggestions(filterSuggestions(tagInput.value));
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (suggestions.length > 0) {
                    highlightedIndex = (highlightedIndex - 1 + suggestions.length) % suggestions.length;
                    renderSuggestions(filterSuggestions(tagInput.value));
                }
            } else if (e.key === 'Enter' && highlightedIndex >= 0) {
                e.preventDefault();
                const selectedSuggestion = suggestions[highlightedIndex];
                const tagId = selectedSuggestion.dataset.id;
                const tagName = selectedSuggestion.dataset.name;
                addTag({ id: tagId, name: tagName });
                tagInput.value = '';
                tagsSuggestions.classList.add('hidden');
            } else if (e.key === 'Escape') {
                tagsSuggestions.classList.add('hidden');
                highlightedIndex = -1;
            }
        });
        
        // Handle click on remove tag
        tagsChips.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-tag')) {
                const tagId = e.target.dataset.id;
                removeTag(tagId);
            }
        });
        
        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!tagInput.contains(e.target) && !tagsSuggestions.contains(e.target)) {
                tagsSuggestions.classList.add('hidden');
            }
        });
        
        // Initialize selected tags
        renderTags();

        // Co-author management
        const container = document.getElementById('coAuthorsContainer');
        const addButton = document.getElementById('addCoAuthor');
        
        let coAuthorCount = {{ $journal->coAuthors->count() }};
        
        function createCoAuthorField() {
            coAuthorCount++;
            const field = document.createElement('div');
            field.className = 'co-author-field bg-gray-50 p-4 rounded-lg relative border border-gray-200';
            field.innerHTML = `
                <button type="button" class="remove-co-author absolute top-2 right-2 text-gray-400 hover:text-red-600 transition-colors">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="co_authors[${coAuthorCount}][name]" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none text-sm"
                               required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" 
                               name="co_authors[${coAuthorCount}][email]" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Institution</label>
                        <input type="text" 
                               name="co_authors[${coAuthorCount}][institution]" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">ORCID ID</label>
                        <input type="text" 
                               name="co_authors[${coAuthorCount}][orcid_id]" 
                               placeholder="0000-0001-2345-6789"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none text-sm">
                    </div>
                </div>
            `;
            
            field.querySelector('.remove-co-author').addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Remove this co-author?')) {
                    field.remove();
                }
            });
            
            return field;
        }
        
        // Add co-author on button click
        if (addButton) {
            addButton.addEventListener('click', function(e) {
                e.preventDefault();
                container.appendChild(createCoAuthorField());
            });
        }
        
        // Remove existing co-authors
        document.querySelectorAll('.remove-co-author').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Remove this co-author?')) {
                    this.closest('.co-author-field').remove();
                }
            });
        });

        // File upload handlers with visual feedback
        const manuscriptInput = document.getElementById('manuscript');
        if (manuscriptInput) {
            const manuscriptPlaceholder = document.getElementById('manuscript-placeholder');
            const manuscriptSelected = document.getElementById('manuscript-selected');
            const manuscriptFilename = document.getElementById('manuscript-filename');

            manuscriptInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    manuscriptPlaceholder.classList.add('hidden');
                    manuscriptSelected.classList.remove('hidden');
                    manuscriptFilename.textContent = file.name;
                } else {
                    manuscriptPlaceholder.classList.remove('hidden');
                    manuscriptSelected.classList.add('hidden');
                }
            });
        }

        const coverInput = document.getElementById('cover_image');
        if (coverInput) {
            const coverPlaceholder = document.getElementById('cover-placeholder');
            const coverSelected = document.getElementById('cover-selected');
            const coverFilename = document.getElementById('cover-filename');

            coverInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    coverPlaceholder.classList.add('hidden');
                    coverSelected.classList.remove('hidden');
                    coverFilename.textContent = file.name;
                } else {
                    coverPlaceholder.classList.remove('hidden');
                    coverSelected.classList.add('hidden');
                }
            });
        }

        const supplementaryInput = document.getElementById('supplementary_files');
        if (supplementaryInput) {
            const supplementaryPlaceholder = document.getElementById('supplementary-placeholder');
            const supplementarySelected = document.getElementById('supplementary-selected');
            const supplementaryCount = document.getElementById('supplementary-count');

            supplementaryInput.addEventListener('change', function(e) {
                const files = e.target.files;
                if (files.length > 0) {
                    supplementaryPlaceholder.classList.add('hidden');
                    supplementarySelected.classList.remove('hidden');
                    supplementaryCount.textContent = files.length + ' file(s) selected';
                } else {
                    supplementaryPlaceholder.classList.remove('hidden');
                    supplementarySelected.classList.add('hidden');
                }
            });
        }

        // Drag and drop visual feedback
        const dropzones = document.querySelectorAll('[id$="-dropzone"]');
        dropzones.forEach(dropzone => {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, function() {
                    this.classList.add('border-[#86662c]', 'bg-[#86662c]/5');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, function() {
                    this.classList.remove('border-[#86662c]', 'bg-[#86662c]/5');
                }, false);
            });
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
    });
</script>
@endpush