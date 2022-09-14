<?php
/**
 * user locations repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\User;
use App\Models\UserGeoLocation;

class UserGeoLocationRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserLocation $model
     */
    public function __construct(UserGeoLocation $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                   $attributes
     * @param  App\Models\User         $user
     * @param  App\Models\UserLocation $model
     *
     * @return App\Models\UserLocation
     */
    public function store(array $attributes, User $user, UserGeoLocation $model = null) : UserGeoLocation
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        $model->user()->associate($user);

        // save model
        $model = parent::save($attributes, $model);

        return $model;
    }
}
