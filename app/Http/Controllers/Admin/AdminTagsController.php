<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminTagsController extends Controller
{
    /**
     * Display a listing of tags
     */
    public function index(Request $request)
    {
        $query = Tag::withCount('journals')->orderBy('name');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }
        
        $tags = $query->paginate(15);
        
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show form to create a new tag
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created tag
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tags',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Display the specified tag
     */
    public function show($id)
    {
        $tag = Tag::withCount('journals')
            ->with(['journals' => function($query) {
                $query->with('author')->latest()->limit(10);
            }])
            ->findOrFail($id);
            
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show form to edit tag
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    /**
     * Delete the specified tag
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        
        // Detach from all journals before deleting
        $tag->journals()->detach();
        
        // Delete the tag
        $tag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully.');
    }

    /**
     * Bulk delete tags
     */
    public function bulkDestroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid selection'], 400);
        }

        foreach ($request->ids as $id) {
            $tag = Tag::find($id);
            if ($tag) {
                $tag->journals()->detach();
                $tag->delete();
            }
        }

        return response()->json(['success' => true, 'message' => 'Tags deleted successfully.']);
    }

    /**
     * Merge tags (replace one tag with another)
     */
    public function merge(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_id' => 'required|exists:tags,id',
            'target_id' => 'required|exists:tags,id|different:source_id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $sourceTag = Tag::findOrFail($request->source_id);
        $targetTag = Tag::findOrFail($request->target_id);

        // Get all journals with the source tag
        $journals = $sourceTag->journals;

        // Attach the target tag to all these journals
        foreach ($journals as $journal) {
            if (!$journal->tags()->where('tags.id', $targetTag->id)->exists()) {
                $journal->tags()->attach($targetTag->id);
            }
        }

        // Detach and delete source tag
        $sourceTag->journals()->detach();
        $sourceTag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tags merged successfully.');
    }
}