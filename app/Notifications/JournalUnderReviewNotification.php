<?php

namespace App\Notifications;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class JournalUnderReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Journal $journal) {}

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
        $authorName = $this->journal->author->name;
        $journalTitle = $this->journal->title;
        $submittedDate = $this->journal->created_at->format('M d, Y');
        $trackingId = 'JRN-' . str_pad($this->journal->id, 6, '0', STR_PAD_LEFT);

        return (new MailMessage)
            ->subject('🔍 Journal Under Review: ' . $journalTitle)
            ->greeting('Hello ' . $authorName . '!')
            ->line(new HtmlString('<h2 style="color: #8b5cf6; margin-bottom: 20px;">Your Journal is Now Under Review</h2>'))
            ->line(new HtmlString('<div style="background-color: #f5f3ff; padding: 20px; border-radius: 10px; margin: 20px 0;">'))
            ->line(new HtmlString('<strong style="font-size: 16px;">Journal:</strong> ' . $journalTitle))
            ->line(new HtmlString('<strong style="font-size: 16px;">Tracking ID:</strong> ' . $trackingId))
            ->line(new HtmlString('<strong style="font-size: 16px;">Submitted:</strong> ' . $submittedDate))
            ->line(new HtmlString('<strong style="font-size: 16px;">Current Status:</strong> <span style="color: #8b5cf6;">Peer Review</span>'))
            ->line(new HtmlString('</div>'))
            ->line('Good news! Your journal has passed the initial screening and has been sent for peer review.')
            ->line('The review process typically takes 2-4 weeks. Here\'s what you can expect:')
            ->line(new HtmlString('<div style="margin: 20px 0;">'))
            ->line(new HtmlString('<div style="display: flex; align-items: center; margin-bottom: 15px;">'))
            ->line(new HtmlString('<div style="width: 30px; height: 30px; background-color: #8b5cf6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-weight: bold;">1</div>'))
            ->line(new HtmlString('<div><strong>Reviewer Assignment</strong> - Reviewers are being assigned to evaluate your work</div>'))
            ->line(new HtmlString('</div>'))
            ->line(new HtmlString('<div style="display: flex; align-items: center; margin-bottom: 15px;">'))
            ->line(new HtmlString('<div style="width: 30px; height: 30px; background-color: #8b5cf6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-weight: bold;">2</div>'))
            ->line(new HtmlString('<div><strong>Review Process</strong> - Reviewers will evaluate your methodology, results, and conclusions</div>'))
            ->line(new HtmlString('</div>'))
            ->line(new HtmlString('<div style="display: flex; align-items: center;">'))
            ->line(new HtmlString('<div style="width: 30px; height: 30px; background-color: #8b5cf6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-weight: bold;">3</div>'))
            ->line(new HtmlString('<div><strong>Editor Decision</strong> - You\'ll receive feedback and a decision</div>'))
            ->line(new HtmlString('</div>'))
            ->line(new HtmlString('</div>'))
            ->line('You can check the review status anytime.')
            ->action('Check Review Status', $journalUrl)
            ->line('Thank you for your patience during the review process.')
            ->line('Best regards,')
            ->line(config('app.name') . ' Editorial Team')
            ->salutation(' ');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        $trackingId = 'JRN-' . str_pad($this->journal->id, 6, '0', STR_PAD_LEFT);

        return [
            'type' => 'journal_under_review',
            'journal_id' => $this->journal->id,
            'journal_title' => $this->journal->title,
            'journal_slug' => $this->journal->slug,
            'tracking_id' => $trackingId,
            'message' => 'Your journal "' . $this->journal->title . '" is now under review.',
            'full_message' => 'Your journal has passed initial screening and is now being reviewed by our editorial board. This process typically takes 2-4 weeks.',
            'icon' => 'fa-regular fa-clock',
            'icon_bg' => 'bg-purple-100',
            'icon_color' => 'text-purple-600',
            'action_url' => route('author.journals.show', $this->journal->id),
            'action_text' => 'Track Progress',
            'submission_date' => $this->journal->created_at->format('M d, Y'),
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