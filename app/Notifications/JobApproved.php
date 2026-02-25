<?php

namespace App\Notifications;

use App\Models\TourJob;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobApproved extends Notification
{
    use Queueable;

    public function __construct(public TourJob $tourJob) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Job Approved — Tour Base')
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your job posting \"{$this->tourJob->title}\" has been approved and is now live.")
            ->action('View My Jobs', url('/agency/tour-jobs'))
            ->line('Guides can now apply for this position.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Job Approved',
            'body' => "Your job \"{$this->tourJob->title}\" is now live.",
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success',
        ];
    }
}
