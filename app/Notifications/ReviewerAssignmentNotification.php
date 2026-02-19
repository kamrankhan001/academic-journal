<?php

namespace App\Notifications;

use App\Models\JournalReviewAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewerAssignmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public JournalReviewAssignment $assignment)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Review Invitation: ' . $this->assignment->journal->title)
            ->view('emails.notifications.reviewer-assignment', [
                'assignment' => $this->assignment
            ]);
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'review_invitation',
            'assignment_id' => $this->assignment->id,
            'journal_id' => $this->assignment->journal->id,
            'journal_title' => $this->assignment->journal->title,
            'journal_slug' => $this->assignment->journal->slug,
            'due_date' => $this->assignment->due_date->format('M d, Y'),
            'message' => 'You have been invited to review "' . $this->assignment->journal->title . '"',
            'icon' => 'fa-regular fa-envelope',
            'icon_bg' => 'bg-blue-100',
            'icon_color' => 'text-blue-700',
            'action_url' => route('reviewer.assignments.show', $this->assignment->id),
            'action_text' => 'View Invitation',
            'created_at' => now()->toDateTimeString(),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'assignment_id' => $this->assignment->id,
            'journal_id' => $this->assignment->journal->id,
            'journal_title' => $this->assignment->journal->title,
            'due_date' => $this->assignment->due_date,
            'type' => 'review_invitation',
        ];
    }
}