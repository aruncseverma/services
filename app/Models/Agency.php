<?php
/**
 * agency model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use App\Support\Entity\AgencyData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use App\Notifications\AgencyAdmin\Auth\ResetPasswordNotification;
use App\Notifications\AgencyAdmin\AccountSettings\ChangeEmailNotification;
use App\Notifications\EscortAdmin\AccountSettings\EscortAgencyApplicationNotification;
use Carbon\Carbon;

class Agency extends User
{
    use Concerns\HasDescriptions;

   /**
    * agent user type value
    *
    * @const
    */
    const USER_TYPE = 'G';

    /**
     * agency default permissions
     * 
     * @array
     */
    protected $defaultRolesPermissions = [
        'escorts' => [
            'create',
            'update',
        ]
    ];

    /**
     * relation to escort model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function escorts() : Relations\HasMany
    {
        return $this->hasMany(Escort::class, 'agency_id');
    }

    /**
     * wraps parent::descriptions method
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function about() : Relations\HasMany
    {
        return $this->descriptions();
    }

    /**
     * relation to user location model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mainLocation() : Relations\HasOne
    {
        return $this->hasOne(UserLocation::class, 'user_id')
            ->where('type', UserLocation::MAIN_LOCATION_TYPE)
            ->withDefault();
    }

    /**
     * get total number of escorts
     *
     * @return integer
     */
    public function getTotalEscorts() : int
    {
        return $this->escorts()->count();
    }

    /**
     * get total number of new escorts
     *
     * @return integer
     */
    public function getTotalNewEscorts(): int
    {
        return $this->escorts()->whereDate(Photo::CREATED_AT, Carbon::today())->count();
    }

    /**
     * sends notification for escort applying to agency as escort agency
     *
     * @param  mixed  $token
     * @param  Escort $escort
     *
     * @return void
     */
    public function sendEscortAgencyApplicationNotification($token, Escort $escort) : void
    {
        $this->notify(new EscortAgencyApplicationNotification($token, $escort));
    }

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
    public function sendChangeEmailNotification($token) : void
    {
        $this->notify(new ChangeEmailNotification($token));
    }

    /**
     * {@inheritDoc}
     *
     * @return App\Support\Entity\AgencyData
     */
    public function getUserDataAttribute()
    {
        $data = $this->userData()->get();
        $entity = new AgencyData(['user' => $this]);

        foreach ($data as $model) {
            $entity->populate([
                $model->field => $model->content
            ]);
        }

        return $entity;
    }
    
    /**
     * checks if given group and key is defined
     *
     * @param  string $group
     * @param  string $key
     *
     * @return boolean
     */
    public function hasPermission(string $group, string $key) : bool
    {
        $permissions = $this->role->permissions ?: $this->defaultRolesPermissions;

        return (array_key_exists($group, $permissions) && in_array($key, $permissions[$group]));
    }

    /**
     * relation to role model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role() : Relations\BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id')->withDefault();
    }

    /**
     * relation to agency ranking model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rank(): Relations\HasOne
    {
        return $this->hasOne(AgencyRanking::class, 'user_id');
    }

    /**
     * get ranking
     *
     * @return int
     */
    public function getRanking(): int
    {
        return $this->rank()->select('rank')->first()->rank ?? 0;
    }
}
