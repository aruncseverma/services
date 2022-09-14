<?php

namespace App\Repository;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CommentRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Comment $model
     */
    public function __construct(Comment $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                   $attributes
     * @param  App\Models\User         $user
     * @param  App\Models\Comment $model
     *
     * @return App\Models\Comment
     */
    public function store(array $attributes, User $user, Comment $model = null): Comment
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        $model->user()->associate($user);

        // save model
        $model = parent::save($attributes, $model);

        return $model;
    }

    /**
     * search list of favorites
     *
     * @param  integer $limit
     * @param  array   $search
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(int $limit, array $search = []): LengthAwarePaginator
    {
        $appendQueryString = array_except($search, ['user_id', 'object_type', 'with_data']);
        return $this->createSearchBuilder($search)->paginate($limit)->appends($appendQueryString);
    }

    /**
     * create builder instance
     *
     * @param array $search
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createSearchBuilder(array $search = []): Builder
    {
        $builder = $this->getBuilder();

        if (!empty($search['with_data'])) {
            $builder->with($search['with_data']);
        }

        $builder->where(function ($query) use ($search) {
            if (isset($search['object_type'])) {
                $query->where('object_type', $search['object_type']);
            }
            if (isset($search['object_id'])) {
                $query->where('object_id', $search['object_id']);
            }
            if (isset($search['user_id'])) {
                $query->where('user_id', $search['user_id']);
            }
        });

        $builder->orderBy('created_at', 'DESC');

        return $builder;
    }
}
