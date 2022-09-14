<?php
/**
 * repository class for service category description eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Language;
use App\Models\ServiceCategory;
use App\Models\ServiceCategoryDescription;

class ServiceCategoryDescriptionRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\ServiceCategoryDescription $model
     */
    public function __construct(ServiceCategoryDescription $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * store values to repository
     *
     * @param  array                                 $attributes
     * @param  App\Models\ServiceCategory            $category
     * @param  App\Models\Language                   $language
     * @param  App\Models\ServiceCategoryDescription $model
     *
     * @return App\Models\ServiceCategoryDescription
     */
    public function store(array $attributes, ServiceCategory $category, Language $language, ServiceCategoryDescription $model = null) : ServiceCategoryDescription
    {
        // create new model instance if null is given
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        $model->language()->associate($language);
        $model->category()->associate($category);

        // save
        return parent::save($attributes, $model);
    }
}
