<?php
/**
 * rate duration description eloquent repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Language;
use App\Models\RateDuration;
use App\Models\RateDurationDescription;

class RateDurationDescriptionRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\RateDurationDescription $model
     */
    public function __construct(RateDurationDescription $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/update record to storage
     *
     * @param  array                              $attributes
     * @param  App\Models\Language                $language
     * @param  App\Models\RateDuration            $rateDuration
     * @param  App\Models\RateDurationDescription $model
     *
     * @return App\Models\RateDurationDescription
     */
    public function store(
        array $attributes,
        Language $language,
        RateDuration $rateDuration,
        RateDurationDescription $model = null
    ) : RateDurationDescription {

        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // map attributes to model
        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        $model->language()->associate($language);
        $model->rateDuration()->associate($rateDuration);

        // save model instance
        $model->save();

        return $model;
    }
}
