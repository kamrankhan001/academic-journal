@extends('layouts.guest')

@section('page-title', 'Announcements')
@section('page-subtitle', 'Latest news and updates from Journal of Medical and Surgical Allied')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section -->
    <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-8 text-white mb-10">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <i class="fa-solid fa-bullhorn text-3xl text-white"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold mb-2">Announcements</h2>
                <p class="text-white/90 text-lg">Stay updated with the latest news from our journal</p>
            </div>
        </div>
    </div>

    <!-- Coming Soon Card -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow py-16 px-8 text-center">
        <div class="max-w-md mx-auto">
            <!-- Icon -->
            <div class="w-24 h-24 bg-linear-to-br from-[#86662c]/10 to-[#6b4f23]/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-regular fa-clock text-5xl text-[#86662c]"></i>
            </div>
            
            <!-- Text -->
            <h3 class="text-3xl font-bold text-gray-800 mb-3">Coming Soon</h3>
            <p class="text-gray-600 text-lg mb-2">We're preparing exciting announcements for you.</p>
            <p class="text-gray-500 mb-8">Please check back later for updates on new issues, calls for papers, and journal news.</p>
        </div>
    </div>
</div>
@endsection