<?php
/**
 * agency model repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Agency;

class AgencyRepository extends UserRepository
{
    /**
     * create instance
     *
     * @param App\Models\Agency $model
     */
    public function __construct(Agency $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * {@inheritDoc}
     *
     * @param  mixed $id
     *
     * @return App\Models\Agency|null
     */
    public function find($id)
    {
        return $this->getBuilder()
            ->where('type', Agency::USER_TYPE)
            ->where($this->getModel()->getKeyName(), $id)
            ->first();
    }

    public function getProfile($username)
    {
        return $this->getBuilder()
            ->where('type', Agency::USER_TYPE)
            ->where('username', $username)
            ->first();
    }

    /**
     * get record from storage using condition given
     *
     * @param  array|Closure|string $where
     *
     * @return null|App\Models\Agency
     */
    public function findBy($where)
    {
        return $this->getBuilder()
            ->where('type', Agency::USER_TYPE)
            ->where($where)
            ->first();
    }

    /**
     * fetches all agency
     *
     * @return Collection<Agency>|null
     */
    public function getAll()
    {
        return $this->getBuilder()
            ->with('description')
            ->with('mainLocation')
            ->where('type', Agency::USER_TYPE)
            ->get();
    }
}
