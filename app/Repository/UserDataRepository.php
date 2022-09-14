<?php
/**
 * user data repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\User;
use App\Models\UserData;

class UserDataRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserData $model
     */
    public function __construct(UserData $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * {@inheritDoc}
     *
     * @param  array           $attributes
     * @param  App\Models\User $user
     *
     * @return App\Models\UserData
     */
    public function create(array $attributes, $user = null) : UserData
    {
        // check if given user model instance of App\Models\User class
        $this->isModelInstanceOf($user, User::class);

        // creates new instance of this model
        $model = $this->getModel()->newInstance();

        // set model attributes
        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        // save user data user and bind it
        $user->userData()->save($model);

        return $model;
    }

    /**
     * find user data by field that is attached from the user
     *
     * @param  string $field
     * @param  App\Models\User $user
     *
     * @return App\Models\UserData|null
     */
    public function findUserDataByField(string $field, User $user)
    {
        return $user->userData()->where('field', $field)->first();
    }

    /**
     * Save user data
     * 
     * @param User $userId
     * @param array $userData
     * @return bool
     */
    public function saveUserData($user, array $userData = [])
    {
        if (empty($user) || !($user instanceof User)) {
            return false;
        }

        if (empty($userData) || !is_array($userData)) {
            return false;
        }

        $prevFields = $user->userData()
            ->whereIn('field', array_keys($userData))->get()
            ->keyBy('field');

        foreach($userData as $field => $content) {
            if ($prevFields->has($field)) {
                // $prevFields->get($field)->update([
                //     'content' => is_array($content) ? implode(',', $content) : $content,
                // ]);

                $prevFields->get($field)
                ->where('user_id', $user->getKey())
                ->where('field', $field)
                ->update([
                    'content' => is_array($content) ? implode(',', $content) : $content,
                ]);
            } else {
                $user->userData()->create([
                    'field' => $field,
                    'content' => $content
                ]);
            }
        }
        return true;
    }
}
