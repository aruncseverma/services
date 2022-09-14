<?php
/**
 * trait class for clases which needs user groups defined for the application
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

use App\Models\UserGroup;
use Illuminate\Support\Collection;
use App\Repository\UserGroupRepository;

trait NeedsUserGroups
{
    /**
     * user groups cache key
     *
     * @var string
     */
    protected $userGroupCacheKey = 'service_category';

    /**
     * get user groups list
     *
     * @return Illuminate\Support\Collection
     */
    public function getUserGroups() : Collection
    {
        if (app()->environment(['local', 'dev'])) {
            return $this->getUserGroupsFromRepository();
        }

        return $this->getUserGroupsFromCache();
    }

    /**
     * get user groups repository instance
     *
     * @return App\Repository\UserGroupRepository
     */
    protected function getUserGroupRepository() : UserGroupRepository
    {
        return app(UserGroupRepository::class);
    }

    /**
     * get user groups from the repository
     *
     * @return Illuminate\Support\Collection
     */
    protected function getUserGroupsFromRepository() : Collection
    {
        return $this->getUserGroupRepository()->getActiveGroups();
    }

    /**
     * get user groups from cached object
     *
     * @return Illuminate\Support\Collection
     */
    protected function getUserGroupsFromCache() : Collection
    {
        $cache = app('cache');

        // if does not have store it forever to cache
        if (! $cache->has($this->userGroupCacheKey)) {
            $cache->rememberForever($this->userGroupCacheKey, function () {
                return $this->getUserGroupsFromRepository();
            });
        }

        return $cache->get($this->userGroupCacheKey);
    }

    /**
     * clears stored cache
     *
     * @return void
     */
    protected function forgetUserGroupCache() : void
    {
        app('cache')->forget($this->userGroupCacheKey);
    }

    /**
     * wraps repository default user group
     *
     * @return App\Models\UserGroup|null
     */
    protected function getDefaultUserGroup() : ?UserGroup
    {
        return $this->getUserGroupRepository()->getDefaultGroup();
    }
}
