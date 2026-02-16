<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalFile extends Model
{
    protected $fillable = [
        'journal_id',
        'file_type',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'order'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'order' => 'integer'
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getSizeForHumansAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}