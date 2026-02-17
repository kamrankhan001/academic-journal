<aside id="sidebar"
    class="bg-white border-r border-gray-200 w-64 fixed inset-y-0 left-0 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="h-full flex flex-col">
        <!-- Logo -->
        <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                <img src="{{ asset('logo.png') }}" alt="Academic Journal" class="h-8 w-auto">
                <span
                    class="ml-2 text-xs font-medium text-[#86662c] bg-[#86662c]/10 px-2 py-1 rounded-full">Admin</span>
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
                <div>
                    <p class="font-medium text-gray-800 capitalize">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->role ?? 'Administrator' }}</p>
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
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-chart-pie w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.dashboard') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Dashboard</span>
                    </a>
                </li>
            </ul>

            <!-- Section 2: Content Management -->
            <div class="px-3 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Content Management</p>
            </div>
            <ul class="space-y-1 px-3 mb-6">
                <!-- Volumes Management -->
                <li>
                    <a href="{{ route('admin.volumes.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.volumes*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-book-open w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.volumes*') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Volumes</span>
                    </a>
                </li>

                <!-- Issues Management -->
                <li>
                    <a href="{{ route('admin.issues.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.issues*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-newspaper w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.issues*') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Issues</span>
                        @php
                            $publishedIssuesCount = \App\Models\Issue::where('status', 'published')->count();
                        @endphp
                        @if($publishedIssuesCount > 0)
                            <span
                                class="ml-auto bg-green-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $publishedIssuesCount > 9 ? '9+' : $publishedIssuesCount }}</span>
                        @endif
                    </a>
                </li>

                <!-- Journals Management -->
                <li>
                    <a href="{{ route('admin.journals.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.journals*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-file-lines w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.journals*') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Journals</span>
                        @php
                            $pendingCount = \App\Models\Journal::where('status', 'submitted')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span
                                class="ml-auto bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $pendingCount > 9 ? '9+' : $pendingCount }}</span>
                        @endif
                    </a>
                </li>

                <!-- Tags / Categories -->
                <li>
                    <a href="{{ route('admin.tags.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.tags*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-tags w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.tags*') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Tags / Categories</span>
                    </a>
                </li>
            </ul>

            <!-- Section 3: Review System -->
            <div class="px-3 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Review System</p>
            </div>
            <ul class="space-y-1 px-3 mb-6">
                <!-- Reviewers Management -->
                <li>
                    <a href="{{ route('admin.reviewers.index') }}"
                        class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.reviewers*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.reviewers*') ? 'text-[#86662c]' : '' }}"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                        <span class="ml-3 text-sm font-medium">Reviewers</span>
                        @php
                            $pendingReviewersCount = \App\Models\Reviewer::where('status', 'pending')->count();
                        @endphp
                        @if($pendingReviewersCount > 0)
                            <span
                                class="ml-auto bg-yellow-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $pendingReviewersCount > 9 ? '9+' : $pendingReviewersCount }}</span>
                        @endif
                    </a>
                </li>

                <!-- Review Assignments -->
                <li>
                    <a href="{{ route('admin.assignments.index') }}"
                        class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.assignments*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.assignments*') ? 'text-[#86662c]' : '' }}"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                        </svg>
                        <span class="ml-3 text-sm font-medium">Assignments</span>
                        @php
                            $pendingAssignmentsCount = \App\Models\JournalReviewAssignment::where('status', 'pending')->count();
                        @endphp
                        @if($pendingAssignmentsCount > 0)
                            <span
                                class="ml-auto bg-yellow-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $pendingAssignmentsCount > 9 ? '9+' : $pendingAssignmentsCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>

            <!-- Section 4: Communication -->
            <div class="px-3 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Communication</p>
            </div>
            <ul class="space-y-1 px-3 mb-6">
                <!-- Announcements -->
                <li>
                    <a href="{{ route('admin.announcements.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.announcements*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-bullhorn w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.announcements*') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Announcements</span>
                    </a>
                </li>

                <!-- Notifications -->
                <li>
                    <a href="#"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group">
                        <i
                            class="fa-solid fa-bell w-5 text-gray-400 group-hover:text-[#86662c]"></i>
                        <span class="ml-3 text-sm font-medium">Notifications</span>
                    </a>
                </li>
            </ul>

            <!-- Section 5: Administration -->
            <div class="px-3 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Administration</p>
            </div>
            <ul class="space-y-1 px-3 mb-6">
                <!-- Users Management -->
                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.users*') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-users w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.users*') ? 'text-[#86662c]' : '' }}"></i>
                        <span class="ml-3 text-sm font-medium">Users</span>
                    </a>
                </li>

                <!-- Profile -->
                <li>
                    <a href="{{ route('admin.profile') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#86662c]/10 hover:text-[#86662c] transition-colors group {{ request()->routeIs('admin.profile') ? 'bg-[#86662c]/10 text-[#86662c]' : '' }}">
                        <i
                            class="fa-solid fa-user w-5 text-gray-400 group-hover:text-[#86662c] {{ request()->routeIs('admin.profile') ? 'text-[#86662c]' : '' }}"></i>
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