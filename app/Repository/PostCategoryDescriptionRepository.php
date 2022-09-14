<?php

namespace App\Repository;

use App\Models\Language;
use App\Models\PostCategory;
use App\Models\PostCategoryDescription;

class PostCategoryDescriptionRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\PostCategoryDescription $model
     */
    public function __construct(PostCategoryDescription $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/update record to storage
     *
     * @param  array                              $attributes
     * @param  App\Models\Language                $language
     * @param  App\Models\PostCategory            $category
     * @param  App\Models\PostCategoryDescription $model
     *
     * @return App\Models\PostCategoryDescription
     */
    public function store(
        array $attributes,
        Language $language,
        PostCategory $category,
        PostCategoryDescription $model = null
    ): PostCategoryDescription {
        // insert
        if (is_null($model) || !$model->exists) {

            $model = $this->newModelInstance();
            $model->language()->associate($language);
            $model->category()->associate($category);

            // map attributes to model
            foreach ($attributes as $attribute => $value) {
                $model->setAttribute($attribute, $value);
            }

            // save model instance
            $model->save();
            return $model;
        }

        // update
        $model
        ->where('category_id', $category->getKey())
        ->where('lang_code', $language->code)
        ->update($attributes);

        return $model;
    }

    /**
     * Delete post category descriptions by category_id
     * 
     * @param int|array $ids
     * 
     * @return bool
     */
    public function deleteByIds($ids) : bool
    {
        if (empty($ids)) {
            return false;
        }
        if (!is_array($ids)) {
            $ids = array($ids);
        }

        $res = $this->getBuilder()->whereIn('category_id', $ids)->delete();
        return ($res);
    }

    /**
     * get category by category name and langcode
     * 
     * @param string $categoryName
     * @param string $langCode
     * @return null|PostCategory
     */
    public function findByCategoryName($categoryName, $langCode) : ?PostCategory
    {
        if (is_null($categoryName)) {
            return null;
        }
        if (is_null($langCode)) {
            $langCode = app()->getLocale();
        }
        $model = $this->findBy([
            'name' => $categoryName,
            'lang_code' => $langCode,
        ]);
        
        if (!$model) {
            return null;
        }
        return $model->category;
    }
}
