@extends('layouts.admnin')

@section('title', 'Pending Journals - Admin')
@section('page-title', 'Pending Journals')

@section('content')
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-yellow-50">
            <div class="flex items-center">
                <i class="fa-regular fa-clock text-yellow-600 mr-2"></i>
                <p class="text-sm text-yellow-700">
                    <span class="font-semibold">{{ $journals->total() }}</span> journals waiting for review
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($journals as $journal)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-800">{{ $journal->title }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800">{{ $journal->author->name }}</div>
                                <div class="text-xs text-gray-500">{{ $journal->author->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $journal->created_at->format('M d, Y') }}
                                <div class="text-xs">{{ $journal->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.journals.show', $journal->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-[#86662c] text-white text-sm rounded-lg hover:bg-[#6b4f23] transition-colors">
                                    <i class="fa-regular fa-eye mr-1"></i>
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-regular fa-circle-check text-5xl text-green-300 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-700 mb-1">No Pending Journals</h3>
                                    <p class="text-sm text-gray-500">All caught up! No journals waiting for review.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($journals->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $journals->links() }}
            </div>
        @endif
    </div>
@endsection