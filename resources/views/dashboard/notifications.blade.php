@extends('layouts.dashboard')

@section('title', 'Notifications - Academic Journal')
@section('page-title', 'Notifications')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    <span class="text-gray-800">Notifications</span>
@endsection

@section('content')
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <a href="{{ route('author.notifications', ['filter' => 'all']) }}" 
                   class="px-4 py-2 {{ $filter === 'all' ? 'bg-[#86662c] text-white' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg text-sm font-medium transition-colors">
                    All
                </a>
                <a href="{{ route('author.notifications', ['filter' => 'unread']) }}" 
                   class="px-4 py-2 {{ $filter === 'unread' ? 'bg-[#86662c] text-white' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg text-sm font-medium transition-colors">
                    Unread
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="ml-1 px-1.5 py-0.5 bg-red-500 text-white text-xs rounded-full">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('author.notifications', ['filter' => 'read']) }}" 
                   class="px-4 py-2 {{ $filter === 'read' ? 'bg-[#86662c] text-white' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg text-sm font-medium transition-colors">
                    Read
                </a>
            </div>
            
            @if(Auth::user()->unreadNotifications->count() > 0)
                <form action="{{ route('author.notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-[#86662c] hover:text-[#6b4f23]">
                        <i class="fa-regular fa-circle-check mr-1"></i>
                        Mark All as Read
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        @forelse($notifications as $notification)
            @php
                $data = $notification->data;
                $isUnread = is_null($notification->read_at);
                $iconBg = $data['icon_bg'] ?? 'bg-gray-100';
                $iconColor = $data['icon_color'] ?? 'text-gray-600';
                $icon = $data['icon'] ?? 'fa-regular fa-bell';
            @endphp
            
            <div class="p-6 border-b border-gray-200 {{ $isUnread ? 'bg-[#86662c]/5' : '' }}" data-notification-id="{{ $notification->id }}">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 {{ $iconBg }} rounded-full flex items-center justify-center shrink-0">
                            <i class="{{ $icon }} {{ $iconColor }}"></i>
                        </div>
                        <div>
                            <div class="flex items-center mb-1">
                                <h4 class="text-sm font-semibold text-gray-800">
                                    {{ $data['type'] === 'announcement' ? $data['title'] : ucwords(str_replace('_', ' ', $data['type'])) }}
                                </h4>
                                @if($isUnread)
                                    <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">New</span>
                                @endif
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-2">{{ $data['message'] }}</p>
                            @if (isset($data['revision_notes']))
                                <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-xs text-yellow-800 font-medium">Revision Notes:</p>
                                    <p class="text-xs text-yellow-700">{{ $data['revision_notes'] }}</p>
                                </div>
                            @endif
                            @if (isset($data['rejection_reason']))
                                <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-xs text-yellow-800 font-medium">Rejection Reason:</p>
                                    <p class="text-xs text-yellow-700">{{ $data['rejection_reason'] }}</p>
                                </div>
                            @endif
                            
                            <div class="flex items-center space-x-3">
                                <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                
                                @if(isset($data['action_url']))
                                    <a href="{{ $data['action_url'] }}" class="text-xs text-[#86662c] hover:text-[#6b4f23]">
                                        View Details
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        @if($isUnread)
                            <button onclick="markAsRead('{{ $notification->id }}')" 
                                    class="text-gray-400 hover:text-[#86662c] transition-colors"
                                    title="Mark as read">
                                <i class="fa-regular fa-circle-check"></i>
                            </button>
                        @endif
                        <button onclick="deleteNotification('{{ $notification->id }}')" 
                                class="text-gray-400 hover:text-red-600 transition-colors"
                                title="Delete">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-regular fa-bell-slash text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">No notifications</h3>
                <p class="text-gray-500">You're all caught up! Check back later for updates on your submissions.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @endif
@endsection

@push('scripts')
<script>
    function markAsRead(notificationId) {
        fetch(`/author/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        }).then(response => {
            if (response.ok) {
                // Remove the "New" badge and update styles
                const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
                notification.classList.remove('bg-[#86662c]/5');
                const newBadge = notification.querySelector('.bg-blue-100');
                if (newBadge) newBadge.remove();
                
                // Update notification count in header
                updateNotificationCount();
            }
        });
    }

    function deleteNotification(notificationId) {
        if (confirm('Are you sure you want to delete this notification?')) {
            fetch(`/author/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            }).then(response => {
                if (response.ok) {
                    const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    notification.remove();
                    
                    // Check if there are any notifications left
                    const notificationsList = document.querySelector('.bg-white.overflow-hidden');
                    if (notificationsList.children.length === 0) {
                        location.reload(); // Reload to show empty state
                    }
                    
                    // Update notification count in header
                    updateNotificationCount();
                }
            });
        }
    }

    function updateNotificationCount() {
        // Update the header notification count
        const unreadCount = document.querySelectorAll('[data-notification-id] .bg-blue-100').length;
        const badge = document.querySelector('.relative .bg-red-500');
        if (badge) {
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
            } else {
                badge.remove();
            }
        }
    }
</script>
@endpush