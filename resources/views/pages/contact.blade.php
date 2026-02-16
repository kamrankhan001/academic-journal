@extends('layouts.page')

@section('page-title', 'Contact Us')
@section('page-subtitle', 'Get in touch with our editorial team for questions, support, or collaborations.')

@section('page-content')
    <div class="grid md:grid-cols-2 gap-12">
        <!-- Contact Form -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-6">Send us a Message</h2>
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center text-green-600">
                        <i class="fa-regular fa-circle-check mr-2"></i>
                        <span class="text-sm">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center text-red-600 mb-2">
                        <i class="fa-regular fa-circle-exclamation mr-2"></i>
                        <span class="text-sm font-medium">Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name <span class="text-red-500">*</span></label>
                    <input type="text" 
                           id="name"
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('name') border-red-500 @enderror"
                           required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" 
                           id="email"
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('email') border-red-500 @enderror"
                           required>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject <span class="text-red-500">*</span></label>
                    <select name="subject" 
                            id="subject"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('subject') border-red-500 @enderror"
                            required>
                        <option value="">Select a subject</option>
                        <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                        <option value="submission" {{ old('subject') == 'submission' ? 'selected' : '' }}>Submission Question</option>
                        <option value="editorial" {{ old('subject') == 'editorial' ? 'selected' : '' }}>Editorial Support</option>
                        <option value="technical" {{ old('subject') == 'technical' ? 'selected' : '' }}>Technical Support</option>
                        <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Partnership Opportunity</option>
                    </select>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                    <textarea id="message"
                              name="message" 
                              rows="5" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c] focus:border-transparent outline-none @error('message') border-red-500 @enderror"
                              required>{{ old('message') }}</textarea>
                </div>

                <button type="submit" 
                        class="bg-[#86662c] text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-[#6b4f23] transition-colors duration-200 inline-flex items-center">
                    <i class="fa-regular fa-paper-plane mr-2"></i>
                    Send Message
                </button>
            </form>
        </div>

        <!-- Contact Information -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-6">Contact Information</h2>
            
            <div class="space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-[#86662c]/10 rounded-lg flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-location-dot text-[#86662c]"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Office Address</h3>
                        <p class="text-sm text-gray-600">123 University Avenue<br>Academic City, AC 12345<br>United States</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-[#86662c]/10 rounded-lg flex items-center justify-center shrink-0">
                        <i class="fa-regular fa-envelope text-[#86662c]"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Email</h3>
                        <p class="text-sm text-gray-600">editorial@academicjournal.edu</p>
                        <p class="text-sm text-gray-600">support@academicjournal.edu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-[#86662c]/10 rounded-lg flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-phone text-[#86662c]"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Phone</h3>
                        <p class="text-sm text-gray-600">+1 (555) 123-4567</p>
                        <p class="text-sm text-gray-600">+1 (555) 123-4568</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection