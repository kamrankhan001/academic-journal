<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            // Check if email is verified
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('verification.notice')
                    ->with('warning', 'Please verify your email address before logging in.');
            }
            return redirect()->intended('/author/dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->withInput($request->except('password'));
    }

    // Show registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ], [
            'terms.required' => 'You must accept the Terms of Service and Privacy Policy.',
            'terms.accepted' => 'You must accept the Terms of Service and Privacy Policy.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'author',
        ]);

        // Handle newsletter preference
        NewsletterController::handleRegistrationPreference($request, $user);

        // Fire registered event (sends verification email)
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please verify your email address.');
    }

    /**
     * Show email verification notice
     */
    public function showVerificationNotice()
    {
        // If user is already verified, redirect to dashboard
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            return redirect('/author/dashboard');
        }

        return view('auth.verify-email');
    }

    /**
     * Verify email
     */
    public function verifyEmail(Request $request, $id, $hash)
    {
        // Find the user by ID from the URL
        $user = User::findOrFail($id);

        // Verify the hash matches
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        // Check if the link has expired (using signed URL)
        if (!URL::hasValidSignature($request)) {
            return redirect()->route('verification.notice')
                ->with('error', 'The verification link has expired. Please request a new one.');
        }

        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            // Log the user in if they're not already
            if (!Auth::check()) {
                Auth::login($user);
            }

            return redirect('/author/dashboard')
                ->with('info', 'Your email is already verified.');
        }

        // Mark email as verified
        $user->markEmailAsVerified();

        // Log the user in (if they're not already)
        if (!Auth::check()) {
            Auth::login($user);
        }

        return redirect('/author/dashboard')
            ->with('success', 'Email verified successfully!');
    }

    /**
     * Resend verification email
     */
    public function resendVerification(Request $request)
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect('/author/dashboard');
        }

        Auth::user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent!');
    }

    // Show forgot password form
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send reset link to email
     */
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'We could not find a user with that email address.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Send password reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', __($status));
        }

        return back()
            ->withErrors(['email' => __($status)])
            ->withInput($request->only('email'));
    }

    /**
     * Show reset password form
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset the user's password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Reset the password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', __($status));
        }

        return back()
            ->withErrors(['email' => [__($status)]])
            ->withInput($request->only('email'));
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}