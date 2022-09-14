<?php

namespace App\Repository;

use App\Models\Language;
use App\Models\PostTag;
use App\Models\PostTagDescription;

class PostTagDescriptionRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\PostTagDescription $model
     */
    public function __construct(PostTagDescription $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/update record to storage
     *
     * @param  array                              $attributes
     * @param  App\Models\Language                $language
     * @param  App\Models\PostTag            $tag
     * @param  App\Models\PostTagDescription $model
     *
     * @return App\Models\PostTagDescription
     */
    public function store(
        array $attributes,
        Language $language,
        PostTag $tag,
        PostTagDescription $model = null
    ): PostTagDescription {
        // insert
        if (is_null($model) || !$model->exists) {

            $model = $this->newModelInstance();
            $model->language()->associate($language);
            $model->tag()->associate($tag);

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
            ->where('tag_id', $tag->getKey())
            ->where('lang_code', $language->code)
            ->update($attributes);

        return $model;
    }

    /**
     * Delete post tag descriptions by tag_id
     * 
     * @param int|array $ids
     * 
     * @return bool
     */
    public function deleteByIds($ids): bool
    {
        if (empty($ids)) {
            return false;
        }
        if (!is_array($ids)) {
            $ids = array($ids);
        }

        $res = $this->getBuilder()->whereIn('tag_id', $ids)->delete();
        return ($res);
    }

    /**
     * get tag by tag name and langcode
     * 
     * @param string $tagName
     * @param string $langCode
     * @return null|PostTag
     */
    public function findByTagName($tagName, $langCode): ?PostTag
    {
        if (is_null($tagName)) {
            return null;
        }
        if (is_null($langCode)) {
            $langCode = app()->getLocale();
        }
        $model = $this->findBy([
            'name' => $tagName,
            'lang_code' => $langCode,
        ]);

        if (!$model) {
            return null;
        }
        return $model->tag;
    }
}
