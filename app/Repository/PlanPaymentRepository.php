<?php

namespace App\Repository;

use App\Models\User;
use App\Models\VipSubscription;
use App\PlanPayments;

class PlanPaymentRepository extends Repository
{
    public function __construct(PlanPayments $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * Stores the payment made
     *
     * @param array $params
     * @param User $user
     * @param VipSubscription $plan
     * @param PlanPayments $model
     * @return PlanPayments
     */
    public function store(array $params, ?User $user, ?VipSubscription $plan, PlanPayments $model = null) : PlanPayments
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        $model->plan()->associate($plan);
        $model->admin()->associate($user);

        return parent::save($params, $model);
    }
}