<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journal;
use App\Models\Tag;
use App\Notifications\JournalSubmittedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JournalController extends Controller
{
    /**
     * Display a listing of the journals.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Journal::where('user_id', $user->id)
            ->with(['coAuthors', 'tags']);

        // Search filter
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $journals = $query->paginate(10)->withQueryString();

        return view('dashboard.journals.index', compact('journals'));
    }

    /**
     * Show the form for creating a new journal.
     */
    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return view('dashboard.journals.create', compact('tags'));
    }

    /**
     * Store a newly created journal in storage.
     */
    /**
     * Store a newly created journal in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'journal_content' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'co_authors' => 'nullable|array',
            'co_authors.*.name' => 'required_with:co_authors|string|max:255',
            'co_authors.*.email' => 'nullable|email|max:255',
            'co_authors.*.institution' => 'nullable|string|max:255',
            'co_authors.*.orcid_id' => 'nullable|string|max:255',
            'manuscript' => 'required|file|mimes:pdf|max:10240', // 10MB
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB
            'supplementary_files.*' => 'nullable|file|max:10240', // 10MB each
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create journal
        $journal = Journal::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'abstract' => $request->abstract,
            'content' => $request->journal_content,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'status' => 'draft',
            'views_count' => 0,
            'submitted_at' => null,
        ]);

        // Handle tags
        if ($request->has('tags')) {
            $journal->tags()->attach($request->tags);
        }

        // Handle co-authors
        if ($request->has('co_authors')) {
            foreach ($request->co_authors as $index => $coAuthorData) {
                if (!empty($coAuthorData['name'])) {
                    $journal->coAuthors()->create([
                        'name' => $coAuthorData['name'],
                        'email' => $coAuthorData['email'] ?? null,
                        'institution' => $coAuthorData['institution'] ?? null,
                        'orcid_id' => $coAuthorData['orcid_id'] ?? null,
                        'order' => $index + 1,
                    ]);
                }
            }
        }

        // Handle manuscript with version and uploaded_by
        if ($request->hasFile('manuscript')) {
            $file = $request->file('manuscript');
            $path = $file->store('journals/' . $journal->id . '/manuscript', 'public');

            $journal->files()->create([
                'file_type' => 'manuscript',
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'version' => 1, // First version
                'uploaded_by' => Auth::id(), // Current user ID
            ]);
        }

        // Handle cover image with version and uploaded_by
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $path = $file->store('journals/' . $journal->id . '/cover', 'public');

            $journal->files()->create([
                'file_type' => 'cover_image',
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'version' => 1, // First version
                'uploaded_by' => Auth::id(), // Current user ID
            ]);
        }

        // Handle supplementary files with version and uploaded_by
        if ($request->hasFile('supplementary_files')) {
            foreach ($request->file('supplementary_files') as $index => $file) {
                $path = $file->store('journals/' . $journal->id . '/supplementary', 'public');

                $journal->files()->create([
                    'file_type' => 'supplementary',
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'order' => $index + 1,
                    'version' => 1, // First version
                    'uploaded_by' => Auth::id(), // Current user ID
                ]);
            }
        }

        return redirect()
            ->route('author.journals.show', $journal)
            ->with('success', 'Journal created successfully!');
    }

    /**
     * Display the specified journal.
     */
    public function show(Journal $journal)
    {
        // Check if the journal belongs to the authenticated user
        if ($journal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $journal->load(['coAuthors', 'tags', 'files']);

        return view('dashboard.journals.show', compact('journal'));
    }

    /**
     * Show the form for editing the specified journal.
     */
    public function edit(Journal $journal)
    {
        // Check if the journal belongs to the authenticated user
        if ($journal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $journal->load(['coAuthors', 'tags', 'files']);
        $tags = Tag::orderBy('name')->get();
        $selectedTags = $journal->tags->pluck('id')->toArray();

        return view('dashboard.journals.edit', compact('journal', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified journal.
     */
    /**
     * Update the specified journal.
     */
    public function update(Request $request, Journal $journal)
    {
        // Check if the journal belongs to the authenticated user
        if ($journal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'journal_content' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'co_authors' => 'nullable|array',
            'co_authors.*.name' => 'required_with:co_authors|string|max:255',
            'co_authors.*.email' => 'nullable|email|max:255',
            'co_authors.*.institution' => 'nullable|string|max:255',
            'co_authors.*.orcid_id' => 'nullable|string|max:255',
            'manuscript' => 'nullable|file|mimes:pdf|max:10240',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'supplementary_files.*' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update journal
        $journal->update([
            'title' => $request->title,
            'abstract' => $request->abstract,
            'content' => $request->journal_content,
        ]);

        // Update tags
        $journal->tags()->sync($request->tags ?? []);

        // Update co-authors (delete old and create new)
        $journal->coAuthors()->delete();
        if ($request->has('co_authors')) {
            foreach ($request->co_authors as $index => $coAuthorData) {
                if (!empty($coAuthorData['name'])) {
                    $journal->coAuthors()->create([
                        'name' => $coAuthorData['name'],
                        'email' => $coAuthorData['email'] ?? null,
                        'institution' => $coAuthorData['institution'] ?? null,
                        'orcid_id' => $coAuthorData['orcid_id'] ?? null,
                        'order' => $index + 1,
                    ]);
                }
            }
        }

        // Handle new manuscript upload (version increment)
        if ($request->hasFile('manuscript')) {
            // Get next version number
            $nextVersion = \App\Models\JournalFile::getNextVersion($journal->id, 'manuscript');

            // Store old manuscript for history (optional - you can keep it or delete it)
            $oldManuscript = $journal->manuscript;
            if ($oldManuscript) {
                // Option 1: Keep old versions (recommended for audit trail)
                // Just don't delete it

                // Option 2: Delete old version if you only want to keep the latest
                // Storage::disk('public')->delete($oldManuscript->file_path);
                // $oldManuscript->delete();
            }

            $file = $request->file('manuscript');
            $path = $file->store('journals/' . $journal->id . '/manuscript', 'public');

            $journal->files()->create([
                'file_type' => 'manuscript',
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'version' => $nextVersion, // Increment version
                'uploaded_by' => Auth::id(), // Current user ID
            ]);
        }

        // Handle new cover image upload (version increment)
        if ($request->hasFile('cover_image')) {
            // Get next version number
            $nextVersion = \App\Models\JournalFile::getNextVersion($journal->id, 'cover_image');

            // Store old cover for history (optional)
            $oldCover = $journal->coverImage;
            if ($oldCover) {
                // Option 1: Keep old versions
                // Option 2: Delete old version
                // Storage::disk('public')->delete($oldCover->file_path);
                // $oldCover->delete();
            }

            $file = $request->file('cover_image');
            $path = $file->store('journals/' . $journal->id . '/cover', 'public');

            $journal->files()->create([
                'file_type' => 'cover_image',
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'version' => $nextVersion, // Increment version
                'uploaded_by' => Auth::id(), // Current user ID
            ]);
        }

        // Handle new supplementary files (new files, not versions of existing)
        if ($request->hasFile('supplementary_files')) {
            $currentCount = $journal->supplementaryFiles()->count();

            foreach ($request->file('supplementary_files') as $index => $file) {
                $path = $file->store('journals/' . $journal->id . '/supplementary', 'public');

                $journal->files()->create([
                    'file_type' => 'supplementary',
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'order' => $currentCount + $index + 1,
                    'version' => 1, // First version for new supplementary files
                    'uploaded_by' => Auth::id(), // Current user ID
                ]);
            }
        }

        return redirect()
            ->route('author.journals.index')
            ->with('success', 'Journal updated successfully!');
    }

    /**
     * Remove the specified journal.
     */
    public function destroy(Journal $journal)
    {
        // Check if the journal belongs to the authenticated user
        if ($journal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete all files
        foreach ($journal->files as $file) {
            Storage::disk('public')->delete($file->file_path);
        }

        // Delete the journal directory
        Storage::disk('public')->deleteDirectory('journals/' . $journal->id);

        // Delete the journal (cascades to co_authors, files, etc.)
        $journal->delete();

        return redirect()
            ->route('author.journals.index')
            ->with('success', 'Journal deleted successfully!');
    }

    /**
     * Submit journal for review
     */
    public function submit(Journal $journal)
    {
        if ($journal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $journal->update([
            'status' => 'submitted',
            'submitted_at' => now()
        ]);

        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            $admin->notify(new JournalSubmittedNotification($journal));
        }

        return redirect()
            ->route('author.journals.show', $journal)
            ->with('success', 'Journal submitted for review successfully!');
    }
}