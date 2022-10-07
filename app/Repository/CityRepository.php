<?php
/**
 * cities repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\City;
use App\Models\State;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CityRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\City $model
     */
    public function __construct(City $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * {@inheritDoc}
     *
     * @param array $params
     *
     * @return void
     */
    public function findAll(array $params = []) : Collection
    {
        return $this->getBuilder()
            ->where($params)
            ->orderBy('name', 'ASC')
            ->get();
    }

    /**
     * save ctiy instance
     *
     * @param  array            $attributes
     * @param  App\Models\State $state
     * @param  App\Models\City  $model
     *
     * @return App\Models\City
     */
    public function saveCity(array $attributes, State $state, City $model = null) : City
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        // assign attributes
        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        // save model instance
        $state->cities()->save($model);

        return $model;
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
     * get all active cities by state identifier
     *
     * @param  mixed $id
     *
     * @return Collection
     */
    public function getActiveCitiesByState($id) : Collection
    {
        return $this->getBuilder()
            ->where(function ($query) use ($id) {
                if (is_array($id)) {
                    $query->whereIn('state_id', $id);
                } else {
                    $query->where(['state_id' => $id]);
                }
            })
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->get();
    }

    /**
     * checks if current city or city key is active
     *
     * @param  mixed $city
     *
     * @return boolean
     */
    public function isActiveCity($city) : bool
    {
        if ($city instanceof City) {
            return $city->isActive();
        }

        // get city
        $city = $this->find($city);

        return ($city) ? $city->isActive() : false;
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
        $builder = $this->getBuilder()->with('state');

        $builder->whereHas('state', function ($query) use ($params) {
            // set country id where clause
            if (isset($params['country_id']) && ($countryId = $params['country_id']) !== '*') {
                $query->where('country_id', $countryId);
            }

            // country where clause
            $query->whereHas('country', function ($query) use ($params) {
                if (isset($params['continent_id']) && ($continentId = $params['continent_id']) !== '*') {
                    $query->where('continent_id', $continentId);
                }
            });
        });

        // state_id where clause
        if (isset($params['state_id']) && ($stateId = $params['state_id']) !== '*') {
            $builder->where('state_id', $stateId);
        }

        // is_active where clause
        if (isset($params['is_active']) && ($isActive = $params['is_active']) !== '*') {
            $builder->where('is_active', $isActive);
        }

        // city name where clause
        if (isset($params['name'])) {
            $builder->where('name', $params['name']);
        }

        return $builder;
    }

    /**
     * fetches city details by city name
     *
     * @param string $city
     * @param int $stateId
     * @return City|null
     */
    public function getCityByName($city, $stateId) : ?City
    {
        return $this->getBuilder()
            ->where('state_id', $stateId)
            ->where('name', $city)
            ->first();
    }

    /**
     * fetches city details by city name
     *
     * @param id $city
     * @return City|null
     */
    public function getCityById($city) : ?City
    {
        return $this->getBuilder()
            ->where('id', $city)
            ->first();
    }
}
