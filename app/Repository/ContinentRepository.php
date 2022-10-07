<?php
/**
 * continents repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Continent;

class ContinentRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Continent $model
     */
    public function __construct(Continent $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * fetches country information by name
     *
     * @param int $continent
     * @return Continent|null
     */
    public function getContinentById($continent) : ?Continent
    {
        return $this->getBuilder()
            ->where('id', $continent)
            ->first();
    }

}
