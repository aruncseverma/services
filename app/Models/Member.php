<?php

namespace App\Models;

use App\Notifications\MemberAdmin\Auth\ResetPasswordNotification;
use App\Notifications\MemberAdmin\AccountSettings\ChangeEmailNotification;
use App\Support\Entity\MemberData;
use Illuminate\Database\Eloquent\Relations;

class Member extends User
{
    use Concerns\HasDescriptions;

    /**
     * user type value
     */
    const USER_TYPE = 'M';

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * send an change email notification
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendChangeEmailNotification($token): void
    {
        $this->notify(new ChangeEmailNotification($token));
    }

    /**
     * {@inheritDoc}
     *
     * @return App\Support\Entity\MemberData
     */
    public function getUserDataAttribute()
    {
        $data = $this->userData()->get();
        $entity = new MemberData(['user' => $this]);

        foreach ($data as $model) {
            $entity->populate([
                $model->field => $model->content
            ]);
        }

        return $entity;
    }

    /**
     * relation to user location model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mainLocation(): Relations\HasOne
    {
        return $this->hasOne(UserLocation::class, 'user_id')
        ->where('type', UserLocation::MAIN_LOCATION_TYPE)
            ->withDefault();
    }
}
