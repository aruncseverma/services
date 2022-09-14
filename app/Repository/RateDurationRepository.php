<?php
/**
 * rate duration eloquent repository
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\RateDuration;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RateDurationRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\RateDuration $model
     */
    public function __construct(RateDuration $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/update record to storage repository
     *
     * @param  array                   $attributes
     * @param  App\Models\RateDuration $model
     *
     * @return App\Models\RateDuration
     */
    public function store(array $attributes, RateDuration $model = null) : RateDuration
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // map attribute to model
        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        // save model to storage
        $model->save();

        return $model;
    }

    /**
     * search repository for given params and return result
     * with a paginated result
     *
     * @param  integer $limit
     * @param  array   $search
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function search(int $limit, array $search = []) : LengthAwarePaginator
    {
        return $this->createSearchBuilder($search)->paginate($limit)->appends($search);
    }

    /**
     * create builder instance
     *
     * @param  array $search
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createSearchBuilder(array $search) : Builder
    {
        $builder = $this->getBuilder()->with('descriptions');

        // set clause for the descriptions
        $builder->whereHas('descriptions', function ($query) use ($search) {
            // lang code where clause
            $query->where('lang_code', $search['lang_code']);

            // where name clause
            if (isset($search['name'])) {
                $query->where('content', 'like', "%{$search['name']}%");
            }
        });

        // is active where clause
        if (isset($search['is_active']) && ($isActive = $search['is_active']) !== '*') {
            $builder->where('is_active', (bool) $isActive);
        }

        return $builder;
    }

    /**
     * get all active durations
     *
     * @return Illuminate\Support\Collection
     */
    public function getActiveDurations() : Collection
    {
        return $this->getBuilder()
            //->with('descriptions')
            // ->whereHas('descriptions', function ($query) {
            //     $query->where('lang_code', app()->getLocale());
            // })
            ->where(['is_active' => true])
            ->orderBy('position', 'ASC')
            ->get();
    }
}
