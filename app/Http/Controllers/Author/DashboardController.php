<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the author dashboard with statistics and recent journals
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get journal statistics
        $totalJournals = Journal::where('user_id', $user->id)->count();
        $draftJournals = Journal::where('user_id', $user->id)->where('status', 'draft')->count();
        $submittedJournals = Journal::where('user_id', $user->id)->where('status', 'submitted')->count();
        $underReviewJournals = Journal::where('user_id', $user->id)->where('status', 'under_review')->count();
        $acceptedJournals = Journal::where('user_id', $user->id)->where('status', 'accepted')->count();
        $rejectedJournals = Journal::where('user_id', $user->id)->where('status', 'rejected')->count();
        $publishedJournals = Journal::where('user_id', $user->id)->where('status', 'published')->count();
        
        // Get total views across all journals
        $totalViews = Journal::where('user_id', $user->id)->sum('views_count');
        
        // Get recent journals
        $recentJournals = Journal::where('user_id', $user->id)
            ->with(['coAuthors', 'tags'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get journals by month for chart
        $journalsByMonth = Journal::where('user_id', $user->id)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();
        
        return view('dashboard.index', compact(
            'user',
            'totalJournals',
            'draftJournals',
            'submittedJournals',
            'underReviewJournals',
            'acceptedJournals',
            'rejectedJournals',
            'publishedJournals',
            'totalViews',
            'recentJournals',
            'journalsByMonth'
        ));
    }
}