<?php

namespace App\Notifications\Admin\ProfileValidation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApprovedProfileValidationNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) : array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) : MailMessage
    {
        return (new MailMessage)
                    ->subject(__('Profile Validation Result'))
                    ->line(__('Congratulations, Your profile was successfully validated and approved.'))
                    ->line('<br/>')
                    ->line('<br/>')
                    ->line('Thank you for using our application!');
    }
}
