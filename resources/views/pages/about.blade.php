@extends('layouts.page')

@section('page-title', 'About Us')
@section('page-subtitle', 'Learn more about Academic Journal, our mission, and our commitment to scholarly publishing.')

@section('page-content')
    <!-- Mission Section -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Our Mission</h2>
        <p class="text-gray-600 leading-relaxed mb-4">
            Founded in 1995, Academic Journal has been at the forefront of scholarly communication, 
            dedicated to advancing research and knowledge across multiple disciplines. Our mission is 
            to provide a platform for researchers, academics, and scholars to share their groundbreaking 
            discoveries with the global academic community.
        </p>
        <p class="text-gray-600 leading-relaxed">
            We believe in open access to高质量 research and maintaining the highest standards of 
            peer review and academic integrity. Our commitment to excellence has made us a trusted 
            name in academic publishing worldwide.
        </p>
    </section>

    <!-- Stats Section -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">By the Numbers</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-[#86662c]">25+</div>
                <div class="text-sm text-gray-600">Years of Service</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-[#86662c]">10K+</div>
                <div class="text-sm text-gray-600">Published Articles</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-[#86662c]">50K+</div>
                <div class="text-sm text-gray-600">Global Authors</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-[#86662c]">100+</div>
                <div class="text-sm text-gray-600">Countries</div>
            </div>
        </div>
    </section>

    <!-- Editorial Board -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Editorial Board</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="flex items-start space-x-4">
                <img src="https://ui-avatars.com/api/?name=Sarah+Chen&background=86662c&color=fff&size=64" class="w-16 h-16 rounded-full">
                <div>
                    <h3 class="font-bold text-gray-800">Dr. Sarah Chen</h3>
                    <p class="text-sm text-[#86662c] mb-1">Editor-in-Chief</p>
                    <p class="text-xs text-gray-600">Stanford University</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <img src="https://ui-avatars.com/api/?name=Michael+Roberts&background=86662c&color=fff&size=64" class="w-16 h-16 rounded-full">
                <div>
                    <h3 class="font-bold text-gray-800">Prof. Michael Roberts</h3>
                    <p class="text-sm text-[#86662c] mb-1">Senior Editor</p>
                    <p class="text-xs text-gray-600">Oxford University</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <img src="https://ui-avatars.com/api/?name=Elena+Petrova&background=86662c&color=fff&size=64" class="w-16 h-16 rounded-full">
                <div>
                    <h3 class="font-bold text-gray-800">Dr. Elena Petrova</h3>
                    <p class="text-sm text-[#86662c] mb-1">Associate Editor</p>
                    <p class="text-xs text-gray-600">Max Planck Institute</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <img src="https://ui-avatars.com/api/?name=James+Wilson&background=86662c&color=fff&size=64" class="w-16 h-16 rounded-full">
                <div>
                    <h3 class="font-bold text-gray-800">Prof. James Wilson</h3>
                    <p class="text-sm text-[#86662c] mb-1">Editorial Board Member</p>
                    <p class="text-xs text-gray-600">MIT</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Indexing & Partnerships -->
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Indexing & Partnerships</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <i class="fa-solid fa-database text-3xl text-[#86662c] mb-2"></i>
                <p class="text-sm font-medium">Scopus</p>
            </div>
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <i class="fa-solid fa-globe text-3xl text-[#86662c] mb-2"></i>
                <p class="text-sm font-medium">Web of Science</p>
            </div>
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <i class="fa-solid fa-flask text-3xl text-[#86662c] mb-2"></i>
                <p class="text-sm font-medium">PubMed</p>
            </div>
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <i class="fa-solid fa-building-columns text-3xl text-[#86662c] mb-2"></i>
                <p class="text-sm font-medium">DOAJ</p>
            </div>
        </div>
    </section>
@endsection