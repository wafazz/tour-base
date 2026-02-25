<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        public Application $application,
        public string $newStatus,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $jobTitle = $this->application->tourJob->title;
        $status = ucfirst($this->newStatus);

        $mail = (new MailMessage)
            ->subject("Application {$status} — Tour Base")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your application for \"{$jobTitle}\" has been {$this->newStatus}.")
            ->action('View My Applications', url('/guide/applications'));

        if ($this->newStatus === 'accepted') {
            $mail->line('Congratulations! The agency has confirmed you for this job.');
        }

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        $jobTitle = $this->application->tourJob->title;

        return [
            'title' => 'Application ' . ucfirst($this->newStatus),
            'body' => "Your application for \"{$jobTitle}\" has been {$this->newStatus}.",
            'icon' => match ($this->newStatus) {
                'shortlisted' => 'heroicon-o-star',
                'accepted' => 'heroicon-o-check-circle',
                'rejected' => 'heroicon-o-x-circle',
                default => 'heroicon-o-bell',
            },
            'color' => match ($this->newStatus) {
                'shortlisted' => 'info',
                'accepted' => 'success',
                'rejected' => 'danger',
                default => 'warning',
            },
        ];
    }
}
