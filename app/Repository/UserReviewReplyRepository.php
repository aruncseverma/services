<?php

namespace App\Repository;

use App\Models\User;
use App\Models\UserReview;
use App\Models\UserReviewReply;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class UserReviewReplyRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserReviewReply $model
     */
    public function __construct(UserReviewReply $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                      $attributes
     * @param  App\Models\User            $user
     * @param  App\Models\UserReview      $review
     * @param  App\Models\UserReviewReply $model
     *
     * @return App\Models\UserReviewReply
     */
    public function store(array $attributes, User $user, UserReview $review, UserReviewReply $model = null) : UserReviewReply
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        $model->user()->associate($user);
        $model->review()->associate($review);

        // save model
        $model = parent::save($attributes, $model);

        return $model;
    }

    /**
     * Get all latest new review replies 
     * 
     * @param User $user
     * @return Collection|null
     */
    public function getAllLatestNewReviewReplies($user): ?Collection
    {
        $replies = $user->sentReviews()
            ->with([
                'replies' => function($q) {
                    $q->select('id', 'review_id', 'content', 'created_at');
                    $q->whereNull('seen_at');
                    $q->whereDate(UserReviewReply::CREATED_AT, Carbon::today());
                },
                'object'=> function($q) {
                    $q->select('id', 'name');
                }
            ])
            ->whereHas('replies', function($q) {
                $q->whereNull('seen_at');
                $q->whereDate(UserReviewReply::CREATED_AT, Carbon::today());
            })
            ->get();
        return $replies;
    }

    /**
     * Marks reply as seen
     * 
     * @param string|array $ids
     * @return bool|null
     */
    public function markReplyAsSeen($ids): ?bool
    {
        if (empty($ids)) {
            return false;
        }
        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        $model = $this->newModelInstance();
        return $model->whereIn($model->getKeyName(), $ids)
            ->whereNull('seen_at')
            ->update([
                'seen_at'   => Carbon::now()
            ]);
    }
}
