<?php
/**
 * user model thats is seperated from the application
 * this model can be use for mimicking or create a user object
 * without the need of the application models
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Models;

use App\Models\Escort;
use Illuminate\Notifications\Notifiable;
use App\Notifications\EscortAdmin\AccountSettings\EscortIndependentApplicationNotification;

class User
{
    use Notifiable;

    /**
     * user email address
     *
     * @var string
     */
    public $email;

    /**
     * sends notification for escorts who are converting to
     * independent escort
     *
     * @param  string            $token
     * @param  App\Models\Escort $escort
     *
     * @return void
     */
    public function sendEscortIndependentApplicationNotification($token, Escort $escort)
    {
        $this->notify(new EscortIndependentApplicationNotification($token, $escort));
    }
}
