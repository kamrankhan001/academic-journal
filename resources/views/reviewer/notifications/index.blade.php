@extends('layouts.reviewer')

@section('title', 'Notifications - Reviewer Dashboard')
@section('page-title', 'Notifications')

@section('content')
    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <a href="{{ route('reviewer.notifications.index', ['filter' => 'all']) }}" 
                   class="px-4 py-2 {{ $filter === 'all' ? 'bg-[#86662c] text-white' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg text-sm font-medium transition-colors">
                    All
                </a>
                <a href="{{ route('reviewer.notifications.index', ['filter' => 'unread']) }}" 
                   class="px-4 py-2 {{ $filter === 'unread' ? 'bg-[#86662c] text-white' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg text-sm font-medium transition-colors">
                    Unread
                    @php
                        $unreadCount = DB::table('notifications')
                            ->where('notifiable_id', auth()->id())
                            ->where('notifiable_type', 'App\Models\User')
                            ->whereNull('read_at')
                            ->count();
                    @endphp
                    @if($unreadCount > 0 && $filter !== 'unread')
                        <span class="ml-1 px-1.5 py-0.5 bg-red-500 text-white text-xs rounded-full">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('reviewer.notifications.index', ['filter' => 'read']) }}" 
                   class="px-4 py-2 {{ $filter === 'read' ? 'bg-[#86662c] text-white' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg text-sm font-medium transition-colors">
                    Read
                </a>
            </div>
            
            @if($filter === 'unread' || ($unreadCount ?? 0) > 0)
                <form action="{{ route('reviewer.notifications.mark-all-read') }}" method="POST" class="inline">
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
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @forelse($notifications as $notification)
            @php
                $data = json_decode($notification->data, true);
                $isUnread = is_null($notification->read_at);
                
                // Determine notification type and icon
                $type = $data['type'] ?? 'notification';
                $title = match($type) {
                    'review_invitation' => 'New Review Invitation',
                    'assignment_accepted' => 'Review Accepted',
                    'reminder' => 'Reminder',
                    'deadline_extension' => 'Deadline Extended',
                    'review_submitted' => 'Review Submitted',
                    'admin_message' => 'Message from Admin',
                    default => 'Notification'
                };
                
                $icon = match($type) {
                    'review_invitation' => 'fa-regular fa-envelope',
                    'assignment_accepted' => 'fa-regular fa-circle-check',
                    'reminder' => 'fa-regular fa-clock',
                    'deadline_extension' => 'fa-regular fa-calendar-plus',
                    'review_submitted' => 'fa-regular fa-file-lines',
                    'admin_message' => 'fa-regular fa-message',
                    default => 'fa-regular fa-bell'
                };
                
                $iconBg = match($type) {
                    'review_invitation' => 'bg-blue-100',
                    'assignment_accepted' => 'bg-green-100',
                    'reminder' => 'bg-yellow-100',
                    'deadline_extension' => 'bg-purple-100',
                    'review_submitted' => 'bg-indigo-100',
                    'admin_message' => 'bg-gray-100',
                    default => 'bg-gray-100'
                };
                
                $iconColor = match($type) {
                    'review_invitation' => 'text-blue-600',
                    'assignment_accepted' => 'text-green-600',
                    'reminder' => 'text-yellow-600',
                    'deadline_extension' => 'text-purple-600',
                    'review_submitted' => 'text-indigo-600',
                    'admin_message' => 'text-gray-600',
                    default => 'text-gray-600'
                };
            @endphp
            
            <div class="p-6 border-b border-gray-200 {{ $isUnread ? 'bg-[#86662c]/5' : '' }}" data-notification-id="{{ $notification->id }}">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4 flex-1">
                        <!-- Icon -->
                        <div class="w-10 h-10 {{ $iconBg }} rounded-full flex items-center justify-center shrink-0">
                            <i class="{{ $icon }} {{ $iconColor }}"></i>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-center mb-1">
                                <h4 class="text-sm font-semibold text-gray-800">
                                    {{ $data['title'] ?? $title }}
                                </h4>
                                @if($isUnread)
                                    <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">New</span>
                                @endif
                            </div>
                            
                            <!-- Message -->
                            <p class="text-sm text-gray-600 mb-2">{{ $data['message'] ?? 'No message content' }}</p>
                            
                            <!-- Additional Data -->
                            @if(isset($data['journal_title']))
                                <p class="text-xs text-gray-500 mb-1">
                                    <i class="fa-regular fa-file-lines mr-1"></i>
                                    Journal: {{ $data['journal_title'] }}
                                </p>
                            @endif
                            
                            @if(isset($data['due_date']))
                                <p class="text-xs text-gray-500 mb-1">
                                    <i class="fa-regular fa-calendar mr-1"></i>
                                    Due: {{ \Carbon\Carbon::parse($data['due_date'])->format('M d, Y') }}
                                </p>
                            @endif
                            
                            @if(isset($data['deadline']))
                                <p class="text-xs text-gray-500 mb-1">
                                    <i class="fa-regular fa-calendar mr-1"></i>
                                    New Deadline: {{ \Carbon\Carbon::parse($data['deadline'])->format('M d, Y') }}
                                </p>
                            @endif
                            
                            @if(isset($data['admin_message']))
                                <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-xs text-blue-800 font-medium">Message from Admin:</p>
                                    <p class="text-xs text-blue-700">{{ $data['admin_message'] }}</p>
                                </div>
                            @endif
                            
                            <!-- Metadata -->
                            <div class="flex items-center flex-wrap gap-3 mt-2">
                                <p class="text-xs text-gray-400">
                                    <i class="fa-regular fa-clock mr-1"></i>
                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                </p>
                                
                                <!-- @if(isset($data['action_url']) && $data['action_url'] !== '#')
                                    <a href="{{ $data['action_url'] }}" class="text-xs text-[#86662c] hover:text-[#6b4f23]">
                                        <i class="fa-regular fa-eye mr-1"></i>
                                        View Details
                                    </a>
                                @endif -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center space-x-2 ml-4">
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
                <p class="text-gray-500">You're all caught up! Check back later for updates.</p>
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
        fetch(`/reviewer/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notification) {
                    notification.classList.remove('bg-[#86662c]/5');
                    const newBadge = notification.querySelector('.bg-blue-100');
                    if (newBadge) newBadge.remove();
                }
                
                // Update notification count
                updateNotificationCount();
                
                // Show success message if toast exists
                if (window.toast) {
                    toast.success('Notification marked as read');
                }
                
                // If current filter is 'unread', remove the notification from view
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('filter') === 'unread') {
                    notification.remove();
                    
                    // Check if there are any notifications left
                    const notificationsList = document.querySelector('.bg-white.overflow-hidden');
                    if (notificationsList.children.length === 0) {
                        location.reload(); // Reload to show empty state
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (window.toast) {
                toast.error('Failed to mark notification as read');
            }
        });
    }

    function deleteNotification(notificationId) {
        if (confirm('Are you sure you want to delete this notification?')) {
            fetch(`/reviewer/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    notification.remove();
                    
                    // Check if there are any notifications left
                    const notificationsList = document.querySelector('.bg-white.overflow-hidden');
                    if (notificationsList.children.length === 0) {
                        location.reload(); // Reload to show empty state
                    }
                    
                    // Update notification count
                    updateNotificationCount();
                    
                    if (window.toast) {
                        toast.success('Notification deleted');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (window.toast) {
                    toast.error('Failed to delete notification');
                }
            });
        }
    }

    function updateNotificationCount() {
        fetch('/reviewer/notifications/unread-count', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            // Update header badge
            const badge = document.getElementById('notificationBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count > 9 ? '9+' : data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
            
            // Update filter badge if on unread filter
            const filterBadge = document.querySelector('a[href*="filter=unread"] span');
            if (filterBadge) {
                if (data.count > 0) {
                    filterBadge.textContent = data.count > 9 ? '9+' : data.count;
                    filterBadge.classList.remove('hidden');
                } else {
                    filterBadge.classList.add('hidden');
                }
            }
        })
        .catch(error => console.error('Error updating count:', error));
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateNotificationCount();
    });
</script>
@endpush