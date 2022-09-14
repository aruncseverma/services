<?php
/**
 * notification class which sends notification to the agency
 * for escorts applying to be part of the agency
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Notifications\EscortAdmin\AccountSettings;

use App\Models\Escort;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EscortAgencyApplicationNotification extends Notification
{
    /**
     * notification token for later processing
     *
     * @var string
     */
    protected $token;

    /**
     * current escort model instance
     *
     * @var string
     */
    protected $escort;

    /**
     * Create a new notification instance.
     *
     * @param  mixed             $token
     * @param  App\Models\Escort $escort
     */
    public function __construct($token, Escort $escort)
    {
        $this->token = $token;
        $this->escort = $escort;
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
     *
     * @return Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('Escort Agency Application'))
            ->line(
                __(
                    'You are receiving this email because we received an application from <strong>:name</strong> which wants to be part of your agency',
                    [
                        'name' => $this->escort->name
                    ]
                )
            )
            ->action(__('Accept Application'), route('agency_admin.escorts.accept_invitation', ['_token' => $this->token]));
    }
}
