<?php
/**
 * usable trait method for fetching system languages defined from the database
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

use Illuminate\Support\Collection;
use App\Repository\LanguageRepository;

trait NeedsLanguages
{
    /**
     * cache key
     *
     * @var string
     */
    protected $languageCacheKey = 'languages';

    /**
     * get languages list
     *
     * @return Illuminate\Support\Collection
     */
    public function getLanguages() : Collection
    {
        if (app()->environment(['local', 'dev'])) {
            return $this->getLanguagesFromRepository();
        }

        return $this->getLanguagesFromCache();
    }

    /**
     * get language repository instance
     *
     * @return App\Repository\LanguageRepository
     */
    protected function getLanguageRepository() : LanguageRepository
    {
        return app(LanguageRepository::class);
    }

    /**
     * get languages from the repository
     *
     * @return Illuminate\Support\Collection
     */
    protected function getLanguagesFromRepository() : Collection
    {
        return $this->getLanguageRepository()->findAll(['is_active' => true]);
    }

    /**
     * get languages from cached object
     *
     * @return Illuminate\Support\Collection
     */
    protected function getLanguagesFromCache() : Collection
    {
        $cache = app('cache');

        // if does not have store it forever to cache
        if (! $cache->has($this->languageCacheKey)) {
            $cache->rememberForever($this->languageCacheKey, function () {
                return $this->getLanguagesFromRepository();
            });
        }

        return $cache->get($this->languageCacheKey);
    }

    /**
     * clears stored cache
     *
     * @return void
     */
    protected function forgetLanguagesCache() : void
    {
        app('cache')->forget($this->languageCacheKey);
    }
}
