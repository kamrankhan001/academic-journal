@extends('layouts.admin')

@section('title', 'Dashboard - Admin')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="flex items-center text-gray-800">Dashboard</li>
@endsection

@section('content')
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_users'] }}</p>
                    <p class="text-xs text-green-600 mt-2">
                        <i class="fa-solid fa-arrow-up mr-1"></i>
                        {{ $stats['recent_users'] ?? 0 }} new this week
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-xs">
                <span class="text-gray-500">Authors: {{ $stats['total_authors'] }}</span>
                <span class="text-gray-500">Reviewers: {{ $stats['total_reviewers'] }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Journals</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_journals'] }}</p>
                    <p class="text-xs text-green-600 mt-2">
                        <i class="fa-solid fa-arrow-up mr-1"></i>
                        {{ $stats['recent_journals'] ?? 0 }} new this week
                    </p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-file-lines text-amber-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-xs">
                <span class="text-gray-500">Published: {{ $stats['published_journals'] }}</span>
                <span class="text-gray-500">Pending: {{ $stats['pending_journals'] }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Under Review</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['under_review_journals'] }}</p>
                    <p class="text-xs text-amber-600 mt-2">
                        <i class="fa-regular fa-clock mr-1"></i>
                        Awaiting review
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-eye text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-xs">
                <span class="text-gray-500">Revision: {{ $stats['revision_required_journals'] }}</span>
                <span class="text-gray-500">Rejected: {{ $stats['rejected_journals'] }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Tags & Countries</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_tags'] }}</p>
                    <p class="text-xs text-gray-600 mt-2">
                        <i class="fa-regular fa-flag mr-1"></i>
                        {{ $stats['total_countries'] }} countries
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-tags text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-xs">
                <span class="text-gray-500">Active tags</span>
                <span class="text-gray-500">Global reach</span>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Journals by Month Chart -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Journals Overview</h3>
                <div class="flex space-x-2">
                    <button class="chart-period-btn active px-3 py-1 text-xs rounded-lg bg-amber-100 text-amber-700" data-period="6m">6 Months</button>
                    <button class="chart-period-btn px-3 py-1 text-xs rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200" data-period="12m">12 Months</button>
                </div>
            </div>
            <div class="h-80 relative">
                <canvas id="journalsChart"></canvas>
            </div>
        </div>

        <!-- Journals by Status Chart -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Journals by Status</h3>
            <div class="h-80 relative">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Top Authors -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Authors</h3>
            <div class="space-y-4">
                @forelse($topAuthors as $author)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center">
                                @if($author->profile && $author->profile->avatar)
                                    <img src="{{ asset('storage/' . $author->profile->avatar) }}" 
                                         alt="{{ $author->name }}"
                                         class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <span class="text-amber-700 text-xs font-bold">
                                        {{ strtoupper(substr($author->name, 0, 2)) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ Str::limit($author->name, 20) }}</p>
                                <p class="text-xs text-gray-500">{{ $author->journals_count }} journals</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.show', $author->id) }}" 
                           class="text-amber-600 hover:text-amber-700 text-xs">
                            View
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No authors yet</p>
                @endforelse
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.users.index', ['role' => 'author']) }}" 
                   class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                    View All Authors <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Popular Tags -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Popular Tags</h3>
            <div class="space-y-3">
                @forelse($popularTags as $tag)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-tag text-amber-500 text-xs"></i>
                            <span class="text-sm text-gray-700">{{ $tag->name }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                {{ $tag->journals_count }} journals
                            </span>
                            <a href="{{ route('admin.tags.show', $tag->id) }}" 
                               class="text-amber-600 hover:text-amber-700 text-xs">
                                View
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No tags yet</p>
                @endforelse
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.tags.index') }}" 
                   class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                    Manage Tags <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Users</h3>
            <div class="space-y-4">
                @forelse($recentUsers as $user)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center">
                                @if($user->profile && $user->profile->avatar)
                                    <img src="{{ asset('storage/' . $user->profile->avatar) }}" 
                                         alt="{{ $user->name }}"
                                         class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <span class="text-amber-700 text-xs font-bold">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ Str::limit($user->name, 20) }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst($user->role) }} • {{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.show', $user->id) }}" 
                           class="text-amber-600 hover:text-amber-700 text-xs">
                            View
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No users yet</p>
                @endforelse
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" 
                   class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                    View All Users <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Journals and Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Journals -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Recent Journals</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentJournals as $journal)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <a href="{{ route('admin.journals.show', $journal->id) }}" 
                                   class="text-sm font-medium text-gray-800 hover:text-amber-700">
                                    {{ Str::limit($journal->title, 60) }}
                                </a>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs text-gray-500">
                                        By {{ $journal->author->name }}
                                    </span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">
                                        {{ $journal->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                @if($journal->tags->count() > 0)
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach($journal->tags->take(3) as $tag)
                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                        @if($journal->tags->count() > 3)
                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full">
                                                +{{ $journal->tags->count() - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                @php
                                    $statusColors = [
                                        'draft' => 'bg-gray-100 text-gray-700',
                                        'submitted' => 'bg-yellow-100 text-yellow-700',
                                        'under_review' => 'bg-purple-100 text-purple-700',
                                        'published' => 'bg-green-100 text-green-700',
                                        'revision_required' => 'bg-orange-100 text-orange-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusColor = $statusColors[$journal->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full {{ $statusColor }}">
                                    {{ str_replace('_', ' ', ucfirst($journal->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <i class="fa-regular fa-file-lines text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No journals yet</p>
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <a href="{{ route('admin.journals.index') }}" 
                   class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                    View All Journals <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">Recent Activities</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentActivities as $activity)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start space-x-3">
                            <div class="shrink-0">
                                <div class="w-8 h-8 rounded-full bg-{{ $activity->color }}-100 flex items-center justify-center">
                                    <i class="{{ $activity->icon }} text-{{ $activity->color }}-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">{{ $activity->user }}</span>
                                    {{ $activity->action }}
                                    <span class="font-medium">{{ Str::limit($activity->subject, 30) }}</span>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">{{ $activity->time->diffForHumans() }}</p>
                            </div>
                            @if($activity->link)
                                <a href="{{ $activity->link }}" class="text-amber-600 hover:text-amber-700 text-xs">
                                    View
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <i class="fa-regular fa-clock text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No recent activities</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('styles')
<!-- Chart.js CSS -->
<style>
    .chart-period-btn.active {
        background-color: #86662c;
        color: white;
    }
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Journals by Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($journalsByStatus)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($journalsByStatus)) !!},
                    backgroundColor: [
                        '#10b981', // published - green
                        '#f59e0b', // pending - amber
                        '#8b5cf6', // under review - purple
                        '#f97316', // revision - orange
                        '#ef4444', // rejected - red
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                cutout: '70%',
            }
        });

        // Journals by Month Chart
        const journalsCtx = document.getElementById('journalsChart').getContext('2d');
        let journalsChart = new Chart(journalsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Journals Submitted',
                    data: {!! json_encode($journalsByMonth) !!},
                    borderColor: '#86662c',
                    backgroundColor: 'rgba(134, 102, 44, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#86662c',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Chart period buttons
        document.querySelectorAll('.chart-period-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const period = this.dataset.period;
                
                // Update active state
                document.querySelectorAll('.chart-period-btn').forEach(b => {
                    b.classList.remove('active', 'bg-amber-100', 'text-amber-700');
                    b.classList.add('bg-gray-100', 'text-gray-600');
                });
                this.classList.remove('bg-gray-100', 'text-gray-600');
                this.classList.add('active', 'bg-amber-100', 'text-amber-700');
                
                // Fetch new data
                fetch(`{{ route('admin.chart-data') }}?type=journals&period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        journalsChart.data.labels = data.labels;
                        journalsChart.data.datasets[0].data = data.data;
                        journalsChart.update();
                    });
            });
        });

        // Auto-refresh quick stats every 5 minutes
        setInterval(function() {
            fetch('{{ route("admin.quick-stats") }}')
                .then(response => response.json())
                .then(data => {
                    // Update stats if needed
                    console.log('Stats refreshed:', data);
                });
        }, 300000); // 5 minutes
    });
</script>
@endpush