<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Reviewer Dashboard - Journal of Medical and Surgical Allied')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Page Specific Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen relative">
        <!-- Sidebar - Fixed -->
        @include('reviewer.partials.sidebar')

        <!-- Main Content - With left margin on desktop -->
        <div class="lg:ml-64 min-h-screen flex flex-col transition-all duration-300" id="mainContent">
            <!-- Top Header -->
            @include('reviewer.partials.header')

            <!-- Breadcrumb -->
            @include('reviewer.partials.breadcrumb')

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6">
                <!-- Status Alert for Pending/Inactive Reviewers -->
                @if(auth()->user()->reviewerProfile && auth()->user()->reviewerProfile->status !== 'active')
                    <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="shrink-0">
                                <i class="fa-regular fa-clock text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    @if(auth()->user()->reviewerProfile->status === 'pending')
                                        Your reviewer profile is pending approval from the admin. You'll be able to accept review assignments once approved.
                                    @else
                                        Your reviewer account is currently inactive. Please contact the admin for more information.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-6">
                <div class="text-sm text-gray-500 text-center">
                    © {{ date('Y') }} Journal of Medical and Surgical Allied. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Page Specific Scripts -->
    @stack('scripts')

</body>
</html>