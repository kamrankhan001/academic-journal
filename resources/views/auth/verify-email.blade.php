@extends('layouts.guest')

@section('title', 'Verify Email - Academic Journal')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">

            <!-- Verification Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-8 shadow-sm">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center text-green-600">
                            <i class="fa-regular fa-circle-check mr-2"></i>
                            <span class="text-sm">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center text-yellow-600">
                            <i class="fa-regular fa-circle-exclamation mr-2"></i>
                            <span class="text-sm">{{ session('warning') }}</span>
                        </div>
                    </div>
                @endif

                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-[#86662c]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-regular fa-envelope text-[#86662c] text-3xl"></i>
                    </div>
                    
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">
                        Verify Your Email Address
                    </h2>
                    
                    <p class="text-sm text-gray-600 mb-4">
                        @if(Auth::check())
                            We've sent a verification link to <strong>{{ Auth::user()->email }}</strong>
                        @else
                            Please check your email for the verification link.
                        @endif
                    </p>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-left mb-6">
                        <h3 class="text-sm font-semibold text-blue-800 mb-2 flex items-center">
                            Next Steps
                        </h3>
                        <ul class="text-xs text-blue-700 space-y-2">
                            <li class="flex items-start">
                                <i class="fa-regular fa-envelope mr-2 mt-0.5"></i>
                                <span>Check your inbox for the verification email</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fa-regular fa-circle-check mr-2 mt-0.5"></i>
                                <span>Click the verification link in the email</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fa-regular fa-arrow-right-to-bracket mr-2 mt-0.5"></i>
                                <span>Once verified, you can access your dashboard</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Didn't receive email? -->
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-sm text-gray-600 mb-3">
                            Didn't receive the verification email?
                        </p>
                        
                        <form action="{{ route('verification.resend') }}" method="POST" class="space-y-3">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-[#86662c] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#6b4f23] transition-colors">
                                <i class="fa-regular fa-envelope mr-2"></i>
                                Resend Verification Email
                            </button>
                        </form>
                        
                        <div class="mt-4">
                            <p class="text-xs text-gray-500">
                                Check your spam folder if you don't see it in your inbox.
                                The link will expire in 60 minutes.
                            </p>
                        </div>
                        
                        <!-- Alternative actions -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex flex-col space-y-2">
                                <a href="{{ route('home') }}" class="text-xs text-[#86662c] hover:underline">
                                    Return to Home
                                </a>
                                @if(Auth::check())
                                    <form action="{{ route('logout') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-gray-500 hover:text-gray-700">
                                            Logout
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="text-xs text-gray-500 hover:text-gray-700">
                                        <i class="fa-regular fa-arrow-right-to-bracket mr-1"></i>
                                        Back to Login
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Text -->
            <p class="text-xs text-gray-500 text-center mt-6">
                Having trouble? <a href="/contact" class="text-[#86662c] hover:underline">Contact Support</a>
            </p>
        </div>
    </div>
</div>
@endsection