<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reviewer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReviewerController extends Controller
{
    /**
     * Display a listing of reviewers.
     */
    public function index(Request $request)
    {
        $query = Reviewer::with('user');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('institution', 'like', "%{$search}%")
                ->orWhere('expertise_areas', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by expertise area
        if ($request->filled('expertise')) {
            $query->whereJsonContains('expertise_areas', $request->expertise);
        }

        // Get statistics
        $stats = [
            'total' => Reviewer::count(),
            'active' => Reviewer::where('status', 'active')->count(),
            'pending' => Reviewer::where('status', 'pending')->count(),
            'inactive' => Reviewer::where('status', 'inactive')->count(),
            'total_reviews' => Reviewer::sum('review_count'),
            'avg_rating' => Reviewer::whereNotNull('average_rating')->avg('average_rating'),
        ];

        // Get unique expertise areas for filter
        $expertiseOptions = [
            'General Surgery',
            'Cardiothoracic Surgery',
            'Neurosurgery',
            'Orthopedic Surgery',
            'Pediatric Surgery',
            'Plastic Surgery',
            'Vascular Surgery',
            'Surgical Oncology',
            'Trauma Surgery',
            'Transplant Surgery',
            'Anesthesiology',
            'Internal Medicine',
            'Cardiology',
            'Neurology',
            'Pediatrics',
            'Radiology',
            'Pathology',
            'Emergency Medicine',
            'Critical Care',
            'Clinical Research',
            'Medical Education',
            'Public Health'
        ];

        $reviewers = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.reviewers.index', compact('reviewers', 'stats', 'expertiseOptions'));
    }

    /**
     * Show form for creating a new reviewer.
     */
    public function create()
    {
        $expertiseOptions = [
            'General Surgery',
            'Cardiothoracic Surgery',
            'Neurosurgery',
            'Orthopedic Surgery',
            'Pediatric Surgery',
            'Plastic Surgery',
            'Vascular Surgery',
            'Surgical Oncology',
            'Trauma Surgery',
            'Transplant Surgery',
            'Anesthesiology',
            'Internal Medicine',
            'Cardiology',
            'Neurology',
            'Pediatrics',
            'Radiology',
            'Pathology',
            'Emergency Medicine',
            'Critical Care',
            'Clinical Research',
            'Medical Education',
            'Public Health'
        ];

        return view('admin.reviewers.create', compact('expertiseOptions'));
    }

    /**
     * Store a newly created reviewer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'institution' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'orcid_id' => 'nullable|string|max:20|regex:/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9X]$/',
            'bio' => 'nullable|string|max:2000',
            'expertise_areas' => 'required|array|min:1',
            'expertise_areas.*' => 'string',
            'academic_degree' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'status' => 'required|in:active,inactive,pending',
        ], [
            'orcid_id.regex' => 'Please enter a valid ORCID iD (e.g., 0000-0002-1825-0097)',
        ]);

        // Create user account
        $password = Str::random(10); // Generate random password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'reviewer',
            'email_verified_at' => now(), // Auto-verify if created by admin
        ]);

        // Create reviewer profile
        Reviewer::create([
            'user_id' => $user->id,
            'institution' => $request->institution,
            'department' => $request->department,
            'orcid_id' => $request->orcid_id,
            'bio' => $request->bio,
            'expertise_areas' => $request->expertise_areas,
            'academic_degree' => $request->academic_degree,
            'country' => $request->country,
            'status' => $request->status,
        ]);

        // TODO: Send email to reviewer with login credentials

        return redirect()->route('admin.reviewers.index')
            ->with('success', 'Reviewer created successfully. A welcome email has been sent with login credentials.');
    }

    /**
     * Display the specified reviewer.
     */
    public function show(Reviewer $reviewer)
    {
        $reviewer->load('user', 'reviewAssignments.journal');
        
        $stats = [
            'total_assignments' => $reviewer->reviewAssignments()->count(),
            'pending' => $reviewer->reviewAssignments()->where('status', 'pending')->count(),
            'accepted' => $reviewer->reviewAssignments()->whereIn('status', ['accepted', 'in_progress'])->count(),
            'completed' => $reviewer->reviewAssignments()->where('status', 'completed')->count(),
            'declined' => $reviewer->reviewAssignments()->where('status', 'declined')->count(),
            'avg_score' => $reviewer->reviewAssignments()
                ->where('status', 'completed')
                ->whereNotNull('overall_score')
                ->avg('overall_score'),
        ];

        $recentAssignments = $reviewer->reviewAssignments()
            ->with('journal')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reviewers.show', compact('reviewer', 'stats', 'recentAssignments'));
    }

    /**
     * Show form for editing reviewer.
     */
    public function edit(Reviewer $reviewer)
    {
        $reviewer->load('user');
        
        $expertiseOptions = [
            'General Surgery',
            'Cardiothoracic Surgery',
            'Neurosurgery',
            'Orthopedic Surgery',
            'Pediatric Surgery',
            'Plastic Surgery',
            'Vascular Surgery',
            'Surgical Oncology',
            'Trauma Surgery',
            'Transplant Surgery',
            'Anesthesiology',
            'Internal Medicine',
            'Cardiology',
            'Neurology',
            'Pediatrics',
            'Radiology',
            'Pathology',
            'Emergency Medicine',
            'Critical Care',
            'Clinical Research',
            'Medical Education',
            'Public Health'
        ];

        return view('admin.reviewers.edit', compact('reviewer', 'expertiseOptions'));
    }

    /**
     * Update the specified reviewer.
     */
    public function update(Request $request, Reviewer $reviewer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'orcid_id' => 'nullable|string|max:20|regex:/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9X]$/',
            'bio' => 'nullable|string|max:2000',
            'expertise_areas' => 'required|array|min:1',
            'expertise_areas.*' => 'string',
            'academic_degree' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'status' => 'required|in:active,inactive,pending',
        ]);

        // Update user name
        $reviewer->user->update([
            'name' => $request->name
        ]);

        // Update reviewer profile
        $reviewer->update([
            'institution' => $request->institution,
            'department' => $request->department,
            'orcid_id' => $request->orcid_id,
            'bio' => $request->bio,
            'expertise_areas' => $request->expertise_areas,
            'academic_degree' => $request->academic_degree,
            'country' => $request->country,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.reviewers.index')
            ->with('success', 'Reviewer updated successfully.');
    }

    /**
     * Toggle reviewer status.
     */
    public function toggleStatus(Reviewer $reviewer)
    {
        $newStatus = $reviewer->status === 'active' ? 'inactive' : 'active';
        $reviewer->update(['status' => $newStatus]);

        $message = $newStatus === 'active' 
            ? 'Reviewer activated successfully.' 
            : 'Reviewer deactivated successfully.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the specified reviewer.
     */
    public function destroy(Reviewer $reviewer)
    {
        // Check if reviewer has any assignments
        if ($reviewer->reviewAssignments()->whereIn('status', ['pending', 'accepted', 'in_progress'])->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete reviewer with active assignments. Please reassign or complete them first.');
        }

        // Delete the user account (this will cascade to reviewer due to foreign key)
        $reviewer->user->delete();

        return redirect()->route('admin.reviewers.index')
            ->with('success', 'Reviewer deleted successfully.');
    }
}