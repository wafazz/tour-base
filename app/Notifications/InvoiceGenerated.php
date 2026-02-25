<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceGenerated extends Notification
{
    use Queueable;

    public function __construct(public Invoice $invoice) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Invoice {$this->invoice->invoice_number} — Tour Base")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Invoice {$this->invoice->invoice_number} has been generated.")
            ->line("Amount: RM " . number_format($this->invoice->total, 2))
            ->action('View Invoices', url('/agency/invoices'))
            ->line('Please proceed with payment at your earliest convenience.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Invoice Generated',
            'body' => "Invoice {$this->invoice->invoice_number} — RM " . number_format($this->invoice->total, 2),
            'icon' => 'heroicon-o-document-currency-dollar',
            'color' => 'warning',
        ];
    }
}
