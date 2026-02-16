<aside id="sidebar"
    class="bg-white border-r border-gray-200 w-64 fixed inset-y-0 left-0 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="h-full flex flex-col">
        <!-- Logo -->
        <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                <img src="{{ asset('logo.png') }}" alt="Academic Journal" class="h-8 w-auto">
                <span class="ml-2 text-xs font-medium text-[#86662c] bg-[#86662c]/10 px-2 py-1 rounded-full">Admin</span>
            </a>
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-[#86662c]">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>

        <!-- User Info (Mobile) -->
        <div class="lg:hidden p-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=86662c&color=fff&size=40" 
                     class="w-10 h-10 rounded-full"
                     alt="{{ Auth::user()->name }}">
                <div>
                    <p class="font-medium text-gray-800 capitalize">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->role ?? 'Administrator' }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4">
            <div class="px-3 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</p>
            </div>
            <ul class="space-y-1 px-3">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i class="fa-solid fa-chart-pie w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.dashboard') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Dashboard</span>
                    </a>
                </li>

                <!-- Journals Management -->
                <li>
                    <a href="{{ route('admin.journals.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.journals*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i class="fa-regular fa-file-lines w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.journals*') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Journals</span>
                        @php
                            $pendingCount = \App\Models\Journal::where('status', 'submitted')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $pendingCount > 9 ? '9+' : $pendingCount }}</span>
                        @endif
                    </a>
                </li>

                <!-- Users Management -->
                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.users*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i class="fa-regular fa-user w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.users*') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Users</span>
                    </a>
                </li>

                <!-- Tags / Categories -->
                <li>
                    <a href="{{ route('admin.tags.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.tags*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i class="fa-solid fa-tags w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.tags*') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Tags / Categories</span>
                    </a>
                </li>

                <!-- Announcements -->
                <li>
                    <a href="{{ route('admin.announcements.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.announcements*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i class="fa-regular fa-bell w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.announcements*') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Announcements</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.profile') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.profile') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-regular fa-user w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('author.profile') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Profile</span>
                    </a>
                </li>
            </ul>

            <!-- Sidebar Footer with Logout -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-white">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors group cursor-pointer">
                        <i class="fa-solid fa-sign-out-alt w-5 text-gray-400 group-hover:text-red-600"></i>
                        <span class="ml-3 text-sm font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>
</aside>