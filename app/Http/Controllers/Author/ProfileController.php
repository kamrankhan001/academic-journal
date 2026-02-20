<?php
// app/Http/Controllers/Author/ProfileController.php

namespace App\Http\Controllers\Author;

use App\Models\Country;
use App\Models\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Show profile page
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $countries = Country::select('id', 'name')->orderBy('name')->get();

        // Get member since date
        $memberSince = $user->created_at->format('F Y');

        if ($user->role === 'admin') {
            return view('admin.profile', compact(
                'user',
                'profile',
                'memberSince',
                'countries'
            ));
        }

        return view('dashboard.profile', compact(
            'user',
            'profile',
            'memberSince',
            'countries'
        ));
    }

    /**
     * Update profile information
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Base validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'country' => 'nullable|exists:countries,id',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        // Add email validation only for admin users
        if ($user->role == 'admin') { // Assuming you have an isAdmin() method or check role
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $user->id;
        }

        // Validate request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update user name
        $user->name = $request->name;

        // Update email only for admin users
        if ($user->isAdmin() && $request->has('email')) {
            $user->email = $request->email;
        }

        $user->save();

        // Update or create profile
        $profile = $user->profile ?? new Profile();
        $profile->user_id = $user->id;

        // Handle avatar upload if present
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            // Store new avatar
            $profile->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Update other profile fields
        $profile->institution = $request->institution;
        $profile->country_id = $request->country;
        $profile->bio = $request->bio;
        $profile->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }
}