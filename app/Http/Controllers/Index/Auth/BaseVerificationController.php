<?php

namespace App\Http\Controllers\Index\Auth;

use App\Http\Controllers\Controller as BaseController;
use Carbon\Carbon;
use App\Support\Objects\Concerns\InteractsWithObjects;
use App\Models\User;

class BaseVerificationController extends BaseController
{
    use InteractsWithObjects;

    /**
     * no of hours token will expire
     *
     * @const
     */
    const TOKEN_EXPIRATION_HOURS = 1;

    /**
     * response statuses
     *
     * @const
     */
    const RESPONSE_EMAIL_SENT     = 'email_sent';
    const RESPONSE_FAILED_TOKEN   = 'token_failed';

    /**
     * sends email verification notification to user email
     *
     * @param  App\Models\User $user
     *
     * @return string
     */
    protected function sendEmailVerificationNotification(User $user): string
    {
        $payload = [
            $user->getKey(),
            $user->email,
            Carbon::now()->addHours(static::TOKEN_EXPIRATION_HOURS)->getTimestamp(),
        ];

        $token = $this->createObject($payload);

        if (!$token) {
            return static::RESPONSE_FAILED_TOKEN;
        }

        $user->sendEmailForVerificationNotification($token);

        return static::RESPONSE_EMAIL_SENT;
    }
}
