<footer class="bg-gray-50 border-t border-gray-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo and Description -->
            <div class="col-span-1 md:col-span-2">
                <a href="/" class="inline-block">
                    <img src="{{asset('logo.png')}}" alt="Academic Journal" class="h-10 w-auto">
                </a>
                <p class="mt-4 text-gray-600 text-sm leading-relaxed max-w-md">
                    The Journal of Medical and Surgical Allied is a peer-reviewed, open-access scholarly journal dedicated to advancing multidisciplinary research and promoting high-quality academic communication across medical and allied health sciences.
                </p>
                <!-- Social Icons - Using existing social-icon class from topbar -->
                <div class="mt-6 flex space-x-3">
                    <a href="#"
                        class="social-icon text-gray-500 hover:bg-[#1877f2] hover:text-white transition-all duration-300 rounded-full">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#"
                        class="social-icon text-gray-500 hover:bg-[#000000] hover:text-white transition-all duration-300 rounded-full">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="#"
                        class="social-icon text-gray-500 hover:bg-[#ff0000] hover:text-white transition-all duration-300 rounded-full">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="#"
                        class="social-icon text-gray-500 hover:bg-[#e4405f] hover:text-white transition-all duration-300 rounded-full">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#"
                        class="social-icon text-gray-500 hover:bg-[#fffc00] hover:text-black transition-all duration-300 rounded-full">
                        <i class="fa-brands fa-snapchat"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Quick Links</h3>
                <ul class="mt-4 space-y-3">
                    <li>
                        <a href="/" class="{{ request()->is('/') ? 'text-[#86662c] font-medium' : 'text-gray-600 hover:text-[#86662c]' }} text-sm flex items-center">
                            <i class="fa-solid fa-chevron-right mr-2 text-[10px] {{ request()->is('/') ? 'text-[#86662c]' : 'text-[#86662c]' }}"></i>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="/about" class="{{ request()->is('about') ? 'text-[#86662c] font-medium' : 'text-gray-600 hover:text-[#86662c]' }} text-sm flex items-center">
                            <i class="fa-solid fa-chevron-right mr-2 text-[10px] {{ request()->is('about') ? 'text-[#86662c]' : 'text-[#86662c]' }}"></i>
                            About
                        </a>
                    </li>
                    <li>
                        <a href="/contact" class="{{ request()->is('contact') ? 'text-[#86662c] font-medium' : 'text-gray-600 hover:text-[#86662c]' }} text-sm flex items-center">
                            <i class="fa-solid fa-chevron-right mr-2 text-[10px] {{ request()->is('contact') ? 'text-[#86662c]' : 'text-[#86662c]' }}"></i>
                            Contact
                        </a>
                    </li>
                    <li>
                        <a href="/privacy" class="{{ request()->is('privacy') ? 'text-[#86662c] font-medium' : 'text-gray-600 hover:text-[#86662c]' }} text-sm flex items-center">
                            <i class="fa-solid fa-chevron-right mr-2 text-[10px] {{ request()->is('privacy') ? 'text-[#86662c]' : 'text-[#86662c]' }}"></i>
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="/terms" class="{{ request()->is('terms') ? 'text-[#86662c] font-medium' : 'text-gray-600 hover:text-[#86662c]' }} text-sm flex items-center">
                            <i class="fa-solid fa-chevron-right mr-2 text-[10px] {{ request()->is('terms') ? 'text-[#86662c]' : 'text-[#86662c]' }}"></i>
                            Terms of Service
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Get in Touch</h3>
                <ul class="mt-4 space-y-4">
                    <li class="flex items-start">
                        <i class="fa-solid fa-location-dot mt-1 mr-3 text-[#86662c] w-4"></i>
                        <span class="text-gray-600 text-sm">
                            Office No. A.2, Medizone
                            Medicine Company,
                            Dabgari Garden, Peshawar, Pakistan
                        </span>
                    </li>
                    <li class="flex items-center">
                        <i class="fa-regular fa-envelope mr-3 text-[#86662c] w-4"></i>
                        <a href="mailto:editor@academicjournal.edu"
                            class="text-gray-600 hover:text-[#86662c] text-sm">info@jmsa.com</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fa-solid fa-phone mr-3 text-[#86662c] w-4"></i>
                        <a href="tel:+15551234567" class="text-gray-600 hover:text-[#86662c] text-sm">
                            +92 331 8008377
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar with Copyright -->
        <div class="mt-12 pt-6 border-t border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Journal of Medical and Surgical Allied. All rights reserved.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="/privacy" class="text-xs {{ request()->is('privacy') ? 'text-[#86662c] font-medium' : 'text-gray-500 hover:text-[#86662c]' }}">Privacy Policy</a>
                    <a href="/terms" class="text-xs {{ request()->is('terms') ? 'text-[#86662c] font-medium' : 'text-gray-500 hover:text-[#86662c]' }}">Terms of Use</a>
                    <a href="/cookies" class="text-xs {{ request()->is('cookies') ? 'text-[#86662c] font-medium' : 'text-gray-500 hover:text-[#86662c]' }}">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>