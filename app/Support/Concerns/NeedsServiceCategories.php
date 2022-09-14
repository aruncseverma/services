<?php
/**
 * usable trait class for classes that needs service categories
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

use Illuminate\Support\Collection;
use App\Repository\ServiceCategoryRepository;

trait NeedsServiceCategories
{
    /**
     * service category cache key
     *
     * @var string
     */
    protected $serviceCategoryCacheKey = 'service_category';

    /**
     * get service categories list
     *
     * @return Illuminate\Support\Collection
     */
    public function getServiceCategories() : Collection
    {
        if (app()->environment(['local', 'dev'])) {
            return $this->getServiceCategoriesFromRepository();
        }

        return $this->getServiceCategoriesFromCache();
    }

    /**
     * get service category repository instance
     *
     * @return App\Repository\ServiceCategoryRepository
     */
    protected function getServiceCategoryRepository() : ServiceCategoryRepository
    {
        return app(ServiceCategoryRepository::class);
    }

    /**
     * get service categories from the repository
     *
     * @return Illuminate\Support\Collection
     */
    protected function getServiceCategoriesFromRepository() : Collection
    {
        return $this->getServiceCategoryRepository()->getActiveCategories();
    }

    /**
     * get service categories from cached object
     *
     * @return Illuminate\Support\Collection
     */
    protected function getServiceCategoriesFromCache() : Collection
    {
        $cache = app('cache');

        // if does not have store it forever to cache
        if (! $cache->has($this->serviceCategoryCacheKey)) {
            $cache->rememberForever($this->serviceCategoryCacheKey, function () {
                return $this->getServiceCategoriesFromRepository();
            });
        }

        return $cache->get($this->serviceCategoryCacheKey);
    }

    /**
     * clears stored cache
     *
     * @return void
     */
    protected function forgetServiceCategoryCache() : void
    {
        app('cache')->forget($this->serviceCategoryCacheKey);
    }
}
