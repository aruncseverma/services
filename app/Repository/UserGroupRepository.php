<?php
/**
 * user group repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\UserGroup;
use Illuminate\Support\Collection;

class UserGroupRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserGroup $model
     */
    public function __construct(UserGroup $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * get all active groups
     *
     * @return Illuminate\Support\Collection
     */
    public function getActiveGroups() : Collection
    {
        return $this->getBuilder()
            ->where(['is_active' => true])
            ->get();
    }

    /**
     * get defined default group
     *
     * @return App\Models\UserGroup|null
     */
    public function getDefaultGroup() : ?UserGroup
    {
        return $this->getBuilder()
            ->where(['is_default' => true])
            ->where(['is_active' => true])
            ->first();
    }
}
