@extends('layouts.admin')

@section('title', 'Reviewers Management - Admin')
@section('page-title', 'Reviewers Management')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Reviewers</li>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Total Reviewers</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Active</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Inactive</p>
            <p class="text-2xl font-bold text-gray-600">{{ $stats['inactive'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Total Reviews</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['total_reviews'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Avg. Rating</p>
            <p class="text-2xl font-bold text-purple-600">{{ $stats['avg_rating'] ? number_format($stats['avg_rating'], 1) : 'N/A' }}</p>
        </div>
    </div>

    <!-- Header with Create Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manage Reviewers</h2>
            <p class="text-sm text-gray-500 mt-1">Add and manage peer reviewers</p>
        </div>
        <a href="{{ route('admin.reviewers.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors shadow-soft">
            <i class="fa-solid fa-plus mr-2"></i>
            Add New Reviewer
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.reviewers.index') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-50">
                <input type="text" 
                       name="search" 
                       placeholder="Search by name, email, institution..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
            </div>
            <div class="w-40">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="all">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="w-48">
                <select name="expertise" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="">All Expertise</option>
                    @foreach($expertiseOptions as $option)
                        <option value="{{ $option }}" {{ request('expertise') == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                <i class="fa-solid fa-filter mr-2"></i>
                Filter
            </button>
            <a href="{{ route('admin.reviewers.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                Clear
            </a>
        </form>
    </div>

    <!-- Reviewers Table -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reviewer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Institution</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expertise</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reviews</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($reviewers as $reviewer)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="shrink-0 w-10 h-10 rounded-full bg-[#86662c]/10 flex items-center justify-center">
                                        <span class="text-[#86662c] font-semibold text-sm">
                                            {{ strtoupper(substr($reviewer->user->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $reviewer->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $reviewer->user->email }}</p>
                                        @if($reviewer->academic_degree)
                                            <p class="text-xs text-gray-400">{{ $reviewer->academic_degree }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-800">{{ $reviewer->institution }}</p>
                                @if($reviewer->department)
                                    <p class="text-xs text-gray-500">{{ $reviewer->department }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @foreach(array_slice($reviewer->expertise_areas ?? [], 0, 2) as $area)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">
                                            {{ Str::limit($area, 15) }}
                                        </span>
                                    @endforeach
                                    @if(count($reviewer->expertise_areas ?? []) > 2)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">
                                            +{{ count($reviewer->expertise_areas) - 2 }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($reviewer->status === 'active')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                @elseif($reviewer->status === 'pending')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $reviewer->review_count }}</td>
                            <td class="px-6 py-4">
                                @if($reviewer->average_rating)
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-800 mr-1">{{ number_format($reviewer->average_rating, 1) }}</span>
                                        <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $reviewer->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.reviewers.show', $reviewer) }}" 
                                       class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                       title="View">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.reviewers.edit', $reviewer) }}" 
                                       class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                       title="Edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.reviewers.toggle-status', $reviewer) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="p-2 text-gray-500 hover:text-{{ $reviewer->status === 'active' ? 'yellow' : 'green' }}-600 hover:bg-{{ $reviewer->status === 'active' ? 'yellow' : 'green' }}-50 rounded-lg transition-colors"
                                                title="{{ $reviewer->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                            <i class="fa-regular fa-{{ $reviewer->status === 'active' ? 'circle-pause' : 'circle-play' }}"></i>
                                        </button>
                                    </form>
                                    @if($reviewer->review_count === 0)
                                        <button onclick="deleteReviewer({{ $reviewer->id }}, '{{ $reviewer->user->name }}')" 
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
                                    <i class="fa-regular fa-user text-5xl text-gray-300 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-700 mb-1">No Reviewers Found</h3>
                                    <p class="text-sm text-gray-500 mb-4">Get started by adding your first reviewer.</p>
                                    <a href="{{ route('admin.reviewers.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                                        <i class="fa-solid fa-plus mr-2"></i>
                                        Add First Reviewer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($reviewers->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $reviewers->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function deleteReviewer(id, name) {
        if (confirm('Are you sure you want to delete the reviewer "' + name + '"?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/reviewers') }}/${id}`;
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