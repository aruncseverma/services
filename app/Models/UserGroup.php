<?php
/**
 * user group eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserGroup extends Model
{
    /**
     * group ids per type
     *
     * @const
     */
    const BASIC_GROUP_ID = 1;
    const SILVER_GROUP_ID = 2;
    const GOLD_GROUP_ID = 3;

    /**
     * tells eloquent that this model does not have any timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * default attributes value
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => false,
        'is_default' => false,
    ];

    /**
     * casts attribute values
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool',
        'is_default' => 'bool'
    ];

    /**
     * relation to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users() : Relations\HasMany
    {
        return $this->hasMany(User::class, 'user_group_id');
    }
}
