<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JournalReviewAssignment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ReviewController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of all review assignments for the reviewer.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $reviewer = $user->reviewerProfile;
        
        if (!$reviewer) {
            return redirect()->route('reviewer.profile.create')
                ->with('info', 'Please complete your reviewer profile first.');
        }

        $filter = $request->get('filter', 'all');
        
        // Base query
        $query = JournalReviewAssignment::where('reviewer_id', $reviewer->id)
            ->with('journal');
        
        // Apply filters
        switch ($filter) {
            case 'pending':
                $query->where('status', 'pending');
                break;
            case 'accepted':
                $query->whereIn('status', ['accepted', 'in_progress']);
                break;
            case 'completed':
                $query->where('status', 'completed');
                break;
            case 'overdue':
                $query->whereIn('status', ['accepted', 'in_progress'])
                    ->where('due_date', '<', now());
                break;
            default:
                // All assignments
                break;
        }
        
        $assignments = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get counts for stats
        $stats = [
            'pending' => JournalReviewAssignment::where('reviewer_id', $reviewer->id)
                ->where('status', 'pending')->count(),
            'accepted' => JournalReviewAssignment::where('reviewer_id', $reviewer->id)
                ->whereIn('status', ['accepted', 'in_progress'])->count(),
            'completed' => JournalReviewAssignment::where('reviewer_id', $reviewer->id)
                ->where('status', 'completed')->count(),
            'overdue' => JournalReviewAssignment::where('reviewer_id', $reviewer->id)
                ->whereIn('status', ['accepted', 'in_progress'])
                ->where('due_date', '<', now())->count(),
        ];
        
        // Set breadcrumbs
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('reviewer.dashboard')],
            ['name' => 'My Reviews', 'url' => null]
        ];
        
        return view('reviewer.assignments.index', compact('assignments', 'filter', 'stats', 'breadcrumbs'));
    }

    /**
     * Display the specified review assignment.
     */
    public function show(JournalReviewAssignment $assignment)
    {
        $this->authorize('view', $assignment);
        
        $assignment->load('journal', 'journal.author', 'journal.files');
        
        // Set breadcrumbs
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('reviewer.dashboard')],
            ['name' => 'My Reviews', 'url' => route('reviewer.assignments.index')],
            ['name' => 'Review Details', 'url' => null]
        ];
        
        return view('reviewer.assignments.show', compact('assignment', 'breadcrumbs'));
    }

    /**
     * Accept a review assignment.
     */
    public function accept(JournalReviewAssignment $assignment)
    {
        $this->authorize('update', $assignment);
        
        if ($assignment->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This invitation is no longer pending.');
        }
        
        $assignment->accept(now()->addDays(14)); // Due in 14 days
        
        // TODO: Send notification to admin
        
        return redirect()->route('reviewer.assignments.index')
            ->with('success', 'Review invitation accepted. Please complete your review by ' . 
                $assignment->due_date->format('M d, Y'));
    }

    /**
     * Decline a review assignment.
     */
    public function decline(Request $request, JournalReviewAssignment $assignment)
    {
        $this->authorize('update', $assignment);
        
        $request->validate([
            'decline_reason' => 'nullable|string|max:500'
        ]);
        
        if ($assignment->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This invitation is no longer pending.');
        }
        
        $assignment->decline($request->decline_reason);
        
        // TODO: Send notification to admin
        
        return redirect()->route('reviewer.assignments.index')
            ->with('success', 'Review invitation declined.');
    }

    /**
     * Show the review form.
     */
    public function review(JournalReviewAssignment $assignment)
    {
        $this->authorize('review', $assignment);
        
        if (!in_array($assignment->status, ['accepted', 'in_progress'])) {
            return redirect()->route('reviewer.assignments.show', $assignment)
                ->with('error', 'You cannot review this assignment at this time.');
        }
        
        $assignment->load('journal', 'journal.files');
        
        // Update status to in_progress if it's accepted
        if ($assignment->status === 'accepted') {
            $assignment->update(['status' => 'in_progress']);
        }
        
        // Set breadcrumbs
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('reviewer.dashboard')],
            ['name' => 'My Reviews', 'url' => route('reviewer.assignments.index')],
            ['name' => 'Submit Review', 'url' => null]
        ];
        
        return view('reviewer.assignments.review', compact('assignment', 'breadcrumbs'));
    }

    /**
     * Submit the review.
     */
    public function submit(Request $request, JournalReviewAssignment $assignment)
    {
        $this->authorize('review', $assignment);
        
        $request->validate([
            'comments_to_editor' => 'nullable|string|max:5000',
            'comments_to_author' => 'required|string|max:5000',
            'recommendation' => 'required|in:accept,minor_revisions,major_revisions,reject,resubmit',
            'originality_score' => 'required|integer|min:1|max:5',
            'methodology_score' => 'required|integer|min:1|max:5',
            'presentation_score' => 'required|integer|min:1|max:5',
            'overall_score' => 'required|integer|min:1|max:5',
        ]);
        
        $assignment->complete([
            'comments_to_editor' => $request->comments_to_editor,
            'comments_to_author' => $request->comments_to_author,
            'recommendation' => $request->recommendation,
            'originality_score' => $request->originality_score,
            'methodology_score' => $request->methodology_score,
            'presentation_score' => $request->presentation_score,
            'overall_score' => $request->overall_score,
        ]);
        
        // TODO: Send notification to admin
        
        return redirect()->route('reviewer.assignments.index')
            ->with('success', 'Review submitted successfully. Thank you for your contribution!');
    }
}