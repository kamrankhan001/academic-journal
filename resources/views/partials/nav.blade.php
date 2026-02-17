<nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Left side - Logo -->
            <div class="flex items-center md:order-2">
                <a href="/" class="text-2xl font-bold text-gray-800 tracking-tight">
                    <img src="{{asset('logo.png')}}" alt="Journal of Medical and Surgical Allied" class="h-10 w-auto">
                </a>
            </div>

            <!-- Desktop Navigation Links - Clean with just Home, About, Contact + Resources Dropdown -->
            <div class="hidden md:flex items-center space-x-6 lg:space-x-8 md:order-1">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-[#86662c] font-semibold' : 'text-gray-700 hover:text-[#86662c]' }} transition-colors duration-200 text-sm font-medium whitespace-nowrap">
                    Home
                </a>

                <!-- Resources Mega Dropdown -->
                <div class="relative group">
                    <button
                        class="flex items-center space-x-1 text-gray-700 hover:text-[#86662c] transition-colors duration-200 text-sm font-medium group whitespace-nowrap">
                        <span>Resources</span>
                        <i class="fa-solid fa-chevron-down text-xs group-hover:rotate-180 transition-transform duration-200"></i>
                    </button>

                    <!-- Mega Dropdown Menu -->
                    <div
                        class="absolute top-full left-0 mt-2 w-162.5 bg-white rounded-xl shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="grid grid-cols-2 gap-4 p-6">
                            <!-- Left Column - Journal Content -->
                            <div class="space-y-1">
                                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Journal Content</div>

                                <a href="{{ route('current-issue') }}"
                                    class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors group/link">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover/link:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Current Issue</p>
                                        <p class="text-xs text-gray-500">Latest published articles</p>
                                    </div>
                                </a>

                                <a href="{{ route('archives') }}"
                                    class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors group/link">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover/link:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                                            <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Archives</p>
                                        <p class="text-xs text-gray-500">Past issues and articles</p>
                                    </div>
                                </a>

                                <a href="{{ route('announcements') }}"
                                    class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors group/link">
                                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mr-3 group-hover/link:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Announcements</p>
                                        <p class="text-xs text-gray-500">News and updates</p>
                                    </div>
                                </a>
                            </div>

                            <!-- Right Column - For Authors & Policies -->
                            <div class="space-y-1">
                                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">For Authors & Reviewers</div>

                                <a href="{{ route('guidelines') }}"
                                    class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors group/link">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover/link:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Author Guidelines</p>
                                        <p class="text-xs text-gray-500">Author instructions</p>
                                    </div>
                                </a>

                                <a href="{{ route('reviewers') }}"
                                    class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors group/link">
                                    <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center mr-3 group-hover/link:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">For Reviewers</p>
                                        <p class="text-xs text-gray-500">Reviewer guidelines</p>
                                    </div>
                                </a>

                                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Policies</div>

                                <a href="{{ route('journal-policies') }}"
                                    class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors group/link">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3 group-hover/link:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Journal Policies</p>
                                        <p class="text-xs text-gray-500">Indexing, APC, and more</p>
                                    </div>
                                </a>

                                <a href="{{ route('editorial-policy') }}"
                                    class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors group/link">
                                    <div class="w-10 h-10 bg-rose-100 rounded-lg flex items-center justify-center mr-3 group-hover/link:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-rose-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Editorial Policies</p>
                                        <p class="text-xs text-gray-500">Our editorial standards</p>
                                    </div>
                                </a>

                                <a href="{{ route('editorial-team') }}"
                                    class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors group/link">
                                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3 group-hover/link:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Editorial Team</p>
                                        <p class="text-xs text-gray-500">Meet our editors</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('about') }}"
                    class="{{ request()->routeIs('about') ? 'text-[#86662c] font-semibold' : 'text-gray-700 hover:text-[#86662c]' }} transition-colors duration-200 text-sm font-medium whitespace-nowrap">
                    About
                </a>

                <a href="{{ route('contact') }}"
                    class="{{ request()->routeIs('contact') ? 'text-[#86662c] font-semibold' : 'text-gray-700 hover:text-[#86662c]' }} transition-colors duration-200 text-sm font-medium whitespace-nowrap">
                    Contact
                </a>
            </div>

            <!-- Desktop Auth Buttons / Dashboard Links -->
            <div class="hidden md:flex items-center space-x-4 md:order-3">
                @auth
                    @php
                        $dashboardRoute = Auth::user()->role === 'admin' ? route('admin.dashboard') : route('author.index');
                    @endphp
                    <a href="{{ $dashboardRoute }}"
                        class="flex items-center space-x-2 text-gray-600 hover:text-[#86662c] text-sm font-medium px-3 py-2 rounded-lg transition-colors duration-200">
                        <i class="fa-regular fa-user"></i>
                        <span class="capitalize">{{ Auth::user()->name }}</span>
                        @if(Auth::user()->role === 'admin')
                            <span class="ml-1 px-1.5 py-0.5 bg-[#86662c] text-white text-xs rounded-full">Admin</span>
                        @endif
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="{{ request()->is('login') ? 'text-[#86662c] font-semibold' : 'text-gray-600 hover:text-[#86662c]' }} text-sm font-medium px-3 py-2 rounded-lg transition-colors duration-200">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-[#86662c] text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-[#6b4f23] transition-colors duration-200 shadow-sm">
                        Register
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button id="mobileMenuToggle" class="text-gray-600 hover:text-[#86662c] focus:outline-none p-2">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Menu (Slide from right) - Updated with organized sections -->
    <div id="mobileDrawer" class="fixed inset-0 overflow-hidden z-50 invisible">
        <div id="drawerOverlay"
            class="absolute inset-0 bg-black bg-opacity-50 opacity-0 transition-opacity duration-300 ease-in-out"></div>

        <div class="absolute inset-y-0 right-0 max-w-full flex">
            <div id="drawerPanel"
                class="w-80 bg-white shadow-2xl translate-x-full transition-transform duration-300 ease-in-out">
                <!-- Drawer Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <a href="/" class="text-2xl font-bold text-gray-800 tracking-tight">
                        <img src="{{asset('logo.png')}}" alt="Journal of Medical and Surgical Allied" class="h-8 w-auto">
                    </a>
                    <button id="closeDrawerBtn" class="text-gray-500 hover:text-[#86662c] focus:outline-none p-2">
                        <i class="fa-solid fa-times text-2xl"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="p-6 overflow-y-auto max-h-[calc(100vh-80px)]">
                    @auth
                        <!-- User Info for authenticated users -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-[#86662c] rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 capitalize">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    @if(Auth::user()->role === 'admin')
                                        <span class="mt-1 inline-block px-2 py-0.5 bg-[#86662c] text-white text-xs rounded-full">Admin</span>
                                    @endif
                                </div>
                            </div>

                            @php
                                $dashboardRoute = Auth::user()->role === 'admin' ? route('admin.dashboard') : route('author.index');
                            @endphp
                            <a href="{{ $dashboardRoute }}"
                                class="mt-3 block w-full text-center py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors duration-200 text-sm font-medium">
                                <i class="fa-regular fa-chart-pie mr-2"></i>
                                Go to Dashboard
                            </a>
                        </div>
                    @endauth

                    <!-- Main Navigation Sections -->
                    <div class="space-y-6">
                        <!-- Main Pages -->
                        <div>
                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</div>
                            <div class="space-y-1">
                                <a href="{{ route('home') }}"
                                    class="block py-3 px-4 {{ request()->routeIs('home') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                                    <i class="fa-solid fa-home mr-3 text-[#86662c]"></i>
                                    Home
                                </a>
                                <a href="{{ route('about') }}"
                                    class="block py-3 px-4 {{ request()->routeIs('about') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                                    <i class="fa-solid fa-info-circle mr-3 text-[#86662c]"></i>
                                    About
                                </a>
                                <a href="{{ route('contact') }}"
                                    class="block py-3 px-4 {{ request()->routeIs('contact') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                                    <i class="fa-solid fa-envelope mr-3 text-[#86662c]"></i>
                                    Contact
                                </a>
                            </div>
                        </div>

                        <!-- Journal Content -->
                        <div>
                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Journal Content</div>
                            <div class="space-y-1">
                                <a href="{{ route('current-issue') }}"
                                    class="block py-3 px-4 {{ request()->routeIs('current-issue') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3 inline-block text-[#86662c]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Current Issue
                                </a>

                                <a href="{{ route('archives') }}"
                                    class="block py-3 px-4 {{ request()->routeIs('archives') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3 inline-block text-[#86662c]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                                        <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Archives
                                </a>

                                <a href="{{ route('announcements') }}"
                                    class="block py-3 px-4 {{ request()->routeIs('announcements') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3 inline-block text-[#86662c]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                    </svg>
                                    Announcements
                                </a>
                            </div>
                        </div>

                        <!-- For Authors & Reviewers -->
                        <div>
                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">For Authors & Reviewers</div>
                            <div class="space-y-1">
                                <a href="{{ route('guidelines') }}"
                                    class="block py-3 px-4 {{ request()->routeIs('guidelines') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3 inline-block text-[#86662c]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                    </svg>
                                    Author Guidelines
                                </a>

                                <a href="{{ route('reviewers') }}"
                                    class="block py-3 px-4 {{ request()->routeIs('reviewers') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3 inline-block text-[#86662c]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                    </svg>
                                    For Reviewers
                                </a>
                            </div>
                        </div>

                        <!-- Policies -->
                        <div>
                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Policies</div>
                            <div class="space-y-1">
                                <a href="{{ route('journal-policies') }}"
                                    class="block py-3 px-4 {{ request()->routeIs('journal-policies') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3 inline-block text-[#86662c]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Journal Policies
                                </a>

                                <a href="{{ route('editorial-policy') }}"
                                    class="block py-3 px-4 {{ request()->routeIs('editorial-policy') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3 inline-block text-[#86662c]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                    </svg>
                                    Editorial Policies
                                </a>

                                <a href="{{ route('editorial-team') }}"
                                    class="block py-3 px-4 {{ request()->routeIs('editorial-team') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3 inline-block text-[#86662c]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                    </svg>
                                    Editorial Team
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="my-6 border-t border-gray-200"></div>

                    <!-- Auth Section -->
                    <div class="space-y-4">
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left py-3 px-4 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 text-base font-medium">
                                    <i class="fa-solid fa-sign-out-alt mr-2"></i>
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="block w-full text-center py-3 px-4 border border-gray-300 rounded-lg {{ request()->is('login') ? 'bg-gray-50 border-[#86662c] text-[#86662c]' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200">
                                <i class="fa-solid fa-sign-in-alt mr-2"></i>
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="block w-full text-center py-3 px-4 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors duration-200 shadow-sm">
                                <i class="fa-solid fa-user-plus mr-2"></i>
                                Register
                            </a>
                        @endauth
                    </div>

                    <!-- Footer -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <p class="text-xs text-gray-500 text-center">
                            &copy; {{ date('Y') }} Journal of Medical and Surgical Allied.<br>
                            All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>