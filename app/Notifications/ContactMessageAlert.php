<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactMessageAlert extends Notification
{
    use Queueable;

    public $contactMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct($contactMessage)
    {
        $this->contactMessage = $contactMessage;
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
            ->subject('New Contact Form Submission - ' . $this->contactMessage->subject)
            ->view('emails.contact-message', [
                'contactData' => [
                    'name' => $this->contactMessage->name,
                    'email' => $this->contactMessage->email,
                    'phone' => $this->contactMessage->phone,
                    'category' => $this->contactMessage->category,
                    'subject' => $this->contactMessage->subject,
                    'message' => $this->contactMessage->message,
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
            'contact_message_id' => $this->contactMessage->id,
            'name' => $this->contactMessage->name,
            'email' => $this->contactMessage->email,
            'subject' => $this->contactMessage->subject,
        ];
    }
}
