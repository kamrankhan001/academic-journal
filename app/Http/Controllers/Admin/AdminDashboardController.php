<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journal;
use App\Models\Tag;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'total_authors' => User::where('role', 'author')->count(),
            'total_reviewers' => User::where('role', 'reviewer')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_journals' => Journal::count(),
            'published_journals' => Journal::where('status', 'published')->count(),
            'pending_journals' => Journal::where('status', 'submitted')->count(),
            'under_review_journals' => Journal::where('status', 'under_review')->count(),
            'revision_required_journals' => Journal::where('status', 'revision_required')->count(),
            'rejected_journals' => Journal::where('status', 'rejected')->count(),
            'total_tags' => Tag::count(),
            'total_countries' => Country::count(),
        ];

        // Get recent users (last 7 days)
        $recentUsers = User::with('profile')
            ->latest()
            ->limit(7)
            ->get();

        // Get recent journals
        $recentJournals = Journal::with(['author', 'tags'])
            ->latest()
            ->limit(7)
            ->get();

        // Get journals by status for chart
        $journalsByStatus = [
            'Published' => Journal::where('status', 'published')->count(),
            'Pending' => Journal::where('status', 'submitted')->count(),
            'Under Review' => Journal::where('status', 'under_review')->count(),
            'Revision Required' => Journal::where('status', 'revision_required')->count(),
            'Rejected' => Journal::where('status', 'rejected')->count(),
        ];

        // Get journals by month for the last 6 months
        $journalsByMonth = [];
        $months = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->format('M Y');
            $months[] = $monthName;
            
            $count = Journal::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $journalsByMonth[] = $count;
        }

        // Get top authors by journal count
        $topAuthors = User::where('role', 'author')
            ->withCount('journals')
            ->having('journals_count', '>', 0)
            ->orderBy('journals_count', 'desc')
            ->limit(5)
            ->get();

        // Get popular tags
        $popularTags = Tag::withCount('journals')
            ->having('journals_count', '>', 0)
            ->orderBy('journals_count', 'desc')
            ->limit(10)
            ->get();

        // Get user registration trend (last 7 days)
        $userRegistrations = [];
        $registrationDates = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $registrationDates[] = $date->format('D');
            
            $count = User::whereDate('created_at', $date->toDateString())->count();
            $userRegistrations[] = $count;
        }

        // Get recent activities (combined)
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentJournals',
            'journalsByStatus',
            'months',
            'journalsByMonth',
            'topAuthors',
            'popularTags',
            'userRegistrations',
            'registrationDates',
            'recentActivities'
        ));
    }

    /**
     * Get recent activities from different models
     */
    private function getRecentActivities($limit = 10)
    {
        $activities = collect();

        // Recent journal submissions
        $journalActivities = Journal::with('author')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($journal) {
                return (object)[
                    'type' => 'journal',
                    'action' => 'submitted',
                    'subject' => $journal->title,
                    'user' => $journal->author->name,
                    'user_id' => $journal->author->id,
                    'time' => $journal->created_at,
                    'icon' => 'fa-regular fa-file-lines',
                    'color' => 'blue',
                    'link' => route('admin.journals.show', $journal->id),
                ];
            });

        // Recent user registrations
        $userActivities = User::latest()
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return (object)[
                    'type' => 'user',
                    'action' => 'registered',
                    'subject' => $user->name,
                    'user' => $user->name,
                    'user_id' => $user->id,
                    'time' => $user->created_at,
                    'icon' => 'fa-regular fa-user',
                    'color' => 'green',
                    'link' => route('admin.users.show', $user->id),
                ];
            });

        // Recent tag creations
        $tagActivities = Tag::latest()
            ->limit(3)
            ->get()
            ->map(function ($tag) {
                return (object)[
                    'type' => 'tag',
                    'action' => 'created',
                    'subject' => $tag->name,
                    'user' => 'System',
                    'user_id' => null,
                    'time' => $tag->created_at,
                    'icon' => 'fa-solid fa-tag',
                    'color' => 'purple',
                    'link' => route('admin.tags.show', $tag->id),
                ];
            });

        // Merge and sort by time
        $activities = $journalActivities
            ->concat($userActivities)
            ->concat($tagActivities)
            ->sortByDesc('time')
            ->take($limit);

        return $activities;
    }

    /**
     * Get chart data for AJAX requests
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'journals');

        if ($type === 'journals') {
            $data = [];
            $months = [];
            
            for ($i = 11; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $months[] = $month->format('M Y');
                
                $count = Journal::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
                
                $data[] = $count;
            }

            return response()->json([
                'labels' => $months,
                'data' => $data,
            ]);
        }

        if ($type === 'users') {
            $data = [];
            $days = [];
            
            for ($i = 13; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $days[] = $date->format('M d');
                
                $count = User::whereDate('created_at', $date->toDateString())->count();
                $data[] = $count;
            }

            return response()->json([
                'labels' => $days,
                'data' => $data,
            ]);
        }

        return response()->json(['error' => 'Invalid type'], 400);
    }

    /**
     * Get quick stats for dashboard refresh
     */
    public function getQuickStats()
    {
        $stats = [
            'total_users' => User::count(),
            'total_journals' => Journal::count(),
            'pending_journals' => Journal::where('status', 'submitted')->count(),
            'published_journals' => Journal::where('status', 'published')->count(),
            'recent_users' => User::whereDate('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'recent_journals' => Journal::whereDate('created_at', '>=', Carbon::now()->subDays(7))->count(),
        ];

        return response()->json($stats);
    }
}