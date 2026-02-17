@extends('layouts.admin')

@section('title', $announcement->title . ' - Announcement')
@section('page-title', $announcement->title)

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('admin.announcements.index') }}" class="text-gray-600 hover:text-[#86662c] transition-colors">Announcements</a>
        <i class="fa-solid fa-chevron-right text-xs mx-2 text-gray-400"></i>
    </li>
    <li class="flex items-center text-gray-800">View</li>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Action Buttons -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                @if(!$announcement->sent_at)
                    <form action="{{ route('admin.announcements.send', $announcement->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors" onclick="return confirm('Send this announcement now?')">
                            <i class="fa-regular fa-paper-plane mr-2"></i>
                            Send Now
                        </button>
                    </form>
                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fa-regular fa-pen-to-square mr-2"></i>
                        Edit
                    </a>
                @endif
                
                <form action="{{ route('admin.announcements.duplicate', $announcement->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fa-regular fa-copy mr-2"></i>
                        Duplicate
                    </button>
                </form>
                
                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this announcement? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                        <i class="fa-regular fa-trash-can mr-2"></i>
                        Delete
                    </button>
                </form>
            </div>
            
            <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fa-regular fa-arrow-left mr-2"></i>
                Back to Announcements
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                        <i class="fa-regular fa-users text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Recipients</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['total_recipients']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                        <i class="fa-regular fa-eye text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Read Count</p>
                        <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['read_count']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i class="fa-regular fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Read Rate</p>
                        <p class="text-2xl font-semibold text-gray-800">
                            {{ $stats['total_recipients'] > 0 ? round(($stats['read_count'] / $stats['total_recipients']) * 100) : 0 }}%
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcement Details -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-lg {{ $announcement->icon_bg }} flex items-center justify-center">
                            <i class="{{ $announcement->icon }} {{ $announcement->icon_color }} text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $announcement->title }}</h2>
                            <div class="flex items-center mt-1 space-x-4 text-sm">
                                <span class="text-gray-500">
                                    <i class="fa-regular fa-user mr-1"></i>
                                    By {{ $announcement->creator->name ?? 'System' }}
                                </span>
                                <span class="text-gray-500">
                                    <i class="fa-regular fa-calendar mr-1"></i>
                                    Created {{ $announcement->created_at->format('M d, Y \a\t g:i A') }}
                                </span>
                                @if($announcement->sent_at)
                                    <span class="text-green-600">
                                        <i class="fa-regular fa-circle-check mr-1"></i>
                                        Sent {{ $announcement->sent_at->format('M d, Y \a\t g:i A') }}
                                    </span>
                                @elseif($announcement->scheduled_at)
                                    <span class="text-orange-600">
                                        <i class="fa-regular fa-clock mr-1"></i>
                                        Scheduled for {{ $announcement->scheduled_at->format('M d, Y \a\t g:i A') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">
                                        <i class="fa-regular fa-pen-to-square mr-1"></i>
                                        Draft
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-sm rounded-full 
                        @if($announcement->type == 'success') bg-green-100 text-green-700
                        @elseif($announcement->type == 'warning') bg-yellow-100 text-yellow-700
                        @elseif($announcement->type == 'danger') bg-red-100 text-red-700
                        @else bg-purple-100 text-purple-700
                        @endif">
                        {{ ucfirst($announcement->type) }}
                    </span>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Message -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Message</h3>
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-gray-800 whitespace-pre-line">{{ $announcement->message }}</p>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Target Audience</h4>
                        <div class="space-y-1">
                            @if(empty($announcement->target_roles))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    All Users
                                </span>
                            @else
                                @foreach($announcement->target_roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mr-1">
                                        {{ ucfirst($role) }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    @if($announcement->action_text && $announcement->action_url)
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Action Button</h4>
                        <a href="{{ $announcement->action_url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#86662c] text-white rounded-lg hover:bg-[#6b4f23] transition-colors text-sm">
                            <i class="fa-regular fa-arrow-up-right-from-square mr-2"></i>
                            {{ $announcement->action_text }}
                        </a>
                    </div>
                    @endif

                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Created By</h4>
                        <p class="text-sm text-gray-800">
                            {{ $announcement->creator->name ?? 'System' }}
                            <span class="text-gray-500 text-xs block">{{ $announcement->creator->email ?? '' }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Notifications Preview (if sent) -->
        @if($announcement->sent_at)
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Recent Notifications</h3>
            </div>
            <div class="p-6">
                <p class="text-gray-500 text-center py-8">
                    <i class="fa-regular fa-bell text-4xl mb-3 text-gray-300"></i><br>
                    Notification delivery log coming soon...
                </p>
            </div>
        </div>
        @endif
    </div>
@endsection