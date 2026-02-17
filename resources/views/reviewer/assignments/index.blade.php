@extends('layouts.reviewer')

@section('title', 'My Reviews')
@section('page-title', 'My Review Assignments')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    <span class="text-gray-800">My Reviews</span>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">In Progress</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['accepted'] }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-pen-to-square text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Completed</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['completed'] }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-circle-check text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Overdue</p>
                    <p class="text-2xl font-bold {{ $stats['overdue'] > 0 ? 'text-red-600' : 'text-gray-800' }}">
                        {{ $stats['overdue'] }}
                    </p>
                </div>
                <div class="w-10 h-10 {{ $stats['overdue'] > 0 ? 'bg-red-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-clock text-{{ $stats['overdue'] > 0 ? 'red' : 'gray' }}-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="{{ route('reviewer.assignments.index') }}?filter=all" 
                   class="px-6 py-3 text-sm font-medium {{ $filter === 'all' ? 'border-b-2 border-[#86662c] text-[#86662c]' : 'text-gray-500 hover:text-gray-700' }}">
                    All
                </a>
                <a href="{{ route('reviewer.assignments.index') }}?filter=pending" 
                   class="px-6 py-3 text-sm font-medium {{ $filter === 'pending' ? 'border-b-2 border-[#86662c] text-[#86662c]' : 'text-gray-500 hover:text-gray-700' }}">
                    Pending
                </a>
                <a href="{{ route('reviewer.assignments.index') }}?filter=accepted" 
                   class="px-6 py-3 text-sm font-medium {{ $filter === 'accepted' ? 'border-b-2 border-[#86662c] text-[#86662c]' : 'text-gray-500 hover:text-gray-700' }}">
                    In Progress
                </a>
                <a href="{{ route('reviewer.assignments.index') }}?filter=completed" 
                   class="px-6 py-3 text-sm font-medium {{ $filter === 'completed' ? 'border-b-2 border-[#86662c] text-[#86662c]' : 'text-gray-500 hover:text-gray-700' }}">
                    Completed
                </a>
                <a href="{{ route('reviewer.assignments.index') }}?filter=overdue" 
                   class="px-6 py-3 text-sm font-medium {{ $filter === 'overdue' ? 'border-b-2 border-[#86662c] text-[#86662c]' : 'text-gray-500 hover:text-gray-700' }}">
                    Overdue
                </a>
            </nav>
        </div>

        <!-- Assignments List -->
        <div class="divide-y divide-gray-200">
            @forelse($assignments as $assignment)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($assignment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($assignment->status === 'accepted') bg-blue-100 text-blue-800
                                    @elseif($assignment->status === 'in_progress') bg-purple-100 text-purple-800
                                    @elseif($assignment->status === 'completed') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ str_replace('_', ' ', ucfirst($assignment->status)) }}
                                </span>
                                @if($assignment->due_date && $assignment->status !== 'completed')
                                    <span class="text-xs {{ $assignment->due_date->isPast() ? 'text-red-600' : 'text-gray-500' }}">
                                        <i class="fa-regular fa-calendar mr-1"></i>
                                        Due: {{ $assignment->due_date->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                            
                            <h3 class="text-lg font-medium text-gray-800 mb-1">
                                {{ $assignment->journal->title }}
                            </h3>
                            
                            <p class="text-sm text-gray-500 mb-2">
                                Assigned: {{ $assignment->assigned_at->format('M d, Y') }}
                            </p>
                            
                            @if($assignment->status === 'completed' && $assignment->completed_at)
                                <p class="text-xs text-gray-400">
                                    Completed: {{ $assignment->completed_at->format('M d, Y') }}
                                </p>
                            @endif
                        </div>
                        
                        <div class="ml-4 flex flex-col space-y-2">
                            @if($assignment->status === 'pending')
                                <a href="{{ route('reviewer.assignments.show', $assignment) }}" 
                                   class="px-4 py-2 bg-[#86662c] text-white text-sm rounded-lg hover:bg-[#6b4f23] transition-colors text-center">
                                    View & Respond
                                </a>
                            @elseif(in_array($assignment->status, ['accepted', 'in_progress']))
                                <a href="{{ route('reviewer.assignments.review', $assignment) }}" 
                                   class="px-4 py-2 bg-[#86662c] text-white text-sm rounded-lg hover:bg-[#6b4f23] transition-colors text-center">
                                    Continue Review
                                </a>
                            @elseif($assignment->status === 'completed')
                                <a href="{{ route('reviewer.assignments.show', $assignment) }}" 
                                   class="px-4 py-2 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    View Details
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <i class="fa-regular fa-file-lines text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500 mb-2">No review assignments found</p>
                    <p class="text-sm text-gray-400">When you're assigned reviews, they'll appear here</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-200">
            {{ $assignments->appends(['filter' => $filter])->links() }}
        </div>
    </div>
@endsection