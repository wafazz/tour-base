<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplication extends Notification
{
    use Queueable;

    public function __construct(public Application $application) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $guideName = $this->application->guide->name;
        $jobTitle = $this->application->tourJob->title;

        return (new MailMessage)
            ->subject('New Application Received — Tour Base')
            ->greeting("Hello {$notifiable->name}!")
            ->line("{$guideName} has applied for your job posting \"{$jobTitle}\".")
            ->action('Review Applicants', url('/agency/tour-jobs/' . $this->application->tour_job_id))
            ->line('Log in to review the application.');
    }

    public function toArray(object $notifiable): array
    {
        $guideName = $this->application->guide->name;
        $jobTitle = $this->application->tourJob->title;

        return [
            'title' => 'New Application',
            'body' => "{$guideName} applied for \"{$jobTitle}\".",
            'icon' => 'heroicon-o-paper-airplane',
            'color' => 'info',
        ];
    }
}
