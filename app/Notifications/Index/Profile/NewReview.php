<?php

namespace App\Notifications\Index\Profile;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewReview extends Notification
{
    use Queueable;

    public $name;

    public $rate;

    public $review;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $rate, $review)
    {
        $this->name = $name;
        $this->rate = $rate;
        $this->review = $review;
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
            'rate' => $this->rate,
            'review' => $this->review
        ];
    }
}
