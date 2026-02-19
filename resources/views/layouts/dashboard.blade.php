<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Session Messages Meta Tags -->
    @if(session('success'))
        <meta name="session-success" content="{{ session('success') }}">
    @endif
    @if(session('error'))
        <meta name="session-error" content="{{ session('error') }}">
    @endif
    @if(session('warning'))
        <meta name="session-warning" content="{{ session('warning') }}">
    @endif
    @if(session('info'))
        <meta name="session-info" content="{{ session('info') }}">
    @endif
    @if(session('message'))
        <meta name="session-message" content="{{ session('message') }}">
    @endif

    <title>@yield('title', 'Dashboard - Academic Journal')</title>

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
        @include('dashboard.partials.sidebar')

        <!-- Main Content - With left margin on desktop -->
        <div class="lg:ml-64 min-h-screen flex flex-col transition-all duration-300" id="mainContent">
            <!-- Top Header -->
            @include('dashboard.partials.header')

            <!-- Breadcrumb -->
            @include('dashboard.partials.breadcrumb')

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-6">
                <div class="text-sm text-gray-500 text-center">
                    © {{ date('Y') }} Academic Journal. All rights reserved.
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