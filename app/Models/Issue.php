<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Issue extends Model
{
    protected $fillable = [
        'volume_id',
        'title',
        'issue_number',
        'description',
        'cover_image',
        'issue_type',
        'publication_date',
        'status',
        'published_at'
    ];

    protected $casts = [
        'publication_date' => 'date',
        'published_at' => 'datetime',
        'issue_number' => 'integer'
    ];

    // Relationships
    public function volume()
    {
        return $this->belongsTo(Volume::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class)
            ->where('status', 'published')
            ->orderBy('page_start');
    }

    // Accessors
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'published' => '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Published</span>',
            'in_progress' => '<span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">In Progress</span>',
            'planned' => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Planned</span>',
            default => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">' . ucfirst($this->status) . '</span>'
        };
    }

    public function getTypeBadgeAttribute()
    {
        return match($this->issue_type) {
            'regular' => '<span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Regular</span>',
            'special' => '<span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Special</span>',
            'supplement' => '<span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Supplement</span>',
            default => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">' . ucfirst($this->issue_type) . '</span>'
        };
    }
}