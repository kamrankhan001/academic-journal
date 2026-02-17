<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VolumeController extends Controller
{
    /**
     * Display a listing of volumes.
     */
    public function index(Request $request)
    {
        $query = Volume::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('volume_number', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Get statistics
        $stats = [
            'total' => Volume::count(),
            'published' => Volume::where('status', 'published')->count(),
            'in_progress' => Volume::where('status', 'in_progress')->count(),
            'planned' => Volume::where('status', 'planned')->count(),
            'total_articles' => Volume::withCount('journals')->get()->sum('journals_count'),
        ];

        // Get unique years for filter
        $years = Volume::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        $volumes = $query->withCount('issues', 'journals')
                        ->orderBy('year', 'desc')
                        ->orderBy('volume_number', 'desc')
                        ->paginate(10);

        return view('admin.volumes.index', compact('volumes', 'stats', 'years'));
    }

    /**
     * Show form for creating new volume.
     */
    public function create()
    {
        return view('admin.volumes.create');
    }

    /**
     * Store a newly created volume.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'volume_number' => 'required|integer|unique:volumes,volume_number',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'status' => 'required|in:planned,in_progress,published',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('cover_image');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('volumes/covers', 'public');
            $data['cover_image'] = $path;
        }

        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        Volume::create($data);

        return redirect()->route('admin.volumes.index')
            ->with('success', 'Volume created successfully.');
    }

    /**
     * Display the specified volume.
     */
    public function show(Volume $volume)
    {
        $volume->load(['issues' => function($query) {
            $query->orderBy('issue_number')->withCount('journals');
        }]);

        return view('admin.volumes.show', compact('volume'));
    }

    /**
     * Show form for editing volume.
     */
    public function edit(Volume $volume)
    {
        return view('admin.volumes.edit', compact('volume'));
    }

    /**
     * Update the specified volume.
     */
    public function update(Request $request, Volume $volume)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'volume_number' => 'required|integer|unique:volumes,volume_number,' . $volume->id,
            'description' => 'nullable|string',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'status' => 'required|in:planned,in_progress,published',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('cover_image');

        if ($request->has('remove_cover') && $request->remove_cover == '1') {
            if ($volume->cover_image) {
                Storage::disk('public')->delete($volume->cover_image);
                $data['cover_image'] = null;
            }
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($volume->cover_image) {
                Storage::disk('public')->delete($volume->cover_image);
            }
            $path = $request->file('cover_image')->store('volumes/covers', 'public');
            $data['cover_image'] = $path;
        }

        // Set published_at if status changed to published
        if ($request->status === 'published' && $volume->status !== 'published') {
            $data['published_at'] = now();
        }

        $volume->update($data);

        return redirect()->route('admin.volumes.index')
            ->with('success', 'Volume updated successfully.');
    }

    /**
     * Publish a volume.
     */
    public function publish(Volume $volume)
    {
        if ($volume->status === 'published') {
            return redirect()->back()
                ->with('error', 'Volume is already published.');
        }

        $volume->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        return redirect()->route('admin.volumes.index')
            ->with('success', 'Volume published successfully.');
    }

    /**
     * Remove the specified volume.
     */
    public function destroy(Volume $volume)
    {
        // Check if volume has issues
        if ($volume->issues()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete volume with existing issues. Delete the issues first.');
        }

        // Delete cover image
        if ($volume->cover_image) {
            Storage::disk('public')->delete($volume->cover_image);
        }

        $volume->delete();

        return redirect()->route('admin.volumes.index')
            ->with('success', 'Volume deleted successfully.');
    }
}