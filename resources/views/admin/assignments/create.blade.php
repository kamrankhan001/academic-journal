@extends('layouts.admin')

@section('title', 'Assign Reviewers - Admin')
@section('page-title', 'Assign Reviewers')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.assignments.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Assignments</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Assign Reviewers</li>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Article Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden sticky top-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Article Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <h4 class="font-medium text-gray-800">{{ $journal->title }}</h4>
                    
                    <div class="text-sm">
                        <p class="text-gray-600 mb-1"><span class="text-gray-400">Author:</span> {{ $journal->author->name }}</p>
                        <p class="text-gray-600 mb-1"><span class="text-gray-400">Submitted:</span> {{ $journal->submitted_at->format('M d, Y') }}</p>
                        <p class="text-gray-600"><span class="text-gray-400">Status:</span> 
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 ml-2">
                                {{ ucfirst($journal->status) }}
                            </span>
                        </p>
                    </div>

                    @if($journal->abstract)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Abstract</p>
                            <p class="text-sm text-gray-600">{{ Str::limit($journal->abstract, 150) }}</p>
                        </div>
                    @endif

                    <!-- Existing Assignments -->
                    @if($existingAssignments->count() > 0)
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-3">Already Assigned</p>
                            <div class="space-y-2">
                                @foreach($existingAssignments as $assignment)
                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-xs font-medium text-gray-600">
                                                    {{ strtoupper(substr($assignment->reviewer->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <span class="text-sm text-gray-600">{{ $assignment->reviewer->user->name }}</span>
                                        </div>
                                        <span class="text-xs px-2 py-1 rounded-full 
                                            @if($assignment->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($assignment->status === 'accepted') bg-blue-100 text-blue-800
                                            @elseif($assignment->status === 'completed') bg-green-100 text-green-800
                                            @endif">
                                            {{ $assignment->status }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Assignment Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Select Reviewers</h3>
                    <p class="text-sm text-gray-500 mt-1">Choose reviewers to assign this article</p>
                </div>

                <form action="{{ route('admin.assign-reviewers.store', $journal) }}" method="POST" class="p-6">
                    @csrf

                    <!-- Due Date -->
                    <div class="mb-6">
                        <label for="due_days" class="block text-sm font-medium text-gray-700 mb-2">
                            Review Due Date <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-4">
                            <select id="due_days" name="due_days" 
                                    class="w-48 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                    required>
                                <option value="7">7 days</option>
                                <option value="14" selected>14 days</option>
                                <option value="21">21 days</option>
                                <option value="28">28 days</option>
                            </select>
                            <span class="text-sm text-gray-500">from today ({{ now()->addDays(14)->format('M d, Y') }})</span>
                        </div>
                    </div>

                    <!-- Reviewers List -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Select Reviewers <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-3 max-h-96 overflow-y-auto p-4 bg-gray-50 rounded-lg">
                            @forelse($reviewers as $reviewer)
                                <label class="flex items-start p-3 bg-white rounded-lg border {{ $reviewer->already_assigned ? 'border-green-300 bg-green-50' : 'border-gray-200 hover:border-[#86662c]' }} transition-colors cursor-pointer">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" 
                                               name="reviewer_ids[]" 
                                               value="{{ $reviewer->id }}"
                                               {{ $reviewer->already_assigned ? 'disabled' : '' }}
                                               class="rounded border-gray-300 text-[#86662c] focus:ring-[#86662c]">
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-800">
                                                {{ $reviewer->user->name }}
                                                @if($reviewer->academic_degree)
                                                    <span class="ml-2 text-xs text-gray-500">({{ $reviewer->academic_degree }})</span>
                                                @endif
                                            </p>
                                            <span class="text-xs text-gray-500">
                                                {{ $reviewer->pending_count }} pending
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500">{{ $reviewer->institution }}</p>
                                        @if($reviewer->expertise_areas)
                                            <div class="mt-1 flex flex-wrap gap-1">
                                                @foreach(array_slice($reviewer->expertise_areas, 0, 3) as $area)
                                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">
                                                        {{ $area }}
                                                    </span>
                                                @endforeach
                                                @if(count($reviewer->expertise_areas) > 3)
                                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">
                                                        +{{ count($reviewer->expertise_areas) - 3 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                        @if($reviewer->already_assigned)
                                            <p class="mt-1 text-xs text-green-600">
                                                <i class="fa-regular fa-circle-check mr-1"></i>
                                                Already assigned to this article
                                            </p>
                                        @endif
                                    </div>
                                </label>
                            @empty
                                <p class="text-gray-500 text-center py-4">No active reviewers available</p>
                            @endforelse
                        </div>
                        @error('reviewer_ids')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Additional Message (Optional)
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none"
                                  placeholder="Add any specific instructions for the reviewers...">{{ old('message') }}</textarea>
                    </div>

                    <!-- Form Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.assignments.index') }}" 
                           class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                            Send Invitations
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection