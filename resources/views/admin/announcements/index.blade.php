@extends('layouts.admin')

@section('title', 'Announcements - Admin')
@section('page-title', 'Announcements')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">Announcements</li>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="flex flex-wrap gap-4 mb-6">
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Total</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Sent</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['sent'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Scheduled</p>
            <p class="text-2xl font-bold text-purple-600">{{ $stats['scheduled'] }}</p>
        </div>
        <div class="flex-1 min-w-37.5 bg-white rounded-xl shadow-soft border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Drafts</p>
            <p class="text-2xl font-bold text-amber-600">{{ $stats['draft'] }}</p>
        </div>
    </div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manage Announcements</h2>
            <p class="text-sm text-gray-500 mt-1">Create and send announcements to users</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors shadow-soft">
            <i class="fa-solid fa-plus mr-2"></i>
            New Announcement
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.announcements.index') }}" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-50">
                <input type="text" 
                       name="search" 
                       placeholder="Search announcements..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
            </div>
            <div class="w-40">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none">
                    <option value="all">All Status</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                <i class="fa-solid fa-filter mr-2"></i>
                Filter
            </button>
            <a href="{{ route('admin.announcements.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                Clear
            </a>
        </form>
    </div>

    <!-- Announcements List -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Announcement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-start space-x-3">
                                    <div class="shrink-0">
                                        <div class="w-8 h-8 {{ $announcement->icon_bg }} rounded-lg flex items-center justify-center">
                                            <i class="{{ $announcement->icon }} {{ $announcement->icon_color }} text-sm"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-800">{{ $announcement->title }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ Str::limit($announcement->message, 60) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $announcement->icon_bg }} {{ $announcement->icon_color }}">
                                    {{ ucfirst($announcement->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($announcement->target_roles)
                                    <div class="flex gap-1">
                                        @foreach($announcement->target_roles as $role)
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                                {{ ucfirst($role) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-sm text-gray-600">All Users</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($announcement->sent_at)
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                        Sent {{ $announcement->sent_at->diffForHumans() }}
                                    </span>
                                @elseif($announcement->scheduled_at && $announcement->scheduled_at > now())
                                    <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-700">
                                        Scheduled {{ $announcement->scheduled_at->diffForHumans() }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-amber-100 text-amber-700">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $announcement->created_at->format('M d, Y') }}
                                <div class="text-xs">by {{ $announcement->creator->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.announcements.show', $announcement->id) }}" 
                                       class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                       title="View">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    @if(!$announcement->sent_at)
                                        <a href="{{ route('admin.announcements.edit', $announcement->id) }}" 
                                           class="p-2 text-gray-500 hover:text-[#86662c] hover:bg-gray-100 rounded-lg transition-colors"
                                           title="Edit">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <button onclick="sendAnnouncement({{ $announcement->id }})" 
                                                class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                                title="Send Now">
                                            <i class="fa-regular fa-paper-plane"></i>
                                        </button>
                                    @endif
                                    <button onclick="deleteAnnouncement({{ $announcement->id }})" 
                                            class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Delete">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-regular fa-bell text-5xl text-gray-300 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-700 mb-1">No Announcements</h3>
                                    <p class="text-sm text-gray-500 mb-4">Create your first announcement to notify users.</p>
                                    <a href="{{ route('admin.announcements.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                                        <i class="fa-solid fa-plus mr-2"></i>
                                        Create Announcement
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($announcements->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $announcements->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function sendAnnouncement(id) {
        if (confirm('Are you sure you want to send this announcement now?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/announcements') }}/${id}/send`;
            form.innerHTML = `
                @csrf
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function deleteAnnouncement(id) {
        if (confirm('Are you sure you want to delete this announcement? This action cannot be undone.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/announcements') }}/${id}`;
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