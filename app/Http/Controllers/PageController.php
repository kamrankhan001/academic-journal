<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Volume;
use App\Models\Issue;
use App\Models\User;
use App\Models\Reviewer;
use App\Models\Tag;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PageController extends Controller
{
    /**
     * Show the home page
     */
    public function home()
    {
        // Get latest published journals
        $latestJournals = Journal::with(['author', 'tags', 'coAuthors'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        // Get recent issues with their volumes
        $recentIssues = Issue::with('volume')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        // Get statistics
        $stats = [
            'articles' => Journal::where('status', 'published')->count(),
            'authors' => User::where('role', 'author')->count(),
            'reviewers' => Reviewer::where('status', 'active')->count(),
            'countries' => 50, // You can make this dynamic if you have a countries table
        ];

        return view('home', compact('latestJournals', 'recentIssues', 'stats'));
    }

    /**
     * Display a listing of all published issues.
     */
    public function issues(Request $request)
    {
        $query = Issue::with('volume')
            ->where('status', 'published');

        // Filter by volume
        if ($request->filled('volume')) {
            $query->whereHas('volume', function($q) use ($request) {
                $q->where('volume_number', $request->volume);
            });
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->whereYear('publication_date', $request->year);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $issues = $query->orderBy('publication_date', 'desc')
            ->paginate(12);

        // Get all volumes for filter
        $volumes = Volume::where('status', 'published')
            ->orderBy('volume_number', 'desc')
            ->get(['id', 'volume_number', 'title', 'year']);

        // Get archive years
        $years = Issue::where('status', 'published')
            ->whereNotNull('publication_date')
            ->selectRaw('YEAR(publication_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Get recent issues for sidebar
        $recentIssues = Issue::with('volume')
            ->where('status', 'published')
            ->latest('publication_date')
            ->take(5)
            ->get();

        return view('pages.issues', compact('issues', 'volumes', 'years', 'recentIssues'));
    }

    /**
     * Display the specified issue.
     */
    public function issueShow($id)
    {
        $issue = Issue::with(['volume', 'journals' => function($query) {
                $query->where('status', 'published')
                      ->with(['author', 'tags', 'coAuthors']);
            }])
            ->where('status', 'published')
            ->findOrFail($id);

        // Get other issues from same volume
        $otherIssues = Issue::with('volume')
            ->where('volume_id', $issue->volume_id)
            ->where('id', '!=', $issue->id)
            ->where('status', 'published')
            ->orderBy('issue_number')
            ->take(5)
            ->get();

        // Get recent issues for sidebar
        $recentIssues = Issue::with('volume')
            ->where('status', 'published')
            ->where('id', '!=', $issue->id)
            ->latest('publication_date')
            ->take(5)
            ->get();

        return view('pages.issue-show', compact('issue', 'otherIssues', 'recentIssues'));
    }

    /**
     * Show the about page
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Show the contact page
     */
    public function contact()
    {
        return view('pages.contact');
    }

    public function guidelines()
    {
        return view('pages.guidelines');
    }

    public function currentIssue()
    {
        // Get the most recent published issue
        $currentIssue = Issue::with(['volume', 'journals' => function($query) {
                $query->where('status', 'published')
                      ->with(['author', 'tags']);
            }])
            ->where('status', 'published')
            ->latest('publication_date')
            ->first();

        if (!$currentIssue) {
            return redirect()->route('issues')
                ->with('info', 'No current issue available.');
        }

        return view('pages.current-issue', compact('currentIssue'));
    }

    public function announcements()
    {
        return view('pages.announcements');
    }

    public function editorialTeam()
    {
        return view('pages.editorial-team');
    }

    public function editorialPolicy()
    {
        return view('pages.editorial-policies');
    }

    public function journalPolicies()
    {
        return view('pages.journal-policies');
    }

    public function reviewers()
    {
        return view('pages.reviewers');
    }

    /**
     * Show the privacy policy page
     */
    public function privacy()
    {
        return view('pages.privacy');
    }

    /**
     * Show the terms of service page
     */
    public function terms()
    {
        return view('pages.terms');
    }

    /**
     * Show the cookies policy page
     */
    public function cookies()
    {
        return view('pages.cookies');
    }

    /**
     * Handle contact form submission (optional)
     */
    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|in:general,submission,editorial,technical,partnership',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare email data
        $emailData = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

        // Send email to admin (you can set this in .env)
        $adminEmail = config('mail.admin_address', 'admin@academicjournal.edu');

        try {
            Mail::to($adminEmail)->send(new ContactMail($emailData));

            // Optional: Send auto-reply to user
            // Mail::to($request->email)->send(new ContactAutoReply($request->name));

            return back()->with('success', 'Thank you for your message! We\'ll get back to you soon.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Sorry, there was an error sending your message. Please try again later.')
                ->withInput();
        }
    }
}