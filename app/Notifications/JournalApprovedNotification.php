<?php

namespace App\Notifications;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class JournalApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Journal $journal)
    {
        //
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
        $volume = 'Vol. ' . date('Y') . ', Issue ' . date('m');
        $journalUrl = route('author.journals.show', $this->journal->id);
        $journalTitle = $this->journal->title;
        $authorName = $this->journal->author->name;
        $publishedDate = $this->journal->published_at ? $this->journal->published_at->format('F j, Y') : 'soon';

        return (new MailMessage)
            ->subject('Journal Approved: ' . $journalTitle)
            ->greeting('Hello ' . $authorName . '!')
            ->line(new HtmlString('<h2 style="color: #10b981; margin-bottom: 20px;">Congratulations! Your journal has been approved.</h2>'))
            ->line(new HtmlString('<strong>Journal Title:</strong> ' . $journalTitle))
            ->line(new HtmlString('<strong>Publication:</strong> ' . $volume))
            ->line(new HtmlString('<strong>Expected Publication Date:</strong> ' . $publishedDate))
            ->line('Your journal has been reviewed and approved by our editorial team. It will be published in the upcoming issue of our journal.')
            ->line('You can view your published journal and share it with your network using the button below.')
            ->action('View Published Journal', $journalUrl)
            ->line('Thank you for contributing to our academic community!')
            ->line(new HtmlString('<br>'))
            ->line('Best regards,')
            ->line(config('app.name') . ' Editorial Team')
            ->salutation(' ');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        $volume = 'Vol. ' . date('Y') . ', Issue ' . date('m');
        $publishedDate = $this->journal->published_at ? $this->journal->published_at->format('M d, Y') : 'soon';

        return [
            'type' => 'journal_approved',
            'journal_id' => $this->journal->id,
            'journal_title' => $this->journal->title,
            'journal_slug' => $this->journal->slug,
            'message' => 'Your journal "' . $this->journal->title . '" has been approved and will be published in ' . $volume . '.',
            'full_message' => 'Congratulations! Your journal has been approved by our editorial team. It will be published in ' . $volume . ' and available to readers worldwide.',
            'icon' => 'fa-regular fa-circle-check',
            'icon_bg' => 'bg-green-100',
            'icon_color' => 'text-green-600',
            'action_url' => route('author.journals.show', $this->journal->id),
            'action_text' => 'View Journal',
            'volume' => $volume,
            'published_date' => $publishedDate,
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