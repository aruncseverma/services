<?php
/**
 * repository class for user video folders eloquent model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\User;
use App\Models\UserVideoFolder;
use Illuminate\Support\Collection;

class UserVideoFolderRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserVideoFolder $model
     */
    public function __construct(UserVideoFolder $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * store records to storage
     *
     * @param  array                           $attributes
     * @param  App\Models\User                 $user
     * @param  App\Models\UserVideoFolder|null $model
     *
     * @return App\Models\UserVideoFolder
     */
    public function store(array $attributes, User $user, UserVideoFolder $model = null) : UserVideoFolder
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // relations
        $model->user()->associate($user);

        return parent::save($attributes, $model);
    }

    /**
     * get all user video folders
     *
     * @param  App\Models\User $user
     *
     * @return Illuminate\Support\Collection
     */
    public function getUserVideoFolders(User $user) : Collection
    {
        return $this->getBuilder()
            ->where($this->getModel()->user()->getForeignKeyName(), $user->getKey())
            ->get();
    }
}
