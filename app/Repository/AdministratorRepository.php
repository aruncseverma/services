<?php
/**
 * administrator model repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Administrator;

class AdministratorRepository extends UserRepository
{
    /**
     * create instance
     *
     * @param App\Models\Administrator $model
     */
    public function __construct(Administrator $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     *
     * @param  mixed $id
     *
     * @return App\Models\Administrator|null
     */
    public function find($id)
    {
        return $this->getBuilder()
            ->where('type', Administrator::USER_TYPE)
            ->where($this->getModel()->getKeyName(), $id)
            ->first();
    }
}
