<?php
/**
 * escort model repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Agency;
use App\Models\Escort;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EscortRepository extends UserRepository
{
    /**
     * create instance
     *
     * @param App\Models\Escort $model
     */
    public function __construct(Escort $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     *
     * @param  mixed $id
     *
     * @return App\Models\Escort|null
     */
    public function find($id) : ?Escort
    {
        return $this->getBuilder()
            ->with('memberships')
            ->where('type', Escort::USER_TYPE)
            ->where($this->getModel()->getKeyName(), $id)
            ->first();
    }

    /**
     * bind escort to the agency
     *
     * @param  App\Models\Escort $escort
     * @param  App\Models\Agency $agency
     *
     * @return bool
     */
    public function bindEscortToAgency(Escort $escort, Agency $agency) : bool
    {
        return $escort->agency()->associate($agency)->save();
    }

    /**
     * unbind escort to the agency
     *
     * @param  App\Models\Escort $escort
     *
     * @return boolean
     */
    public function unbindEscortToAgency(Escort $escort) : bool
    {
        return $escort->agency()->dissociate()->save();
    }

    /**
     * search for models with paginated results
     *
     * @param  integer $limit
     * @param  array   $search
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(int $pageSize, array $params = []) : LengthAwarePaginator
    {
        $params['type'] = Escort::USER_TYPE;

        // create the builder
        $builder = $this->createUsersBuilder($params);

        return $builder->paginate($pageSize)->appends($params);
    }
}
