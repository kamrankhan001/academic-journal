<?php

namespace App\Notifications;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JournalUnderReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Journal $journal)
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
            ->subject('Journal Under Review: ' . $this->journal->title)
            ->view('emails.notifications.journal-under-review', [
                'journal' => $this->journal
            ]);
    }


    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'journal_under_review',
            'journal_id' => $this->journal->id,
            'journal_title' => $this->journal->title,
            'journal_slug' => $this->journal->slug,
            'tracking_id' => $this->journal->tracking_id,
            'message' => 'Your journal "' . $this->journal->title . '" is now under review.',
            'icon' => 'fa-regular fa-clock',
            'icon_bg' => 'bg-purple-100',
            'icon_color' => 'text-purple-700',
            'action_url' => route('author.journals.show', $this->journal->id),
            'action_text' => 'Track Progress',
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
            'journal_id' => $this->journal->id,
            'journal_title' => $this->journal->title,
            'type' => 'journal_under_review',
        ];
    }
}