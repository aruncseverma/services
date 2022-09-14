<?php

namespace App\Repository;

use App\Models\Post;
use App\Models\PostPhoto;
use App\Support\Concerns\InteractsWithPostPhotoStorage;

class PostPhotoRepository extends Repository
{
    use InteractsWithPostPhotoStorage;

    /**
     * create instance
     *
     * @param App\Models\PostPhoto $model
     */
    public function __construct(PostPhoto $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * {@inheritDoc}
     *
     * @param  mixed $id
     *
     * @return App\Models\PostPhoto|null
     */
    public function find($id)
    {
        return $this->getBuilder()
            ->where($this->getModel()->getKeyName(), $id)
            ->first();
    }

    /**
     *  Fetches all photos by the post
     *
     *  @param int $postId
     *  @return array(App\Models\PostPhoto) | null
     */
    public function fetchAllPhotosByPost($postId)
    {
        return $this->getBuilder()
            ->where('post_id', $postId)
            ->get();
    }

    /**
     *  Fetches the featured photo of the post
     *
     *  @param String $postId
     *  @return (App\Model\PostPhoto) | null
     */
    public function fetchFeaturedPhoto($postId)
    {
        return $this->getBuilder()
            ->where('post_id', $postId)
            ->where('type', PostPhoto::FEATURED_PHOTO)
            ->first();
    }

    /**
     *  Deletes Image
     *
     *  @param int $photoId
     *  @return boolean
     */
    public function remove($photoId)
    {
        return $this->getBuilder()
            ->where('id', $photoId)
            ->delete();
    }

    /**
     * store photo information to repository
     *
     * @param  array                   $attributes
     * @param  App\Models\Post        $post
     * @param  App\Models\PostPhoto|null  $model
     *
     * @return App\Models\PostPhoto
     */
    public function store(array $attributes, Post $post, PostPhoto $model = null) : PostPhoto
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // associate
        $model->post()->associate($post);

        return parent::save($attributes, $model);
    }

    /**
     * Delete post photos by post_id
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

        $photos = $this->getBuilder()->whereIn('post_id', $ids)->get();
        $affected = 0;
        foreach($photos as $photo) {
            if ($this->deletePostPhoto($photo->path)) {
                // delete to repository
                if ($this->delete($photo->getKey())) {
                    ++$affected;
                }
            }
        }
        return $affected;
    }
}
