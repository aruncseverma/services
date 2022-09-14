<?php

namespace App\Notifications\Admin\Plans;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RevokeVip extends Notification
{
    use Queueable;

    public $orderId;

    public $name;

    public $reason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $reason, $orderId)
    {
        $this->name = $name;
        $this->reason = $reason;
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
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'name' => $this->name,
            'reason' => $this->reason,
            'orderId' => $this->orderId 
        ];
    }
}
