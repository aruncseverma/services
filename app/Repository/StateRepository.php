<?php
/**
 * states repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Collection;

class StateRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\State $model
     */
    public function __construct(State $model)
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
     * save state instance
     *
     * @param  array              $attributes
     * @param  App\Models\Country $country
     * @param  App\Models\State   $model
     *
     * @return App\Models\State
     */
    public function saveState(array $attributes, Country $country, State $model = null) : State
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        // assign attributes
        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        // save model instance
        $country->states()->save($model);

        return $model;
    }

    /**
     * get all active states by country key
     *
     * @param  mixed $id
     *
     * @return Illuminate\Support\Collection
     */
    public function getActiveStatesByCountry($id) : Collection
    {
        return $this->getBuilder()
            ->where(function ($query) use ($id) {
                if (is_array($id)) {
                    $query->whereIn('country_id', $id);
                } else {
                    $query->where(['country_id' => $id]);
                }
            })
            ->orderBy('name', 'ASC')
            ->get();
    }

    /**
     * checks if current state or state key is active
     *
     * @param  mixed $state
     *
     * @return boolean
     */
    public function isActiveState($state) : bool
    {
        if ($state instanceof State) {
            return $state->isActive();
        }

        // get city
        $state = $this->find($state);

        return ($state) ? $state->isActive() : false;
    }

    /**
     * Finds the state details
     *
     * @return State|null
     */
    public function getStateByName($state, $countryId) : ?State
    {
        return $this->getBuilder()
            ->where('country_id', $countryId)
            ->where('name', $state)
            ->first();
    }

    /**
     * Finds the state details
     * @param  int $state
     * @return State|null
     */
    public function getStateById($state) : ?State
    {
        return $this->getBuilder()
            ->where('id', $state)
            ->first();
    }
}
