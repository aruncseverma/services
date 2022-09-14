<?php
/**
 * language model repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use App\Events\Repository\Languages as Events;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LanguageRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Language $model
     */
    public function __construct(Language $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * store given attributes
     *
     * @param  array               $attributes
     * @param  App\Models\Country  $country
     * @param  App\Models\Language $model
     *
     * @return App\Models\Language
     */
    public function store(array $attributes, Country $country, Language $model = null) : Language
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        // save relation
        $country->languages()->save($model);

        return $model;
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
        // create builder
        $builder = $this->createSearchBuilder($params);

        // create paginated result
        return $builder->paginate($limit)->appends($params);
    }

    /**
     * find language model using code
     *
     * @param  string $code
     *
     * @return void
     */
    public function findByCode($code)
    {
        return $this->findBy(['code' => $code]);
    }

    /**
     * creates search query builder
     *
     * @param  array $params
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createSearchBuilder(array $params = []) : Builder
    {
        // get builder instance
        $builder = $this->getBuilder();

        // name
        if (isset($params['name'])) {
            $builder->where('name', 'like', "%{$params['name']}%");
        }

        // code
        if (isset($params['code'])) {
            $builder->where('code', 'like', "%{$params['code']}%");
        }

        // is_active
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
}
