<?php

namespace App\Repository;

use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TranslationRepository extends Repository
{
    /**
     * create instance
     *
     * @param LanguageLine $model
     */
    public function __construct(LanguageLine $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/update record to storage repository
     *
     * @param  array                   $attributes
     * @param  LanguageLine $model
     *
     * @return LanguageLine
     */
    public function store(array $attributes, LanguageLine $model = null): LanguageLine
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
     * @param  bool    $isPaginate
     * @param  bool    $isAppend
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator|Illuminate\Database\Eloquent\Collection;
     */
    public function search(int $limit, array $search = [], $isPaginate = true, $isAppend = true)
    {
        $builder = $this->createSearchBuilder($search);

        // create sort clause
        if (!empty($search['sort']) && !empty($search['order'])) {
            $this->createBuilderSort($builder, $search['sort'], $search['order']);
        }

        if ($isPaginate) {
            $pagination = $builder->paginate($limit);
            if ($isAppend) {
                $pagination->appends($search);
            }
            return $pagination;
        }

        if ($limit > 0) {
            $builder->take($limit);
        }
        return $builder->get();
    }

    /**
     * create builder instance
     *
     * @param  array $search
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createSearchBuilder(array $search): Builder
    {
        $builder = $this->getBuilder();

        // group where clause
        if (!empty($search['group'])) {
            $groups = is_array($search['group']) ? $search['group'] : explode(',', $search['group']);
            $builder->whereIn('group', $groups);
        }

        // key where clause
        if (isset($search['key'])) {
            $builder->where('key', 'like', "%{$search['key']}%");
        }

        // text where clause
        if (isset($search['text'])) {
            $builder->where('text', 'like', "%{$search['text']}%");
        }

        // updated_at
        if (!empty($search['updated_at_start'])) {
            $builder->whereDate('updated_at', '>=', date("Y-m-d", strtotime($search['updated_at_start'])));
        }
        if (!empty($search['updated_at_end'])) {
            $builder->whereDate('updated_at', '<=', date("Y-m-d", strtotime($search['updated_at_end'])));
        }
        return $builder;
    }


    /**
     * Get all groups
     * @return Collection
     */
    public function getGroups() : Collection
    {
        return $this->getBuilder()->select('group')->groupBy('group')->get();
    }

    /**
     * multiple delete
     * 
     * @param array $ids
     * @return int
     */
    public function multipleDelete(array $ids = []): int
    {
        $affected = 0;
        if (!empty($ids)) {
            $affected = $this->getBuilder()->whereIn('id', $ids)->delete();
        }
        return $affected;
    }
}
