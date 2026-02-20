<?php

namespace App\Notifications;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JournalSubmittedNotification extends Notification implements ShouldQueue
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
            ->subject('New Journal Submission: ' . $this->journal->title)
            ->view('emails.notifications.journal-submitted', [
                'journal' => $this->journal
            ]);
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'admin_journal_submitted',
            'journal_id' => $this->journal->id,
            'journal_title' => $this->journal->title,
            'journal_slug' => $this->journal->slug,
            'tracking_id' => $this->journal->tracking_id,
            'author_name' => $this->journal->author->name,
            'message' => 'New journal submission: "' . $this->journal->title . '"',
            'icon' => 'fa-regular fa-file-lines',
            'icon_bg' => 'bg-amber-100',
            'icon_color' => 'text-amber-700',
            'action_url' => route('admin.journals.show', $this->journal->id),
            'action_text' => 'Review Submission',
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
            'author_name' => $this->journal->author->name,
            'type' => 'admin_journal_submitted',
        ];
    }
}