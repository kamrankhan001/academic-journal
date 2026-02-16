<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AdminAnnouncementController extends Controller
{
    /**
     * Display a listing of announcements
     */
    public function index(Request $request)
    {
        $query = Announcement::with('creator')
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            if ($request->status == 'sent') {
                $query->whereNotNull('sent_at');
            } elseif ($request->status == 'draft') {
                $query->whereNull('sent_at');
            } elseif ($request->status == 'scheduled') {
                $query->whereNull('sent_at')
                    ->whereNotNull('scheduled_at')
                    ->where('scheduled_at', '>', now());
            }
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $announcements = $query->paginate(15);

        // Get stats
        $stats = [
            'total' => Announcement::count(),
            'sent' => Announcement::whereNotNull('sent_at')->count(),
            'draft' => Announcement::whereNull('sent_at')->count(),
            'scheduled' => Announcement::whereNull('sent_at')
                ->whereNotNull('scheduled_at')
                ->where('scheduled_at', '>', now())
                ->count(),
        ];

        return view('admin.announcements.index', compact('announcements', 'stats'));
    }

    /**
     * Show form to create announcement
     */
    public function create()
    {
        $roles = [
            'all' => 'All Users',
            'author' => 'Authors Only',
            'reviewer' => 'Reviewers Only',
            'admin' => 'Admins Only',
        ];

        return view('admin.announcements.create', compact('roles'));
    }

    /**
     * Store announcement
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
            'action_url' => 'nullable|url|max:255',
            'action_text' => 'nullable|string|max:50',
            'target_roles' => 'required|array',
            'target_roles.*' => 'in:author,reviewer,admin',
            'scheduled_at' => 'nullable|date|after:now',
            'send_now' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $announcement = Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'action_url' => $request->action_url,
            'action_text' => $request->action_text,
            'target_roles' => in_array('all', $request->target_roles) ? null : $request->target_roles,
            'created_by' => auth()->id(),
            'scheduled_at' => $request->scheduled_at,
        ]);

        // Send immediately if requested
        if ($request->has('send_now') && $request->send_now) {
            $this->sendAnnouncement($announcement);
            $announcement->update(['sent_at' => now()]);
            $message = 'Announcement sent successfully.';
        } else {
            $message = $request->scheduled_at 
                ? 'Announcement scheduled successfully.' 
                : 'Announcement saved as draft.';
        }

        return redirect()
            ->route('admin.announcements.show', $announcement->id)
            ->with('success', $message);
    }

    /**
     * Display announcement
     */
    public function show($id)
    {
        $announcement = Announcement::with('creator')->findOrFail($id);
        
        // Get delivery stats
        $stats = [
            'total_recipients' => $this->getRecipientCount($announcement),
            'read_count' => auth()->user()->notifications()
                ->where('data->type', 'announcement')
                ->where('data->announcement_id', $announcement->id)
                ->whereNotNull('read_at')
                ->count(),
        ];

        return view('admin.announcements.show', compact('announcement', 'stats'));
    }

    /**
     * Show form to edit announcement
     */
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Don't allow editing sent announcements
        if ($announcement->sent_at) {
            return redirect()
                ->route('admin.announcements.show', $announcement->id)
                ->with('error', 'Cannot edit sent announcements.');
        }

        $roles = [
            'all' => 'All Users',
            'author' => 'Authors Only',
            'reviewer' => 'Reviewers Only',
            'admin' => 'Admins Only',
        ];

        return view('admin.announcements.edit', compact('announcement', 'roles'));
    }

    /**
     * Update announcement
     */
    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        // Don't allow updating sent announcements
        if ($announcement->sent_at) {
            return redirect()
                ->route('admin.announcements.show', $announcement->id)
                ->with('error', 'Cannot edit sent announcements.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
            'action_url' => 'nullable|url|max:255',
            'action_text' => 'nullable|string|max:50',
            'target_roles' => 'required|array',
            'target_roles.*' => 'in:author,reviewer,admin',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $announcement->update([
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'action_url' => $request->action_url,
            'action_text' => $request->action_text,
            'target_roles' => in_array('all', $request->target_roles) ? null : $request->target_roles,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return redirect()
            ->route('admin.announcements.show', $announcement->id)
            ->with('success', 'Announcement updated successfully.');
    }

    /**
     * Delete announcement
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Delete associated notifications
        \DB::table('notifications')
            ->where('data->announcement_id', $announcement->id)
            ->delete();
        
        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }

    /**
     * Send announcement
     */
    public function send($id)
    {
        $announcement = Announcement::findOrFail($id);

        if ($announcement->sent_at) {
            return back()->with('error', 'Announcement already sent.');
        }

        $this->sendAnnouncement($announcement);
        $announcement->update(['sent_at' => now()]);

        return back()->with('success', 'Announcement sent successfully.');
    }

    /**
     * Send announcement to users
     */
    private function sendAnnouncement(Announcement $announcement)
    {
        $users = $this->getTargetUsers($announcement);
        
        foreach ($users as $user) {
            $user->notify(new AnnouncementNotification(
                $announcement->title,
                $announcement->message,
                $announcement->action_url,
                $announcement->id,
                $announcement->type
            ));
        }

        return $users->count();
    }

    /**
     * Get target users based on roles
     */
    private function getTargetUsers(Announcement $announcement)
    {
        $query = User::query();

        if ($announcement->target_roles) {
            $query->whereIn('role', $announcement->target_roles);
        }

        return $query->get();
    }

    /**
     * Get recipient count
     */
    private function getRecipientCount(Announcement $announcement)
    {
        $query = User::query();

        if ($announcement->target_roles) {
            $query->whereIn('role', $announcement->target_roles);
        }

        return $query->count();
    }

    /**
     * Duplicate announcement
     */
    public function duplicate($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        $newAnnouncement = $announcement->replicate();
        $newAnnouncement->title = $announcement->title . ' (Copy)';
        $newAnnouncement->sent_at = null;
        $newAnnouncement->scheduled_at = null;
        $newAnnouncement->created_by = auth()->id();
        $newAnnouncement->save();

        return redirect()
            ->route('admin.announcements.edit', $newAnnouncement->id)
            ->with('success', 'Announcement duplicated. You can now edit and send it.');
    }

    /**
     * Preview announcement
     */
    public function preview(Request $request)
    {
        return view('admin.announcements.preview', [
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'action_url' => $request->action_url,
            'action_text' => $request->action_text,
        ]);
    }
}