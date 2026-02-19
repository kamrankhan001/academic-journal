<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Reviewer;
use App\Models\JournalReviewAssignment;
use App\Notifications\ReviewerAssignmentNotification;
use App\Notifications\ReviewerReminderNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class ReviewAssignmentController extends Controller
{
    /**
     * Display a listing of all review assignments.
     */
    public function index(Request $request)
    {
        $query = JournalReviewAssignment::with(['journal', 'reviewer.user', 'assigner']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('journal', function ($journalQuery) use ($search) {
                    $journalQuery->where('title', 'like', "%{$search}%");
                })
                    ->orWhereHas('reviewer.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by reviewer
        if ($request->filled('reviewer_id')) {
            $query->where('reviewer_id', $request->reviewer_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Get statistics
        $stats = [
            'total' => JournalReviewAssignment::count(),
            'pending' => JournalReviewAssignment::where('status', 'pending')->count(),
            'accepted' => JournalReviewAssignment::whereIn('status', ['accepted', 'in_progress'])->count(),
            'completed' => JournalReviewAssignment::where('status', 'completed')->count(),
            'declined' => JournalReviewAssignment::where('status', 'declined')->count(),
            'overdue' => JournalReviewAssignment::whereIn('status', ['accepted', 'in_progress'])
                ->where('due_date', '<', now())
                ->count(),
        ];

        // Get reviewers for filter
        $reviewers = Reviewer::with('user')->where('status', 'active')->get();

        $assignments = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.assignments.index', compact('assignments', 'stats', 'reviewers'));
    }

    /**
     * Show form for assigning reviewers to a journal.
     */
    public function create(Journal $journal)
    {
        // Get active reviewers
        $reviewers = Reviewer::with('user')
            ->where('status', 'active')
            ->get()
            ->map(function ($reviewer) use ($journal) {
                // Check if already assigned to this journal
                $reviewer->already_assigned = JournalReviewAssignment::where('journal_id', $journal->id)
                    ->where('reviewer_id', $reviewer->id)
                    ->exists();

                // Get pending assignments count
                $reviewer->pending_count = $reviewer->reviewAssignments()
                    ->whereIn('status', ['pending', 'accepted', 'in_progress'])
                    ->count();

                return $reviewer;
            });

        // Get existing assignments for this journal
        $existingAssignments = JournalReviewAssignment::where('journal_id', $journal->id)
            ->with('reviewer.user')
            ->get();

        return view('admin.assignments.create', compact('journal', 'reviewers', 'existingAssignments'));
    }

    /**
     * Store new review assignments.
     */
    public function store(Request $request, Journal $journal)
    {
        $request->validate([
            'reviewer_ids' => 'required|array|min:1',
            'reviewer_ids.*' => 'exists:reviewers,id',
            'due_days' => 'required|integer|min:3|max:30',
            'message' => 'nullable|string|max:1000',
        ]);

        $assignedBy = auth()->id();
        $dueDate = now()->addDays(intval($request->due_days));
        $assignments = [];

        foreach ($request->reviewer_ids as $reviewerId) {
            // Check if already assigned
            $exists = JournalReviewAssignment::where('journal_id', $journal->id)
                ->where('reviewer_id', $reviewerId)
                ->exists();

            if (!$exists) {
                $assignment = JournalReviewAssignment::create([
                    'journal_id' => $journal->id,
                    'reviewer_id' => $reviewerId,
                    'assigned_by' => $assignedBy,
                    'assigned_at' => now(),
                    'due_date' => $dueDate,
                    'status' => 'pending',
                    'notes' => $request->message,
                ]);

                $assignments[] = $assignment;

                // Send email notification to reviewer
                 $assignment->reviewer->user->notify(new ReviewerAssignmentNotification($assignment));
            }
        }

        // Update journal status if needed
        if ($journal->status === 'submitted') {
            $journal->update(['status' => 'under_review']);
        }

        return redirect()->route('admin.assignments.index')
            ->with('success', count($assignments) . ' reviewer(s) assigned successfully.');
    }

    /**
     * Display the specified assignment.
     */
    public function show(JournalReviewAssignment $assignment)
    {
        $assignment->load(['journal', 'journal.author', 'reviewer.user', 'assigner']);

        return view('admin.assignments.show', compact('assignment'));
    }

    /**
     * Send reminder to reviewer.
     */
    public function sendReminder(JournalReviewAssignment $assignment)
    {
        if (!in_array($assignment->status, ['accepted', 'in_progress'])) {
            return redirect()->back()
                ->with('error', 'Cannot send reminder for this assignment.');
        }

        // Update reminder timestamp
        $assignment->update(['reminder_sent_at' => now()]);

        // Send reminder email
         $assignment->reviewer->user->notify(new ReviewerReminderNotification($assignment));

        return redirect()->back()
            ->with('success', 'Reminder sent successfully to ' . $assignment->reviewer->user->name);
    }

    /**
     * Remove the specified assignment.
     */
    public function destroy(JournalReviewAssignment $assignment)
    {
        if ($assignment->status === 'completed') {
            return redirect()->back()
                ->with('error', 'Cannot delete completed assignments.');
        }

        $assignment->delete();

        return redirect()->route('admin.assignments.index')
            ->with('success', 'Assignment deleted successfully.');
    }

}