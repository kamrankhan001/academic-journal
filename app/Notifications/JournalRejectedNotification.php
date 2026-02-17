<?php

namespace App\Notifications;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JournalRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Journal $journal,
        public ?string $rejection_reason = null
    ) {
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
            ->subject('Journal Submission Update: ' . $this->journal->title)
            ->view('emails.notifications.journal-rejected', [
                'journal' => $this->journal,
                'rejection_reason' => $this->rejection_reason
            ]);
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        $data = [
            'type' => 'journal_rejected',
            'journal_id' => $this->journal->id,
            'journal_title' => $this->journal->title,
            'journal_slug' => $this->journal->slug,
            'message' => 'Your journal "' . $this->journal->title . '" has been reviewed.',
            'icon' => 'fa-regular fa-circle-xmark',
            'icon_bg' => 'bg-red-100',
            'icon_color' => 'text-red-700',
            'action_url' => route('author.journals.show', $this->journal->id),
            'action_text' => 'View Details',
            'created_at' => now()->toDateTimeString(),
        ];

        if ($this->rejection_reason) {
            $data['rejection_reason'] = $this->rejection_reason;
        }

        return $data;
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
            'rejection_reason' => $this->rejection_reason,
            'type' => 'journal_rejected',
        ];
    }
}