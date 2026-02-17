@extends('layouts.guest')

@section('page-title', 'Current Issue')
@section('page-subtitle', 'Volume 1, Issue 1 - January - March 2026')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-8 text-white mb-10">
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-2">Current Issue</h2>
                    <p class="text-white/90 text-lg">Volume 1, Issue 1 • January - March 2026</p>
                </div>
            </div>
        </div>

        <!-- Issue Details Card -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow mb-10">
            <div class="bg-linear-to-r from-[#86662c]/10 to-[#6b4f23]/10 px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fa-solid fa-circle-info mr-2 text-[#86662c]"></i>
                    Issue Information
                </h3>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-layer-group text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Volume</p>
                            <p class="text-lg font-bold text-gray-800">1</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Issue</p>
                            <p class="text-lg font-bold text-gray-800">1</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <i class="fa-regular fa-calendar text-amber-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Year</p>
                            <p class="text-lg font-bold text-gray-800">2026</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Publication Period</p>
                            <p class="text-lg font-bold text-gray-800">January - March</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 my-6"></div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fa-regular fa-calendar-check text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Publication Date</p>
                            <p class="text-base font-semibold text-gray-800">February 15, 2026</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-lock-open text-emerald-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Access Type</p>
                            <p class="text-base font-semibold text-gray-800">Open Access</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-rose-100 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fa-regular fa-eye text-rose-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Review Model</p>
                            <p class="text-base font-semibold text-gray-800">Double-blind peer review</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Issue Description -->
        <div class="bg-indigo-50 border-l-4 border-[#86662c] p-6 rounded-r-xl mb-10">
            <p class="text-gray-700 leading-relaxed">
                This issue presents peer-reviewed articles addressing modern scientific and technological developments, interdisciplinary research, and emerging analytical approaches. Readers can browse articles individually or download full texts in PDF format.
            </p>
        </div>

        <!-- Articles Section -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow mb-10">
            <div class="bg-linear-to-r from-[#86662c]/10 to-[#6b4f23]/10 px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fa-regular fa-file-lines mr-2 text-[#86662c]"></i>
                    Articles in this Issue
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Article 1 -->
                    <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Research Article</span>
                                <span class="text-xs text-gray-500"><i class="fa-regular fa-calendar mr-1"></i> Feb 15, 2026</span>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Advances in Minimally Invasive Cardiac Surgery: A Systematic Review</h4>
                            <p class="text-sm text-gray-600 mb-2">John Smith, Sarah Johnson, Michael Chen</p>
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span><i class="fa-regular fa-file-pdf mr-1 text-red-500"></i> PDF (2.4 MB)</span>
                                <span><i class="fa-regular fa-eye mr-1"></i> 1,234 views</span>
                                <span><i class="fa-regular fa-quote-right mr-1"></i> 12 citations</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <a href="#" class="p-2 bg-white rounded-lg border border-gray-200 hover:border-[#86662c] transition-colors" title="Download PDF">
                                <i class="fa-regular fa-file-pdf text-red-500"></i>
                            </a>
                            <a href="#" class="p-2 bg-white rounded-lg border border-gray-200 hover:border-[#86662c] transition-colors" title="View Article">
                                <i class="fa-solid fa-arrow-right text-[#86662c]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Article 2 -->
                    <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Original Research</span>
                                <span class="text-xs text-gray-500"><i class="fa-regular fa-calendar mr-1"></i> Feb 15, 2026</span>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Postoperative Outcomes in Elderly Patients Undergoing Hip Arthroplasty</h4>
                            <p class="text-sm text-gray-600 mb-2">Emily Williams, David Brown, Lisa Wong</p>
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span><i class="fa-regular fa-file-pdf mr-1 text-red-500"></i> PDF (1.8 MB)</span>
                                <span><i class="fa-regular fa-eye mr-1"></i> 892 views</span>
                                <span><i class="fa-regular fa-quote-right mr-1"></i> 8 citations</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <a href="#" class="p-2 bg-white rounded-lg border border-gray-200 hover:border-[#86662c] transition-colors" title="Download PDF">
                                <i class="fa-regular fa-file-pdf text-red-500"></i>
                            </a>
                            <a href="#" class="p-2 bg-white rounded-lg border border-gray-200 hover:border-[#86662c] transition-colors" title="View Article">
                                <i class="fa-solid fa-arrow-right text-[#86662c]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Article 3 -->
                    <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">Case Report</span>
                                <span class="text-xs text-gray-500"><i class="fa-regular fa-calendar mr-1"></i> Feb 15, 2026</span>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Rare Presentation of Mediastinal Mass: A Case Report and Literature Review</h4>
                            <p class="text-sm text-gray-600 mb-2">Robert Martinez, Lisa Wong, James Wilson</p>
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span><i class="fa-regular fa-file-pdf mr-1 text-red-500"></i> PDF (3.2 MB)</span>
                                <span><i class="fa-regular fa-eye mr-1"></i> 567 views</span>
                                <span><i class="fa-regular fa-quote-right mr-1"></i> 3 citations</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <a href="#" class="p-2 bg-white rounded-lg border border-gray-200 hover:border-[#86662c] transition-colors" title="Download PDF">
                                <i class="fa-regular fa-file-pdf text-red-500"></i>
                            </a>
                            <a href="#" class="p-2 bg-white rounded-lg border border-gray-200 hover:border-[#86662c] transition-colors" title="View Article">
                                <i class="fa-solid fa-arrow-right text-[#86662c]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Article 4 -->
                    <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs font-medium rounded-full">Review Article</span>
                                <span class="text-xs text-gray-500"><i class="fa-regular fa-calendar mr-1"></i> Feb 15, 2026</span>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Artificial Intelligence in Medical Diagnostics: Current Applications and Future Directions</h4>
                            <p class="text-sm text-gray-600 mb-2">Sarah Chen, Michael Roberts, Elena Petrova</p>
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span><i class="fa-regular fa-file-pdf mr-1 text-red-500"></i> PDF (2.1 MB)</span>
                                <span><i class="fa-regular fa-eye mr-1"></i> 2,156 views</span>
                                <span><i class="fa-regular fa-quote-right mr-1"></i> 24 citations</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <a href="#" class="p-2 bg-white rounded-lg border border-gray-200 hover:border-[#86662c] transition-colors" title="Download PDF">
                                <i class="fa-regular fa-file-pdf text-red-500"></i>
                            </a>
                            <a href="#" class="p-2 bg-white rounded-lg border border-gray-200 hover:border-[#86662c] transition-colors" title="View Article">
                                <i class="fa-solid fa-arrow-right text-[#86662c]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archives Link -->
        <div class="text-center">
            <a href="{{ route('archives') }}" class="inline-flex items-center text-[#86662c] hover:text-[#6b4f23] font-medium">
                <i class="fa-solid fa-box-archive mr-2"></i>
                Browse Archives
                <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
@endsection