<?php
/**
 * tour plans repository class
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Repository;

use App\Models\User;
use App\Models\TourPlan;

class TourPlanRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\TourPlan $model
     */
    public function __construct(TourPlan $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                   $attributes
     * @param  App\Models\User         $user
     * @param  App\Models\TourPlan $model
     *
     * @return App\Models\TourPlan
     */
    public function store(array $attributes, User $user, TourPlan $model = null) : TourPlan
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
     * find tour plan by id that is attached from the user
     *
     * @param  string $field
     * @param  App\Models\User $user
     *
     * @return App\Models\UserData|null
     */
    public function findTourPlanById(string $id, User $user)
    {
        return $user->tourPlans()->where('id', $id)->first();
    }
}
