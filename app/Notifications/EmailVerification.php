<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerification extends Notification
{
    use Queueable;

    protected $url;

    /**
     * Create a new notification instance.
     */
    public function __construct($url)
    {
        //
        $this->url = $url;
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
        return (new MailMessage)
            ->subject('Verify Email Address')
            ->greeting("Hello {$notifiable->first_name}")
            ->line("Thank you for creating an account with {$_ENV['APP_NAME']} ")
            ->line("To complete your registration, please verify your email address by clicking the link below:")
            ->action('Verify Email', $this->url)
            ->line("If you didn't create an account, no further action is required");
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
