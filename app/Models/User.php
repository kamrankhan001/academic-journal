<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($user) {
            if ($user->wasChanged('email_verified_at') && $user->email_verified_at) {
                // When email is verified, also verify newsletter subscription
                \App\Http\Controllers\NewsletterController::verifyUserSubscription($user);
            }
        });
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function reviewerProfile()
    {
        return $this->hasOne(Reviewer::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function coAuthoredJournals()
    {
        return $this->belongsToMany(Journal::class, 'co_authors', 'email', 'journal_id', 'email', 'id')
            ->where('co_authors.email', DB::raw('users.email'));
    }
}
