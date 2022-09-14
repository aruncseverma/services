<?php
/**
 * repository class for service category eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\ServiceCategory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ServiceCategoryRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\ServiceCategory $model
     */
    public function __construct(ServiceCategory $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * get all active categories
     *
     * @return Illuminate\Support\Collection
     */
    public function getActiveCategories() : Collection
    {
        return $this->getBuilder()
            ->with('descriptions')
            ->with('services')
            ->with('services.descriptions')
            ->where(['is_active' => true])
            ->orderBy('position', 'ASC')
            ->get();
    }

    /**
     * search for service categories
     *
     * @param  integer $limit
     * @param  array   $params
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(int $limit, array $params) : LengthAwarePaginator
    {
        return $this->createSearchBuilder($params)->paginate($limit)->appends($params);
    }

    /**
     * create search builder from params
     *
     * @param  array $params
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createSearchBuilder(array $params) : Builder
    {
        $builder = $this->getBuilder();

        // include descriptions
        $builder->with('descriptions')->whereHas('descriptions', function ($query) use ($params) {
            // name
            if (isset($params['name'])) {
                $query->where('content', 'like', "%{$params['name']}%");
            }
        });

        // active where clause
        $isActive = (isset($params['is_active'])) ? $params['is_active'] : '*';
        if ($isActive !== '*') {
            $builder->where('is_active', (int) $isActive);
        }

        return $builder;
    }
}
