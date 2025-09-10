<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestimonyAlert extends Notification
{
    use Queueable;

    public $testimony;

    /**
     * Create a new notification instance.
     */
    public function __construct($testimony)
    {
        $this->testimony = $testimony;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Testimony Submission - ' . $this->testimony->title)
            ->view('emails.testimony-alert', [
                'testimonyData' => [
                    'title' => $this->testimony->title,
                    'author' => $this->testimony->author,
                    'email' => $this->testimony->email,
                    'phone' => $this->testimony->phone,
                    'result_category' => $this->testimony->result_category,
                    'testimony_date' => $this->testimony->testimony_date,
                    'engagements' => $this->testimony->engagements,
                    'content' => $this->testimony->content,
                    'publish_permission' => $this->testimony->publish_permission,
                    'status' => $this->testimony->status,
                    'submitted_at' => $this->testimony->created_at,
                ]
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'testimony_id' => $this->testimony->id,
            'title' => $this->testimony->title,
            'author' => $this->testimony->author,
            'email' => $this->testimony->email,
            'result_category' => $this->testimony->result_category,
        ];
    }
}
