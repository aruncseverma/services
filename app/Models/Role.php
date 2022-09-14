<?php
/**
 * role eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * attributes to be casted to defined datatype
     *
     * @var array
     */
    protected $casts = [
        'permissions' => 'array'
    ];

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
        $permissions = $this->permissions ?: [];

        return (array_key_exists($group, $permissions) && in_array($key, $permissions[$group]));
    }
}
