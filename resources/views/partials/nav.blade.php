<nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Left side - Logo -->
            <div class="flex items-center md:order-2">
                <a href="/" class="text-2xl font-bold text-gray-800 tracking-tight">
                    <img src="{{asset('logo.png')}}" alt="Academic Journal" class="h-10 w-auto">
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center space-x-8 md:order-1">
                <a href="/"
                    class="{{ request()->routeIs('home') ? 'text-[#86662c] font-semibold' : 'text-gray-700 hover:text-[#86662c]' }} transition-colors duration-200 text-sm font-medium">Home</a>
                <a href="/about"
                    class="{{ request()->routeIs('about') ? 'text-[#86662c] font-semibold' : 'text-gray-700 hover:text-[#86662c]' }} transition-colors duration-200 text-sm font-medium">About</a>
                <a href="/contact"
                    class="{{ request()->routeIs('contact') ? 'text-[#86662c] font-semibold' : 'text-gray-700 hover:text-[#86662c]' }} transition-colors duration-200 text-sm font-medium">Contact</a>
            </div>

            <!-- Desktop Auth Buttons / Dashboard Links -->
            <div class="hidden md:flex items-center space-x-4 md:order-3">
                @auth
                    <!-- Show user name that links to appropriate dashboard based on role -->
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
                    <!-- Show when user is not logged in -->
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

            <!-- Mobile menu button - only hamburger icon, no user name -->
            <div class="flex items-center md:hidden">
                <button id="mobileMenuToggle" class="text-gray-600 hover:text-[#86662c] focus:outline-none p-2">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Menu (Slide from right) -->
    <div id="mobileDrawer" class="fixed inset-0 overflow-hidden z-50 invisible">
        <!-- Overlay with Tailwind transitions -->
        <div id="drawerOverlay"
            class="absolute inset-0 bg-black bg-opacity-50 opacity-0 transition-opacity duration-300 ease-in-out"></div>

        <!-- Drawer Panel with Tailwind transitions -->
        <div class="absolute inset-y-0 right-0 max-w-full flex">
            <div id="drawerPanel"
                class="w-80 bg-white shadow-2xl translate-x-full transition-transform duration-300 ease-in-out">
                <!-- Drawer Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <a href="/" class="text-2xl font-bold text-gray-800 tracking-tight">
                        <img src="{{asset('logo.png')}}" alt="Academic Journal" class="h-8 w-auto">
                    </a>
                    <button id="closeDrawerBtn" class="text-gray-500 hover:text-[#86662c] focus:outline-none p-2">
                        <i class="fa-solid fa-times text-2xl"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="p-6">
                    @auth
                        <!-- User Info inside drawer for authenticated users -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-[#86662c] rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 capitalize">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    @if(Auth::user()->role === 'admin')
                                        <span class="mt-1 inline-block px-2 py-0.5 bg-[#86662c] text-white text-xs rounded-full">Administrator</span>
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

                    <!-- Navigation Links -->
                    <div class="space-y-1">
                        <a href="/"
                            class="block py-3 px-4 {{ request()->routeIs('home') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200 text-base font-medium">
                            <i
                                class="fa-solid fa-home mr-3 {{ request()->routeIs('home') ? 'text-[#86662c]' : 'text-[#86662c]' }}"></i>
                            Home
                        </a>
                        <a href="/about"
                            class="block py-3 px-4 {{ request()->routeIs('about') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200 text-base font-medium">
                            <i
                                class="fa-solid fa-info-circle mr-3 {{ request()->routeIs('about') ? 'text-[#86662c]' : 'text-[#86662c]' }}"></i>
                            About
                        </a>
                        <a href="/contact"
                            class="block py-3 px-4 {{ request()->routeIs('contact') ? 'text-[#86662c] bg-gray-50 font-semibold' : 'text-gray-700 hover:text-[#86662c] hover:bg-gray-50' }} rounded-lg transition-colors duration-200 text-base font-medium">
                            <i
                                class="fa-solid fa-envelope mr-3 {{ request()->routeIs('contact') ? 'text-[#86662c]' : 'text-[#86662c]' }}"></i>
                            Contact
                        </a>
                    </div>

                    <!-- Divider -->
                    <div class="my-6 border-t border-gray-200"></div>

                    <!-- Auth Section inside drawer -->
                    <div class="space-y-4">
                        @auth
                            <!-- Show logout for authenticated users -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                    class="w-full text-left py-3 px-4 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 text-base font-medium">
                                    <i class="fa-solid fa-sign-out-alt mr-2"></i>
                                    Logout
                                </button>
                            </form>
                        @else
                            <!-- Login/Register for guests inside drawer -->
                            <a href="{{ route('login') }}"
                                class="block w-full text-center py-3 px-4 border border-gray-300 rounded-lg {{ request()->is('login') ? 'bg-gray-50 border-[#86662c] text-[#86662c]' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-200 text-base font-medium">
                                <i class="fa-solid fa-sign-in-alt mr-2"></i>
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="block w-full text-center py-3 px-4 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors duration-200 text-base font-medium shadow-sm">
                                <i class="fa-solid fa-user-plus mr-2"></i>
                                Register
                            </a>
                        @endauth
                    </div>

                    <!-- Footer -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <p class="text-xs text-gray-500 text-center">
                            &copy; {{ date('Y') }} Academic Journal.<br>
                            All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>