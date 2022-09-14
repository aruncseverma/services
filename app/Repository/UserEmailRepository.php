<?php
/**
 * repository class for user emails eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use Carbon\Carbon;
use App\Models\UserEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserEmailRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserEmail $model
     */
    public function __construct(UserEmail $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * search list of emails
     *
     * @param  integer $limit
     * @param  array   $search
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(int $limit, array $search = []) :  LengthAwarePaginator
    {
        return $this->createSearchBuilder($search)->paginate($limit)->appends($search);
    }

    /**
     * create builder instance
     *
     * @param array $search
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createSearchBuilder(array $search = []) : Builder
    {
        $builder = $this->getBuilder();

        $builder->with('sender');
        $builder->with('recipient');

        $builder->whereHas('sender', function ($query) use ($search) {
            if (isset($search['sender_user_id'])) {
                $query->where($query->getModel()->getKeyName(), $search['sender_user_id']);
            }
        });

        $builder->whereHas('recipient', function ($query) use ($search) {
            if (isset($search['recipient_user_id'])) {
                $query->where($query->getModel()->getKeyName(), $search['recipient_user_id']);
            }
        });

        $builder->orderBy('created_at', 'DESC');

        return $builder;
    }

    /**
     * Fetches the current number of unread emails
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @param int $userId
     * @return integer
     */
    public function getAllUnreadEmails($userId) : int
    {
        return $this->getBuilder()
            ->where('recipient_user_id', $userId)
            ->whereNull('seen_at')
            ->count();
    }

    /**
     * Marks the provided email as seen
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @param App\Models\UserEmail $email
     * @return App\Models\UserEmail|null
     */
    public function markEmailAsSeen(UserEmail $email) : ?UserEmail
    {
        return $this->save([
                'seen_at'   => Carbon::now()
            ], $email);
    }

    /**
     * Mark selected email as starred
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @param App\Models\UserEmail $email
     * @return App\Models\UserEmail|null
     */
    public function markEmailAsStarred(UserEmail $email) : ?UserEmail
    {
        return $this->save([
                'is_starred'    => true
            ], $email);
    }

    /**
     * Remove star from email
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @param App\Models\UserEmail $email
     * @return App\Models\UserEmail|null
     */
    public function unStarEmail(UserEmail $email) : ?UserEmail
    {
        return $this->save([
                'is_starred'    => false
            ], $email);
    }

    /**
     * Get all latest new emails
     * 
     * @param User $user
     * @return Collection|null
     */
    public function getAllLatestNewEmails($user) :? Collection
    {
        return $user->recipientEmails()->with([
            'sender' => function($q) {
                $q->select('id', 'name');
        }])
        ->whereNull('seen_at')
        ->whereDate(UserEmail::CREATED_AT, Carbon::today())
        ->get();
    }
}
