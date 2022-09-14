<?php

namespace App\Repository;

use App\Models\UserActivity;
use App\Models\User;

class UserActivityRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\UserActivity $model
     */
    public function __construct(UserActivity $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * create/updates model data to storage
     *
     * @param  array                   $attributes
     * @param  App\Models\User         $user
     * @param  App\Models\UserActivity $model
     *
     * @return App\Models\Favorite
     */
    public function store(array $attributes, User $user, UserActivity $model = null): UserActivity
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
     * Get last activity of escort used for member
     * 
     * @param int $escortId
     * @param int $memberId
     * @return UserActivity|null
     */
    public function getLastEscortActivityForMember($escortId, $memberId) :? UserActivity
    {
        $activity = $this->getBuilder()
            ->where('user_id', $escortId)
            ->where(function($q) use ($memberId) {
                // profile update
                $q->where('object_type', UserActivity::ESCORT_TYPE);
                // photo
                $q->orWhere(function($q2) {
                    $q2->where('object_type', UserActivity::PHOTO_TYPE);
                    $q2->whereIn('action', ['add_photo']);
                });
                // video
                $q->orWhere(function($q3) {
                    $q3->where('object_type', UserActivity::VIDEO_TYPE);
                    $q3->whereIn('action', ['add_private_video', 'add_public_video']);
                });
                // review reply
                $q->orWhere(function($q3) use ($memberId) {
                    $q3->where('object_type', UserActivity::REVIEW_TYPE);
                    $q3->whereIn('action', ['reply']);
                    $q3->whereRaw('object_id IN(SELECT id FROM user_reviews WHERE user_id = ' . $memberId . ')');
                });
            })
            ->orderByDesc(UserActivity::UPDATED_AT)
            ->first();
        
        return $activity;
    }
}
