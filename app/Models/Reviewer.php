<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Reviewer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'reviewer';

    protected $fillable = [
        'user_id',
        'institution',
        'department',
        'orcid_id',
        'bio',
        'expertise_areas',
        'academic_degree',
        'country',
        'avatar',
        'review_count',
        'average_rating',
        'status',
        'email_verified_at'
    ];

    protected $casts = [
        'review_count' => 'integer',
        'average_rating' => 'decimal:2',
        'expertise_areas' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function reviewAssignments()
    {
        return $this->hasMany(JournalReviewAssignment::class);
    }

    public function completedReviews()
    {
        return $this->hasMany(JournalReviewAssignment::class)
            ->where('status', 'completed');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByExpertise($query, $area)
    {
        return $query->where('expertise_areas', 'LIKE', "%{$area}%");
    }

    // Accessors
    public function getExpertiseAreasListAttribute()
    {
        return is_array($this->expertise_areas) 
            ? implode(', ', $this->expertise_areas) 
            : $this->expertise_areas;
    }

    public function getCompletionRateAttribute()
    {
        if ($this->review_count === 0) {
            return 0;
        }
        
        $completed = $this->completedReviews()->count();
        return round(($completed / $this->review_count) * 100);
    }

    // Methods
    public function isAvailableForReview()
    {
        // Check if reviewer has less than 3 pending assignments
        $pendingCount = $this->reviewAssignments()
            ->whereIn('status', ['pending', 'accepted', 'in_progress'])
            ->count();
            
        return $this->status === 'active' && $pendingCount < 3;
    }

    public function updateRating()
    {
        $avg = $this->completedReviews()
            ->whereNotNull('overall_score')
            ->avg('overall_score');
            
        $this->update(['average_rating' => $avg]);
    }
}