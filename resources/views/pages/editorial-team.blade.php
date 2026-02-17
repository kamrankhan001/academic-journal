@extends('layouts.guest')

@section('page-title', 'Editorial Team')
@section('page-subtitle', 'Meet the distinguished board members guiding Journal of Medical and Surgical Allied')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section -->
    <div class="bg-linear-to-r from-[#86662c] to-[#6b4f23] rounded-2xl p-8 text-white mb-10">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <i class="fa-solid fa-users text-3xl text-white"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold mb-2">Editorial Team</h2>
                <p class="text-white/90 text-lg">Distinguished experts guiding our journal's scientific excellence</p>
            </div>
        </div>
    </div>

    <!-- Editor-in-Chief -->
    <div class="mb-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <span class="w-1 h-8 bg-[#86662c] rounded-full mr-3"></span>
            Editor-in-Chief
        </h3>
        
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-1/4 flex justify-center">
                        <div class="w-40 h-40 bg-linear-to-br from-[#86662c] to-[#6b4f23] rounded-2xl flex items-center justify-center text-white shadow-lg">
                            <span class="text-5xl font-bold">MA</span>
                        </div>
                    </div>
                    <div class="md:w-3/4">
                        <h4 class="text-2xl font-bold text-gray-800 mb-1">Dr. Mansoor Ahmad</h4>
                        <p class="text-[#86662c] font-medium mb-4">Assistant Professor, Department of Neurosurgery</p>
                        <p class="text-gray-600 mb-4">Qazi Hussain Ahmed Medical Complex, Nowshera, Pakistan</p>
                        
                        <div class="bg-gray-50 rounded-xl p-5">
                            <p class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fa-solid fa-clipboard-list text-[#86662c] mr-2"></i>
                                Responsibilities:
                            </p>
                            <div class="grid md:grid-cols-2 gap-2">
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Provides overall editorial leadership</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Sets journal policy and scope</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Makes final publication decisions</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Oversees ethical compliance</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Ensures academic integrity and transparency</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Associate Editor -->
    <div class="mb-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <span class="w-1 h-8 bg-[#86662c] rounded-full mr-3"></span>
            Associate Editor
        </h3>
        
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-1/4 flex justify-center">
                        <div class="w-40 h-40 bg-linear-to-br from-[#86662c]/80 to-[#6b4f23]/80 rounded-2xl flex items-center justify-center text-white shadow-lg">
                            <span class="text-5xl font-bold">MN</span>
                        </div>
                    </div>
                    <div class="md:w-3/4">
                        <h4 class="text-2xl font-bold text-gray-800 mb-1">Prof. Dr. Muhammad Nawaz Khan</h4>
                        
                        <div class="bg-gray-50 rounded-xl p-5 mt-4">
                            <p class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fa-solid fa-clipboard-list text-[#86662c] mr-2"></i>
                                Responsibilities:
                            </p>
                            <div class="grid md:grid-cols-2 gap-2">
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Handle manuscript assignments</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Coordinate peer review</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Recommend editorial decisions</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Ensure subject relevance</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Support editorial policy implementation</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Editor -->
    <div class="mb-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <span class="w-1 h-8 bg-[#86662c] rounded-full mr-3"></span>
            Section Editor
        </h3>
        
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-1/4 flex justify-center">
                        <div class="w-40 h-40 bg-linear-to-br from-[#86662c]/60 to-[#6b4f23]/60 rounded-2xl flex items-center justify-center text-white shadow-lg">
                            <span class="text-5xl font-bold">MD</span>
                        </div>
                    </div>
                    <div class="md:w-3/4">
                        <h4 class="text-2xl font-bold text-gray-800 mb-1">Dr. Muhammad Daud</h4>
                        <p class="text-[#86662c] font-medium mb-1">Gastroenterologist, Associate Professor</p>
                        <p class="text-gray-600 mb-4">Rehman Medical Institute (RMI), Peshawar, Pakistan</p>
                        
                        <div class="bg-gray-50 rounded-xl p-5">
                            <p class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fa-solid fa-clipboard-list text-[#86662c] mr-2"></i>
                                Responsibilities:
                            </p>
                            <div class="grid md:grid-cols-2 gap-2">
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Manage submissions within specialty areas</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Evaluate technical quality</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Support reviewer selection</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fa-regular fa-circle-check text-[#86662c] mt-1 text-sm"></i>
                                    <span class="text-gray-700">Ensure specialty-based quality standards</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Editorial Board Members -->
    <div class="mb-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <span class="w-1 h-8 bg-[#86662c] rounded-full mr-3"></span>
            Editorial Board Members
        </h3>
        
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Dr. Irfan Ullah -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                        <span class="font-bold text-blue-600">IU</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">Dr. Irfan Ullah, PhD</h4>
                        <p class="text-sm text-gray-700">Postdoctoral Associate, Department of Neuroscience</p>
                        <p class="text-xs text-gray-600">Medical School, University of Minnesota, Minneapolis, MN 55455, USA</p>
                    </div>
                </div>
            </div>

            <!-- Dr. Muhammad Nawaz Khan -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                        <span class="font-bold text-green-600">NK</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">Dr. Muhammad Nawaz Khan</h4>
                        <p class="text-sm text-gray-700">Assistant Professor, Department of Neurosurgery</p>
                        <p class="text-xs text-gray-600">Lady Reading Hospital (LRH), Peshawar, Pakistan</p>
                    </div>
                </div>
            </div>

            <!-- Dr. Qudrat Ullah -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center shrink-0">
                        <span class="font-bold text-purple-600">QU</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">Dr. Qudrat Ullah</h4>
                        <p class="text-sm text-gray-700">Consultant Urologist, Institute of Kidney Diseases</p>
                        <p class="text-xs text-gray-600">Hayatabad Medical Complex, Peshawar, Pakistan</p>
                    </div>
                </div>
            </div>

            <!-- Dr. Waseem Anwer Khattak -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center shrink-0">
                        <span class="font-bold text-amber-600">WK</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">Dr. Waseem Anwer Khattak</h4>
                        <p class="text-sm text-gray-700">Orthopedic and Sports Surgeon</p>
                        <p class="text-xs text-gray-600">Hayatabad Medical Complex (HMC), Peshawar, Pakistan</p>
                    </div>
                </div>
            </div>

            <!-- Dr. Zahir Ahmad -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow md:col-span-2 max-w-md mx-auto">
                <div class="flex items-start gap-3">
                    <div class="w-12 h-12 bg-rose-100 rounded-lg flex items-center justify-center shrink-0">
                        <span class="font-bold text-rose-600">ZA</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">Dr. Zahir Ahmad</h4>
                        <p class="text-sm text-gray-700">Specialist Physician & Neurologist</p>
                        <p class="text-xs text-gray-600">Sheikh Tahnoon Bin Mohammad Medical City, Al Ain, Abu Dhabi, United Arab Emirates</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsibilities of Editorial Board Members -->
    <div class="bg-linear-to-r from-[#86662c]/5 to-[#6b4f23]/5 rounded-2xl p-8 border border-[#86662c]/20">
        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fa-solid fa-clipboard-list text-[#86662c] mr-2"></i>
            Responsibilities of Editorial Board Members
        </h3>
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
</div>
@endsection