<?php
/**
 * user administrator eloquent model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Relations;
use App\Notifications\Admin\Auth\ResetPasswordNotification;

class Administrator extends User
{
    /**
     * user type value
     *
     * @const
     */
    const USER_TYPE = 'A';

    /**
     * attributes to be casted to defined datatype
     *
     * @var array
     */
    protected $casts = [
        'permissions' => 'array'
    ];

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
     * checks if given group and key is defined
     *
     * @param  string $group
     * @param  string $key
     *
     * @return boolean
     */
    public function hasPermission(string $group, string $key) : bool
    {
        $permissions = $this->role->permissions ?: [];

        return (array_key_exists($group, $permissions) && in_array($key, $permissions[$group]));
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
}
