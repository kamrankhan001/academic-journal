@extends('layouts.admin')

@section('title', 'Notifications - Admin Dashboard')
@section('page-title', 'All Notifications')

@section('content')
    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.notifications.index', ['filter' => 'all']) }}" 
                   class="px-4 py-2 {{ request('filter', 'all') === 'all' ? 'bg-[#86662c] text-white' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg text-sm font-medium transition-colors">
                    All
                </a>
                <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}" 
                   class="px-4 py-2 {{ request('filter') === 'unread' ? 'bg-[#86662c] text-white' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg text-sm font-medium transition-colors">
                    Unread
                </a>
                <a href="{{ route('admin.notifications.index', ['filter' => 'read']) }}" 
                   class="px-4 py-2 {{ request('filter') === 'read' ? 'bg-[#86662c] text-white' : 'text-gray-600 hover:bg-gray-100' }} rounded-lg text-sm font-medium transition-colors">
                    Read
                </a>
            </div>
            
            <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-[#86662c] hover:text-[#6b4f23]">
                    <i class="fa-regular fa-circle-check mr-1"></i>
                    Mark All as Read
                </button>
            </form>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @forelse($notifications as $notification)
            @php
                $data = json_decode($notification->data, true);
                $isUnread = is_null($notification->read_at);
                
                // Determine icon based on notification type or data
                $type = $data['type'] ?? 'notification';
                $icon = match($type) {
                    'announcement' => 'fa-solid fa-bullhorn',
                    'review_assigned' => 'fa-solid fa-user-check',
                    'review_completed' => 'fa-solid fa-check-circle',
                    'revision_requested' => 'fa-solid fa-pen-to-square',
                    'submission_received' => 'fa-solid fa-file-arrow-up',
                    'paper_accepted' => 'fa-solid fa-circle-check',
                    'paper_rejected' => 'fa-solid fa-circle-xmark',
                    default => 'fa-regular fa-bell'
                };
                
                $iconColor = match($type) {
                    'announcement' => 'text-purple-600',
                    'review_assigned' => 'text-blue-600',
                    'review_completed' => 'text-green-600',
                    'revision_requested' => 'text-yellow-600',
                    'submission_received' => 'text-indigo-600',
                    'paper_accepted' => 'text-green-600',
                    'paper_rejected' => 'text-red-600',
                    default => 'text-gray-600'
                };
                
                $iconBg = match($type) {
                    'announcement' => 'bg-purple-100',
                    'review_assigned' => 'bg-blue-100',
                    'review_completed' => 'bg-green-100',
                    'revision_requested' => 'bg-yellow-100',
                    'submission_received' => 'bg-indigo-100',
                    'paper_accepted' => 'bg-green-100',
                    'paper_rejected' => 'bg-red-100',
                    default => 'bg-gray-100'
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
                                    {{ $data['title'] ?? ucwords(str_replace('_', ' ', $type)) }}
                                </h4>
                                @if($isUnread)
                                    <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">New</span>
                                @endif
                            </div>
                            
                            <!-- Message -->
                            <p class="text-sm text-gray-600 mb-2">{{ $data['message'] ?? 'No message content' }}</p>
                            
                            <!-- Additional Data (if any) -->
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
                            
                            <!-- Metadata -->
                            <div class="flex items-center flex-wrap gap-3 mt-2">
                                <p class="text-xs text-gray-400">
                                    <i class="fa-regular fa-clock mr-1"></i>
                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                </p>
                                
                                @if($notification->notifiable_type)
                                    @php
                                        $notifiableType = class_basename($notification->notifiable_type);
                                    @endphp
                                    <p class="text-xs text-gray-400">
                                        <i class="fa-regular fa-user mr-1"></i>
                                        To: {{ $notifiableType }}
                                    </p>
                                @endif
                                
                                @if(isset($data['action_url']))
                                    <a href="{{ $data['action_url'] }}" class="text-xs text-[#86662c] hover:text-[#6b4f23]">
                                        <i class="fa-regular fa-eye mr-1"></i>
                                        View Details
                                    </a>
                                @endif
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
                <p class="text-gray-500">There are no notifications in the system yet.</p>
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
        fetch(`/admin/notifications/${notificationId}/mark-as-read`, {
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
                
                // Show success toast
                if (window.toast) {
                    toast.success('Notification marked as read');
                }
            }
        }).catch(error => {
            console.error('Error:', error);
            if (window.toast) {
                toast.error('Failed to mark notification as read');
            }
        });
    }

    function deleteNotification(notificationId) {
        if (confirm('Are you sure you want to delete this notification?')) {
            fetch(`/admin/notifications/${notificationId}`, {
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
                    
                    // Show success toast
                    if (window.toast) {
                        toast.success('Notification deleted successfully');
                    }
                }
            }).catch(error => {
                console.error('Error:', error);
                if (window.toast) {
                    toast.error('Failed to delete notification');
                }
            });
        }
    }

    function updateNotificationCount() {
        // You can implement this to update the header badge
        fetch('/admin/notifications/unread-count', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('#notificationBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count > 9 ? '9+' : data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        });
    }
</script>
@endpush