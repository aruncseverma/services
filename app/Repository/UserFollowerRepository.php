<?php

namespace App\Repository;

use App\Models\User;
use App\Models\UserFollower;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserFollowerRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserFollower $model
     */
    public function __construct(UserFollower $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                        $attributes
     * @param  App\Models\User              $follower
     * @param  App\Models\User              $followed
     * @param  App\Models\UserFollower|null $model
     *
     * @return App\Models\UserFollower
     */
    public function store(array $attributes, User $follower, User $followed, UserFollower $model = null) : UserFollower
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        $model->follower()->associate($follower);
        $model->followed()->associate($followed);

        // save model
        $model = parent::save($attributes, $model);

        return $model;
    }

    /**
     * find follower by id that is attached from the user
     *
     * @param  string $field
     * @param  App\Models\User $user
     *
     * @return App\Models\UserFollower|null
     */
    public function findFollowerById(string $id, User $user) : ?UserFollower
    {
        return $user->followers()->where('id', $id)->first();
    }

    /**
     * find followers by ids that is attached from the user
     *
     * @param  array $ids
     * @param  App\Models\User $user
     *
     * @return Collection
     */
    public function findFollowerByIds(array $ids, User $user) : Collection
    {
        return $user->followers()->whereIn('id', $ids)->get();
    }

    /**
     * update followers by ids that is attached from the user
     *
     * @param  array $attributes
     * @param  array $ids
     * @param  App\Models\User $user
     *
     * @return integer
     */
    public function updateFollowerByIds(array $attributes, array $ids, User $user) : int
    {
        $rows = $this->findFollowerByIds($ids, $user);

        $ids = $rows->pluck('id');

        return $user->followers()->whereIn('id', $ids)->update($attributes);
    }

    /**
     * search for models with paginated results
     *
     * @param  integer $limit
     * @param  array   $search
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(int $pageSize, array $params = []) : LengthAwarePaginator
    {
        $builder = $this->createUserFollowersBuilder($params);

        if (isset($params['followed_user_id'])) {
            unset($params['followed_user_id']);
        }

        if (isset($params['is_banned'])) {
            unset($params['is_banned']);
        }

        // change page param
        $pageParam = (isset($params['page_param'])) ? $params['page_param'] : 'page';
        unset($params['page_param']);

        return $builder->paginate($pageSize, ['*'], $pageParam)->appends($params);
    }


    /**
     * creates user reviews collection query builder
     *
     * @param  array $params
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createUserFollowersBuilder(array $params) : Builder
    {
        // merge default params
        $params = array_merge(
            [
                'sort'       => $this->getModel()->getKeyName(),
                'sort_order' => 'desc'
            ],
            $params
        );

        // get model query builder
        $builder = $this->getBuilder();

        // followed user id where clause
        if (isset($params['followed_user_id'])) {
            if (is_array($params['followed_user_id'])) {
                $builder->whereIn('followed_user_id', $params['followed_user_id']);
            } else {
                $builder->where('followed_user_id', (int) $params['followed_user_id']);
            }
        }

        // follower user id where clause
        if (isset($params['follower_user_id'])) {
            $builder->where('follower_user_id', (int) $params['follower_user_id']);
        }

        // is banned where clause
        if (isset($params['is_banned'])) {
            $builder->where('is_banned', (int) $params['is_banned']);
        }

        // define all allowed fields to be sorted
        $allowedOrderFields = [
            'follower_user_id',
            UserFollower::CREATED_AT,
            UserFollower::UPDATED_AT,
        ];

        // create sort clause
        $this->createBuilderSort($builder, $params['sort'], $params['sort_order'], $allowedOrderFields);

        return $builder;
    }

    /**
     * find follower by follower id that is attached from the user
     *
     * @param  string $field
     * @param  App\Models\User $user
     *
     * @return App\Models\UserFollower|null
     */
    public function findFollowerByFollowerId(string $id, User $user): ?UserFollower
    {
        return $user->followers()->where('follower_user_id', $id)->first();
    }

    /**
     * get all followed user ids of follower user id
     * 
     * @param User $user
     * @param array $conditions
     * @return array
     */
    public function getFollowedUserIds($user, $conditions = []) : array
    {
        return $user->followed()
            ->select('id', 'followed_user_id')
            ->where(function($q) use ($conditions) {
                if (!empty($conditions) && is_array($conditions)) {

                }
                foreach($conditions as $col => $val) {
                    if (is_array($val)) {
                        $q->whereIn($col, $val);
                    } else {
                        $q->where($col, $val);
                    }
                }
            })
            ->get()
            ->pluck('followed_user_id', 'id')
            ->toArray();
    }
}
