<?php
/**
 * handles the database queries for membership plans
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Repository;

use App\Models\Membership;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class MembershipPlanRepository extends Repository
{
    /**
     * Create new instance of the repository
     *
     * @param Membership $model
     */
    public function __construct(Membership $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * Fetches all membership plans from database
     *
     * @return App\Models\MembershipPlan
     */
    public function getAllActive()
    {
        return $this->getBuilder()
            ->with('currency')
            ->where('is_active', 1)
            ->get();
    }

    /**
     * {@inheritDoc}
     *
     * @param  mixed $id
     *
     * @return App\Models\Package|null
     */
    public function new()
    {
        return new Membership();
    }

    /**
   * search for paginated result set
   *
   * @param  integer $limit
   * @param  array   $params
   *
   * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
    public function search(int $limit, array $params = []) : LengthAwarePaginator
    {
        $builder = $this->createSearchBuilder($params);

        //paginate result
        return $builder->paginate($limit)->appends($params);
    }

    /**
   * create search builder instance
   *
   * @param  array $params
   *
   * @return Illuminate\Database\Eloquent\Builder
   */
    public function createSearchBuilder(array $params = []) : Builder
    {
        $builder = $this->getBuilder()->with('currency');

        if (isset($params['currency']) && ($currency = $params['currency']) !== '*') {
            $builder->where('currency_id', $currency);
        }

        return $builder;
    }
}