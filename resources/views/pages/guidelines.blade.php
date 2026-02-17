@extends('layouts.guest')

@section('page-title', 'For Authors')
@section('page-subtitle', 'Guidelines, policies, and instructions for submitting your research to Journal of Medical and Surgical Allied')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-8 text-white mb-10">
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <i class="fa-solid fa-users text-3xl text-white"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-2">Author Guidelines</h2>
                    <p class="text-white/90 text-lg">Everything you need to know about submitting your manuscript to our
                        journal</p>
                </div>
            </div>
        </div>

        <!-- Author Guidelines Section -->
        <section class="mb-12">
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-linear-to-r from-[#86662c]/10 to-[#6b4f23]/10 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fa-regular fa-file-lines mr-2 text-[#86662c]"></i>
                        Author Guidelines
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-4">Authors submitting manuscripts must ensure that their work is original,
                        unpublished, and not under consideration elsewhere. All submissions must follow the journal
                        formatting requirements.</p>

                    <div class="bg-amber-50 border-l-4 border-[#86662c] p-4 rounded-r-lg">
                        <p class="text-sm text-gray-700">
                            <span class="font-bold">Important:</span> All manuscripts are screened for plagiarism using
                            detection tools. Proven misconduct results in rejection or retraction.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Manuscript Structure -->
        <section class="mb-12">
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-linear-to-r from-[#86662c]/10 to-[#6b4f23]/10 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fa-solid fa-sitemap mr-2 text-[#86662c]"></i>
                        Manuscript Structure
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-4">Manuscripts should include the following sections in order:</p>

                    <div class="grid md:grid-cols-2 gap-3">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#86662c]/10 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-[#86662c]">1</span>
                            </div>
                            <span class="text-gray-700">Title Page</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#86662c]/10 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-[#86662c]">2</span>
                            </div>
                            <span class="text-gray-700">Abstract (structured when applicable)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#86662c]/10 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-[#86662c]">3</span>
                            </div>
                            <span class="text-gray-700">Keywords (3–6 terms)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#86662c]/10 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-[#86662c]">4</span>
                            </div>
                            <span class="text-gray-700">Introduction</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#86662c]/10 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-[#86662c]">5</span>
                            </div>
                            <span class="text-gray-700">Methods</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#86662c]/10 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-[#86662c]">6</span>
                            </div>
                            <span class="text-gray-700">Results</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#86662c]/10 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-[#86662c]">7</span>
                            </div>
                            <span class="text-gray-700">Discussion</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#86662c]/10 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-[#86662c]">8</span>
                            </div>
                            <span class="text-gray-700">Conclusion</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#86662c]/10 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-[#86662c]">9</span>
                            </div>
                            <span class="text-gray-700">References</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-[#86662c]/10 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-[#86662c]">10</span>
                            </div>
                            <span class="text-gray-700">Tables and Figures (if applicable)</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Formatting Requirements -->
        <section class="mb-12">
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-linear-to-r from-[#86662c]/10 to-[#6b4f23]/10 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fa-solid fa-text-height mr-2 text-[#86662c]"></i>
                        Formatting Requirements
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700"><span class="font-medium">Language:</span> English</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700"><span class="font-medium">Font:</span> Times New Roman, 12
                                        pt</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700"><span class="font-medium">Line spacing:</span> 1.5</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700"><span class="font-medium">References:</span> Vancouver / APA
                                        (choose one and keep consistent)</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700"><span class="font-medium">Figures and tables:</span> Must be
                                        numbered and titled</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700"><span class="font-medium">Units:</span> Must follow SI
                                        (International System) standards</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ethical Requirements & Submission Instructions - Two Column -->
        <div class="grid md:grid-cols-2 gap-6 mb-12">
            <!-- Ethical Requirements -->
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-linear-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fa-solid fa-scale-balanced mr-2 text-emerald-600"></i>
                        Ethical Requirements
                    </h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-emerald-600 mt-1 text-sm"></i>
                            <span class="text-gray-700">Human/animal studies must include ethical approval statement</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-emerald-600 mt-1 text-sm"></i>
                            <span class="text-gray-700">Informed consent must be declared where applicable</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-emerald-600 mt-1 text-sm"></i>
                            <span class="text-gray-700">Conflict of interest disclosure is required</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-emerald-600 mt-1 text-sm"></i>
                            <span class="text-gray-700">Funding sources must be listed</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Submission Instructions -->
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-linear-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fa-solid fa-cloud-arrow-up mr-2 text-blue-600"></i>
                        Submission Instructions
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-4">Authors can submit manuscripts through the journal's online submission
                        system.</p>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-700 mb-2 font-medium">After submission, authors receive a tracking ID
                            for correspondence.</p>
                        <a href="{{ route('author.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Submit your manuscript
                            <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submission Checklist & Required Files -->
        <div class="grid md:grid-cols-2 gap-6 mb-12">
            <!-- Submission Checklist -->
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-linear-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fa-solid fa-list-check mr-2 text-amber-600"></i>
                        Submission Checklist
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-3 text-sm">Before submitting, ensure:</p>
                    <ul class="space-y-2">
                        <li class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-amber-600 mt-1 text-sm"></i>
                            <span class="text-sm text-gray-700">Manuscript is formatted correctly</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-amber-600 mt-1 text-sm"></i>
                            <span class="text-sm text-gray-700">Title page is included</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-amber-600 mt-1 text-sm"></i>
                            <span class="text-sm text-gray-700">Author details are complete</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-amber-600 mt-1 text-sm"></i>
                            <span class="text-sm text-gray-700">Ethical approval statement is present</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-amber-600 mt-1 text-sm"></i>
                            <span class="text-sm text-gray-700">References are properly formatted</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-amber-600 mt-1 text-sm"></i>
                            <span class="text-sm text-gray-700">Figures/tables are labeled</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-amber-600 mt-1 text-sm"></i>
                            <span class="text-sm text-gray-700">Conflict of interest declared</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Required Files -->
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-linear-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        Required Files
                    </h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-regular fa-file-lines text-purple-600 text-sm"></i>
                            </div>
                            <span class="text-gray-700">Main manuscript file</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-regular fa-file-lines text-purple-600 text-sm"></i>
                            </div>
                            <span class="text-gray-700">Title page</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-regular fa-image text-purple-600 text-sm"></i>
                            </div>
                            <span class="text-gray-700">Figures (separate files if required)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-regular fa-folder-open text-purple-600 text-sm"></i>
                            </div>
                            <span class="text-gray-700">Supplementary material (if any)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Publication Ethics -->
        <section class="mb-12">
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-linear-to-r from-red-50 to-rose-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fa-solid fa-shield mr-2 text-red-600"></i>
                        Publication Ethics
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-4">The journal follows international publication ethics standards. The
                        journal prohibits:</p>

                    <div class="grid md:grid-cols-2 gap-4 mb-6">
                        <div class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-xmark text-red-500 mt-1"></i>
                            <span class="text-gray-700">Plagiarism</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-xmark text-red-500 mt-1"></i>
                            <span class="text-gray-700">Data fabrication or falsification</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-xmark text-red-500 mt-1"></i>
                            <span class="text-gray-700">Duplicate submission</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-xmark text-red-500 mt-1"></i>
                            <span class="text-gray-700">Redundant publication</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-xmark text-red-500 mt-1"></i>
                            <span class="text-gray-700">Image manipulation</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-xmark text-red-500 mt-1"></i>
                            <span class="text-gray-700">Undisclosed conflicts of interest</span>
                        </div>
                    </div>

                    <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-r-lg">
                        <p class="text-sm text-gray-700">All manuscripts are screened using plagiarism detection tools.
                            Proven misconduct results in rejection or retraction.</p>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-bold text-gray-800 mb-3">Author Responsibilities</h4>
                        <div class="grid md:grid-cols-2 gap-3">
                            <div class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-emerald-600 mt-1"></i>
                                <span class="text-sm text-gray-700">Report accurate data</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-emerald-600 mt-1"></i>
                                <span class="text-sm text-gray-700">Cite sources properly</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-emerald-600 mt-1"></i>
                                <span class="text-sm text-gray-700">Obtain permissions when needed</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-emerald-600 mt-1"></i>
                                <span class="text-sm text-gray-700">Cooperate with corrections if required</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Copyright & Licensing -->
        <section class="mb-8">
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Copyright Policy -->
                <div
                    class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="bg-linear-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fa-solid fa-copyright mr-2 text-indigo-600"></i>
                            Copyright Policy
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 mb-3">Authors retain copyright of their published work. By submitting to the
                            journal, authors grant the journal the right to publish and distribute the article.</p>
                        <div class="bg-indigo-50 p-3 rounded-lg text-sm text-gray-700">
                            <span class="font-medium">Copyright Holder:</span> Author(s)
                        </div>
                    </div>
                </div>

                <!-- Licensing -->
                <div
                    class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="bg-linear-to-r from-teal-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fa-solid fa-lock-open mr-2 text-teal-600"></i>
                            Licensing
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 mb-3">All published articles are distributed under an Open Access license,
                            allowing readers to:</p>
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-eye text-teal-600"></i>
                                <span class="text-sm text-gray-700">Read</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-download text-teal-600"></i>
                                <span class="text-sm text-gray-700">Download</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-share-nodes text-teal-600"></i>
                                <span class="text-sm text-gray-700">Share</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-quote-right text-teal-600"></i>
                                <span class="text-sm text-gray-700">Cite</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Provided proper author attribution is given.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Author Rights -->
        <section class="mb-8">
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-linear-to-r from-[#86662c]/10 to-[#6b4f23]/10 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fa-solid fa-user-check mr-2 text-[#86662c]"></i>
                        Author Rights
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-4">Authors may:</p>
                    <div class="grid md:grid-cols-2 gap-3">
                        <div class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                            <span class="text-gray-700">Share their article on personal websites</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                            <span class="text-gray-700">Deposit in institutional repositories</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                            <span class="text-gray-700">Use in academic teaching</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                            <span class="text-gray-700">Include in future books or theses</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">Proper citation of the journal publication is required.</p>
                </div>
            </div>
        </section>
    </div>
@endsection