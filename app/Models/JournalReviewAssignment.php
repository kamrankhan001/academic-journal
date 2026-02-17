<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalReviewAssignment extends Model
{
    protected $table = 'journal_review_assignments';

    protected $fillable = [
        'journal_id',
        'reviewer_id',
        'assigned_by',
        'review_type',
        'status',
        'comments_to_editor',
        'comments_to_author',
        'recommendation',
        'originality_score',
        'methodology_score',
        'presentation_score',
        'overall_score',
        'assigned_at',
        'responded_at',
        'due_date',
        'completed_at',
        'reminder_sent_at',
        'decline_reason',
        'notes'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'responded_at' => 'datetime',
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'originality_score' => 'integer',
        'methodology_score' => 'integer',
        'presentation_score' => 'integer',
        'overall_score' => 'integer'
    ];

    // Relationships
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(Reviewer::class);
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'accepted', 'in_progress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->whereIn('status', ['pending', 'accepted', 'in_progress'])
            ->where('due_date', '<', now());
    }

    // Accessors
    public function getIsOverdueAttribute()
    {
        return in_array($this->status, ['pending', 'accepted', 'in_progress']) 
            && $this->due_date 
            && $this->due_date->isPast();
    }

    public function getAverageScoreAttribute()
    {
        $scores = array_filter([
            $this->originality_score,
            $this->methodology_score,
            $this->presentation_score,
            $this->overall_score
        ]);
        
        return count($scores) > 0 ? round(array_sum($scores) / count($scores), 2) : null;
    }

    // Methods
    public function accept($dueDate = null)
    {
        $this->update([
            'status' => 'accepted',
            'responded_at' => now(),
            'due_date' => $dueDate ?? now()->addDays(14)
        ]);
    }

    public function decline($reason = null)
    {
        $this->update([
            'status' => 'declined',
            'responded_at' => now(),
            'decline_reason' => $reason
        ]);
    }

    public function complete(array $reviewData)
    {
        $this->update(array_merge($reviewData, [
            'status' => 'completed',
            'completed_at' => now()
        ]));

        // Update reviewer's stats
        $this->reviewer->increment('review_count');
        $this->reviewer->updateRating();
    }
}