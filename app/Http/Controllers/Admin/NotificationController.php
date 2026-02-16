<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function createAnnouncement()
    {
        return view('admin.notifications.create-announcement');
    }
    
    public function sendAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'action_url' => 'nullable|url',
            'send_to' => 'required|in:all,authors,reviewers',
        ]);
        
        $query = User::query();
        
        if ($request->send_to === 'authors') {
            $query->where('role', 'author');
        } elseif ($request->send_to === 'reviewers') {
            $query->where('role', 'reviewer');
        }
        
        $users = $query->get();
        
        foreach ($users as $user) {
            $user->notify(new AnnouncementNotification(
                $request->title,
                $request->message,
                $request->action_url
            ));
        }
        
        return redirect()->route('admin.notifications.index')
            ->with('success', 'Announcement sent to ' . $users->count() . ' users.');
    }
    
    public function index()
    {
        // Get all notifications from all users (for admin overview)
        $notifications = \DB::table('notifications')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->route('admin.notifications.index')->with('success', 'All notifications marked as read.');
    }
}