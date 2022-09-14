<?php

namespace App\Repository;

use App\Models\Language;
use App\Models\Post;
use App\Models\PostDescription;

class PostDescriptionRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\PostDescription $model
     */
    public function __construct(PostDescription $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/update record to storage
     *
     * @param  array                              $attributes
     * @param  App\Models\Language                $language
     * @param  App\Models\Post            $post
     * @param  App\Models\PostDescription $model
     *
     * @return App\Models\PostDescription
     */
    public function store(
        array $attributes,
        Language $language,
        Post $post,
        PostDescription $model = null
    ): PostDescription {
        // insert
        if (is_null($model) || !$model->exists) {

            $model = $this->newModelInstance();
            $model->language()->associate($language);
            $model->post()->associate($post);

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
        ->where('post_id', $post->getKey())
        ->where('lang_code', $language->code)
        ->update($attributes);

        return $model;
    }

    /**
     * Delete post descriptions by post_id
     * 
     * @param int|array $ids
     * 
     * @return bool
     */
    public function deleteByPostIds($ids) : bool
    {
        if (empty($ids)) {
            return false;
        }
        if (!is_array($ids)) {
            $ids = array($ids);
        }

        $res = $this->getBuilder()->whereIn('post_id', $ids)->delete();
        return ($res);
    }

    /**
     * Create unique title
     * 
     * @param string $title 
     * @param string $langCode
     * @param int|array $id
     * @return string|bool
     */
    public function generateTitle($title = '', $langCode = null, $id = 0)
    {
        if (empty($title)) {
            return false;
        }

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allTitles = $this->getRelatedTitles($title, $langCode, $id);

        // If we haven't used it before then we are all good.
        if (!$allTitles->contains('title', $title)) {
            return $title;
        }

        // Just append numbers like a savage until we find not used.
        $count = 1;
        $newTitle = $title . ' ' . $count;
        while ($allTitles->contains('title', $newTitle)) {
            ++$count;
            $newTitle = $title . ' ' . $count;
        }
        return $newTitle;
    }

    /**
     * Get Related titles
     * 
     * @param string $title
     * @param string $langCode
     * @param int|array $postId
     * @return Collection
     */
    protected function getRelatedTitles($title, $langCode, $postId = 0)
    {
        $langCode = $langCode ?? app()->getLocale();
        return $this->model
            ->select('title')
            ->where('title', 'like', $title . '%')
            ->where('lang_code', $langCode)
            ->where(function ($q) use ($postId) {
                if (!empty($postId)) {
                    $q->where('post_id', '<>', $postId);
                }
            })
            ->get();
    }
}
