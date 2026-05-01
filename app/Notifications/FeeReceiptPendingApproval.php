<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeeReceiptPendingApproval extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($feeReceipt)
    {
        $this->feeReceipt = $feeReceipt;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Or 'mail' if you want to send an email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'A new fee receipt is pending approval.',
            'receipt_no' => $this->feeReceipt->receipt_no,
            'student_name' => $this->feeReceipt->student->name,
            'link' => route('admin.fee_receipts.show', $this->feeReceipt->id),
        ];
    }
}
