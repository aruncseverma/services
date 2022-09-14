<?php
/**
 * repository class for user videos eloquent model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\User;
use App\Models\UserVideo;
use App\Models\UserVideoFolder;
use Illuminate\Support\Collection;

class UserVideoRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserVideo $model
     */
    public function __construct(UserVideo $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * stores model attributes value to repostiory
     *
     * @param  array                           $attributes
     * @param  App\Models\User                 $user
     * @param  App\Models\UserVideoFolder|null $folder
     * @param  App\Models\UserVideo|null       $model
     *
     * @return App\Models\UserVideo
     */
    public function store(array $attributes, User $user, ?UserVideoFolder $folder, ?UserVideo $model) : UserVideo
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // associate relations
        $model->user()->associate($user);
        $model->folder()->associate($folder);

        return parent::save($attributes, $model);
    }

    /**
     * get all user public videos
     *
     * @param  App\Models\User $user
     *
     * @return Illuminate\Support\Collection
     */
    public function getUserPublicVideos(User $user) : Collection
    {
        return $this->getBuilder()
            ->where($this->getModel()->user()->getForeignKeyName(), $user->getKey())
            ->where('visibility', UserVideo::VISIBILITY_PUBLIC)
            ->get();
    }

    /**
     * get all user private videos
     *
     * @param  App\Models\User $user
     *
     * @return Illuminate\Support\Collection
     */
    public function getUserPrivateVideos(User $user) : Collection
    {
        return $this->getBuilder()
            ->where($this->getModel()->user()->getForeignKeyName(), $user->getKey())
            ->where('visibility', UserVideo::VISIBILITY_PRIVATE)
            ->get();
    }
}
