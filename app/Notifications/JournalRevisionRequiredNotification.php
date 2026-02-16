<?php

namespace App\Notifications;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class JournalRevisionRequiredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Journal $journal, 
        public ?string $revision_notes = null
    ) {}

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
        $journalUrl = route('author.journals.show', $this->journal->id);
        $editUrl = route('author.journals.edit', $this->journal->id);
        $authorName = $this->journal->author->name;
        $journalTitle = $this->journal->title;

        $mail = (new MailMessage)
            ->subject('Revision Required: ' . $journalTitle)
            ->greeting('Hello ' . $authorName . '!')
            ->line(new HtmlString('<h2 style="color: #f97316; margin-bottom: 20px;">Revision Required for Your Journal</h2>'))
            ->line(new HtmlString('<div style="background-color: #fff7ed; padding: 20px; border-radius: 10px; margin: 20px 0;">'))
            ->line(new HtmlString('<strong style="font-size: 16px;">Journal:</strong> ' . $journalTitle))
            ->line(new HtmlString('<strong style="font-size: 16px;">Status:</strong> <span style="color: #f97316;">Revision Required</span>'))
            ->line(new HtmlString('</div>'));

        if ($this->revision_notes) {
            $mail->line(new HtmlString('<h3 style="margin: 20px 0 10px;">Reviewer Comments:</h3>'))
                ->line(new HtmlString('<div style="background-color: #fef3c7; padding: 20px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #f97316;">'))
                ->line(new HtmlString(nl2br(e($this->revision_notes))))
                ->line(new HtmlString('</div>'));
        } else {
            $mail->line('Our reviewers have provided feedback that requires your attention.')
                ->line('Please log in to your account to view the detailed reviewer comments.');
        }

        $mail->line('Please make the necessary revisions and resubmit your journal at your earliest convenience.')
            ->line(new HtmlString('<div style="text-align: center; margin: 30px 0;">'))
            ->line(new HtmlString('<a href="' . $editUrl . '" style="display: inline-block; background-color: #f97316; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; margin-right: 10px;">Revise Journal</a>'))
            ->line(new HtmlString('<a href="' . $journalUrl . '" style="display: inline-block; background-color: #6b7280; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold;">View Details</a>'))
            ->line(new HtmlString('</div>'))
            ->line('If you have any questions about the revision requirements, please don\'t hesitate to contact our editorial office.')
            ->line('Thank you for your contribution to ' . config('app.name') . '.')
            ->line('Best regards,')
            ->line(config('app.name') . ' Editorial Team')
            ->salutation(' ');

        return $mail;
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        $message = 'Your journal "' . $this->journal->title . '" requires revisions.';
        
        $fullMessage = 'Your journal requires revisions before it can be accepted for publication.';
        
        if ($this->revision_notes) {
            $fullMessage .= ' Please review the reviewer comments.';
        } else {
            $fullMessage .= ' Please check the reviewer comments in your dashboard.';
        }

        $data = [
            'type' => 'journal_revision_required',
            'journal_id' => $this->journal->id,
            'journal_title' => $this->journal->title,
            'journal_slug' => $this->journal->slug,
            'message' => $message,
            'full_message' => $fullMessage,
            'icon' => 'fa-regular fa-pen-to-square',
            'icon_bg' => 'bg-orange-100',
            'icon_color' => 'text-orange-600',
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