<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Reviewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display the reviewer dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $reviewer = $user->reviewerProfile;

        if (!$reviewer) {
            return redirect()->route('reviewer.profile')
                ->with('info', 'Please create your reviewer profile first.');
        }

        // Get dashboard statistics
        $stats = [
            'pending_invitations' => $reviewer->reviewAssignments()
                ->where('status', 'pending')
                ->count(),

            'accepted_reviews' => $reviewer->reviewAssignments()
                ->whereIn('status', ['accepted', 'in_progress'])
                ->count(),

            'completed_reviews' => $reviewer->reviewAssignments()
                ->where('status', 'completed')
                ->count(),

            'overdue_reviews' => $reviewer->reviewAssignments()
                ->whereIn('status', ['accepted', 'in_progress'])
                ->where('due_date', '<', now())
                ->count(),
        ];

        // Get recent assignments
        $recentAssignments = $reviewer->reviewAssignments()
            ->with('journal')
            ->latest()
            ->take(5)
            ->get();

        // Get reviews by status for charts
        $reviewsByStatus = [
            'pending' => $reviewer->reviewAssignments()->where('status', 'pending')->count(),
            'accepted' => $reviewer->reviewAssignments()->where('status', 'accepted')->count(),
            'in_progress' => $reviewer->reviewAssignments()->where('status', 'in_progress')->count(),
            'completed' => $reviewer->reviewAssignments()->where('status', 'completed')->count(),
            'declined' => $reviewer->reviewAssignments()->where('status', 'declined')->count(),
        ];

        return view('reviewer.dashboard', compact('user', 'reviewer', 'stats', 'recentAssignments', 'reviewsByStatus'));
    }

    /**
     * Show the profile form (for both create and edit)
     */
    public function profile()
    {
        $user = Auth::user();
        $reviewer = $user->reviewerProfile;

        $countries = Country::orderBy('name')->pluck('name', 'id');

        return view('reviewer.profile', compact('user', 'reviewer', 'countries'));
    }

    /**
     * Store or update reviewer profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $reviewer = $user->reviewerProfile;

        $request->validate([
            'name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'orcid_id' => 'nullable|string|max:20|regex:/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9X]$/',
            'bio' => 'nullable|string|max:2000',
            'expertise_areas' => 'required|array|min:1',
            'expertise_areas.*' => 'string|max:100',
            'academic_degree' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB max
        ], [
            'orcid_id.regex' => 'Please enter a valid ORCID iD (e.g., 0000-0002-1825-0097)',
            'expertise_areas.required' => 'Please select at least one area of expertise',
            'avatar.image' => 'The file must be an image',
            'avatar.mimes' => 'Only JPG, JPEG, and PNG files are allowed',
            'avatar.max' => 'The image size must not exceed 2MB',
        ]);

        // Update user name
        $user->update([
            'name' => $request->name
        ]);

        $data = [
            'user_id' => $user->id,
            'institution' => $request->institution,
            'department' => $request->department,
            'orcid_id' => $request->orcid_id,
            'bio' => $request->bio,
            'expertise_areas' => $request->expertise_areas,
            'academic_degree' => $request->academic_degree,
            'country' => $request->country,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $user->id . '.' . $avatar->getClientOriginalExtension();

            // Store in public disk
            $path = $avatar->storeAs('avatars', $avatarName, 'public');

            // Delete old avatar if exists
            if ($reviewer && $reviewer->avatar) {
                Storage::disk('public')->delete($reviewer->avatar);
            }

            $data['avatar'] = $path;
        }

        if ($reviewer) {
            // Update existing profile
            $reviewer->update($data);
            $message = 'Profile updated successfully.';
        } else {
            // Create new profile with pending status
            $data['status'] = 'pending';
            Reviewer::create($data);
            $message = 'Profile created successfully. It will be activated after admin approval.';
        }

        return redirect()->route('reviewer.profile')
            ->with('success', $message);
    }
}