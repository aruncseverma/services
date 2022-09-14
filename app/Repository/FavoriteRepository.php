<?php

namespace App\Repository;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class FavoriteRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Favorite $model
     */
    public function __construct(Favorite $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                   $attributes
     * @param  App\Models\User         $user
     * @param  App\Models\Favorite $model
     *
     * @return App\Models\Favorite
     */
    public function store(array $attributes, User $user, Favorite $model = null): Favorite
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
     * find favorite by id that is attached from the user
     *
     * @param  string $field
     * @param  App\Models\User $user
     *
     * @return App\Models\Favorite|null
     */
    public function findFavoriteById(string $id, User $user): ?Favorite
    {
        return $user->favorites()->where('id', $id)->first();
    }

    /**
     * Get data by conditions
     * 
     * @param array $conditions
     * @return Favorite|null
     */
    public function getByConditions(array $conditions = []): ?Favorite
    {
        if (empty($conditions) || !is_array($conditions)) {
            return null;
        }

        return $this->getBuilder()
            ->where(function ($q) use ($conditions) {
                foreach ($conditions as $col => $val) {
                    $q->where($col, $val);
                }
            })->first();
    }

    /**
     * find favorite escort by escort id that is attached from the user
     *
     * @param  int $escortId
     * @param  App\Models\User $user
     *
     * @return App\Models\Favorite|null
     */
    public function findFavoriteEscortByEscortId(int $escortId, User $user): ?Favorite
    {
        return $user->favorites()
            ->where('object_type', Favorite::ESCORT_TYPE)
            ->where('object_id', $escortId)->first();
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
        } else {
            $builder->with('object');
        }

        $builder->where(function ($query) use ($search) {
            if (isset($search['object_type'])) {
                $query->where('object_type', $search['object_type']);
            }
            if (isset($search['user_id'])) {
                $query->where('user_id', $search['user_id']);
            }
        });

        // $builder->whereHas('recipient', function ($query) use ($search) {
        //     if (isset($search['recipient_user_id'])) {
        //         $query->where($query->getModel()->getKeyName(), $search['recipient_user_id']);
        //     }
        // });

        $builder->orderBy('created_at', 'DESC');

        return $builder;
    }

    /**
     * get all user latest reviews
     *
     * @param  App\Models\User $user
     * @param string objectType
     * @param  int             $limit
     *
     * @return void
     */
    public function getLatestFavorites(User $user, string $objectType, int $limit)
    {
        $defaultWith = 'object';
        $withList = [
            Favorite::ESCORT_TYPE => 'escort',
            Favorite::AGENCY_TYPE => 'agency',
        ];

        $with = $withList[$objectType] ?? $defaultWith;

        $reviews = $user->favorites()
            ->with([
                $with => function ($query) {
                    $query->select('id', 'name');
                }
            ])
            ->where('object_type', $objectType)
            ->whereDate(Favorite::CREATED_AT, Carbon::today())
            ->orderBy(Favorite::CREATED_AT, 'DESC')
            ->limit($limit)
            ->get();

        return $reviews;
    }
}
