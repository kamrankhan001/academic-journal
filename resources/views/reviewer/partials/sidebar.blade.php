@php
    $currentRoute = request()->route()->getName();
    $reviewer = auth()->user()->reviewerProfile;
@endphp

<aside id="sidebar"
    class="bg-white border-r border-gray-200 w-64 fixed inset-y-0 left-0 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="h-full flex flex-col">
        <!-- Logo -->
        <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200">
            <a href="{{ route('reviewer.dashboard') }}" class="flex items-center">
                <img src="{{ asset('logo.png') }}" alt="JournalMSA" class="h-8 w-auto">
            </a>
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-[#86662c]">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>

        <!-- User Info (Mobile only) -->
        <div class="lg:hidden p-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=86662c&color=fff&size=40"
                    class="w-10 h-10 rounded-full" alt="{{ auth()->user()->name }}">
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-gray-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1 px-3">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('reviewer.dashboard') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ $currentRoute === 'reviewer.dashboard' ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i class="fa-solid fa-chart-pie w-5 text-gray-400 group-hover:text-[#86662c] {{ $currentRoute === 'reviewer.dashboard' ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Dashboard</span>
                    </a>
                </li>

                <!-- My Reviews -->
                <li>
                    <a href="{{ route('reviewer.assignments.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ str_starts_with($currentRoute, 'reviewer.assignments') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i class="fa-regular fa-file-lines w-5 text-gray-400 group-hover:text-[#86662c] {{ str_starts_with($currentRoute, 'reviewer.assignments') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">My Reviews</span>
                        @php
                            $pendingCount = $reviewer ? $reviewer->reviewAssignments()->where('status', 'pending')->count() : 0;
                        @endphp
                        @if($pendingCount > 0)
                            <span class="ml-auto bg-red-100 text-red-600 text-xs font-medium px-2 py-0.5 rounded-full">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>

            <div class="border-t border-gray-200 my-4"></div>

            <ul class="space-y-1 px-3">
                <!-- Profile -->
                <li>
                    <a href="{{ route('reviewer.profile') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ $currentRoute === 'reviewer.profile' ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i class="fa-regular fa-user w-5 text-gray-400 group-hover:text-[#86662c] {{ $currentRoute === 'reviewer.profile' ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Profile</span>
                    </a>
                </li>

                <!-- Notifications -->
                <li>
                    <a href="{{ route('reviewer.notifications') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('reviewer.notifications') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i class="fa-regular fa-bell w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('reviewer.notifications') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Notifications</span>
                        @php
                            $unreadCount = auth()->user()->unreadNotifications->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span id="sidebarNotificationBadge"
                                class="ml-auto bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @else
                            <span id="sidebarNotificationBadge"
                                class="hidden ml-auto bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"></span>
                        @endif
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