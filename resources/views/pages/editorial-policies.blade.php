@extends('layouts.guest')

@section('page-title', 'Editorial Policies')
@section('page-subtitle', 'Our commitment to editorial independence, transparency, and ethical publishing')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section -->
    <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-8 text-white mb-10">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <i class="fa-solid fa-scale-balanced text-3xl text-white"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold mb-2">Editorial Policies</h2>
                <p class="text-white/90 text-lg">Maintaining the highest standards of academic integrity</p>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow mb-8">
        <div class="bg-linear-to-r from-[#86662c]/10 to-[#6b4f23]/10 px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fa-regular fa-file-lines mr-2 text-[#86662c]"></i>
                Editorial Independence & Transparency
            </h3>
        </div>
        
        <div class="p-8">
            <div class="bg-amber-50 border-l-4 border-[#86662c] p-5 rounded-r-lg mb-8">
                <p class="text-gray-800 text-lg font-medium">The journal maintains strict editorial independence and transparency.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Left Column - Decision Criteria -->
                <div>
                    <h4 class="text-xl font-bold text-gray-800 mb-5 flex items-center">
                        <span class="w-1 h-6 bg-[#86662c] rounded-full mr-3"></span>
                        Editorial decisions are based solely on:
                    </h4>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-flask text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Scientific quality</span>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-regular fa-lightbulb text-purple-600 text-sm"></i>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Originality</span>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-chart-line text-amber-600 text-sm"></i>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Methodological rigor</span>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-bullseye text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Relevance to scope</span>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-rose-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-regular fa-hand text-rose-600 text-sm"></i>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Ethical compliance</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Editorial Actions -->
                <div>
                    <h4 class="text-xl font-bold text-gray-800 mb-5 flex items-center">
                        <span class="w-1 h-6 bg-[#86662c] rounded-full mr-3"></span>
                        Editorial actions include:
                    </h4>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-magnifying-glass text-indigo-600 text-sm"></i>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Initial screening</span>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-people-arrows text-teal-600 text-sm"></i>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Peer review coordination</span>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-regular fa-pen-to-square text-orange-600 text-sm"></i>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Revision decisions</span>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-regular fa-circle-check text-emerald-600 text-sm"></i>
                            </div>
                            <div>
                                <span class="font-medium text-gray-800">Final acceptance or rejection</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Non-discrimination Statement -->
            <div class="mt-10 p-6 bg-linear-to-r from-[#86662c]/5 to-[#6b4f23]/5 rounded-xl border border-[#86662c]/20">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-[#86662c]/10 rounded-full flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-scale-balanced text-[#86662c] text-xl"></i>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800 mb-2">Non-Discrimination Policy</h5>
                        <p class="text-gray-700 leading-relaxed">
                            Editors do not discriminate based on author nationality, gender, institution, or funding source. 
                            All manuscripts are evaluated fairly and confidentially.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links to Related Pages -->
    <div class="grid md:grid-cols-3 gap-4">
        <a href="{{ route('editorial-team') }}" class="bg-white p-5 rounded-xl border border-gray-200 hover:border-[#86662c] hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-users text-blue-600"></i>
                </div>
                <span class="font-medium text-gray-800">Editorial Team</span>
            </div>
            <i class="fa-solid fa-arrow-right text-gray-400 group-hover:text-[#86662c] transition-colors"></i>
        </a>
        
        <a href="{{ route('guidelines') }}" class="bg-white p-5 rounded-xl border border-gray-200 hover:border-[#86662c] hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-file-lines text-green-600"></i>
                </div>
                <span class="font-medium text-gray-800">Author Guidelines</span>
            </div>
            <i class="fa-solid fa-arrow-right text-gray-400 group-hover:text-[#86662c] transition-colors"></i>
        </a>
        
        <a href="{{ route('contact') }}" class="bg-white p-5 rounded-xl border border-gray-200 hover:border-[#86662c] hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-envelope text-amber-600"></i>
                </div>
                <span class="font-medium text-gray-800">Contact Us</span>
            </div>
            <i class="fa-solid fa-arrow-right text-gray-400 group-hover:text-[#86662c] transition-colors"></i>
        </a>
    </div>
</div>
@endsection