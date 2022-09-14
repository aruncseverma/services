<?php
/**
 * package model repository class
 *
 */

namespace App\Repository;

use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PackageRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Package $model
     */
    public function __construct(Package $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     *
     *
     * @return App\Models\Package
     */
    public function getAllActive()
    {
        return $this->getBuilder()
            ->where('is_active', 1)
            ->orderBy('rank')
            ->get();
    }

    public function getPackages($biller, $currency = 2)
    {
      return $this->getBuilder()
        ->where('is_active', 1)
        ->where('biller_id', $biller)
        ->where('currency_id', $currency)
        ->orderBy('currency_id')
        ->orderBy('credits')
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
      return new Package;
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
    $builder = $this->getBuilder()->with('biller')->orderBy('biller_id')->orderBy('currency_id')->orderBy('price');

    if (isset($params['currency']) && ($currency = $params['currency']) !== '*') {
      $builder->where('currency_id', $currency);
    }

    if (isset($params['is_active']) && ($is_active = $params['is_active']) !== '*') {
      $builder->where('is_active', $is_active);
    }

    $builder->whereHas('biller', function ($query) use ($params) {
      if (isset($params['biller']) && ($biller = $params['biller']) !== '*') {
        $query->where('id', $biller)
          ->orWhere('name', $biller);
      }
    });

    return $builder;
  }
}
