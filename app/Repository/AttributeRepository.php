<?php
/**
 * attribute repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Builder;
use App\Events\Repository\Attributes as Events;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AttributeRepository extends Repository
{
    /**
     * fallback attribute name
     *
     * @const
     */
    const FALLBACK_ATTRIBUTE_NAME = Attribute::ATTRIBUTE_HAIR_COLOR;

    /**
     * create instance
     *
     * @param App\Models\Attribute $model
     */
    public function __construct(Attribute $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * search for models with paginated results
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

    public function getFilter(array $params = [])
    {
        $builder = $this->createSearchBuilder($params);
        return $builder->get();
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
        $params = array_merge([
            'lang_code' => app()->getLocale(),
            'name' => self::FALLBACK_ATTRIBUTE_NAME,
        ], $params);

        $builder = $this->getBuilder()->with('descriptions');

        // set attribute name clause
        $builder->where('name', $params['name']);

        // relative table where clause
        $builder->whereHas('descriptions', function ($query) use ($params) {
            // set lang code where clause
            $query->where('lang_code', $params['lang_code']);

            if (isset($params['content'])) {
                $query->where('content', 'like', '%' . $params['content'] . '%');
            }
        });

        // is active where clause
        if (isset($params['is_active']) && ($isActive = $params['is_active']) !== '*') {
            $builder->where('is_active', $isActive);
        }

        /**
         * trigger event
         *
         * @param Illuminate\Database\Eloquent\Builder $builder
         * @param array                                $params
         */
        event(new Events\CreatingSearchBuilder($builder, $params));

        return $builder;
    }

    /**
     * Fetches all available languages and number of escorts
     * that speaks them
     *
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     * 
     * @return Collection|null
     */
    public function getEscortLanguageFilter()
    {
        $model = $this->getBuilder();
        $mainTable = $model->getModel()->getTable();

        $model->leftJoin('attribute_descriptions', "{$mainTable}.id", '=', 'attribute_descriptions.attribute_id');
        $model->leftJoin('escort_languages', "{$mainTable}.id", "=", "escort_languages.attribute_id");

        $model->select("{$mainTable}.id", 
            'attribute_descriptions.content', 
            DB::raw('count(escort_languages.attribute_id) as total')
        );

        $model->where("{$mainTable}.name", Attribute::ATTRIBUTE_LANGUAGES);
        $model->groupBy("escort_languages.attribute_id");

        return $model->get();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getEscortHairColorFilter()
    {
        $model = $this->getBuilder();
        $mainTable = $model->getModel()->getTable();

        $model->leftJoin('attribute_descriptions', "{$mainTable}.id", '=', 'attribute_descriptions.attribute_id');

        $model->select("{$mainTable}.id", "attribute_descriptions.content as name");

        $model->where("attribute_descriptions.lang_code", "en");
        $model->where("{$mainTable}.name", Attribute::ATTRIBUTE_HAIR_COLOR);

        return $model->get();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getEscortEyeColorFilter()
    {
        $model = $this->getBuilder();
        $mainTable = $model->getModel()->getTable();

        $model->leftJoin('attribute_descriptions', "{$mainTable}.id", '=', 'attribute_descriptions.attribute_id');

        $model->select("{$mainTable}.id", "attribute_descriptions.content as name");

        $model->where("attribute_descriptions.lang_code", "en");
        $model->where("{$mainTable}.name", Attribute::ATTRIBUTE_EYE_COLOR);

        return $model->get();
    }
}
