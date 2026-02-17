@extends('layouts.page')

@section('page-title', 'About the Journal')
@section('page-subtitle', 'Journal of Medical and Surgical Allied - Advancing multidisciplinary research and promoting high-quality academic communication.')

@section('page-content')

    <!-- Aim & Scope Section -->
    <section class="mb-16">
        <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-8 text-white mb-8">
            <h2 class="text-3xl font-bold mb-4">Aim & Scope</h2>
            <p class="text-white/90 text-lg leading-relaxed">
                The Journal of Medical and Surgical Allied is a peer-reviewed, open-access scholarly journal dedicated to
                advancing multidisciplinary research and promoting high-quality academic communication across medical and
                allied health sciences.
            </p>
        </div>

        <!-- Publication Types -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <i class="fa-regular fa-file-lines text-[#86662c] text-xl mb-2"></i>
                <h3 class="font-semibold text-gray-800">Original Research Articles</h3>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <i class="fa-regular fa-file-lines text-[#86662c] text-xl mb-2"></i>
                <h3 class="font-semibold text-gray-800">Review Articles</h3>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <i class="fa-regular fa-file-lines text-[#86662c] text-xl mb-2"></i>
                <h3 class="font-semibold text-gray-800">Systematic Reviews & Meta-Analyses</h3>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <i class="fa-regular fa-file-lines text-[#86662c] text-xl mb-2"></i>
                <h3 class="font-semibold text-gray-800">Case Reports</h3>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <i class="fa-regular fa-file-lines text-[#86662c] text-xl mb-2"></i>
                <h3 class="font-semibold text-gray-800">Short Communications</h3>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <i class="fa-regular fa-file-lines text-[#86662c] text-xl mb-2"></i>
                <h3 class="font-semibold text-gray-800">Technical Notes</h3>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <i class="fa-regular fa-file-lines text-[#86662c] text-xl mb-2"></i>
                <h3 class="font-semibold text-gray-800">Perspectives and Commentaries</h3>
            </div>
        </div>

        <!-- Scope Grid -->
        <div class="bg-gray-50 rounded-2xl p-8 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Scope of the Journal</h3>
            <p class="text-gray-600 mb-4">The journal welcomes submissions in, but not limited to:</p>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                    <span class="text-gray-700">Allied Health Sciences</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                    <span class="text-gray-700">Medical and Health Sciences</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                    <span class="text-gray-700">Nursing and Clinical Practice</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                    <span class="text-gray-700">Biomedical Sciences</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                    <span class="text-gray-700">Dentistry and Oral Health</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                    <span class="text-gray-700">Rehabilitation and Physiotherapy</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                    <span class="text-gray-700">Public Health and Epidemiology</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                    <span class="text-gray-700">Mental Health and Psychiatry</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                    <span class="text-gray-700">Pharmacy and Pharmacology</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                    <span class="text-gray-700">Health Informatics</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c]"></i>
                    <span class="text-gray-700">Interdisciplinary Research</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Submissions Section -->
    <div class="mb-16 bg-linear-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-200">
        <div class="flex items-start gap-4">
            <div class="w-14 h-14 bg-[#86662c] rounded-xl flex items-center justify-center shrink-0 shadow-lg">
                <i class="fa-regular fa-paper-plane text-2xl text-white"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Submissions</h3>
                <p class="text-gray-700 text-lg leading-relaxed">
                    Authors can submit manuscripts via the journal's online submission system. After submission, authors
                    receive a tracking ID for correspondence and can monitor manuscript progress.
                </p>
                <div class="mt-4 flex items-center gap-4">
                    <a href="{{ route('author.index') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors">
                        Submit Manuscript
                    </a>
                    <a href="{{ route('guidelines') }}"
                        class="inline-flex items-center px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Submission Guidelines
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Editorial Board Introduction -->
    <section class="mb-16">
        <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-8 text-white mb-8">
            <h2 class="text-3xl font-bold mb-4">Editorial Board</h2>
            <p class="text-white/90 text-lg leading-relaxed">
                Journal of Medical and Surgical Allied is guided by a distinguished Editorial Board composed of experienced
                clinicians, researchers, and academicians from national and international institutions. The board ensures
                scientific excellence, ethical integrity, and high editorial standards in all published work.
            </p>
        </div>

        <!-- Editorial Leadership -->
        <div class="grid md:grid-cols-2 gap-6 mb-10">
            <!-- Editor-in-Chief -->
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                <div class="bg-[#86662c] px-6 py-3">
                    <h3 class="text-white font-bold text-lg">Editor-in-Chief</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-start gap-4 mb-4">
                        <img src="https://ui-avatars.com/api/?name=Mansoor+Ahmad&background=86662c&color=fff&size=80"
                            class="w-20 h-20 rounded-full border-4 border-[#86662c]/20">
                        <div>
                            <h4 class="text-xl font-bold text-gray-800">Dr. Mansoor Ahmad</h4>
                            <p class="text-[#86662c] font-medium">Assistant Professor, Department of Neurosurgery</p>
                            <p class="text-sm text-gray-600">Qazi Hussain Ahmed Medical Complex, Nowshera, Pakistan</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="font-medium text-gray-700 mb-2">Responsibilities:</p>
                        <ul class="space-y-1">
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Provides overall editorial leadership</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Sets journal policy and scope</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Makes final publication decisions</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Oversees ethical compliance</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Ensures academic integrity and transparency</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Associate Editor -->
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                <div class="bg-[#86662c]/80 px-6 py-3">
                    <h3 class="text-white font-bold text-lg">Associate Editor</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-start gap-4 mb-4">
                        <img src="https://ui-avatars.com/api/?name=Muhammad+Nawaz+Khan&background=86662c&color=fff&size=80"
                            class="w-20 h-20 rounded-full border-4 border-[#86662c]/20">
                        <div>
                            <h4 class="text-xl font-bold text-gray-800">Prof. Dr. Muhammad Nawaz Khan</h4>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="font-medium text-gray-700 mb-2">Responsibilities:</p>
                        <ul class="space-y-1">
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Handle manuscript assignments</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Coordinate peer review</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Recommend editorial decisions</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Ensure subject relevance</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Support editorial policy implementation</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Editor -->
        <div class="mb-10">
            <div
                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-lg hover:shadow-xl transition-shadow max-w-2xl mx-auto">
                <div class="bg-[#86662c]/60 px-6 py-3">
                    <h3 class="text-white font-bold text-lg">Section Editor</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-start gap-4 mb-4">
                        <img src="https://ui-avatars.com/api/?name=Muhammad+Daud&background=86662c&color=fff&size=80"
                            class="w-20 h-20 rounded-full border-4 border-[#86662c]/20">
                        <div>
                            <h4 class="text-xl font-bold text-gray-800">Dr. Muhammad Daud</h4>
                            <p class="text-[#86662c] font-medium">Gastroenterologist, Associate Professor</p>
                            <p class="text-sm text-gray-600">Rehman Medical Institute (RMI), Peshawar, Pakistan</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="font-medium text-gray-700 mb-2">Responsibilities:</p>
                        <ul class="space-y-1">
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Manage submissions within specialty areas</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Evaluate technical quality</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Support reviewer selection</span>
                            </li>
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span>Ensure specialty-based quality standards</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Editorial Board Members -->
        <div class="mb-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Editorial Board Members</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <!-- Dr. Irfan Ullah -->
                <div class="bg-white rounded-xl p-5 border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-3">
                        <img src="https://ui-avatars.com/api/?name=Irfan+Ullah&background=86662c&color=fff&size=48"
                            class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-gray-800">Dr. Irfan Ullah, PhD</h4>
                            <p class="text-sm text-gray-700">Postdoctoral Associate, Department of Neuroscience</p>
                            <p class="text-xs text-gray-600">Medical School, University of Minnesota, Minneapolis, MN 55455,
                                USA</p>
                        </div>
                    </div>
                </div>

                <!-- Dr. Muhammad Nawaz Khan -->
                <div class="bg-white rounded-xl p-5 border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-3">
                        <img src="https://ui-avatars.com/api/?name=Muhammad+Nawaz+Khan&background=86662c&color=fff&size=48"
                            class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-gray-800">Dr. Muhammad Nawaz Khan</h4>
                            <p class="text-sm text-gray-700">Assistant Professor, Department of Neurosurgery</p>
                            <p class="text-xs text-gray-600">Lady Reading Hospital (LRH), Peshawar, Pakistan</p>
                        </div>
                    </div>
                </div>

                <!-- Dr. Qudrat Ullah -->
                <div class="bg-white rounded-xl p-5 border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-3">
                        <img src="https://ui-avatars.com/api/?name=Qudrat+Ullah&background=86662c&color=fff&size=48"
                            class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-gray-800">Dr. Qudrat Ullah</h4>
                            <p class="text-sm text-gray-700">Consultant Urologist, Institute of Kidney Diseases</p>
                            <p class="text-xs text-gray-600">Hayatabad Medical Complex, Peshawar, Pakistan</p>
                        </div>
                    </div>
                </div>

                <!-- Dr. Waseem Anwer Khattak -->
                <div class="bg-white rounded-xl p-5 border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-3">
                        <img src="https://ui-avatars.com/api/?name=Waseem+Anwer+Khattak&background=86662c&color=fff&size=48"
                            class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-gray-800">Dr. Waseem Anwer Khattak</h4>
                            <p class="text-sm text-gray-700">Orthopedic and Sports Surgeon</p>
                            <p class="text-xs text-gray-600">Hayatabad Medical Complex (HMC), Peshawar, Pakistan</p>
                        </div>
                    </div>
                </div>

                <!-- Dr. Zahir Ahmad -->
                <div
                    class="bg-white rounded-xl p-5 border border-gray-200 hover:shadow-md transition-shadow md:col-span-2 max-w-md mx-auto">
                    <div class="flex items-start gap-3">
                        <img src="https://ui-avatars.com/api/?name=Zahir+Ahmad&background=86662c&color=fff&size=48"
                            class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-gray-800">Dr. Zahir Ahmad</h4>
                            <p class="text-sm text-gray-700">Specialist Physician & Neurologist</p>
                            <p class="text-xs text-gray-600">Sheikh Tahnoon Bin Mohammad Medical City, Al Ain, Abu Dhabi,
                                United Arab Emirates</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Responsibilities of Editorial Board Members -->
        <div class="bg-linear-to-br from-gray-50 to-white rounded-2xl p-8 border border-gray-200 mb-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Responsibilities of Editorial Board Members</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                    <span class="text-gray-700">Advise on journal policy</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                    <span class="text-gray-700">Promote journal visibility</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                    <span class="text-gray-700">Review manuscripts when required</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                    <span class="text-gray-700">Support quality standards</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                    <span class="text-gray-700">Uphold publication ethics</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                    <span class="text-gray-700">Contribute to the strategic development of the journal</span>
                </div>
            </div>
        </div>

        <!-- Editorial Policies -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] px-8 py-4">
                <h2 class="text-2xl font-bold text-white">Editorial Policies</h2>
            </div>

            <div class="p-8">
                <p class="text-gray-700 mb-6 text-lg">The journal maintains strict editorial independence and transparency.
                </p>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Editorial decisions are based solely on:</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span class="text-gray-700">Scientific quality</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span class="text-gray-700">Originality</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span class="text-gray-700">Methodological rigor</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span class="text-gray-700">Relevance to scope</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span class="text-gray-700">Ethical compliance</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Editorial actions include:</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span class="text-gray-700">Initial screening</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span class="text-gray-700">Peer review coordination</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span class="text-gray-700">Revision decisions</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-regular fa-circle-check text-[#86662c] mt-1"></i>
                                <span class="text-gray-700">Final acceptance or rejection</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 p-6 bg-amber-50 rounded-xl border border-amber-200">
                    <p class="text-gray-800 font-medium">
                        Editors do not discriminate based on author nationality, gender, institution, or funding source. All
                        manuscripts are evaluated fairly and confidentially.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection