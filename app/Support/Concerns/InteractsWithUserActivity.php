<?php

namespace App\Support\Concerns;

use App\Repository\UserActivityRepository;
use App\Models\UserActivity;

trait InteractsWithUserActivity
{
    /**
     * get user activity repository instance
     *
     * @return App\Repository\UserActivityRepository
     */
    protected function getUserActivityRepository(): UserActivityRepository
    {
        return app(UserActivityRepository::class);
    }

    /**
     * Add user activity
     * 
     * @param string $objectType
     * @param int $objectId
     * @param string $action
     * @param array $data
     * 
     * @return UserActivity|null
     */
    protected function addUserActivity($objectType, $objectId, $action, $data = null) :? UserActivity
    {
        $user = $this->getAuthUser();
        if (!$user) {
            return null;
        }

        if (empty($objectType) || empty($objectId) || empty($action)) {
            return null;
        }

        $repository = $this->getUserActivityRepository();

        $attributes = [
            'object_type' => $objectType,
            'object_id' => $objectId,
            'action' => $action,
            'data' => $data ?? []
        ];
        $activity = $repository->store($attributes, $user);
        return $activity;
    }
}
