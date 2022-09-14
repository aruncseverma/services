<?php
/**
 * usable trait class for classes that needs rates duration
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

use Illuminate\Support\Collection;
use App\Repository\RateDurationRepository;

trait NeedsRateDurations
{
    /**
     * rate durations cache key
     *
     * @var string
     */
    protected $rateDurationCacheKey = 'rate_durations';

    /**
     * get rate durations list
     *
     * @return Illuminate\Support\Collection
     */
    public function getRateDurations() : Collection
    {
        if (app()->environment(['local', 'dev'])) {
            return $this->getRateDurationsFromRepository();
        }

        return $this->getRateDurationsFromCache();
    }

    /**
     * get rate durations repository instance
     *
     * @return App\Repository\RateDurationRepository
     */
    protected function getRateDurationRepository() : RateDurationRepository
    {
        return app(RateDurationRepository::class);
    }

    /**
     * get rate durations from the repository
     *
     * @return Illuminate\Support\Collection
     */
    protected function getRateDurationsFromRepository() : Collection
    {
        return $this->getRateDurationRepository()->getActiveDurations();
    }

    /**
     * get rate duration from cached object
     *
     * @return Illuminate\Support\Collection
     */
    protected function getRateDurationsFromCache() : Collection
    {
        $cache = app('cache');

        // if does not have store it forever to cache
        if (! $cache->has($this->rateDurationCacheKey)) {
            $cache->rememberForever($this->rateDurationCacheKey, function () {
                return $this->getRateDurationsFromRepository();
            });
        }

        return $cache->get($this->rateDurationCacheKey);
    }

    /**
     * clears stored cache
     *
     * @return void
     */
    protected function forgetRateDurationCache() : void
    {
        app('cache')->forget($this->rateDurationCacheKey);
    }
}
