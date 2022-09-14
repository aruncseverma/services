<?php
/**
 * repository class for ban country eloquentm odel class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\User;
use App\Models\Country;
use App\Models\BanCountry;

class BanCountryRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\BanCountry $model
     */
    public function __construct(BanCountry $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * creates/updates record to the storage
     *
     * @param  array                 $attributes
     * @param  App\Models\User       $user
     * @param  App\Models\Country    $country
     * @param  App\Models\BanCountry $model
     *
     * @return App\Models\BanCountry
     */
    public function store(array $attributes, User $user, Country $country, BanCountry $model = null) : BanCountry
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        // associates relations
        $model->user()->associate($user);
        $model->country()->associate($country);

        // saves model
        $model->save();

        return $model;
    }
}
