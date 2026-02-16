@extends('layouts.page')

@section('page-title', 'Cookie Policy')
@section('page-subtitle', 'Last updated: January 1, 2024')

@section('page-content')
    <div class="prose prose-sm max-w-none text-gray-600">
        <section class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-3">1. What Are Cookies</h2>
            <p class="mb-4">
                Cookies are small text files that are placed on your computer or mobile device when you visit a website. 
                They are widely used to make websites work more efficiently and provide useful information to website owners.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-3">2. How We Use Cookies</h2>
            <p class="mb-4">Academic Journal uses cookies for the following purposes:</p>
            
            <h3 class="font-semibold text-gray-800 mb-2">Essential Cookies</h3>
            <p class="mb-4">
                These cookies are necessary for the website to function properly. They enable core functionality 
                such as security, network management, and account access. You cannot opt out of these cookies.
            </p>

            <h3 class="font-semibold text-gray-800 mb-2">Functional Cookies</h3>
            <p class="mb-4">
                These cookies allow the website to remember choices you make and provide enhanced, personalized features. 
                They may be set by us or by third-party providers.
            </p>

            <h3 class="font-semibold text-gray-800 mb-2">Analytics Cookies</h3>
            <p class="mb-4">
                These cookies help us understand how visitors interact with our website by collecting and reporting 
                information anonymously. We use this data to improve our website and user experience.
            </p>

            <h3 class="font-semibold text-gray-800 mb-2">Preference Cookies</h3>
            <p class="mb-4">
                These cookies remember your settings and preferences to enhance your experience on our website.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-3">3. Types of Cookies We Use</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-800">Cookie Type</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-800">Purpose</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-800">Duration</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-2 text-sm">session_token</td>
                            <td class="px-4 py-2 text-sm">Maintains your login session</td>
                            <td class="px-4 py-2 text-sm">Session</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-sm">user_preferences</td>
                            <td class="px-4 py-2 text-sm">Stores your display preferences</td>
                            <td class="px-4 py-2 text-sm">1 year</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-sm">_ga</td>
                            <td class="px-4 py-2 text-sm">Google Analytics - distinguishes users</td>
                            <td class="px-4 py-2 text-sm">2 years</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-sm">_gid</td>
                            <td class="px-4 py-2 text-sm">Google Analytics - distinguishes users</td>
                            <td class="px-4 py-2 text-sm">24 hours</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-3">4. Third-Party Cookies</h2>
            <p class="mb-4">
                We may use third-party services that use cookies. These include:
            </p>
            <ul class="list-disc pl-6 mb-4 space-y-1">
                <li>Google Analytics for website analytics</li>
                <li>Font Awesome for icon rendering</li>
                <li>Social media platforms for sharing features</li>
            </ul>
            <p class="mb-4">
                These third parties have their own privacy policies and cookie practices. We recommend reviewing 
                their policies for more information.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-3">5. Managing Cookies</h2>
            <p class="mb-4">
                Most web browsers allow you to control cookies through their settings preferences. You can:
            </p>
            <ul class="list-disc pl-6 mb-4 space-y-1">
                <li>Delete all cookies from your browser</li>
                <li>Block cookies from being set</li>
                <li>Receive notifications when cookies are set</li>
                <li>Set preferences for specific websites</li>
            </ul>
            <p class="mb-4">
                To learn more about cookie management for your specific browser, visit:
            </p>
            <ul class="list-disc pl-6 mb-4 space-y-1">
                <li><a href="#" class="text-[#86662c] hover:underline">Chrome</a></li>
                <li><a href="#" class="text-[#86662c] hover:underline">Firefox</a></li>
                <li><a href="#" class="text-[#86662c] hover:underline">Safari</a></li>
                <li><a href="#" class="text-[#86662c] hover:underline">Edge</a></li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-3">6. Your Consent</h2>
            <p class="mb-4">
                By continuing to use our website, you consent to our use of cookies as described in this policy. 
                When you first visit our site, you will see a cookie banner allowing you to accept or manage 
                your cookie preferences.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-3">7. Updates to This Policy</h2>
            <p class="mb-4">
                We may update this Cookie Policy from time to time. We will notify you of any changes by posting 
                the new policy on this page with an updated effective date.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-3">8. Contact Us</h2>
            <p class="mb-4">
                If you have questions about our use of cookies, please contact us:
            </p>
            <ul class="list-none space-y-2">
                <li><i class="fa-regular fa-envelope mr-2 text-[#86662c]"></i> privacy@academicjournal.edu</li>
                <li><i class="fa-solid fa-phone mr-2 text-[#86662c]"></i> +1 (555) 123-4567</li>
            </ul>
        </section>
    </div>
@endsection