<section class="bg-gray-50 py-16 border-t border-gray-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Header -->
            <div class="mb-8">
                <span class="inline-block px-3 py-1 bg-[#86662c]/10 text-[#86662c] text-xs font-semibold rounded-full mb-4">
                    Stay Updated
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">
                    Subscribe to Our <span class="text-[#86662c]">Newsletter</span>
                </h2>
                <p class="text-gray-600 text-sm max-w-md mx-auto">
                    Get the latest research and journal updates delivered to your inbox.
                </p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    <i class="fa-regular fa-circle-check mr-1"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mb-4 p-3 bg-blue-100 text-blue-700 rounded-lg text-sm">
                    <i class="fa-regular fa-circle-info mr-1"></i>
                    {{ session('info') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                    <i class="fa-regular fa-circle-exclamation mr-1"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Newsletter Form -->
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="max-w-md mx-auto">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="email" 
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="Your email address" 
                               class="w-full pl-10 pr-4 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#86662c]/20 focus:border-[#86662c] outline-none transition-all @error('email') border-red-300 @enderror"
                               required>
                    </div>
                    <button type="submit" 
                            class="bg-[#86662c] text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-[#6b4f23] transition-colors duration-200 shadow-sm whitespace-nowrap">
                        Subscribe
                    </button>
                </div>

                <!-- Consent Checkbox -->
                <div class="flex items-center justify-center mt-4">
                    <input type="checkbox" 
                           name="consent" 
                           id="consent" 
                           class="mr-2 rounded border-gray-300 text-[#86662c] focus:ring-[#86662c]/20" 
                           {{ old('consent') ? 'checked' : '' }}
                           required>
                    <label for="consent" class="text-xs text-gray-500">
                        I agree to the <a href="/privacy" class="text-[#86662c] hover:underline">Privacy Policy</a>
                    </label>
                </div>
            </form>

            <!-- Subscriber count -->
            @php
                $subscriberCount = App\Models\NewsletterSubscription::where('is_subscribed', true)
                    ->where('is_verified', true)
                    ->count();
            @endphp
            <p class="text-xs text-gray-500 mt-6">
                <span class="font-medium text-gray-700">{{ number_format($subscriberCount) }}+</span> researchers already subscribed
            </p>
        </div>
    </div>
</section>