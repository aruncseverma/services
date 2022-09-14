<?php
/**
 * repository class for escort rates eloquent
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Escort;
use App\Models\Service;
use App\Models\EscortService;

class EscortServiceRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\EscortService $model
     */
    public function __construct(EscortService $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * store values to repository storage
     *
     * @param  array $attributes
     * @param  App\Models\Escort        $escort
     * @param  App\Models\Service       $service
     * @param  App\Models\EscortService $model
     *
     * @return App\Models\EscortService
     */
    public function store(array $attributes, Escort $escort, Service $service, EscortService $model = null) : EscortService
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // associate relations
        $model->escort()->associate($escort);
        $model->service()->associate($service);

        // save
        return parent::save($attributes, $model);
    }
}
