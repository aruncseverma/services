<?php
/**
 * account deletion request eloquent model repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Models\AccountDeletionRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountDeletionRequestRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Model\AccountDeletionRequest $model
     */
    public function __construct(AccountDeletionRequest $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * creates/updates data to storage
     *
     * @param  array                            $attributes
     * @param  App\Model\User                   $user
     * @param  App\Model\AccountDeletionRequest $model
     *
     * @return App\Model\AccountDeletionRequest
     */
    public function store(array $attributes, User $user, AccountDeletionRequest $model = null) : AccountDeletionRequest
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        // populate model
        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        $model = $user->deletionRequest()->save($model);

        return $model;
    }

    /**
     * search repository with given params
     *
     * @param  int   $limit
     * @param  array $params
     *
     * @return Illuminate\Support\Collection
     */
    public function search(int $limit, array $params = []) : LengthAwarePaginator
    {
        $builder = $this->createSearchBuilder($params);

        return $builder->paginate($limit)->appends($params);
    }

    /**
     * create query builder instance
     *
     * @param  array $params
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createSearchBuilder(array $params = []) : Builder
    {
        $builder = $this->getBuilder();

        $builder->with('user');

        // where clause for relationship
        $builder->whereHas('user', function ($query) use ($params) {
            // type where clause
            if (isset($params['type'])) {
                $query->where('type', $params['type']);
            }

            // name where clause
            if (isset($params['name'])) {
                $query->where('name', 'like', "%{$params['name']}%");
            }

            if (isset($params['is_active']) && ($isActive = $params['is_active']) !== '*') {
                $query->where('is_active', $isActive);
            }
        });

        return $builder;
    }
}
