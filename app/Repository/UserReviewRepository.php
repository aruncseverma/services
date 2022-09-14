<?php
/**
 * reviews repository class
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Repository;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserReview;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserReviewRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserReview $model
     */
    public function __construct(UserReview $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                 $attributes
     * @param  App\Models\User       $user
     * @param  App\Models\UserReview $model
     *
     * @return App\Models\UserReview
     */
    public function store(array $attributes, User $user, UserReview $model = null) : UserReview
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
     * find review by id that is attached from the user
     *
     * @param  string          $id
     * @param  App\Models\User $user
     *
     * @return App\Models\UserReview|null
     */
    public function findReviewById(string $id, User $user) : ?UserReview
    {
        return $user->reviews()->find($id);
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
        $builder = $this->createEscortReviewsBuilder($params);

        if (isset($params['user_id'])) {
            unset($params['user_id']);
        }

        // change page param
        $pageParam = (isset($params['page_param'])) ? $params['page_param'] : 'page';
        unset($params['page_param']);

        return $builder->paginate($pageSize, ['*'], $pageParam)->appends($params);
    }

    /**
     * get all user latest reviews
     *
     * @param  App\Models\User $user
     * @param  int             $limit
     *
     * @return void
     */
    public function getLatestReviews(User $user, int $limit)
    {
        $reviews = $user->reviews()
            ->whereDate(UserReview::CREATED_AT, Carbon::today())
            ->orderBy(UserReview::CREATED_AT, 'DESC')
            ->limit($limit)
            ->get();

        return $reviews;
    }

    /**
     * get rating average that is attached from the user
     *
     * @param  App\Models\User $user
     *
     * @return mixed
     */
    public function getReviewRatingAverage(User $user)
    {
        $ratings = $this->getBuilder()
            ->select('rating', DB::raw('count(*) as total'))
            ->where('object_id', $user->getKey())
            ->where('is_approved', 1)
            ->groupBy('rating')
            ->pluck('total', 'rating')
            ->all();

        $totalRatings = 0;
        $totalResponses = 0;
        if (!empty($ratings)) {
            foreach ($ratings as $rating => $totalResponse) {
                $totalRatings += ($rating*$totalResponse);
                $totalResponses += $totalResponse;
            }
        }

        $average = 0;
        if (!empty($totalRatings) && !empty($totalResponses)) {
            $average = $totalRatings/$totalResponses;
        }
        return number_format($average, 1, '.', ',');
    }

    /**
     * creates escort reviews collection query builder
     *
     * @param  array $params
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function createEscortReviewsBuilder(array $params) : Builder
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

        // user id where clause
        if (isset($params['user_id'])) {
            $builder->where('user_id', (int) $params['user_id']);
        }

        // user id where clause
        if (isset($params['object_id'])) {
            if (is_array($params['object_id'])) {
                $builder->whereIn('object_id', $params['object_id']);
            } else {
                $builder->where('object_id', (int) $params['object_id']);
            }
        }

        // content where clause
        if (isset($params['content'])) {
            $builder->where('content', 'like', "%{$params['content']}%");
        }

        // is approved where clause
        if (isset($params['is_approved'])) {
            $builder->where('is_approved', (bool) $params['is_approved']);
        }

        if (isset($params['id'])) {
            $builder->where($this->getModel()->getKeyName(), $params['id']);
        }

        if (isset($params['is_latest'])) {
            $builder->whereDate(UserReview::CREATED_AT, Carbon::today())->orderBy('created_at', 'DESC');
        }

        // define all allowed fields to be sorted
        $allowedOrderFields = [
            'user_id',
            UserReview::CREATED_AT,
            UserReview::UPDATED_AT,
        ];

        // create sort clause
        $this->createBuilderSort($builder, $params['sort'], $params['sort_order'], $allowedOrderFields);

        return $builder;
    }
}
