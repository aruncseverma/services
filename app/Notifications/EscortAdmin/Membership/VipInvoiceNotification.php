<?php

namespace App\Notifications\EscortAdmin\Membership;

use App\Models\Biller;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VipInvoiceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $biller;
    private $message;
    private $price;
    private $orderId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Biller $biller, $message, $price, $orderId)
    {
        $this->biller = $biller;
        $this->message = $message;
        $this->price = $price;
        $this->orderId = $orderId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject('Vip Membership Purchase')
                ->greeting('Welcome to Escort Services.')
                ->line('Amount to be paid: ' . $this->price)
                ->line($this->message)
                ->line('Here are the informations you will be needing.')
                ->line($this->biller->billnote)
                ->line('Order ID:' . $this->orderId)
                ->line('Please send us a copy of the receipt via email');
    }
}
