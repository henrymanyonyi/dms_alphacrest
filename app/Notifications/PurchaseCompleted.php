<?php

// app/Notifications/PurchaseCompleted.php
namespace App\Notifications;

use App\Models\Purchase;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PurchaseCompleted extends Notification
{
    public function __construct(public Purchase $purchase) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Data Purchase is Ready!')
            ->greeting('Hello!')
            ->line('Thank you for your purchase of: ' . $this->purchase->dataPoint->name)
            ->line('Order ID: ' . $this->purchase->order_id)
            ->line('Amount Paid: KES ' . number_format($this->purchase->amount, 2))
            ->action('Download Now', route('purchase.download', $this->purchase->order_id))
            ->line('This link will remain active for lifetime access.')
            ->line('Thank you for using Alphacrest Data!');
    }
}
