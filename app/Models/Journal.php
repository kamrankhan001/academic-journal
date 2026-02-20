<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Journal extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'abstract',
        'slug',
        'status',
        'views_count',
        'submitted_at',
        'published_at',
        'volume_id',
        'issue_id',
        'review_type',
        'decision',
        'decision_communicated_at',
        'page_start',
        'page_end',
        'doi',
        'tracking_id'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'published_at' => 'datetime',
        'views_count' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($journal) {
            if (!$journal->slug) {
                $journal->slug = Str::slug($journal->title) . '-' . uniqid();
            }

            // Generate tracking ID if not set
            if (!$journal->tracking_id) {
                $journal->tracking_id = self::generateTrackingId();
            }
        });
    }

    /**
     * Generate a unique tracking ID for the journal
     * Format: JMSA-YYYY-XXXXX (JMSA = Journal of Medical and Surgical Allied)
     */
    public static function generateTrackingId()
    {
        $prefix = 'JMSA';
        $year = date('Y');
        $lastJournal = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastJournal && preg_match('/JMSA-' . $year . '-(\d+)/', $lastJournal->tracking_id, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }
        
        // Format with leading zeros (5 digits)
        $formattedNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        
        return "{$prefix}-{$year}-{$formattedNumber}";
    }

    // Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coAuthors()
    {
        return $this->hasMany(CoAuthor::class)->orderBy('order');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function files()
    {
        return $this->hasMany(JournalFile::class);
    }

    public function manuscript()
    {
        return $this->hasOne(JournalFile::class)->where('file_type', 'manuscript');
    }

    public function coverImage()
    {
        return $this->hasOne(JournalFile::class)->where('file_type', 'cover_image');
    }

    public function supplementaryFiles()
    {
        return $this->hasMany(JournalFile::class)->where('file_type', 'supplementary')->orderBy('order');
    }

    public function volume()
    {
        return $this->belongsTo(Volume::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function reviewAssignments()
    {
        return $this->hasMany(JournalReviewAssignment::class);
    }

    public function reviewers()
    {
        return $this->belongsToMany(Reviewer::class, 'journal_review_assignments')
            ->withPivot(['status', 'recommendation', 'completed_at'])
            ->withTimestamps();
    }

    // Add these methods
    public function assignReviewer($reviewerId, $assignedBy, $reviewType = 'single_blind', $dueDate = null)
    {
        return $this->reviewAssignments()->create([
            'reviewer_id' => $reviewerId,
            'assigned_by' => $assignedBy,
            'review_type' => $reviewType,
            'assigned_at' => now(),
            'due_date' => $dueDate ?? now()->addDays(14),
            'status' => 'pending'
        ]);
    }

    public function getCurrentStatusAttribute()
    {
        if ($this->status === 'published') {
            return 'Published';
        }

        $pendingReviews = $this->reviewAssignments()
            ->whereIn('status', ['pending', 'accepted', 'in_progress'])
            ->count();

        $completedReviews = $this->reviewAssignments()
            ->where('status', 'completed')
            ->count();

        if ($completedReviews >= 2) {
            return 'Review Complete';
        } elseif ($pendingReviews > 0) {
            return 'Under Review';
        } elseif ($this->status === 'submitted') {
            return 'Pending Assignment';
        }

        return ucfirst($this->status);
    }

    public function getDoiUrlAttribute()
    {
        return $this->doi ? "https://doi.org/{$this->doi}" : null;
    }

    // Helper methods
    public function incrementViews($request)
    {
        $this->increment('views_count');
    }

    public function getFileByType($type)
    {
        return $this->files()->where('file_type', $type)->first();
    }

    public function getCoverImageUrlAttribute()
    {
        $cover = $this->coverImage;
        return $cover ? asset('storage/' . $cover->file_path) : null;
    }

    public function getManuscriptUrlAttribute()
    {
        $manuscript = $this->manuscript;
        return $manuscript ? asset('storage/' . $manuscript->file_path) : null;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}