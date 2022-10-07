<?php
/**
 * countries repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Country;
use Illuminate\Support\Collection;

class CountryRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Country $model
     */
    public function __construct(Country $model)
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
     * get all active countries by continent identifier
     *
     * @param  mixed $id
     *
     * @return Collection
     */
    public function getActiveCountriesByContinent($id) : Collection
    {
        return $this->getBuilder()
            ->where(function ($query) use ($id) {
                if (is_array($id)) {
                    $query->whereIn('continent_id', $id);
                } else {
                    $query->where(['continent_id' => $id]);
                }
            })
            ->orderBy('name', 'ASC')
            ->get();
    }

    /**
     * checks if current country or country key is active
     *
     * @param  mixed $country
     *
     * @return boolean
     */
    public function isActiveCountry($country) : bool
    {
        if ($country instanceof Country) {
            return $country->isActive();
        }

        // get city
        $country = $this->find($country);

        return ($country) ? $country->isActive() : false;
    }

    /**
     * fetches country information by name
     *
     * @param string $country
     * @return Country|null
     */
    public function getCountryByName($country) : ?Country
    {
        return $this->getBuilder()
            ->where('name', $country)
            ->first();
    }

    /**
     * fetches country information by name
     *
     * @param int $country
     * @return Country|null
     */
    public function getCountryById($country) : ?Country
    {
        return $this->getBuilder()
            ->where('id', $country)
            ->first();
    }
}
