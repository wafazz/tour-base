<?php

namespace App\Notifications;

use App\Models\TourJob;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobRejected extends Notification
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
            ->subject('Job Posting Update — Tour Base')
            ->greeting("Hello {$notifiable->name},")
            ->line("Your job posting \"{$this->tourJob->title}\" has been rejected by the admin.")
            ->line('Please review the posting details and resubmit if needed.')
            ->action('View My Jobs', url('/agency/tour-jobs'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Job Rejected',
            'body' => "Your job \"{$this->tourJob->title}\" has been rejected.",
            'icon' => 'heroicon-o-x-circle',
            'color' => 'danger',
        ];
    }
}
