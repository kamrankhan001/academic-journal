@extends('layouts.guest')

@section('page-title', 'Journal Policies')
@section('page-subtitle', 'Indexing, abstracting, and article processing charges')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section -->
    <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-8 text-white mb-10">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <i class="fa-regular fa-file-lines text-3xl text-white"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold mb-2">Journal Policies</h2>
                <p class="text-white/90 text-lg">Indexing, abstracting, and article processing charges</p>
            </div>
        </div>
    </div>

    <!-- Indexing & Abstracting Section -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow mb-8">
        <div class="bg-linear-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fa-solid fa-magnifying-glass-chart mr-2 text-indigo-600"></i>
                Indexing & Abstracting
            </h3>
        </div>
        <div class="p-6">
            <p class="text-gray-700 mb-4">The journal aims to maximize visibility and accessibility of published research through indexing and archiving services. Applications are submitted to recognized indexing databases and scholarly directories to enhance discoverability.</p>
            
            <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                <i class="fa-regular fa-eye mr-2 text-[#86662c]"></i>
                Visibility Measures
            </h4>
            
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Search engine indexing</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Academic database applications</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Institutional repository inclusion</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Metadata standardization</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">DOI registration (if enabled)</span>
                </div>
            </div>

            <div class="bg-indigo-50 border-l-4 border-indigo-600 p-4 rounded-r-lg">
                <p class="text-gray-700 italic flex items-center">
                    <i class="fa-solid fa-quote-left text-indigo-600 mr-2"></i>
                    Authors benefit from increased citation potential and global accessibility.
                </p>
            </div>
        </div>
    </div>

    <!-- Article Processing Charges Section -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow mb-8">
        <div class="bg-linear-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fa-regular fa-credit-card mr-2 text-amber-600"></i>
                Article Processing Charges (APC)
            </h3>
        </div>
        <div class="p-6">
            <p class="text-gray-700 mb-4">To support editorial processing, peer review management, website hosting, and archiving, the journal may charge an Article Processing Fee after acceptance.</p>
            
            <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                <i class="fa-regular fa-file-lines mr-2 text-[#86662c]"></i>
                APC Policy
            </h4>
            
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">No fee for initial submission</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Fee applies only after acceptance</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Waivers may be granted for students or low-income regions</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Fast-track review (if offered) may have separate charges</span>
                </div>
            </div>

            <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                <i class="fa-regular fa-rectangle-list mr-2 text-[#86662c]"></i>
                What APC Covers
            </h4>
            
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Peer review management</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Editorial processing</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Copyediting</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Typesetting</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">DOI assignment (if used)</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Online hosting</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-green-600 mt-1"></i>
                    <span class="text-gray-700">Long-term archiving</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-8 text-white text-center">
        <h3 class="text-2xl font-bold mb-3">Need a Waiver?</h3>
        <p class="text-white/90 mb-6 max-w-2xl mx-auto">Waivers may be granted for students, researchers from low-income regions, or exceptional circumstances.</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-white text-[#86662c] rounded-xl hover:bg-gray-100 transition-colors font-semibold shadow-lg">
            Contact Us
        </a>
    </div>
</div>
@endsection