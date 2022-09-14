<?php

namespace App\Repository;

use App\Models\PostComment;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostCommentRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\PostComment $model
     */
    public function __construct(PostComment $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/update record to storage repository
     *
     * @param  array                   $attributes
     * @param  App\Models\PostComment  $model
     *
     * @return App\Models\PostComment
     */
    public function store(array $attributes, PostComment $model = null): PostComment
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // save model
        $model = parent::save($attributes, $model);

        return $model;
    }

    /**
     * search repository for given params and return result
     * with a paginated result
     *
     * @param  integer $limit
     * @param  array   $search
     * @param  bool    $isPaginate
     * @param  bool    $isAppend
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator|Illuminate\Database\Eloquent\Collection;
     */
    public function search(int $limit, array $search = [], $isPaginate = true, $isAppend = true)
    {
        $builder = $this->createSearchBuilder($search);

        // create sort clause
        if (!empty($search['sort']) && !empty($search['order'])) {
            $this->createBuilderSort($builder, $search['sort'], $search['order']);
        }

        if ($isPaginate) {
            $pagination = $builder->paginate($limit);
            if ($isAppend) {
                $pagination->appends($search);
            }
            return $pagination;
        }

        if ($limit > 0) {
            $builder->take($limit);
        }
        return $builder->get();
    }

    /**
     * create builder instance
     *
     * @param  array $search
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createSearchBuilder(array $search): Builder
    {
        $builder = $this->getBuilder();

        $builder->where(function($q) use ($search) {
            // is approved where clause
            if (isset($search['is_approved']) && ($isApproved = $search['is_approved']) !== '*') {
                $q->orWhere('is_approved', (bool) $isApproved);
            }
            if (!empty($search['display_pending_id'])) {
                $ids = is_array($search['display_pending_id']) ? $search['display_pending_id'] : explode(',', $search['display_pending_id']);
                $q->whereIn('id', $ids, 'or');
            }
            if (!empty($search['comment_user_id'])) {
                $q->orWhere('user_id', $search['comment_user_id']);
            }
        });

        // parent where clause
        if (array_key_exists("parent_id", $search)) {
            $builder->where('parent_id', $search['parent_id']);
        }

        // id where clause
        if (!empty($search['id'])) {
            $ids = is_array($search['id']) ? $search['id'] : explode(',', $search['id']);
            $builder->whereIn('id', $ids);
        }

        // post_id where clause
        if (!empty($search['post_id'])) {
            $ids = is_array($search['post_id']) ? $search['post_id'] : explode(',', $search['post_id']);
            $builder->whereIn('post_id', $ids);
        }

        // where content clause
        if (isset($search['content'])) {
            $builder->where('content', 'like', "%{$search['content']}%");
        }

        // user_id where clause
        if (!empty($search['user_id'])) {
            $ids = is_array($search['user_id']) ? $search['user_id'] : explode(',', $search['user_id']);
            $builder->whereIn('user_id', $ids);
        }

        return $builder;
    }

    /**
     * Update parent comment
     * 
     * find all replies w/ parent_id equal to $oldParentId
     * and replace it with the value of $newParentId
     * 
     * @param int|null $oldParentId 
     * @param int|null $newParentId 
     * @return int
     */
    public function updateParentId($oldParentId = null, $newParentId = null): int
    {
        return $this->getModel()
            ->where('parent_id', $oldParentId)
            ->update([
                'parent_id' => $newParentId,
            ]);
    }

    public function deleteReplies($replies)
    {
        $affected = 0;
        if (!$replies) {
            return $affected;
        }
        $ids = [];
        foreach ($replies as $reply) {
            $comments = $reply->comments ?? false;
            if ($comments) {
                $affected += $this->deleteReplies($comments);
            }
            $ids[] = $reply->getKey();

            if (!empty($ids)) {
                $affected += $this->getBuilder()->whereIn('id', $ids)->delete() ?? 0;
            }
        }

        return $affected;
    }

    /**
     * Get latest comments
     * 
     * @param int $limit
     * @return Collection
     */
    public function getLatest($limit = 5): Collection
    {
        $rows = $this->getBuilder()->with('post')->where('is_approved', true)->latest()->take($limit)->get();
        return $rows;
    }

    /**
     * Delete post comments by post_id
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
}
