@extends('layouts.admin')

@section('title', 'Volumes Management - Admin')
@section('page-title', 'Volumes Management')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Volumes</li>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="flex flex-wrap gap-4 mb-6">
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Total Volumes</p>
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
            <p class="text-sm text-gray-500">Total Articles</p>
            <p class="text-2xl font-bold text-purple-600">{{ $stats['total_articles'] }}</p>
        </div>
    </div>

    <!-- Header with Create Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manage Volumes</h2>
            <p class="text-sm text-gray-500 mt-1">Create and manage journal volumes</p>
        </div>
        <a href="{{ route('admin.volumes.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors shadow-soft">
            <i class="fa-solid fa-plus mr-2"></i>
            Create New Volume
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.volumes.index') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-50">
                <input type="text" 
                       name="search" 
                       placeholder="Search by title, volume number, or year..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
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
                <select name="year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                <i class="fa-solid fa-filter mr-2"></i>
                Filter
            </button>
            <a href="{{ route('admin.volumes.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                Clear
            </a>
        </form>
    </div>

    <!-- Volumes Table -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-[#86662c] focus:ring-[#86662c]">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volume</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issues</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Articles</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($volumes as $volume)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" 
                                       class="volume-checkbox rounded border-gray-300 text-[#86662c] focus:ring-[#86662c]" 
                                       value="{{ $volume->id }}">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    @if($volume->cover_image)
                                        <div class="shrink-0 w-10 h-10 rounded-lg bg-gray-100 overflow-hidden">
                                            <img src="{{ $volume->cover_image_url }}" 
                                                 alt="{{ $volume->title }}" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="shrink-0 w-10 h-10 rounded-lg bg-[#86662c]/10 flex items-center justify-center">
                                            <i class="fa-solid fa-book text-[#86662c]"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-800">{{ $volume->title }}</div>
                                        <div class="text-xs text-gray-500">Volume {{ $volume->volume_number }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $volume->year }}</td>
                            <td class="px-6 py-4">{!! $volume->status_badge !!}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800">{{ $volume->issues_count }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800">{{ $volume->journals_count }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if($volume->published_at)
                                    {{ $volume->published_at->format('M d, Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.volumes.show', $volume) }}" 
                                       class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                       title="View">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.volumes.edit', $volume) }}" 
                                       class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                       title="Edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    @if($volume->status !== 'published')
                                        <button onclick="publishVolume({{ $volume->id }}, '{{ $volume->title }}')" 
                                                class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                                title="Publish">
                                            <i class="fa-regular fa-circle-check"></i>
                                        </button>
                                    @endif
                                    @if($volume->issues_count === 0)
                                        <button onclick="deleteVolume({{ $volume->id }}, '{{ $volume->title }}')" 
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
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-books text-5xl text-gray-300 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-700 mb-1">No Volumes Found</h3>
                                    <p class="text-sm text-gray-500 mb-4">Get started by creating your first volume.</p>
                                    <a href="{{ route('admin.volumes.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                                        <i class="fa-solid fa-plus mr-2"></i>
                                        Create First Volume
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bulk Actions -->
        @if($volumes->count() > 0)
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600" id="selectedCount">0 selected</span>
                        <button type="button" 
                                id="deleteSelectedBtn"
                                class="text-sm text-red-600 hover:text-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            <i class="fa-regular fa-trash-can mr-1"></i>
                            Delete Selected
                        </button>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Pagination -->
        @if($volumes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $volumes->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    // Select all functionality
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.volume-checkbox');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    const selectedCount = document.getElementById('selectedCount');

    function updateSelectedCount() {
        const checked = document.querySelectorAll('.volume-checkbox:checked').length;
        selectedCount.textContent = checked + ' selected';
        deleteSelectedBtn.disabled = checked === 0;
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            if (selectAll) {
                selectAll.checked = allChecked;
                selectAll.indeterminate = !allChecked && Array.from(checkboxes).some(cb => cb.checked);
            }
            updateSelectedCount();
        });
    });

    // Delete selected
    deleteSelectedBtn.addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.volume-checkbox:checked')).map(cb => cb.value);
        
        if (selectedIds.length === 0) return;
        
        if (confirm('Are you sure you want to delete ' + selectedIds.length + ' selected volumes? Volumes with issues will be skipped.')) {
            // Implement bulk delete
        }
    });

    // Publish volume
    function publishVolume(id, title) {
        if (confirm('Are you sure you want to publish the volume "' + title + '"?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/volumes') }}/${id}/publish`;
            form.innerHTML = `@csrf`;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Delete single volume
    function deleteVolume(id, title) {
        if (confirm('Are you sure you want to delete the volume "' + title + '"?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/volumes') }}/${id}`;
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