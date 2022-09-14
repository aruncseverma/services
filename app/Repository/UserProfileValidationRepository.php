<?php
/**
 * repository class for membership requests eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserProfileValidation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserProfileValidationRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserProfileValidation $model
     */
    public function __construct(UserProfileValidation $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * store data to repository
     *
     * @param  array                        $attributes
     * @param  App\Models\User              $user
     * @param  App\Models\UserGroup         $userGroup
     * @param  App\Models\UserProfileValidation $model
     *
     * @return App\Models\UserProfileValidation
     */
    public function store(array $attributes, User $user, UserGroup $userGroup, UserProfileValidation $model = null) : UserProfileValidation
    {
        if (is_null($model)) {
            $model = $this->newModelInstance();
        }

        // associate relations
        $model->user()->associate($user);
        $model->userGroup()->associate($userGroup);

        return parent::save($attributes, $model);
    }

    /**
     * search for list of user group request with paginated result
     *
     * @param  integer    $limit
     * @param  array|null $params
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function search(int $limit, ?array $params = []) : LengthAwarePaginator
    {
        return $this->createSearchBuilder($params)->paginate($limit)->appends($params);
    }

    /**
     * create search builder
     *
     * @param  array $params
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createSearchBuilder(array $params = []) : Builder
    {
        // get builder instance
        $builder =  $this->getBuilder();

        // eager load relations
        $builder->with('user');
        $builder->with('userGroup');

        // relation where clause
        $builder->whereHas('user', function ($query) use ($params) {
            if (isset($params['user_type'])) {
                $query->where('type', $params['user_type']);
            }

            if (isset($params['name'])) {
                $query->where('name', 'like', "%{$params['name']}%");
            }
        });

        $builder->whereHas('userGroup', function ($query) use ($params) {
            $userGroupId = (isset($params['user_group_id'])) ? $params['user_group_id'] : '*';

            if ($userGroupId !== '*') {
                $query->where($query->getModel()->getKeyName(), $params['user_group_id']);
            }
        });

        $isDenied = (isset($params['is_denied'])) ? $params['is_denied'] : '*';
        if ($isDenied !== '*') {
            $builder->where('is_denied', (bool) $isDenied);
        }

        $isApproved = (isset($params['is_approved'])) ? $params['is_approved'] : '*';
        if ($isApproved !== '*') {
            $builder->where('is_approved', (bool) $isApproved);
        }

        $builder->orderBy($this->getModel()->getCreatedAtColumn(), 'DESC');

        return $builder;
    }
}
