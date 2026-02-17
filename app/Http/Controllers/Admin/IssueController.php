<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IssueController extends Controller
{
    /**
     * Display a listing of all issues.
     */
    public function index(Request $request)
    {
        $query = Issue::with('volume');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('issue_number', 'like', "%{$search}%");
            });
        }

        // Filter by volume
        if ($request->filled('volume_id')) {
            $query->where('volume_id', $request->volume_id);
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by issue type
        if ($request->filled('issue_type') && $request->issue_type !== 'all') {
            $query->where('issue_type', $request->issue_type);
        }

        // Get statistics
        $stats = [
            'total' => Issue::count(),
            'published' => Issue::where('status', 'published')->count(),
            'in_progress' => Issue::where('status', 'in_progress')->count(),
            'planned' => Issue::where('status', 'planned')->count(),
            'special_issues' => Issue::where('issue_type', 'special')->count(),
        ];

        // Get volumes for filter
        $volumes = Volume::orderBy('year', 'desc')->get(['id', 'title', 'volume_number']);

        $issues = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.issues.index', compact('issues', 'stats', 'volumes'));
    }

    /**
     * Show form for creating a new issue.
     */
    public function create()
    {
        $volumes = Volume::whereIn('status', ['in_progress', 'published'])
                        ->orderBy('year', 'desc')
                        ->get();
        
        return view('admin.issues.create', compact('volumes'));
    }

    /**
     * Show form for creating a new issue for a specific volume.
     */
    public function createForVolume(Volume $volume)
    {
        return view('admin.issues.create', compact('volume'));
    }

    /**
     * Store a newly created issue.
     */
    public function store(Request $request)
    {
        $request->validate([
            'volume_id' => 'required|exists:volumes,id',
            'title' => 'required|string|max:255',
            'issue_number' => 'required|integer|unique:issues,issue_number,NULL,id,volume_id,' . $request->volume_id,
            'description' => 'nullable|string',
            'issue_type' => 'required|in:regular,special,supplement',
            'publication_date' => 'nullable|date',
            'status' => 'required|in:planned,in_progress,published',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'issue_number.unique' => 'This issue number already exists in the selected volume.',
        ]);

        $data = $request->except('cover_image');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('issues/covers', 'public');
            $data['cover_image'] = $path;
        }

        // Set published_at if status is published
        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        Issue::create($data);

        return redirect()->route('admin.issues.index')
            ->with('success', 'Issue created successfully.');
    }

    /**
     * Display the specified issue.
     */
    public function show(Issue $issue)
    {
        $issue->load(['volume', 'journals' => function($query) {
            $query->where('status', 'published')->orderBy('page_start');
        }]);

        return view('admin.issues.show', compact('issue'));
    }

    /**
     * Show form for editing issue.
     */
    public function edit(Issue $issue)
    {
        $volumes = Volume::orderBy('year', 'desc')->get();
        return view('admin.issues.edit', compact('issue', 'volumes'));
    }

    /**
     * Update the specified issue.
     */
    public function update(Request $request, Issue $issue)
    {
        $request->validate([
            'volume_id' => 'required|exists:volumes,id',
            'title' => 'required|string|max:255',
            'issue_number' => 'required|integer|unique:issues,issue_number,' . $issue->id . ',id,volume_id,' . $request->volume_id,
            'description' => 'nullable|string',
            'issue_type' => 'required|in:regular,special,supplement',
            'publication_date' => 'nullable|date',
            'status' => 'required|in:planned,in_progress,published',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('cover_image');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($issue->cover_image) {
                Storage::disk('public')->delete($issue->cover_image);
            }
            $path = $request->file('cover_image')->store('issues/covers', 'public');
            $data['cover_image'] = $path;
        }

        // Handle cover removal
        if ($request->has('remove_cover') && $request->remove_cover == '1') {
            if ($issue->cover_image) {
                Storage::disk('public')->delete($issue->cover_image);
                $data['cover_image'] = null;
            }
        }

        // Set published_at if status changed to published
        if ($request->status === 'published' && $issue->status !== 'published') {
            $data['published_at'] = now();
        }

        $issue->update($data);

        return redirect()->route('admin.issues.index')
            ->with('success', 'Issue updated successfully.');
    }

    /**
     * Publish an issue.
     */
    public function publish(Issue $issue)
    {
        if ($issue->status === 'published') {
            return redirect()->back()
                ->with('error', 'Issue is already published.');
        }

        $issue->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        return redirect()->route('admin.issues.index')
            ->with('success', 'Issue published successfully.');
    }

    /**
     * Remove the specified issue.
     */
    public function destroy(Issue $issue)
    {
        // Check if issue has articles
        if ($issue->journals()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete issue with existing articles. Move or delete the articles first.');
        }

        // Delete cover image
        if ($issue->cover_image) {
            Storage::disk('public')->delete($issue->cover_image);
        }

        $issue->delete();

        return redirect()->route('admin.issues.index')
            ->with('success', 'Issue deleted successfully.');
    }
}