<?php

namespace App\Notifications\Index\Auth;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EmailVerificationNotification extends Notification
{
    /**
     * notification token for later processing
     *
     * @var string
     */
    protected $token;

    /**
     * create instance
     *
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('Verify Email Address'))
            ->greeting(__('Hello!'))
            ->line(__('Please click the button below to verify your email address.'))
            ->action(__('Verify Email Address'), route('index.verification.verify', ['_token' => $this->token]))
            ->line(__('If you did not create an account, no further action is required.'));
    }
}
