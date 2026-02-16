<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterVerification;
use App\Mail\NewsletterWelcome;

class NewsletterController extends Controller
{
    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'consent' => 'required|accepted',
        ], [
            'consent.required' => 'You must agree to the Privacy Policy.',
            'consent.accepted' => 'You must agree to the Privacy Policy.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if already subscribed
        $existing = NewsletterSubscription::where('email', $request->email)->first();

        if ($existing) {
            if ($existing->is_subscribed) {
                return back()->with('info', 'This email is already subscribed to our newsletter.');
            } else {
                // Resubscribe
                $existing->resubscribe();

                // Send welcome back email
                Mail::to($existing->email)
                    ->send(new NewsletterWelcome($existing, true));

                return back()->with('success', 'You have been resubscribed to our newsletter!');
            }
        }

        // Create new subscription
        $subscription = NewsletterSubscription::create([
            'email' => $request->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => auth()->id(),
            'name' => auth()->user()->name ?? null,
        ]);

        // Send verification email
        Mail::to($subscription->email)->send(new NewsletterVerification($subscription));

        return back()->with('success', 'Please check your email to verify your subscription.');
    }

    /**
     * Verify email
     */
    public function verify($token)
    {
        $subscription = NewsletterSubscription::where('verification_token', $token)
            ->where('is_verified', false)
            ->firstOrFail();

        $subscription->markAsVerified();

        // Send welcome email
        Mail::to($subscription->email)->send(new NewsletterWelcome($subscription));

        return redirect('/')->with('success', 'Your email has been verified. Thank you for subscribing!');
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe($email, $token = null)
    {
        $subscription = NewsletterSubscription::where('email', $email)->firstOrFail();

        // If token provided, verify it
        if ($token) {
            if ($subscription->verification_token !== $token) {
                abort(404);
            }
        }

        $subscription->unsubscribe();

        return view('newsletter.unsubscribed', compact('email'));
    }

    /**
     * Handle newsletter preference during registration
     */
    public static function handleRegistrationPreference(Request $request, $user)
    {
        if ($request->has('newsletter')) {
            NewsletterSubscription::updateOrCreate(
                ['email' => $user->email],
                [
                    'name' => $user->name,
                    'user_id' => $user->id,
                    'is_subscribed' => true,
                    'is_verified' => false,
                    'verified_at' => now(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]
            );
        }
    }

    // verify newsletter when user verifies email
    public static function verifyUserSubscription($user)
    {
        $subscription = NewsletterSubscription::where('email', $user->email)->first();
        if ($subscription && !$subscription->is_verified) {
            $subscription->update([
                'is_verified' => true,
                'verified_at' => now(),
            ]);
        }
    }
}