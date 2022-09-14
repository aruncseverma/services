<?php

namespace App\Notifications\Admin\ProfileValidation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DeniedProfileValidationNotification extends Notification
{
    use Queueable;

    /**
     * admin reason why profile validation
     * has been denied
     *
     * @var string
     */
    protected $reason;

    /**
     * create instance
     *
     * @param string $reason
     */
    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }

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
                    ->line(__('We\'re sorry to tell you that your account has been denied for applied profile validation.'))
                    ->line('<br/>')
                    ->line('<br/>')
                    ->line(__('<strong>Reason:</strong> :reason', ['reason' => $this->reason]));
    }
}
