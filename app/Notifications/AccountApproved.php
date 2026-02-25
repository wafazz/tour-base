<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountApproved extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $panel = $notifiable->role === 'agency' ? 'agency' : 'guide';

        return (new MailMessage)
            ->subject('Account Approved — Tour Base')
            ->greeting("Hello {$notifiable->name}!")
            ->line('Your account has been approved. You can now log in and start using Tour Base.')
            ->action('Login Now', url("/{$panel}/login"))
            ->line('Welcome aboard!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Account Approved',
            'body' => 'Your account has been approved. You can now access the platform.',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success',
        ];
    }
}
