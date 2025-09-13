<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserCredentials extends Notification
{
    use Queueable;

    private $password;
    private $role;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $password, string $role)
    {
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $roleDisplay = ucfirst(str_replace('_', ' ', $this->role));

        return (new MailMessage)
            ->subject('Your Admin Account - Winners Chapel International Newport')
            ->greeting('Hello ' . $notifiable->firstname . '!')
            ->line('An admin account has been created for you at Winners Chapel International Newport.')
            ->line('**Login Details:**')
            ->line('Email: ' . $notifiable->email)
            ->line('Password: ' . $this->password)
            ->line('Role: ' . $roleDisplay)
            ->line('Please login and change your password immediately for security.')
            ->action('Login to Admin Panel', url('/login'))
            ->line('If you did not expect this account, please contact the administrator.')
            ->salutation('Blessings, The WCI Newport Admin Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
