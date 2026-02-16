@extends('layouts.guest')

@section('content')
    <!-- Page Header with Gold Background -->
    <div class="bg-[#86662c] border-b border-[#6b4f23]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Breadcrumbs - Centered -->
            <div class="flex justify-center items-center space-x-2 text-sm text-white/80 mb-4">
                <a href="/" class="hover:text-white transition-colors">Home</a>
                <i class="fa-solid fa-chevron-right text-xs text-white/60"></i>
                <span class="text-white">@yield('page-title')</span>
            </div>
            
            <!-- Title - Centered -->
            <h1 class="text-3xl md:text-4xl font-bold text-white text-center">@yield('page-title')</h1>
            
            <!-- Subtitle - Centered -->
            <p class="text-white/80 mt-3 max-w-2xl mx-auto text-center">@yield('page-subtitle')</p>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-4xl mx-auto">
            @yield('page-content')
        </div>
    </div>
@endsection