<?php
/**
 * user model repository class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\Administrator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Events\Repository\Users as Events;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\User $model
     */
    public function __construct(User $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * @override
     *
     * @param  array                $attributes
     * @param  App\Models\User|null $user
     *
     * @return App\Models\User
     */
    public function save(array $attributes, $user = null) : User
    {
        // check if given user model instance of App\Models\User class
        $this->isModelInstanceOf($user, User::class);

        // save model
        $user = parent::save($attributes, $user);

        /**
         * trigger event
         *
         * @param \App\Models\User $user
         * @param array            $attributes
         */
        event(new Events\SavedModelInstance($user, $attributes));

        return $user;
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
        $builder = $this->createUsersBuilder($params);

        return $builder->paginate($pageSize)->appends($params);
    }

    /**
     * find all rows of given params and return its collection
     *
     * @param  array $params
     *
     * @return Illuminate\Support\Collection
     */
    public function findAll(array $params = []) : Collection
    {
        return $this->createUsersBuilder($params)->get();
    }

    /**
     * delete a row from the repository
     *
     * @param  mixed $id
     *
     * @return boolean
     */
    public function delete($id) : bool
    {
        $user = $this->find($id);

        // no model was found
        if (! $user) {
            return false;
        }

        // delete a model
        // when deleting a user from the repository
        // eloquent will automaticaly do a soft delete if current table structure
        // has a delete timestamp run forceDelete method for force deleting
        // unless model is using the trait Illuminate\Database\Eloquent\SoftDeletes
        // see https://laravel.com/docs/5.6/eloquent#deleting-models
        $result = (bool) $user->delete();

        /**
         * trigger event
         *
         * @param bool             $result
         * @param \App\Models\User $user
         */
        event(new Events\DeletingUser($result, $user));

        return $result;
    }

    /**
     * creates users collection query builder
     *
     * @param  array $params
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createUsersBuilder(array $params) : Builder
    {
        
        
        
        // merge default params
        $params = array_merge(
            [
                'type'       => Administrator::USER_TYPE,
                'sort'       => $this->getModel()->getKeyName(),
                'sort_order' => 'asc'
            ],
            $params
        );

        // get model query builder
        $builder = $this->getBuilder();

        // set user type where clause
        $builder->where('type', $params['type']);
        $builder->where($this->getModel()->getDeletedAtColumn(), null);

        // name where clause
        if (isset($params['name'])) {
            $builder->where('name', 'like', "%{$params['name']}%");
        }

        // active where clause
        $isActive = (isset($params['is_active'])) ? $params['is_active'] : '*';
        if ($isActive !== '*') {
            $builder->where('is_active', (int) $isActive);
        }

        // is approved where clause=
        if (isset($params['is_approved'])) {
            $builder->where('is_approved', (bool) $params['is_approved']);
        }

        // agency name where clause
        if (isset($params['name'])) {
            $builder->where('name', 'like', '%' . $params['name'] . '%');
        }

        // email where clause
        if (isset($params['email'])) {
            $builder->where('email', 'like', '%' . $params['email'] . '%');
        }

        // created_at where clause
        if (!empty($params['created_at_start'])) {
            
           $builder->whereDate('created_at', '>=', date("Y-m-d", strtotime($params['created_at_start'])));
        }
        if (!empty($params['created_at_end'])) {
            $builder->whereDate('created_at', '<=', date("Y-m-d", strtotime($params['created_at_end'])));
        }

        // define all allowed fields to be sorted
        $allowedOrderFields = [
            'name',
            User::CREATED_AT,
            User::UPDATED_AT,
        ];

        // create sort clause
        $this->createBuilderSort($builder, $params['sort'], $params['sort_order'], $allowedOrderFields);

        /**
         * trigger event
         *
         * @param \Illuminate\Database\Eloquent\Builder $builder
         * @param array                                 $params
         */
        event(new Events\CreatingSearchBuilder($builder, $params));

        return $builder;
    }

    /**
     * get total
     *
     * @return integer
     */
    public function getTotal() : int
    {
        return $this->getBuilder()
            ->where('type', $this->getModel()->getType())
            ->whereNull($this->getModel()->getDeletedAtColumn())
            ->count();
    }

    /**
     * get total pending
     *
     * @return integer
     */
    public function getTotalPending() : int
    {
        return $this->getBuilder()
            ->where('type', $this->getModel()->getType())
            ->where('is_approved', false)
            ->whereNull($this->getModel()->getDeletedAtColumn())
            ->count();
    }

    /**
     * get total approved
     *
     * @return integer
     */
    public function getTotalApproved() : int
    {
        return $this->getBuilder()
            ->where('type', $this->getModel()->getType())
            ->where('is_approved', true)
            ->whereNull($this->getModel()->getDeletedAtColumn())
            ->count();
    }

    /**
     * get total blocked
     *
     * @return integer
     */
    public function getTotalBlocked() : int
    {
        return $this->getBuilder()
            ->where('type', $this->getModel()->getType())
            ->where('is_blocked', true)
            ->whereNull($this->getModel()->getDeletedAtColumn())
            ->count();
    }

    /**
     * get new user total
     *
     * @return integer
     */
    public function getNewTotal() : int
    {
        return $this->getBuilder()
            ->where('type', $this->getModel()->getType())
            ->whereDate($this->getModel()->getCreatedAtColumn(), Carbon::today())
            ->whereNull($this->getModel()->getDeletedAtColumn())
            ->count();
    }

    /**
     * set user group
     *
     * @param  App\Models\User      $user
     * @param  App\Models\UserGroup $group
     *
     * @return void
     */
    public function setUserGroup(User $user, UserGroup $group) : User
    {
        // associate to user group
        $user->userGroup()->associate($group);

        return parent::save([], $user);
    }

    /**
     * Get user data by email
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @param string $email
     *
     * @return User|null
     */
    public function findUserByEmail($email) : ?User
    {
        return $this->getBuilder()
            ->where('email', $email)
            ->first();
    }

    /**
     * Get user data by username
     * 
     * @param string $email
     * @return User|null
     */
    public function findUserByUsername($username): ?User
    {
        return $this->getBuilder()
            ->where('username', $username)
            ->first();
    }

    /**
     * Get all users by usernames
     * 
     * @param string|array $username
     * @return Collection|null
     */
    public function getAllByUsernames($usernames): ?Collection
    {
        if (empty($usernames)) {
            return null;
        }

        if (!is_array($usernames)) {
            $usernames = explode(',', $usernames);
        }
        return $this->getBuilder()
            ->whereIn('username', $usernames)
            ->get();
    }

    /**
     * Get all users by emails
     * 
     * @param string|array $emails
     * @return Collection|null
     */
    public function getAllByEmails($emails): ?Collection
    {
        if (empty($emails)) {
            return null;
        }

        if (!is_array($emails)) {
            $emails = explode(',', $emails);
        }
        return $this->getBuilder()
            ->whereIn('email', $emails)
            ->get();
    }
}
