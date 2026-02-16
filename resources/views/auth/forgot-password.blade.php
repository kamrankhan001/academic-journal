@extends('layouts.guest')

@section('title', 'Forgot Password - Academic Journal')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Reset Password</h1>
                <p class="text-gray-600">Enter your email address and we'll send you instructions to reset your password.</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fa-regular fa-circle-check text-green-500 mr-3"></i>
                        <p class="text-sm text-green-600">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fa-regular fa-circle-exclamation text-red-500 mr-3"></i>
                        <p class="text-sm text-red-600">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Forgot Password Form -->
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-8">
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" 
                                   id="email" 
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="block w-full pl-10 pr-3 py-3 border {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#86662c]' }} rounded-lg focus:ring-2 focus:border-transparent outline-none transition-colors"
                                   placeholder="you@university.edu"
                                   required autofocus>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-[#86662c] text-white py-3 px-4 rounded-lg text-sm font-medium hover:bg-[#6b4f23] transition-colors duration-200 shadow-sm flex items-center justify-center space-x-2 group">
                        <i class="fa-regular fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                        <span>Send Reset Instructions</span>
                    </button>
                </form>

                <!-- Back to Login -->
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-[#86662c] hover:text-[#6b4f23] hover:underline transition-colors inline-flex items-center">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Back to Login
                    </a>
                </div>
            </div>

            <!-- Help Text -->
            <p class="text-xs text-gray-400 text-center mt-6">
                Having trouble? <a href="/contact" class="text-[#86662c] hover:underline">Contact support</a>
            </p>
        </div>
    </div>
</div>
@endsection