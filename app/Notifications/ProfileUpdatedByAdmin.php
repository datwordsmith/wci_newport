<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileUpdatedByAdmin extends Notification
{
    use Queueable;

    private $updatedFields;
    private $newPassword;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $updatedFields, ?string $newPassword = null)
    {
        $this->updatedFields = $updatedFields;
        $this->newPassword = $newPassword;
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
        $message = (new MailMessage)
            ->subject('Your Account Has Been Updated - Winners Chapel International Newport')
            ->greeting('Hello ' . $notifiable->firstname . '!')
            ->line('An administrator has updated your account information at Winners Chapel International Newport.');

        // Show what was updated
        if (!empty($this->updatedFields)) {
            $message->line('**Updated Information:**');

            foreach ($this->updatedFields as $field => $value) {
                switch ($field) {
                    case 'firstname':
                        $message->line('First Name: ' . $value);
                        break;
                    case 'surname':
                        $message->line('Surname: ' . $value);
                        break;
                    case 'role':
                        $message->line('Role: ' . ucfirst(str_replace('_', ' ', $value)));
                        break;
                }
            }
        }

        // If password was changed
        if ($this->newPassword) {
            $message->line('**New Password:** ' . $this->newPassword);
            $message->line('Please login and change your password immediately for security.');
        }

        $message->action('Login to Admin Panel', url('/login'))
            ->line('If you have any questions about these changes, please contact the administrator.')
            ->salutation('Blessings, The WCI Newport Admin Team');

        return $message;
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
