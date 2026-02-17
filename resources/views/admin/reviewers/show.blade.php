@extends('layouts.admin')

@section('title', $reviewer->user->name . ' - Reviewer Details')
@section('page-title', 'Reviewer Details')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.reviewers.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Reviewers</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">{{ $reviewer->user->name }}</li>
@endsection

@section('content')
    <div class="w-full space-y-6">
        <!-- Header Actions -->
        <div class="flex justify-end items-center space-x-3">
            <a href="{{ route('admin.reviewers.edit', $reviewer) }}" 
               class="px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                <i class="fa-regular fa-pen-to-square mr-2"></i>
                Edit Reviewer
            </a>
            <form action="{{ route('admin.reviewers.toggle-status', $reviewer) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 {{ $reviewer->status === 'active' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-colors">
                    <i class="fa-regular fa-{{ $reviewer->status === 'active' ? 'circle-pause' : 'circle-play' }} mr-2"></i>
                    {{ $reviewer->status === 'active' ? 'Deactivate' : 'Activate' }}
                </button>
            </form>
        </div>

        <!-- Reviewer Info Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info Card -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Reviewer Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-start space-x-6">
                        <!-- Avatar -->
                        <div class="shrink-0">
                            <div class="w-24 h-24 rounded-full bg-[#86662c]/10 flex items-center justify-center">
                                <span class="text-[#86662c] text-3xl font-bold">
                                    {{ strtoupper(substr($reviewer->user->name, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Details -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $reviewer->user->name }}</h1>
                                <div class="flex items-center space-x-2">
                                    @if($reviewer->status === 'active')
                                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                    @elseif($reviewer->status === 'pending')
                                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @else
                                        <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Inactive</span>
                                    @endif
                                    @if($reviewer->academic_degree)
                                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ $reviewer->academic_degree }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Email</p>
                                    <p class="text-sm text-gray-800">{{ $reviewer->user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">ORCID iD</p>
                                    @if($reviewer->orcid_id)
                                        <a href="https://orcid.org/{{ $reviewer->orcid_id }}" target="_blank" 
                                           class="text-sm text-[#86662c] hover:underline">
                                            {{ $reviewer->orcid_id }}
                                        </a>
                                    @else
                                        <p class="text-sm text-gray-400">Not provided</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Institution</p>
                                    <p class="text-sm text-gray-800">{{ $reviewer->institution }}</p>
                                    @if($reviewer->department)
                                        <p class="text-xs text-gray-500">{{ $reviewer->department }}</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Country</p>
                                    <p class="text-sm text-gray-800">{{ $reviewer->country }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Member Since</p>
                                    <p class="text-sm text-gray-800">{{ $reviewer->created_at->format('F d, Y') }}</p>
                                </div>
                            </div>

                            @if($reviewer->bio)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Biography</p>
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $reviewer->bio }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="lg:col-span-1 bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Performance Stats</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_assignments'] }}</p>
                        <p class="text-sm text-gray-600">Total Assignments</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <p class="text-xl font-bold text-green-600">{{ $stats['completed'] }}</p>
                            <p class="text-xs text-gray-600">Completed</p>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-lg">
                            <p class="text-xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                            <p class="text-xs text-gray-600">Pending</p>
                        </div>
                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                            <p class="text-xl font-bold text-purple-600">{{ $stats['accepted'] }}</p>
                            <p class="text-xs text-gray-600">In Progress</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-xl font-bold text-gray-600">{{ $stats['declined'] }}</p>
                            <p class="text-xs text-gray-600">Declined</p>
                        </div>
                    </div>

                    <div class="text-center p-4 bg-[#86662c]/10 rounded-lg">
                        <p class="text-3xl font-bold text-[#86662c]">
                            {{ $stats['avg_score'] ? number_format($stats['avg_score'], 1) : 'N/A' }}
                        </p>
                        <p class="text-sm text-gray-600">Average Rating</p>
                        @if($stats['avg_score'])
                            <div class="flex justify-center mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= round($stats['avg_score']) ? 'text-yellow-400' : 'text-gray-300' }} text-xs"></i>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Expertise Areas -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Areas of Expertise</h3>
            </div>
            <div class="p-6">
                @if($reviewer->expertise_areas && count($reviewer->expertise_areas) > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($reviewer->expertise_areas as $area)
                            <span class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm">
                                {{ $area }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No expertise areas specified.</p>
                @endif
            </div>
        </div>

        <!-- Recent Assignments -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Recent Review Assignments</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Article</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recommendation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentAssignments as $assignment)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-800">{{ Str::limit($assignment->journal->title, 50) }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $assignment->assigned_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm {{ $assignment->due_date && $assignment->due_date->isPast() && $assignment->status !== 'completed' ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                    {{ $assignment->due_date ? $assignment->due_date->format('M d, Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($assignment->status === 'completed')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                    @elseif($assignment->status === 'pending')
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($assignment->status === 'accepted')
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Accepted</span>
                                    @elseif($assignment->status === 'in_progress')
                                        <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">In Progress</span>
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
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    {{ $assignment->overall_score ?? '-' }}/5
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    No review assignments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection