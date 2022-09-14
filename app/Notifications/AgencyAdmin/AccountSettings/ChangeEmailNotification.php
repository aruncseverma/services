<?php
/**
 * mail notification class for changing email address under account settings under escort admin namespace
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Notifications\AgencyAdmin\AccountSettings;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ChangeEmailNotification extends Notification
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
            ->subject(__('Change Email Notification'))
            ->line(__('You are receiving this email because we received a change email request for your account.'))
            ->action(__('Change Email'), route('agency_admin.account_settings.change_email', ['_token' => $this->token]))
            ->line(__('If you did not request a email change request, no further action is required.'));
    }
}
