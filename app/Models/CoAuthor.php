<?php
// app/Models/CoAuthor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoAuthor extends Model
{
    protected $fillable = [
        'journal_id',
        'name',
        'email',
        'institution',
        'orcid_id',
        'order'
    ];

    protected $casts = [
        'order' => 'integer'
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}