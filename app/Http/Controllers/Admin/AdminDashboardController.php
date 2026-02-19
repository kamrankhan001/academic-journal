<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journal;
use App\Models\Tag;
use App\Models\Country;
use App\Models\Volume;
use App\Models\Issue;
use App\Models\Reviewer;
use App\Models\JournalReviewAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            
            // New stats
            'total_volumes' => Volume::count(),
            'published_volumes' => Volume::where('status', 'published')->count(),
            'total_issues' => Issue::count(),
            'published_issues' => Issue::where('status', 'published')->count(),
            'total_reviewer_profiles' => Reviewer::count(),
            'active_reviewers' => Reviewer::where('status', 'active')->count(),
            'pending_reviewers' => Reviewer::where('status', 'pending')->count(),
            'total_assignments' => JournalReviewAssignment::count(),
            'pending_assignments' => JournalReviewAssignment::where('status', 'pending')->count(),
            'completed_assignments' => JournalReviewAssignment::where('status', 'completed')->count(),
            'overdue_assignments' => JournalReviewAssignment::whereIn('status', ['accepted', 'in_progress'])
                ->where('due_date', '<', now())
                ->count(),
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

        // Get recent volumes
        $recentVolumes = Volume::latest()
            ->limit(5)
            ->get();

        // Get recent issues
        $recentIssues = Issue::with('volume')
            ->latest()
            ->limit(5)
            ->get();

        // Get recent assignments
        $recentAssignments = JournalReviewAssignment::with(['journal', 'reviewer.user'])
            ->latest()
            ->limit(5)
            ->get();

        // Get journals by status for chart
        $journalsByStatus = [
            'Published' => Journal::where('status', 'published')->count(),
            'Pending' => Journal::where('status', 'submitted')->count(),
            'Under Review' => Journal::where('status', 'under_review')->count(),
            'Revision Required' => Journal::where('status', 'revision_required')->count(),
            'Rejected' => Journal::where('status', 'rejected')->count(),
        ];

        // Get assignments by status for chart
        $assignmentsByStatus = [
            'Pending' => JournalReviewAssignment::where('status', 'pending')->count(),
            'In Progress' => JournalReviewAssignment::whereIn('status', ['accepted', 'in_progress'])->count(),
            'Completed' => JournalReviewAssignment::where('status', 'completed')->count(),
            'Declined' => JournalReviewAssignment::where('status', 'declined')->count(),
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

        // Get top reviewers by assignment count
        $topReviewers = Reviewer::with('user')
            ->withCount('reviewAssignments')
            ->having('review_assignments_count', '>', 0)
            ->orderBy('review_assignments_count', 'desc')
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
            'recentVolumes',
            'recentIssues',
            'recentAssignments',
            'journalsByStatus',
            'assignmentsByStatus',
            'months',
            'journalsByMonth',
            'topAuthors',
            'topReviewers',
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
            ->limit(3)
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

        // Recent volume creations
        $volumeActivities = Volume::latest()
            ->limit(2)
            ->get()
            ->map(function ($volume) {
                return (object)[
                    'type' => 'volume',
                    'action' => 'created volume',
                    'subject' => $volume->title,
                    'user' => 'System',
                    'user_id' => null,
                    'time' => $volume->created_at,
                    'icon' => 'fa-solid fa-book-open',
                    'color' => 'amber',
                    'link' => route('admin.volumes.show', $volume->id),
                ];
            });

        // Recent issue creations
        $issueActivities = Issue::with('volume')
            ->latest()
            ->limit(2)
            ->get()
            ->map(function ($issue) {
                return (object)[
                    'type' => 'issue',
                    'action' => 'created issue',
                    'subject' => $issue->title,
                    'user' => 'System',
                    'user_id' => null,
                    'time' => $issue->created_at,
                    'icon' => 'fa-solid fa-newspaper',
                    'color' => 'green',
                    'link' => route('admin.issues.show', $issue->id),
                ];
            });

        // Recent reviewer registrations
        $reviewerActivities = Reviewer::with('user')
            ->latest()
            ->limit(2)
            ->get()
            ->map(function ($reviewer) {
                return (object)[
                    'type' => 'reviewer',
                    'action' => 'registered as reviewer',
                    'subject' => $reviewer->user->name,
                    'user' => $reviewer->user->name,
                    'user_id' => $reviewer->user->id,
                    'time' => $reviewer->created_at,
                    'icon' => 'fa-regular fa-user-doctor',
                    'color' => 'purple',
                    'link' => route('admin.reviewers.show', $reviewer->id),
                ];
            });

        // Recent assignments
        $assignmentActivities = JournalReviewAssignment::with(['journal', 'reviewer.user'])
            ->latest()
            ->limit(3)
            ->get()
            ->map(function ($assignment) {
                return (object)[
                    'type' => 'assignment',
                    'action' => 'assigned reviewer',
                    'subject' => $assignment->reviewer->user->name . ' to ' . Str::limit($assignment->journal->title, 30),
                    'user' => 'Admin',
                    'user_id' => null,
                    'time' => $assignment->created_at,
                    'icon' => 'fa-regular fa-file-lines',
                    'color' => 'indigo',
                    'link' => route('admin.assignments.show', $assignment->id),
                ];
            });

        // Recent user registrations
        $userActivities = User::latest()
            ->limit(2)
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

        // Merge and sort by time
        $activities = $journalActivities
            ->concat($volumeActivities)
            ->concat($issueActivities)
            ->concat($reviewerActivities)
            ->concat($assignmentActivities)
            ->concat($userActivities)
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

        if ($type === 'assignments') {
            $data = [];
            $months = [];
            
            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $months[] = $month->format('M Y');
                
                $count = JournalReviewAssignment::whereYear('created_at', $month->year)
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
            'total_volumes' => Volume::count(),
            'total_issues' => Issue::count(),
            'active_reviewers' => Reviewer::where('status', 'active')->count(),
            'pending_assignments' => JournalReviewAssignment::where('status', 'pending')->count(),
            'recent_users' => User::whereDate('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'recent_journals' => Journal::whereDate('created_at', '>=', Carbon::now()->subDays(7))->count(),
        ];

        return response()->json($stats);
    }
}