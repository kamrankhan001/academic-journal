<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    protected $fillable = [
        'title',
        'volume_number',
        'description',
        'cover_image',
        'year',
        'status',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'year' => 'integer',
        'volume_number' => 'integer'
    ];

    // Relationships
    public function issues()
    {
        return $this->hasMany(Issue::class)->orderBy('issue_number');
    }

    public function journals()
    {
        return $this->hasManyThrough(Journal::class, Issue::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    // Accessors
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'published' => '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Published</span>',
            'in_progress' => '<span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">In Progress</span>',
            'planned' => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Planned</span>',
            default => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">' . ucfirst($this->status) . '</span>'
        };
    }
}