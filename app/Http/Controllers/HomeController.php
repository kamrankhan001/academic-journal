<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Tag;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get search query
        $search = $request->get('search');

        // Get selected tag filter
        $tagSlug = $request->get('tag_slug');

        // If slug is provided, get the tag ID
        $tagId = null;
        $currentTag = null;
        if ($tagSlug) {
            $currentTag = Tag::where('slug', $tagSlug)->first();
            $tagId = $currentTag ? $currentTag->id : null;
        }

        // Get month/year filter for archive
        $month = $request->get('month');
        $year = $request->get('year');

        // Base query for published journals
        $query = Journal::with(['author', 'coAuthors', 'tags', 'files'])
            ->published()
            ->orderBy('published_at', 'desc');

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('abstract', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhereHas('author', function ($authorQuery) use ($search) {
                        $authorQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tags', function ($tagQuery) use ($search) {
                        $tagQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Apply tag filter
        if ($tagId) {
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('tags.id', $tagId);
            });
        }

        // Apply archive filter
        if ($month && $year) {
            $query->whereYear('published_at', $year)
                ->whereMonth('published_at', $month);
        }

        // Get paginated journals
        $journals = $query->paginate(5)->withQueryString(); // withQueryString() preserves query params in pagination links

        // Get popular tags with counts (only for published journals)
        $popularTags = Tag::withCount([
            'journals' => function ($query) {
                $query->published();
            }
        ])
            ->having('journals_count', '>', 0)
            ->orderBy('journals_count', 'desc')
            ->limit(10)
            ->get();

        // Get archive data (journals count by month/year) - only for published journals
        $archives = Journal::published()
            ->selectRaw('YEAR(published_at) as year, MONTH(published_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($item) {
                $date = Carbon::create($item->year, $item->month, 1);
                return [
                    'year' => $item->year,
                    'month' => $item->month,
                    'month_name' => $date->format('F'),
                    'total' => $item->total,
                    'slug' => strtolower($date->format('F Y'))
                ];
            });

        // Get recent journals for sidebar (only published)
        $recentJournals = Journal::published()
            ->with('author')
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('home', compact(
            'journals',
            'popularTags',
            'archives',
            'recentJournals',
            'search',
            'tagId',
            'currentTag',
            'month',
            'year'
        ));
    }

    public function archives(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');

        $query = Journal::with(['author', 'coAuthors', 'tags'])
            ->published()
            ->orderBy('published_at', 'desc');

        if ($month && $year) {
            $query->whereYear('published_at', $year)
                ->whereMonth('published_at', $month);
            $period = Carbon::create($year, $month, 1)->format('F Y');
        } else {
            $period = 'All Archives';
        }

        $journals = $query->paginate(10);

        // Get archive data for sidebar
        $archives = Journal::published()
            ->selectRaw('YEAR(published_at) as year, MONTH(published_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                $date = Carbon::create($item->year, $item->month, 1);
                return [
                    'year' => $item->year,
                    'month' => $item->month,
                    'month_name' => $date->format('F'),
                    'total' => $item->total,
                    'slug' => strtolower($date->format('F Y'))
                ];
            });

        return view('pages.archives', compact('journals', 'archives', 'period'));
    }

    public function showJournal($slug)
    {
        $journal = Journal::with(['author', 'coAuthors', 'tags', 'files'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment view count
        $journal->increment('views_count');

        // Get related journals (same tags)
        $relatedJournals = Journal::published()
            ->whereHas('tags', function ($query) use ($journal) {
                $query->whereIn('tags.id', $journal->tags->pluck('id'));
            })
            ->where('id', '!=', $journal->id)
            ->limit(3)
            ->get();

        return view('pages.journal-show', compact('journal', 'relatedJournals'));
    }
}