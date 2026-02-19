<aside id="sidebar"
    class="bg-white border-r border-gray-200 w-64 fixed inset-y-0 left-0 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="h-full flex flex-col">
        <!-- Logo -->
        <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200">
            <a href="{{ route('author.index') }}" class="flex items-center">
                <img src="{{ asset('logo.png') }}" alt="Academic Journal" class="h-8 w-auto">
            </a>
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-[#86662c]">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>

        <!-- User Info (Mobile) -->
        <div class="lg:hidden p-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=86662c&color=fff&size=40"
                    class="w-10 h-10 rounded-full" alt="{{ Auth::user()->name }}">
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4">
            <!-- Section 1: Main -->
            <div class="px-3 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</p>
            </div>
            <ul class="space-y-1 px-3 mb-6">
                <!-- Dashboard Overview -->
                <li>
                    <a href="{{ route('author.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('author.index') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-chart-pie w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('author.index') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Dashboard</span>
                    </a>
                </li>
            </ul>

            <!-- Section 2: Submissions -->
            <div class="px-3 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Submissions</p>
            </div>
            <ul class="space-y-1 px-3 mb-6">
                <!-- My Journals (Submissions) -->
                <li>
                    <a href="{{ route('author.journals.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('author.journals.*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-file-lines w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('author.journals.*') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">My Journals</span>
                    </a>
                </li>
            </ul>

            <!-- Section 3: Account -->
            <div class="px-3 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Account</p>
            </div>
            <ul class="space-y-1 px-3 mb-6">
                <!-- Notifications -->
                <li>
                    <a href="{{ route('author.notifications') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('author.notifications') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-bell w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('author.notifications') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Notifications</span>
                        <span id="notificationBadge"
                            class="ml-auto bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center hidden">
                        </span>
                    </a>
                </li>

                <!-- Profile Settings -->
                <li>
                    <a href="{{ route('author.profile') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('author.profile') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-user w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('author.profile') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Profile</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit"
                    class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors group cursor-pointer">
                    <i class="fa-solid fa-sign-out-alt w-5 text-gray-400 group-hover:text-red-600"></i>
                    <span class="ml-3 text-sm font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<script>
function loadNotificationCount() {
    fetch("{{ route('author.notifications.unread-count') }}")
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('notificationBadge');

            if (!badge) return;

            if (data.count > 0) {
                badge.classList.remove('hidden');
                badge.innerText = data.count > 9 ? '9+' : data.count;
            } else {
                badge.classList.add('hidden');
            }
        });
}

// Load on page start
loadNotificationCount();

// Reload when user returns to tab
document.addEventListener("visibilitychange", function () {
    if (!document.hidden) {
        loadNotificationCount();
    }
});
</script>