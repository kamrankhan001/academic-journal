<?php

namespace App\Notifications;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JournalApprovedNotification extends Notification implements ShouldQueue
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
            ->subject('Journal Approved: ' . $this->journal->title)
            ->view('emails.notifications.journal-approved', [
                'journal' => $this->journal
            ]);
    }


    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        $volume = 'Vol. ' . date('Y') . ', Issue ' . date('m');

        return [
            'type' => 'journal_approved',
            'journal_id' => $this->journal->id,
            'journal_title' => $this->journal->title,
            'journal_slug' => $this->journal->slug,
            'message' => 'Your journal "' . $this->journal->title . '" has been approved.',
            'icon' => 'fa-regular fa-circle-check',
            'icon_bg' => 'bg-green-100',
            'icon_color' => 'text-green-700',
            'action_url' => route('author.journals.show', $this->journal->id),
            'action_text' => 'View Journal',
            'volume' => $volume,
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
            'type' => 'journal_approved',
        ];
    }
}