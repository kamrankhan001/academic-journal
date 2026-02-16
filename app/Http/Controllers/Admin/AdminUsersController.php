<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::with('profile.country')
            ->withCount(['journals', 'coAuthoredJournals']);

        // Filter by role
        if ($request->has('role') && $request->role != 'all') {
            $query->where('role', $request->role);
        }

        // Filter by status (email verified)
        if ($request->has('verified') && $request->verified != 'all') {
            if ($request->verified == 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->verified == 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', function ($profileQuery) use ($search) {
                        $profileQuery->where('institution', 'like', "%{$search}%");
                    });
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get counts for stats
        $stats = [
            'total' => User::count(),
            'authors' => User::where('role', 'author')->count(),
            'reviewers' => User::where('role', 'reviewer')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'unverified' => User::whereNull('email_verified_at')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show form to create a new user
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('admin.users.create', compact('countries'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,author,reviewer',
            'institution' => 'nullable|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email_verified' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => $request->has('email_verified') ? now() : null,
        ]);

        // Handle avatar upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Create profile
        $user->profile()->create([
            'institution' => $request->institution,
            'country_id' => $request->country_id,
            'bio' => $request->bio,
            'avatar' => $avatarPath,
        ]);

        return redirect()
            ->route('admin.users.show', $user->id)
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user
     */
    public function show($id)
    {
        $user = User::with([
            'profile.country',
            'journals' => function ($query) {
                $query->with('tags')->latest()->limit(5);
            }
        ])
            ->withCount(['journals'])
            ->findOrFail($id);

        // Get co-authored journals using a separate query
        $coAuthoredJournals = Journal::whereHas('coAuthors', function ($query) use ($user) {
            $query->where('email', $user->email);
        })
            ->with('author')
            ->latest()
            ->limit(5)
            ->get();

        $coAuthoredJournalsCount = Journal::whereHas('coAuthors', function ($query) use ($user) {
            $query->where('email', $user->email);
        })->count();

        // Get additional stats
        $publishedJournals = $user->journals()->where('status', 'published')->count();
        $pendingJournals = $user->journals()->where('status', 'submitted')->count();

        return view('admin.users.show', compact(
            'user',
            'publishedJournals',
            'pendingJournals',
            'coAuthoredJournals',
            'coAuthoredJournalsCount'
        ));
    }

    /**
     * Show form to edit user
     */
    public function edit($id)
    {
        $user = User::with('profile')->findOrFail($id);
        $countries = Country::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'countries'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,author,reviewer',
            'institution' => 'nullable|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email_verified' => 'boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'email_verified_at' => $request->has('email_verified') ? now() : null,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->profile && $user->profile->avatar) {
                Storage::disk('public')->delete($user->profile->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        } else {
            $avatarPath = $user->profile->avatar ?? null;
        }

        // Update or create profile
        if ($user->profile) {
            $user->profile->update([
                'institution' => $request->institution,
                'country_id' => $request->country_id,
                'bio' => $request->bio,
                'avatar' => $avatarPath,
            ]);
        } else {
            $user->profile()->create([
                'institution' => $request->institution,
                'country_id' => $request->country_id,
                'bio' => $request->bio,
                'avatar' => $avatarPath,
            ]);
        }

        return redirect()
            ->route('admin.users.show', $user->id)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete the specified user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Check if user has journals
        if ($user->journals()->count() > 0) {
            return back()->with('error', 'Cannot delete user because they have journals. Reassign or delete the journals first.');
        }

        // Delete avatar
        if ($user->profile && $user->profile->avatar) {
            Storage::disk('public')->delete($user->profile->avatar);
        }

        // Delete profile
        if ($user->profile) {
            $user->profile()->delete();
        }

        // Delete user
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Bulk delete users
     */
    public function bulkDestroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid selection'], 400);
        }

        $deleted = 0;
        $skipped = 0;

        foreach ($request->ids as $id) {
            $user = User::find($id);
            if ($user) {
                // Check if user has journals
                if ($user->journals()->count() > 0) {
                    $skipped++;
                    continue;
                }

                // Delete avatar
                if ($user->profile && $user->profile->avatar) {
                    Storage::disk('public')->delete($user->profile->avatar);
                }

                // Delete profile
                if ($user->profile) {
                    $user->profile()->delete();
                }

                $user->delete();
                $deleted++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "{$deleted} users deleted successfully. {$skipped} users skipped (they have journals)."
        ]);
    }

    /**
     * Verify email manually
     */
    public function verifyEmail($id)
    {
        $user = User::findOrFail($id);
        $user->update(['email_verified_at' => now()]);

        return back()->with('success', 'Email verified successfully.');
    }

    /**
     * Toggle user role
     */
    public function toggleRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'role' => 'required|in:admin,author,reviewer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid role'], 400);
        }

        // Prevent removing last admin
        if ($user->role === 'admin' && $request->role !== 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return response()->json(['error' => 'Cannot remove the last admin'], 400);
            }
        }

        $user->update(['role' => $request->role]);

        return response()->json([
            'success' => true,
            'message' => 'User role updated successfully.',
            'role' => $request->role
        ]);
    }
}