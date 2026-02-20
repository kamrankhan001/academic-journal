<?php

namespace App\Notifications;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JournalRevisionRequiredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Journal $journal,
        public ?string $revision_notes = null
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
            ->subject('Revision Required: ' . $this->journal->title)
            ->view('emails.notifications.journal-revision-required', [
                'journal' => $this->journal,
                'revision_notes' => $this->revision_notes
            ]);
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        $data = [
            'type' => 'journal_revision_required',
            'journal_id' => $this->journal->id,
            'journal_title' => $this->journal->title,
            'journal_slug' => $this->journal->slug,
            'tracking_id' => $this->journal->tracking_id,
            'message' => 'Your journal "' . $this->journal->title . '" requires revisions.',
            'icon' => 'fa-regular fa-pen-to-square',
            'icon_bg' => 'bg-orange-100',
            'icon_color' => 'text-orange-700',
            'action_url' => route('author.journals.edit', $this->journal->id),
            'action_text' => 'Revise Now',
            'created_at' => now()->toDateTimeString(),
        ];

        if ($this->revision_notes) {
            $data['revision_notes'] = $this->revision_notes;
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
            'revision_notes' => $this->revision_notes,
            'type' => 'journal_revision_required',
        ];
    }
}