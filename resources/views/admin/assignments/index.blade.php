@extends('layouts.admin')

@section('title', 'Review Assignments - Admin')
@section('page-title', 'Review Assignments')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Assignments</li>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Total</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">In Progress</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['accepted'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Completed</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Declined</p>
            <p class="text-2xl font-bold text-gray-600">{{ $stats['declined'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Overdue</p>
            <p class="text-2xl font-bold {{ $stats['overdue'] > 0 ? 'text-red-600' : 'text-gray-800' }}">
                {{ $stats['overdue'] }}
            </p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.assignments.index') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-50">
                <input type="text" 
                       name="search" 
                       placeholder="Search by article or reviewer..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
            </div>
            <div class="w-40">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="all">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Declined</option>
                </select>
            </div>
            <div class="w-48">
                <select name="reviewer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="">All Reviewers</option>
                    @foreach($reviewers as $reviewer)
                        <option value="{{ $reviewer->id }}" {{ request('reviewer_id') == $reviewer->id ? 'selected' : '' }}>
                            {{ $reviewer->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                       placeholder="From"
                       class="w-36 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
            </div>
            <div>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       placeholder="To"
                       class="w-36 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
            </div>
            <button type="submit" class="px-6 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                <i class="fa-solid fa-filter mr-2"></i>
                Filter
            </button>
            <a href="{{ route('admin.assignments.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                Clear
            </a>
        </form>
    </div>

    <!-- Assignments Table -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Article</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reviewer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recommendation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($assignments as $assignment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-800">{{ Str::limit($assignment->journal->title, 40) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-[#86662c]/10 flex items-center justify-center">
                                        <span class="text-[#86662c] text-xs font-bold">
                                            {{ strtoupper(substr($assignment->reviewer->user->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $assignment->reviewer->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $assignment->reviewer->institution }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $assignment->assigned_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm {{ $assignment->is_overdue ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                    {{ $assignment->due_date ? $assignment->due_date->format('M d, Y') : '-' }}
                                    @if($assignment->is_overdue)
                                        <i class="fa-solid fa-exclamation-circle ml-1" title="Overdue"></i>
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($assignment->status === 'pending')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($assignment->status === 'accepted')
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Accepted</span>
                                @elseif($assignment->status === 'in_progress')
                                    <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">In Progress</span>
                                @elseif($assignment->status === 'completed')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                @elseif($assignment->status === 'declined')
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Declined</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($assignment->recommendation)
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($assignment->recommendation === 'accept') bg-green-100 text-green-800
                                        @elseif($assignment->recommendation === 'minor_revisions') bg-blue-100 text-blue-800
                                        @elseif($assignment->recommendation === 'major_revisions') bg-yellow-100 text-yellow-800
                                        @elseif($assignment->recommendation === 'reject') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ str_replace('_', ' ', ucfirst($assignment->recommendation)) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.assignments.show', $assignment) }}" 
                                       class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                       title="View">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    @if(in_array($assignment->status, ['accepted', 'in_progress']))
                                        <form action="{{ route('admin.assignments.remind', $assignment) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="p-2 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors"
                                                    title="Send Reminder"
                                                    onclick="return confirm('Send reminder to this reviewer?')">
                                                <i class="fa-regular fa-bell"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($assignment->status !== 'completed')
                                        <form action="{{ route('admin.assignments.destroy', $assignment) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this assignment?')">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-regular fa-file-lines text-5xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500">No review assignments found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($assignments->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $assignments->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection