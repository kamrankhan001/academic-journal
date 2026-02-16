@extends('layouts.guest')

@section('title', 'Unsubscribed - Newsletter')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-md mx-auto text-center">
            <div class="bg-white rounded-lg border border-gray-200 p-8">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-regular fa-bell-slash text-red-600 text-2xl"></i>
                </div>
                
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Unsubscribed Successfully</h1>
                <p class="text-gray-600 mb-6">
                    {{ $email }} has been removed from our newsletter list.
                </p>
                
                <p class="text-sm text-gray-500 mb-6">
                    We're sorry to see you go. If you change your mind, you can subscribe again anytime.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('home') }}" 
                       class="bg-[#86662c] text-white px-6 py-2 rounded-lg hover:bg-[#6b4f23] transition-colors">
                        Return to Home
                    </a>
                    <a href="{{ route('newsletter.subscribe') }}" 
                       class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                        Resubscribe
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection