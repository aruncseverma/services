<?php

namespace App\Notifications\EscortAdmin\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * {@inheritDoc}
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('Reset Password Notification'))
            ->line(__('You are receiving this email because we received a password reset request for your account.'))
            ->action(__('Reset Password'), route('escort_admin.auth.reset_password.form', ['_token' => $this->token]))
            ->line(__('If you did not request a password reset, no further action is required.'));
    }
}
