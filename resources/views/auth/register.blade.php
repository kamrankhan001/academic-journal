@extends('layouts.guest')

@section('title', 'Register - Academic Journal')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Create an Account</h1>
                <p class="text-gray-600">Join our community of researchers and scholars</p>
            </div>

            <!-- Registration Form -->
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Hidden Account Type -->
                    <input type="hidden" name="role" value="author">

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-user text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="name" 
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="block w-full pl-10 pr-3 py-3 border {{ $errors->has('name') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#86662c]' }} rounded-lg focus:ring-2 focus:border-transparent outline-none transition-colors"
                                   placeholder="John Doe"
                                   required>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

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
                                   placeholder="john.doe@university.edu"
                                   required>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   id="password" 
                                   name="password"
                                   class="block w-full pl-10 pr-10 py-3 border {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#86662c]' }} rounded-lg focus:ring-2 focus:border-transparent outline-none transition-colors"
                                   placeholder="••••••••"
                                   required>
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#86662c]" onclick="togglePassword('password', 'togglePasswordIcon')">
                                <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters with letters, numbers & symbols</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   class="block w-full pl-10 pr-10 py-3 border {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#86662c]' }} rounded-lg focus:ring-2 focus:border-transparent outline-none transition-colors"
                                   placeholder="••••••••"
                                   required>
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#86662c]" onclick="togglePassword('password_confirmation', 'toggleConfirmPasswordIcon')">
                                <i class="fa-regular fa-eye" id="toggleConfirmPasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" 
                                       id="terms" 
                                       name="terms"
                                       {{ old('terms') ? 'checked' : '' }}
                                       class="h-4 w-4 text-[#86662c] focus:ring-[#86662c] border-gray-300 rounded transition-colors"
                                       required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="text-gray-600">
                                    I agree to the 
                                    <a href="/terms" class="text-[#86662c] hover:text-[#6b4f23] hover:underline">Terms of Service</a> 
                                    and 
                                    <a href="/privacy" class="text-[#86662c] hover:text-[#6b4f23] hover:underline">Privacy Policy</a>
                                    <span class="text-red-500">*</span>
                                </label>
                            </div>
                        </div>
                        @error('terms')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" 
                                       id="newsletter" 
                                       name="newsletter"
                                       {{ old('newsletter', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-[#86662c] focus:ring-[#86662c] border-gray-300 rounded transition-colors">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="newsletter" class="text-gray-600">
                                    I'd like to receive newsletters about new issues and research opportunities
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-[#86662c] text-white py-3 px-4 rounded-lg text-sm font-medium hover:bg-[#6b4f23] transition-colors duration-200 shadow-sm flex items-center justify-center space-x-2">
                        <i class="fa-regular fa-paper-plane"></i>
                        <span>Create Account</span>
                    </button>
                </form>

                <!-- Login Link -->
                <p class="mt-8 text-center text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-medium text-[#86662c] hover:text-[#6b4f23] hover:underline transition-colors">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Password Toggle Script -->
<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection