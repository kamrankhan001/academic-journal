@extends('layouts.guest')

@section('title', 'Email Verified - Academic Journal')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <!-- Success Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-8 shadow-sm text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-regular fa-circle-check text-green-600 text-3xl"></i>
                </div>
                
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    Email Verified!
                </h1>
                
                <p class="text-gray-600 mb-6">
                    Your email address has been successfully verified.
                </p>
                
                <div class="space-y-3">
                    <a href="{{ route('author.dashboard') }}" 
                       class="block bg-[#86662c] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#6b4f23] transition-colors">
                        Go to Dashboard
                    </a>
                    
                    <a href="{{ route('home') }}" 
                       class="block border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                        Return to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection