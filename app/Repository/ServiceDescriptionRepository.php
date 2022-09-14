<?php
/**
 * repository class for service description eloquent model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Service;
use App\Models\Language;
use App\Models\ServiceDescription;

class ServiceDescriptionRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\ServiceDescription $model
     */
    public function __construct(ServiceDescription $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/update record to storage
     *
     * @param  array                         $attributes
     * @param  App\Models\Language           $language
     * @param  App\Models\Service            $service
     * @param  App\Models\ServiceDescription $model
     *
     * @return App\Models\ServiceDescription
     */
    public function store(
        array $attributes,
        Language $language,
        Service $service,
        ServiceDescription $model = null
    ) : ServiceDescription {

        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // map attributes to model
        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        $model->language()->associate($language);
        $model->service()->associate($service);

        // save model instance
        $model->save();

        return $model;
    }
}
