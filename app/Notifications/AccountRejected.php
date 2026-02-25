<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountRejected extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Account Registration Update — Tour Base')
            ->greeting("Hello {$notifiable->name},")
            ->line('Unfortunately, your account registration has been rejected.')
            ->line('If you believe this is an error, please contact our support team.')
            ->line('Thank you for your interest in Tour Base.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Account Rejected',
            'body' => 'Your account registration has been rejected. Please contact support for details.',
            'icon' => 'heroicon-o-x-circle',
            'color' => 'danger',
        ];
    }
}
