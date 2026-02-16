<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'icon',
        'action_url',
        'action_text',
        'target_roles',
        'created_by',
        'scheduled_at',
        'sent_at',
    ];

    protected $casts = [
        'target_roles' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getIconAttribute($value)
    {
        return $value ?? $this->getDefaultIcon();
    }

    protected function getDefaultIcon()
    {
        return match($this->type) {
            'success' => 'fa-regular fa-circle-check',
            'warning' => 'fa-regular fa-triangle-exclamation',
            'danger' => 'fa-regular fa-circle-exclamation',
            default => 'fa-regular fa-bullhorn',
        };
    }

    public function getIconBgAttribute()
    {
        return match($this->type) {
            'success' => 'bg-green-100',
            'warning' => 'bg-yellow-100',
            'danger' => 'bg-red-100',
            default => 'bg-purple-100',
        };
    }

    public function getIconColorAttribute()
    {
        return match($this->type) {
            'success' => 'text-green-600',
            'warning' => 'text-yellow-600',
            'danger' => 'text-red-600',
            default => 'text-purple-600',
        };
    }
}