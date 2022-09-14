<?php

namespace App\Notifications\Admin\Plans;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApproveVip extends Notification
{
    use Queueable;

    public $oderId;

    public $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($orderId, $name)
    {
        $this->orderId = $orderId;
        $this->name = $name;
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
            'order_id' => $this->oderId,
            'name' => $this->name
        ];
    }
}
