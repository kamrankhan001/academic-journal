<header class="bg-white border-b border-gray-200 h-16 flex items-center px-6">
    <div class="flex items-center justify-between w-full">
        <!-- Left side - Mobile menu toggle and page title -->
        <div class="flex items-center">
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-[#86662c] mr-4">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <h2 class="text-lg font-semibold text-gray-800 hidden md:block">@yield('page-title', 'Admin Dashboard')</h2>
        </div>

        <!-- Right side - Admin menu -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <div class="relative" id="notificationsDropdown">
                <button onclick="toggleDropdown('notifications')" class="text-gray-500 hover:text-[#86662c] relative">
                    <i class="fa-regular fa-bell text-xl"></i>
                    @php
                        $unreadCount = Auth::user()->unreadNotifications->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span id="notificationBadge"
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                    @else
                        <span id="notificationBadge"
                            class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center"></span>
                    @endif
                </button>

                <!-- Notifications Dropdown -->
                <div id="notificationsMenu"
                    class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                    <div class="p-3 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-800">Notifications</h3>
                        @if($unreadCount > 0)
                            <button onclick="markAllAsRead()" class="text-xs text-[#86662c] hover:text-[#6b4f23]">
                                Mark all read
                            </button>
                        @endif
                    </div>

                    <div class="max-h-96 overflow-y-auto" id="notificationsList">
                        @forelse(Auth::user()->notifications()->latest()->take(5)->get() as $notification)
                            @php
                                $data = $notification->data;
                                $isUnread = is_null($notification->read_at);
                                $actionUrl = $data['action_url'] ?? '#';
                            @endphp
                            <a href="{{ $actionUrl }}" 
                               class="block p-3 hover:bg-gray-50 border-b border-gray-100 notification-item {{ $isUnread ? 'bg-blue-50/50' : '' }}"
                               data-id="{{ $notification->id }}"
                               onclick="handleNotificationClick(event, '{{ $notification->id }}')">
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $data['title'] ?? (isset($data['type']) && $data['type'] === 'announcement' ? 'Announcement' : ucwords(str_replace('_', ' ', $data['type'] ?? 'notification'))) }}
                                </p>
                                <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $data['message'] ?? 'No message' }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </a>
                        @empty
                            <div class="p-6 text-center">
                                <i class="fa-regular fa-bell-slash text-2xl text-gray-300 mb-2"></i>
                                <p class="text-sm text-gray-500">No notifications</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-3 border-t border-gray-200 text-center">
                        <a href="{{ route('admin.notifications.index') }}"
                            class="text-xs text-[#86662c] hover:text-[#6b4f23] font-medium">
                            View All Notifications
                        </a>
                    </div>
                </div>
            </div>

            <!-- Admin Dropdown -->
            <div class="relative" id="userDropdown">
                <button onclick="toggleDropdown('user')" class="flex items-center space-x-3 focus:outline-none">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->role ?? 'Administrator' }}</p>
                    </div>

                    @php
                        $uiAvatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=86662c&color=fff&size=40';
                        $avatarUrl = $uiAvatarUrl;

                        if (Auth::user()->profile && Auth::user()->profile->avatar) {
                            $avatarUrl = asset('storage/' . Auth::user()->profile->avatar);
                        }
                    @endphp

                    <img src="{{ $avatarUrl }}"
                        class="w-10 h-10 rounded-full border-2 border-gray-200 {{ Auth::user()->profile && Auth::user()->profile->avatar ? 'object-cover' : '' }}"
                        alt="{{ Auth::user()->name }}" onerror="this.onerror=null; this.src='{{ $uiAvatarUrl }}';">

                    <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="userMenu"
                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                    <a href="{{ route('admin.profile') }}"
                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#86662c]">
                        <i class="fa-regular fa-user mr-2"></i>
                        My Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                            <i class="fa-solid fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Dropdown toggle function
    function toggleDropdown(type) {
        const notificationsMenu = document.getElementById('notificationsMenu');
        const userMenu = document.getElementById('userMenu');

        if (type === 'notifications') {
            if (notificationsMenu) {
                notificationsMenu.classList.toggle('hidden');
                if (userMenu && !userMenu.classList.contains('hidden')) {
                    userMenu.classList.add('hidden');
                }
            }
        } else if (type === 'user') {
            if (userMenu) {
                userMenu.classList.toggle('hidden');
                if (notificationsMenu && !notificationsMenu.classList.contains('hidden')) {
                    notificationsMenu.classList.add('hidden');
                }
            }
        }
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const notificationsDropdown = document.getElementById('notificationsDropdown');
        const userDropdown = document.getElementById('userDropdown');
        const notificationsMenu = document.getElementById('notificationsMenu');
        const userMenu = document.getElementById('userMenu');

        if (notificationsDropdown && !notificationsDropdown.contains(event.target)) {
            if (notificationsMenu && !notificationsMenu.classList.contains('hidden')) {
                notificationsMenu.classList.add('hidden');
            }
        }

        if (userDropdown && !userDropdown.contains(event.target)) {
            if (userMenu && !userMenu.classList.contains('hidden')) {
                userMenu.classList.add('hidden');
            }
        }
    });

    // Handle notification click
    function handleNotificationClick(event, notificationId) {
        // Mark as read when clicked
        markAsRead(notificationId);
        
        // Don't prevent default - let the link work
        // But we want to keep the dropdown open until navigation
        event.stopPropagation();
    }

    // Mark single notification as read
    function markAsRead(notificationId) {
        fetch(`/admin/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update UI
                const notificationItem = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
                if (notificationItem) {
                    notificationItem.classList.remove('bg-blue-50/50');
                }
                
                // Update notification count
                updateNotificationCount();
                
                // Show success toast if available
                if (window.toast) {
                    toast.success('Notification marked as read');
                }
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    }

    // Mark all notifications as read
    function markAllAsRead() {
        fetch('{{ route("admin.notifications.mark-all-read") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update UI
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.classList.remove('bg-blue-50/50');
                });
                
                // Remove mark all button
                const markAllBtn = document.querySelector('#notificationsMenu button[onclick="markAllAsRead()"]');
                if (markAllBtn) {
                    markAllBtn.remove();
                }
                
                // Update notification count
                updateNotificationCount();
                
                // Show success toast if available
                if (window.toast) {
                    toast.success('All notifications marked as read');
                }
            }
        })
        .catch(error => {
            console.error('Error marking all notifications as read:', error);
            if (window.toast) {
                toast.error('Failed to mark all as read');
            }
        });
    }

    // Update notification count badge
    function updateNotificationCount() {
        fetch('/admin/notifications/unread-count', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const badge = document.getElementById('notificationBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count > 9 ? '9+' : data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        })
        .catch(error => {
            console.error('Error updating notification count:', error);
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initial notification count
        updateNotificationCount();
        
        // Add click handlers to notification items
        document.querySelectorAll('.notification-item').forEach(item => {
            const notificationId = item.dataset.id;
            if (notificationId && !item.hasAttribute('data-handler-attached')) {
                item.setAttribute('data-handler-attached', 'true');
            }
        });
    });

    // Poll for new notifications every 60 seconds
    setInterval(updateNotificationCount, 60000);

    // Optional: Show new notification toast when count increases
    let previousCount = {{ $unreadCount }};
    setInterval(function() {
        fetch('/admin/notifications/unread-count', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.count > previousCount && window.toast) {
                toast.info('You have new notifications');
            }
            previousCount = data.count;
        })
        .catch(error => {
            console.error('Error checking for new notifications:', error);
        });
    }, 30000); // Check every 30 seconds
</script>