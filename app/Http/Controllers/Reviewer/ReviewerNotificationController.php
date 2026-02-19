<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewerNotificationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $query = DB::table('notifications')
            ->where('notifiable_id', auth()->id())
            ->where('notifiable_type', 'App\Models\User')
            ->orderBy('created_at', 'desc');
        
        // Apply filter
        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($filter === 'read') {
            $query->whereNotNull('read_at');
        }
        
        $notifications = $query->paginate(20)->withQueryString();
        
        return view('reviewer.notifications.index', compact('notifications', 'filter'));
    }

    public function markAsRead($id)
    {
        $notification = DB::table('notifications')
            ->where('id', $id)
            ->where('notifiable_id', auth()->id())
            ->first();
        
        if ($notification && is_null($notification->read_at)) {
            DB::table('notifications')
                ->where('id', $id)
                ->update(['read_at' => now()]);
        }
        
        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        DB::table('notifications')
            ->where('notifiable_id', auth()->id())
            ->where('notifiable_type', 'App\Models\User')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('reviewer.notifications.index')
            ->with('success', 'All notifications marked as read.');
    }

    public function destroy($id)
    {
        DB::table('notifications')
            ->where('id', $id)
            ->where('notifiable_id', auth()->id())
            ->delete();
        
        return response()->json(['success' => true]);
    }

    public function unreadCount()
    {
        $count = DB::table('notifications')
            ->where('notifiable_id', auth()->id())
            ->where('notifiable_type', 'App\Models\User')
            ->whereNull('read_at')
            ->count();
        
        return response()->json(['count' => $count]);
    }
}