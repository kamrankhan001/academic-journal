<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminJournalsController extends Controller
{
    /**
     * Display a listing of all journals
     */
    public function index(Request $request)
    {
        $query = Journal::with(['author', 'tags', 'files'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search by title or author
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('author', function ($authorQuery) use ($search) {
                        $authorQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $journals = $query->paginate(15);

        // Get counts for stats
        $stats = [
            'total' => Journal::count(),
            'pending' => Journal::where('status', 'submitted')->count(),
            'under_review' => Journal::where('status', 'under_review')->count(),
            'published' => Journal::where('status', 'published')->count(),
            'revision_required' => Journal::where('status', 'revision_required')->count(),
            'rejected' => Journal::where('status', 'rejected')->count(),
        ];

        return view('admin.journals.index', compact('journals', 'stats'));
    }

    /**
     * Display pending journals (submitted)
     */
    public function pending()
    {
        $journals = Journal::with(['author', 'tags'])
            ->where('status', 'submitted')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.journals.pending', compact('journals'));
    }

    /**
     * Display the specified journal
     */
    public function show($id)
    {
        $journal = Journal::with(['author', 'coAuthors', 'tags', 'files'])
            ->findOrFail($id);

        return view('admin.journals.show', compact('journal'));
    }

    /**
     * Show form to edit journal
     */
    public function edit($id)
    {
        $journal = Journal::with(['author', 'coAuthors', 'tags', 'files'])->findOrFail($id);
        $tags = Tag::orderBy('name')->get();
        $authors = User::where('role', 'author')->orderBy('name')->get();

        // Get selected tag IDs for the view
        $selectedTags = $journal->tags->pluck('id')->toArray();

        return view('admin.journals.edit', compact('journal', 'tags', 'authors', 'selectedTags'));
    }

    /**
     * Update journal
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'journal_content' => 'nullable|string',
            'author_id' => 'required|exists:users,id',
            'status' => 'required|in:draft,submitted,under_review,accepted,rejected,published,revision_required',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'admin_notes' => 'nullable|string',

            // Co-authors validation
            'co_authors' => 'nullable|array',
            'co_authors.*.name' => 'required_with:co_authors|string|max:255',
            'co_authors.*.email' => 'nullable|email|max:255',
            'co_authors.*.institution' => 'nullable|string|max:255',
            'co_authors.*.orcid_id' => 'nullable|string|max:255',

            // File validation
            'manuscript' => 'nullable|file|mimes:pdf|max:10240', // 10MB
            'cover_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // 2MB
            'supplementary_files.*' => 'nullable|file|max:10240', // 10MB per file
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $journal = Journal::findOrFail($id);

        // Update journal basic info
        $journal->update([
            'title' => $request->title,
            'abstract' => $request->abstract,
            'content' => $request->journal_content,
            'user_id' => $request->author_id,
            'status' => $request->status,
        ]);

        // Update tags
        if ($request->has('tags')) {
            $journal->tags()->sync($request->tags);
        } else {
            $journal->tags()->detach();
        }

        // Update co-authors
        if ($request->has('co_authors')) {
            // Delete existing co-authors
            $journal->coAuthors()->delete();

            // Create new co-authors
            foreach ($request->co_authors as $index => $coAuthorData) {
                if (!empty($coAuthorData['name'])) {
                    $journal->coAuthors()->create([
                        'name' => $coAuthorData['name'],
                        'email' => $coAuthorData['email'] ?? null,
                        'institution' => $coAuthorData['institution'] ?? null,
                        'orcid_id' => $coAuthorData['orcid_id'] ?? null,
                        'order' => $index,
                    ]);
                }
            }
        } else {
            // If no co-authors provided, delete existing ones
            $journal->coAuthors()->delete();
        }

        // Handle manuscript upload
        if ($request->hasFile('manuscript')) {
            // Delete old manuscript
            $oldManuscript = $journal->manuscript;
            if ($oldManuscript) {
                \Storage::disk('public')->delete($oldManuscript->file_path);
                $oldManuscript->delete();
            }

            $file = $request->file('manuscript');
            $path = $file->store('journals/' . $journal->id . '/manuscripts', 'public');

            $journal->files()->create([
                'file_type' => 'manuscript',
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'order' => 0,
            ]);
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            $oldCover = $journal->coverImage;
            if ($oldCover) {
                \Storage::disk('public')->delete($oldCover->file_path);
                $oldCover->delete();
            }

            $file = $request->file('cover_image');
            $path = $file->store('journals/' . $journal->id . '/cover', 'public');

            $journal->files()->create([
                'file_type' => 'cover_image',
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'order' => 0,
            ]);
        }

        // Handle supplementary files upload
        if ($request->hasFile('supplementary_files')) {
            $files = $request->file('supplementary_files');
            $existingCount = $journal->supplementaryFiles->count();

            foreach ($files as $index => $file) {
                if ($file->isValid()) {
                    $path = $file->store('journals/' . $journal->id . '/supplementary', 'public');

                    $journal->files()->create([
                        'file_type' => 'supplementary',
                        'original_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'order' => $existingCount + $index,
                    ]);
                }
            }
        }

        // Update status-specific timestamps
        if ($request->status == 'submitted' && !$journal->submitted_at) {
            $journal->update(['submitted_at' => now()]);
        } elseif ($request->status == 'published' && !$journal->published_at) {
            $journal->update(['published_at' => now()]);
        }

        return redirect()
            ->route('admin.journals.show', $journal->id)
            ->with('success', 'Journal updated successfully.');
    }

    /**
     * Approve journal
     */
    public function approve($id)
    {
        $journal = Journal::findOrFail($id);
        $journal->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Send notification to author
        // $journal->author->notify(new \App\Notifications\JournalApprovedNotification($journal));

        return back()->with('success', 'Journal approved and published successfully.');
    }

    /**
     * Move journal to under review
     */
    public function underReview($id)
    {
        $journal = Journal::findOrFail($id);
        $journal->update(['status' => 'under_review']);

        // Send notification to author
        // $journal->author->notify(new \App\Notifications\JournalUnderReviewNotification($journal));

        return back()->with('success', 'Journal moved to under review.');
    }

    /**
     * Request revision for journal
     */
    public function requestRevision(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comments' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $journal = Journal::findOrFail($id);
        $journal->update(['status' => 'revision_required']);

        // Send notification to author with comments
        // $journal->author->notify(new \App\Notifications\JournalRevisionRequiredNotification($journal, $request->comments));

        return back()->with('success', 'Revision request sent to author.');
    }

    /**
     * Reject journal
     */
    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $journal = Journal::findOrFail($id);
        $journal->update(['status' => 'rejected']);

        // Send rejection notification to author
        // $journal->author->notify(new \App\Notifications\JournalRejectedNotification($journal, $request->reason));

        return back()->with('success', 'Journal rejected.');
    }

    /**
     * Delete journal
     */
    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);

        // Delete associated files from storage
        foreach ($journal->files as $file) {
            \Storage::disk('public')->delete($file->file_path);
            $file->delete();
        }

        // Delete co-authors
        $journal->coAuthors()->delete();

        // Detach tags
        $journal->tags()->detach();

        // Delete journal
        $journal->delete();

        return redirect()
            ->route('admin.journals.index')
            ->with('success', 'Journal deleted successfully.');
    }
}