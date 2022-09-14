<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserProfileValidation extends Model
{
    /**
     * casts attribute values to specified datatype
     *
     * @var array
     */
    protected $casts = [
        'is_approved' => 'bool',
        'is_denied' => 'bool',
        'data' => 'array',
    ];

    /**
     * relation to user model
     *
     * @return Relations\BelongsTo
     */
    public function user() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * relation to user group model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userGroup() : Relations\BelongsTo
    {
        return $this->belongsTo(UserGroup::class, 'user_group_id');
    }

    /**
     * checks if model is approved
     *
     * @return boolean
     */
    public function isApproved() : bool
    {
        return (bool) $this->getAttribute('is_approved');
    }

    /**
     * checks if model is denied
     *
     * @return boolean
     */
    public function isDenied() : bool
    {
        return (bool) $this->getAttribute('is_denied');
    }
}
