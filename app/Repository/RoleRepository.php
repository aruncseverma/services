<?php
/**
 * roles eloquent model repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Role;

class RoleRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Model\Role $model
     */
    public function __construct(Role $model)
    {
        $this->bootEloquentRepository($model);
    }
}
