<?php
/**
 * user descriptions repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\User;
use App\Models\UserDescription;

class UserDescriptionRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserDescription $model
     */
    public function __construct(UserDescription $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                      $attributes
     * @param  App\Models\User            $user
     * @param  App\Models\UserDescription $model
     *
     * @return App\Models\UserDescription
     */
    public function store(array $attributes, User $user, UserDescription $model = null) : UserDescription
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        $model->user()->associate($user);

        // save model
        $model = parent::save($attributes, $model);

        return $model;
    }

    /**
     * find user description by lang_code that is attached from the user
     *
     * @param  string $field
     * @param  App\Models\User $user
     *
     * @return App\Models\UserData|null
     */
    public function findUserDescriptionByLangCode(string $langCode, User $user)
    {
        return $user->descriptions()->where('lang_code', $langCode)->first();
    }
}
