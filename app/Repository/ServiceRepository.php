<?php
/**
 * repository class for service eloquent class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ServiceRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Service $model
     */
    public function __construct(Service $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * store data to repository storage
     *
     * @param  array                      $attributes
     * @param  App\Models\ServiceCategory $category
     * @param  App\Models\Service         $model
     *
     * @return App\Models\Service
     */
    public function store(array $attributes, ServiceCategory $category, Service $model = null) : Service
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // assoc category
        $model->category()->associate($category);

        return parent::save($attributes, $model);
    }

    /**
     * create paginate results
     *
     * @param  integer $limit
     * @param  array   $search
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(int $limit, array $search = []) : LengthAwarePaginator
    {
        return $this->createSearchBuilder($search)->paginate($limit)->appends($search);
    }

    /**
     * create eloquent builder instance
     *
     * 06/07/2020
     * UPDATE: Commented out sorting by name alphabetically
     * to remove unnecessary inclusions because of model relations
     * (lines 116 ~ line 117)
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @param  array $search
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createSearchBuilder(array $search = []) : Builder
    {
        $builder = $this->getBuilder()->with('descriptions')
            ->with('category')
            ->with('category.descriptions');

        $builder->whereHas('category.descriptions', function ($query) use ($search) {
            if (isset($search['lang_code'])) {
                $query->where('lang_code', $search['lang_code']);
            }
        });

        $builder->whereHas('descriptions', function ($query) use ($search) {
            // lang code
            if (isset($search['lang_code'])) {
                $query->where('lang_code', $search['lang_code']);
            }

            // name
            if (isset($search['name'])) {
                $query->where('content', 'like', "%{$search['name']}%");
            }
        });

        // active where clause
        $isActive = (isset($search['is_active'])) ? $search['is_active'] : '*';
        if ($isActive !== '*') {
            $builder->where('is_active', (int) $isActive);
        }

        $categoryId = (isset($search['service_category_id'])) ? $search['service_category_id'] : '*';
        if ($categoryId !== '*') {
            $builder->where('service_category_id', $categoryId);
        }

        // for sorting to alphabet
        $relation = $builder->getModel()->descriptions();
        $mainTable = $builder->getModel()->getTable();
        $mainTableKey = $builder->getModel()->getKeyName();
        $foreignTable = $relation->getModel()->getTable();

        // $builder->join($foreignTable, "{$mainTable}.{$mainTableKey}", '=', $relation->getQualifiedForeignKeyName());
        // $builder->orderBy("{$foreignTable}.content", 'ASC');

        $builder->orderBy("{$mainTable}.id", 'ASC');

        return $builder;
    }

    /**
     * Get all service filter with their respective counts
     *
     * @param int $type
     * @return void
     */
    public function getServicesFilter($type)
    {
        $model = $this->getBuilder();
        $mainTable = $model->getModel()->getTable();

        $model->leftJoin('escort_services', "{$mainTable}.id", "=", "escort_services.service_id");
        $model->leftJoin('service_descriptions', "{$mainTable}.id", "=", 'service_descriptions.service_id');
    
        $model->select("{$mainTable}.id",
            'service_descriptions.content',
            DB::raw('count(escort_services.service_id) as total')
        );

        $model->where("{$mainTable}.service_category_id", $type);
        $model->where("service_descriptions.lang_code", 'en');
        $model->groupBy("{$mainTable}.id");
        $model->orderBy('service_descriptions.content');

        return $model->get();
    }
}
