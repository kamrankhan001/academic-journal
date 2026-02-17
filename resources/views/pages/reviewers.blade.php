@extends('layouts.guest')

@section('page-title', 'For Reviewers')
@section('page-subtitle', 'Guidelines and responsibilities for peer reviewers')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section -->
    <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-8 text-white mb-10">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <i class="fa-solid fa-user-check text-3xl text-white"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold mb-2">For Reviewers</h2>
                <p class="text-white/90 text-lg">Guidelines and responsibilities for peer reviewers</p>
            </div>
        </div>
    </div>

    <!-- Reviewer Guidelines -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow mb-8">
        <div class="bg-linear-to-r from-[#86662c]/10 to-[#6b4f23]/10 px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fa-regular fa-file-lines mr-2 text-[#86662c]"></i>
                Reviewer Guidelines
            </h3>
        </div>
        <div class="p-6">
            <p class="text-gray-700 mb-4">Peer reviewers play a vital role in maintaining the academic quality of the journal. Reviews should be objective, constructive, and timely.</p>
            
            <div class="bg-blue-50 border-l-4 border-[#86662c] p-4 rounded-r-lg">
                <p class="text-sm text-gray-700">
                    <span class="font-bold">Important:</span> All reviews are treated as confidential and should be completed within the specified timeframe.
                </p>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <!-- Reviewers Should Evaluate -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <div class="bg-linear-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fa-solid fa-clipboard-list mr-2 text-purple-600"></i>
                    Reviewers Should Evaluate
                </h3>
            </div>
            <div class="p-6">
                <ul class="space-y-3">
                    <li class="flex items-start gap-2">
                        <i class="fa-regular fa-circle-check text-purple-600 mt-1"></i>
                        <span class="text-gray-700">Originality and novelty</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-regular fa-circle-check text-purple-600 mt-1"></i>
                        <span class="text-gray-700">Methodological soundness</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-regular fa-circle-check text-purple-600 mt-1"></i>
                        <span class="text-gray-700">Clarity of presentation</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-regular fa-circle-check text-purple-600 mt-1"></i>
                        <span class="text-gray-700">Validity of results</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-regular fa-circle-check text-purple-600 mt-1"></i>
                        <span class="text-gray-700">Relevance to journal scope</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-regular fa-circle-check text-purple-600 mt-1"></i>
                        <span class="text-gray-700">Ethical compliance</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Reviewer Responsibilities -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <div class="bg-linear-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fa-solid fa-scale-balanced mr-2 text-emerald-600"></i>
                    Reviewer Responsibilities
                </h3>
            </div>
            <div class="p-6">
                <ul class="space-y-3">
                    <li class="flex items-start gap-2">
                        <i class="fa-regular fa-circle-check text-emerald-600 mt-1"></i>
                        <span class="text-gray-700">Maintain confidentiality</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-regular fa-circle-check text-emerald-600 mt-1"></i>
                        <span class="text-gray-700">Declare conflicts of interest</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-regular fa-circle-check text-emerald-600 mt-1"></i>
                        <span class="text-gray-700">Provide evidence-based comments</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-regular fa-circle-check text-emerald-600 mt-1"></i>
                        <span class="text-gray-700">Avoid personal criticism</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-regular fa-circle-check text-emerald-600 mt-1"></i>
                        <span class="text-gray-700">Submit reviews within deadline</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Review Recommendations -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow mb-8">
        <div class="bg-linear-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fa-regular fa-star mr-2 text-amber-600"></i>
                Review Recommendations
            </h3>
        </div>
        <div class="p-6">
            <p class="text-gray-700 mb-4">Reviewers may recommend:</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-green-50 p-3 rounded-lg text-center">
                    <span class="font-medium text-green-700">Accept</span>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg text-center">
                    <span class="font-medium text-blue-700">Minor revision</span>
                </div>
                <div class="bg-amber-50 p-3 rounded-lg text-center">
                    <span class="font-medium text-amber-700">Major revision</span>
                </div>
                <div class="bg-red-50 p-3 rounded-lg text-center">
                    <span class="font-medium text-red-700">Reject</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 mt-4">Constructive suggestions for improvement are strongly encouraged.</p>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-8 text-white text-center">
        <h3 class="text-2xl font-bold mb-3">Interested in becoming a reviewer?</h3>
        <p class="text-white/90 mb-6">Register as a reviewer and contribute to maintaining academic quality</p>
        <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-[#86662c] rounded-xl hover:bg-gray-100 transition-colors font-semibold">
            Register as Reviewer
        </a>
    </div>
</div>
@endsection