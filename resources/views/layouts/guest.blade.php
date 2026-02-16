<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Academic Journal'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    <div class="min-h-screen">
        <!-- Top Bar with Search and Social Icons -->
        @include('partials.topbar')

        <!-- Navigation -->
        @include('partials.nav')

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Newsletter Subscription -->
        @if(!request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('password.request'))
            @include('partials.newsletter')
        @endif

        <!-- Footer -->
        @include('partials.footer')
    </div>
</body>
</html>