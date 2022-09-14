<?php

namespace App\Repository;

use App\Models\Member;

class MemberRepository extends UserRepository
{
    /**
     * create instance
     *
     * @param App\Models\Member $model
     */
    public function __construct(Member $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     *
     * @param  mixed $id
     *
     * @return App\Models\Member|null
     */
    public function find($id)
    {
        return $this->getBuilder()
            ->where('type', Member::USER_TYPE)
            ->where($this->getModel()->getKeyName(), $id)
            ->first();
    }
}
