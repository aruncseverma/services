<?php
/**
 * biller model repository class
 *
 */

namespace App\Repository;

use App\Models\Biller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BillerRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Biller $model
     */
    public function __construct(Biller $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     *
     *
     * @return App\Models\Biller
     */
    public function getAllActive()
    {
        return $this->getBuilder()
            ->where('is_active', 1)
            ->orderBy('rank')
            ->get();
    }

    /**
     * {@inheritDoc}
     *
     * @param  mixed $id
     *
     * @return App\Models\biller|null
     */
    public function new()
    {
      return new Biller;
    }
  
    /**
     * {@inheritDoc}
     *
     * @param  mixed $id
     *
     * @return App\Models\biller|null
     */
    public function find($id) : ?Biller
    {
        return $this->getBuilder()
            ->where('id', $id)
            ->first();
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

      // create paginated result
      return $builder->paginate($limit)->appends($params);
  }

  /**
   * create search builder instance
   *
   * @param  array $params
   *
   * @return Illuminate\Database\Eloquent\Builder
   */
  protected function createSearchBuilder(array $params = []) : Builder
  {
    $builder = $this->getBuilder()->orderBy('rank');

    if (isset($params['name']) && ($name = $params['name']) !== '') {
      $builder->where('name', $name);
    }

    if (isset($params['is_active']) && ($is_active = $params['is_active']) !== '*') {
      $builder->where('is_active', $is_active);
    }

    return $builder;
  }
}
