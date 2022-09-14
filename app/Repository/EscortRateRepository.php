<?php
/**
 * repository class for escort rate eloquent model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Escort;
use App\Models\Currency;
use App\Models\EscortRate;
use App\Models\RateDuration;

class EscortRateRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\EscortRate $model
     */
    public function __construct(EscortRate $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * stores data to repository storage
     *
     * @param  array                   $attributes
     * @param  App\Models\Escort       $escort
     * @param  App\Models\Currency     $currency
     * @param  App\Models\RateDuration $duration
     * @param  App\Models\EscortRate   $model
     *
     * @return App\Models\EscortRate
     */
    public function store(array $attributes, Escort $escort, Currency $currency, RateDuration $duration, EscortRate $model = null) : EscortRate
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // associate current escort with the current rate
        $model->escort()->associate($escort);
        $model->duration()->associate($duration);
        $model->currency()->associate($currency);

        // save
        return parent::save($attributes, $model);
    }
}
