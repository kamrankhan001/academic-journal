<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnnouncementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $title,
        public string $message,
        public ?string $action_url = null,
        public ?int $announcement_id = null,
        public string $type = 'info'
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        // Add mail channel if user wants email notifications
        if ($notifiable->notification_preferences['email'] ?? true) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject($this->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->message);

        if ($this->action_url) {
            $mail->action('View Details', $this->action_url);
        }

        $mail->line('Thank you for using our application!');

        return $mail;
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): array
    {
        $iconMap = [
            'info' => 'fa-regular fa-bullhorn',
            'success' => 'fa-regular fa-circle-check',
            'warning' => 'fa-regular fa-triangle-exclamation',
            'danger' => 'fa-regular fa-circle-exclamation',
        ];

        $iconBgMap = [
            'info' => 'bg-purple-100',
            'success' => 'bg-green-100',
            'warning' => 'bg-yellow-100',
            'danger' => 'bg-red-100',
        ];

        $iconColorMap = [
            'info' => 'text-purple-600',
            'success' => 'text-green-600',
            'warning' => 'text-yellow-600',
            'danger' => 'text-red-600',
        ];

        return [
            'type' => 'announcement',
            'announcement_id' => $this->announcement_id,
            'title' => $this->title,
            'message' => $this->message,
            'action_url' => $this->action_url,
            'icon' => $iconMap[$this->type] ?? 'fa-regular fa-bullhorn',
            'icon_bg' => $iconBgMap[$this->type] ?? 'bg-purple-100',
            'icon_color' => $iconColorMap[$this->type] ?? 'text-purple-600',
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
            'title' => $this->title,
            'message' => $this->message,
            'action_url' => $this->action_url,
            'type' => $this->type,
        ];
    }
}