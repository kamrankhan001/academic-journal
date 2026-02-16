@extends('layouts.admin')

@section('title', 'View User - Admin')
@section('page-title', 'User Details')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Users</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">View</li>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- User Profile Header -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="bg-linear-to-r from-gray-50 to-gray-200 h-32"></div>
            <div class="px-6 pb-6 relative">
                <div class="flex flex-col sm:flex-row sm:items-end -mt-16">
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 rounded-full border-4 border-white bg-white overflow-hidden shadow-lg">
                            @if($user->profile && $user->profile->avatar)
                                <img src="{{ asset('storage/' . $user->profile->avatar) }}" alt="{{ $user->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-amber-100 flex items-center justify-center">
                                    <span class="text-amber-700 text-2xl font-bold">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-6 flex-1">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                                <p class="text-gray-600">{{ $user->email }}</p>
                                @if($user->profile && $user->profile->institution)
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="fa-regular fa-building mr-1"></i>
                                        {{ $user->profile->institution }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex space-x-2 mt-4 sm:mt-0">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="px-4 py-2 bg-amber-700 text-white rounded-lg hover:bg-amber-800 transition-colors">
                                    <i class="fa-regular fa-pen-to-square mr-2"></i>
                                    Edit User
                                </a>
                                @if($user->role !== 'admin' || App\Models\User::where('role', 'admin')->count() > 1)
                                    <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')"
                                        class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                        <i class="fa-regular fa-trash-can mr-2"></i>
                                        Delete
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Stats -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
                    <div class="bg-amber-50 rounded-lg p-4 border border-amber-100">
                        <p class="text-xs text-amber-700 uppercase font-semibold">Role</p>
                        <p class="text-lg font-bold text-gray-800">{{ ucfirst($user->role) }}</p>
                    </div>
                    <div class="bg-amber-50 rounded-lg p-4 border border-amber-100">
                        <p class="text-xs text-amber-700 uppercase font-semibold">Status</p>
                        @if($user->email_verified_at)
                            <p class="text-lg font-bold text-green-600">Verified</p>
                        @else
                            <p class="text-lg font-bold text-yellow-600">Unverified</p>
                        @endif
                    </div>
                    <div class="bg-amber-50 rounded-lg p-4 border border-amber-100">
                        <p class="text-xs text-amber-700 uppercase font-semibold">Journals</p>
                        <p class="text-lg font-bold text-gray-800">{{ $user->journals_count }}</p>
                    </div>
                    <div class="bg-amber-50 rounded-lg p-4 border border-amber-100">
                        <p class="text-xs text-amber-700 uppercase font-semibold">Co-authored</p>
                        <p class="text-lg font-bold text-gray-800">{{ $coAuthoredJournalsCount }}</p>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    @if($user->profile && $user->profile->country)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Country</h4>
                            <p class="text-gray-800 font-medium">{{ $user->profile->country->name }}</p>
                        </div>
                    @endif
                    @if($user->profile && $user->profile->bio)
                        <div class="md:col-span-2 bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Biography</h4>
                            <p class="text-gray-700 leading-relaxed">{{ $user->profile->bio }}</p>
                        </div>
                    @endif
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Member Since</h4>
                        <p class="text-gray-800 font-medium">{{ $user->created_at->format('F d, Y') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Last Updated</h4>
                        <p class="text-gray-800 font-medium">{{ $user->updated_at->format('F d, Y') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $user->updated_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Email Verification Action -->
                @if(!$user->email_verified_at)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <form action="{{ route('admin.users.verify-email', $user->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-amber-700 hover:text-amber-800 font-medium">
                                <i class="fa-regular fa-circle-check mr-1"></i>
                                Verify Email Manually
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Authored Journals -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fa-regular fa-pen-to-square mr-2 text-amber-700"></i>
                    Authored Journals
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($user->journals as $journal)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-800">{{ Str::limit($journal->title, 60) }}</div>
                                    @if($journal->tags->count() > 0)
                                        <div class="flex gap-1 mt-1">
                                            @foreach($journal->tags->take(2) as $tag)
                                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $tag->name }}</span>
                                            @endforeach
                                            @if($journal->tags->count() > 2)
                                                <span class="text-xs text-gray-400">+{{ $journal->tags->count() - 2 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
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
                                    <span class="px-3 py-1 text-xs rounded-full {{ $statusColor }}">
                                        {{ str_replace('_', ' ', ucfirst($journal->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $journal->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.journals.show', $journal->id) }}"
                                        class="text-amber-700 hover:text-amber-800 text-sm font-medium">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-regular fa-file-lines text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500">No authored journals found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($user->journals_count > 5)
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <a href="{{ route('admin.journals.index', ['author' => $user->id]) }}"
                        class="text-amber-700 hover:text-amber-800 text-sm font-medium">
                        View all {{ $user->journals_count }} journals <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @endif
        </div>

        <!-- Co-Authored Journals -->
        @if($coAuthoredJournals->count() > 0)
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fa-regular fa-users mr-2 text-amber-700"></i>
                        Co-Authored Journals
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Main Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($coAuthoredJournals as $journal)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-800">{{ Str::limit($journal->title, 60) }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-800">{{ $journal->author->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $journal->author->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
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
                                        <span class="px-3 py-1 text-xs rounded-full {{ $statusColor }}">
                                            {{ str_replace('_', ' ', ucfirst($journal->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.journals.show', $journal->id) }}"
                                            class="text-amber-700 hover:text-amber-800 text-sm font-medium">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($coAuthoredJournalsCount > 5)
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <a href="{{ route('admin.journals.index', ['co-author' => $user->email]) }}"
                            class="text-amber-700 hover:text-amber-800 text-sm font-medium">
                            View all {{ $coAuthoredJournalsCount }} co-authored journals <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function deleteUser(id, name) {
            if (confirm('Are you sure you want to delete the user "' + name + '"? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin/users') }}/${id}`;
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