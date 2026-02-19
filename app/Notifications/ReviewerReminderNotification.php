<?php

namespace App\Notifications;

use App\Models\JournalReviewAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewerReminderNotification extends Notification implements ShouldQueue
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
            ->subject('Reminder: Review Due Soon - ' . $this->assignment->journal->title)
            ->view('emails.notifications.reviewer-reminder', [
                'assignment' => $this->assignment
            ]);
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        $isOverdue = $this->assignment->due_date->isPast();
        
        return [
            'type' => 'review_reminder',
            'assignment_id' => $this->assignment->id,
            'journal_id' => $this->assignment->journal->id,
            'journal_title' => $this->assignment->journal->title,
            'due_date' => $this->assignment->due_date->format('M d, Y'),
            'is_overdue' => $isOverdue,
            'message' => $isOverdue 
                ? 'Your review for "' . $this->assignment->journal->title . '" is overdue.'
                : 'Reminder: Your review for "' . $this->assignment->journal->title . '" is due soon.',
            'icon' => $isOverdue ? 'fa-regular fa-clock' : 'fa-regular fa-bell',
            'icon_bg' => $isOverdue ? 'bg-red-100' : 'bg-yellow-100',
            'icon_color' => $isOverdue ? 'text-red-700' : 'text-yellow-700',
            'action_url' => route('reviewer.assignments.review', $this->assignment->id),
            'action_text' => 'Complete Review',
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
            'type' => 'review_reminder',
        ];
    }
}