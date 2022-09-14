<?php

namespace App\Repository;

use App\Models\RevokeMembership;
use App\Models\User;
use App\Models\VipSubscription;

class RevokeMembershipRepository extends Repository
{
    public function __construct(RevokeMembership $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * Undocumented function
     *
     * @param array $params
     * @param User $user
     * @param VipSubscription $purchase
     * @param RevokeMembership $model
     * @return void
     */
    public function store(array $params, ?User $user, ?VipSubscription $purchase, RevokeMembership $model = null)
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        $model->admin()->associate($user);
        $model->transaction()->associate($purchase);

        return parent::save($params, $model);
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function get($id)
    {
        $model = $this->newModelInstance();
        $model->with('admin');
        $model->with('transaction');

        return $model->find($id);
    }
}