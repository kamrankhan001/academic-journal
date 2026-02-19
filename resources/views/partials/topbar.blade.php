<div class="bg-[#86662c] border-b border-[#6b4f23] py-2 md:block hidden" 
     data-home-route="{{ route('home') }}">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Mobile Layout (Social Icons on top, Search below) -->
        <div class="flex flex-col sm:hidden space-y-3">
            <!-- Social Icons - On top for mobile -->
            <div class="flex justify-center items-center space-x-5">
                <a href="#" class="social-icon text-white/80 hover:text-white p-2 rounded-full transition-all duration-300" data-color="#1877f2">
                    <i class="fa-brands fa-facebook-f text-lg"></i>
                </a>
                <a href="#" class="social-icon text-white/80 hover:text-white p-2 rounded-full transition-all duration-300" data-color="#000000">
                    <i class="fa-brands fa-x-twitter text-lg"></i>
                </a>
                <a href="#" class="social-icon text-white/80 hover:text-white p-2 rounded-full transition-all duration-300" data-color="#ff0000">
                    <i class="fa-brands fa-youtube text-lg"></i>
                </a>
                <a href="#" class="social-icon text-white/80 hover:text-white p-2 rounded-full transition-all duration-300" data-color="#e4405f">
                    <i class="fa-brands fa-instagram text-lg"></i>
                </a>
                <a href="#" class="social-icon text-white/80 hover:text-white p-2 rounded-full transition-all duration-300" data-color="#fffc00">
                    <i class="fa-brands fa-snapchat text-lg"></i>
                </a>
            </div>

            <!-- Search - Below social icons on mobile - UPDATE THIS FORM ACTION -->
            <form action="{{ route('journals') }}" method="GET" class="w-full">
                <div class="relative">
                    <input type="text" 
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search journals, articles..." 
                           class="w-full pl-10 pr-4 py-2 text-sm bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent rounded-lg">
                    <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-white/60 text-sm"></i>
                    @if(request('search'))
                        <a href="{{ route('journals') }}" 
                           class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-white/60 hover:text-white">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Desktop/Tablet Layout (Search toggles, Social Icons always visible) -->
        <div class="hidden sm:flex justify-between items-center">
            <!-- Left side - Search with Toggle Button -->
            <div class="flex items-center space-x-3">
                <!-- Search Toggle Button -->
                <button id="desktopSearchToggle" class="flex items-center justify-center w-9 h-9 bg-white/10 rounded-full text-white hover:text-white hover:bg-white/20 transition-colors">
                    <i class="fa-solid fa-search"></i>
                </button>

                <!-- Search Input for Desktop with smooth transition - UPDATE THIS FORM ACTION -->
                <div id="desktopSearchContainer" class="w-0 opacity-0 overflow-hidden transition-all duration-300 ease-in-out">
                    <form action="{{ route('journals') }}" method="GET" id="desktopSearchForm">
                        <div class="relative w-64">
                            <input type="text" 
                                   name="search"
                                   id="desktopSearchInput"
                                   value="{{ request('search') }}"
                                   placeholder="Search journals, articles..." 
                                   class="w-full pl-9 pr-8 py-1.5 text-sm bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-white/60 text-sm"></i>
                            @if(request('search'))
                                <a href="{{ route('journals') }}" 
                                   class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-white/60 hover:text-white">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right side - Social Icons -->
            <div class="flex items-center space-x-2">
                <a href="#" class="social-icon text-white/80 hover:text-white p-2 rounded-full transition-all duration-300" data-color="#1877f2">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#" class="social-icon text-white/80 hover:text-white p-2 rounded-full transition-all duration-300" data-color="#000000">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="#" class="social-icon text-white/80 hover:text-white p-2 rounded-full transition-all duration-300" data-color="#ff0000">
                    <i class="fa-brands fa-youtube"></i>
                </a>
                <a href="#" class="social-icon text-white/80 hover:text-white p-2 rounded-full transition-all duration-300" data-color="#e4405f">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" class="social-icon text-white/80 hover:text-white p-2 rounded-full transition-all duration-300" data-color="#fffc00">
                    <i class="fa-brands fa-snapchat"></i>
                </a>
            </div>
        </div>
    </div>
</div>