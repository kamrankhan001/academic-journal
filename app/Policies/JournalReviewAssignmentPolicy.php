<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JournalReviewAssignment;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalReviewAssignmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the assignment.
     */
    public function view(User $user, JournalReviewAssignment $assignment)
    {
        return $user->reviewerProfile && $user->reviewerProfile->id === $assignment->reviewer_id;
    }

    /**
     * Determine whether the user can update the assignment.
     */
    public function update(User $user, JournalReviewAssignment $assignment)
    {
        return $user->reviewerProfile && 
               $user->reviewerProfile->id === $assignment->reviewer_id &&
               in_array($assignment->status, ['pending', 'accepted', 'in_progress']);
    }

    /**
     * Determine whether the user can review the assignment.
     */
    public function review(User $user, JournalReviewAssignment $assignment)
    {
        return $user->reviewerProfile && 
               $user->reviewerProfile->id === $assignment->reviewer_id &&
               in_array($assignment->status, ['accepted', 'in_progress']);
    }
}