<?php
/**
 * attribute description model repository
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Attribute;
use App\Models\AttributeDescription;

class AttributeDescriptionRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\AttributeDescription $model
     */
    public function __construct(AttributeDescription $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * save attribute description
     *
     * @param  array                           $attributes
     * @param  App\ModelsAttribute             $attribute
     * @param  App\Models\AttributeDescription $model
     *
     * @return App\Models\AttributeDescription
     */
    public function saveDescription(array $attributes, Attribute $attribute, AttributeDescription $model = null) : AttributeDescription
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        foreach ($attributes as $key => $value) {
            $model->setAttribute($key, $value);
        }

        // save and bind model
        $attribute->descriptions()->save($model);

        return $model;
    }
}
