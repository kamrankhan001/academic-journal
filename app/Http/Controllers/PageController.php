<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    /**
     * Show the home page
     */
    public function home()
    {
        return view('home');
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
        return view('pages.current-issue');
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