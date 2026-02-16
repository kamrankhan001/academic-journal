<?php

namespace App\Notifications;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class JournalSubmittedNotification extends Notification implements ShouldQueue
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
        $adminUrl = route('admin.journals.show', $this->journal->id);
        $authorName = $this->journal->author->name;
        $authorEmail = $this->journal->author->email;
        $journalTitle = $this->journal->title;
        $submissionDate = $this->journal->created_at->format('F j, Y \a\t g:i A');
        $trackingId = 'JRN-' . str_pad($this->journal->id, 6, '0', STR_PAD_LEFT);

        return (new MailMessage)
            ->subject('📥 New Journal Submission: ' . $journalTitle)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line(new HtmlString('<h2 style="color: #3b82f6; margin-bottom: 20px;">New Journal Submission Received</h2>'))
            ->line(new HtmlString('<div style="background-color: #eff6ff; padding: 20px; border-radius: 10px; margin: 20px 0;">'))
            ->line(new HtmlString('<strong style="font-size: 16px;">Journal Title:</strong> ' . $journalTitle))
            ->line(new HtmlString('<strong style="font-size: 16px;">Tracking ID:</strong> ' . $trackingId))
            ->line(new HtmlString('<strong style="font-size: 16px;">Author:</strong> ' . $authorName . ' (' . $authorEmail . ')'))
            ->line(new HtmlString('<strong style="font-size: 16px;">Submission Date:</strong> ' . $submissionDate))
            ->line(new HtmlString('<strong style="font-size: 16px;">Status:</strong> <span style="color: #f59e0b;">Pending Review</span>'))
            ->line(new HtmlString('</div>'))
            ->line('A new journal has been submitted and requires your attention.')
            ->line('**Submission Details:**')
            ->line(new HtmlString('<ul style="margin: 15px 0; padding-left: 20px;">'))
            ->line(new HtmlString('<li><strong>Abstract:</strong> ' . Str::limit($this->journal->abstract, 200) . '</li>'))
            ->line(new HtmlString('<li><strong>Tags:</strong> ' . ($this->journal->tags->pluck('name')->join(', ') ?: 'None') . '</li>'))
            ->line(new HtmlString('<li><strong>Files:</strong> ' . $this->journal->files->count() . ' file(s) attached</li>'))
            ->line(new HtmlString('</ul>'))
            ->line('Please review this submission and take appropriate action:')
            ->line(new HtmlString('<div style="text-align: center; margin: 30px 0;">'))
            ->line(new HtmlString('<a href="' . $adminUrl . '" style="display: inline-block; background-color: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; margin-right: 10px;">🔍 Review Submission</a>'))
            ->line(new HtmlString('</div>'))
            ->line('Quick Actions:')
            ->line(new HtmlString('<div style="margin: 15px 0;">'))
            ->line(new HtmlString('<span style="display: inline-block; background-color: #10b981; color: white; padding: 5px 15px; border-radius: 20px; margin-right: 10px; font-size: 12px;">✓ Approve</span>'))
            ->line(new HtmlString('<span style="display: inline-block; background-color: #8b5cf6; color: white; padding: 5px 15px; border-radius: 20px; margin-right: 10px; font-size: 12px;">📋 Send to Review</span>'))
            ->line(new HtmlString('<span style="display: inline-block; background-color: #f97316; color: white; padding: 5px 15px; border-radius: 20px; margin-right: 10px; font-size: 12px;">✏️ Request Revision</span>'))
            ->line(new HtmlString('<span style="display: inline-block; background-color: #ef4444; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px;">✕ Reject</span>'))
            ->line(new HtmlString('</div>'))
            ->line('Thank you for your prompt attention to this submission.')
            ->line('Best regards,')
            ->line(config('app.name') . ' System')
            ->salutation(' ');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        $trackingId = 'JRN-' . str_pad($this->journal->id, 6, '0', STR_PAD_LEFT);
        $authorName = $this->journal->author->name;
        $fileCount = $this->journal->files->count();

        return [
            'type' => 'admin_journal_submitted',
            'journal_id' => $this->journal->id,
            'journal_title' => $this->journal->title,
            'journal_slug' => $this->journal->slug,
            'tracking_id' => $trackingId,
            'author_name' => $authorName,
            'author_id' => $this->journal->author->id,
            'file_count' => $fileCount,
            'message' => 'New journal submission: "' . $this->journal->title . '"',
            'full_message' => $authorName . ' has submitted a new journal: "' . $this->journal->title . '". Please review the submission.',
            'icon' => 'fa-regular fa-file-lines',
            'icon_bg' => 'bg-blue-100',
            'icon_color' => 'text-blue-600',
            'action_url' => route('admin.journals.show', $this->journal->id),
            'action_text' => 'Review Submission',
            'submission_date' => $this->journal->created_at->format('M d, Y'),
            'created_at' => now()->toDateTimeString(),
            'priority' => 'high',
            'metadata' => [
                'has_abstract' => !empty($this->journal->abstract),
                'has_files' => $fileCount > 0,
                'tags_count' => $this->journal->tags->count(),
            ],
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
            'author_id' => $this->journal->author->id,
            'author_name' => $this->journal->author->name,
            'type' => 'admin_journal_submitted',
        ];
    }
}