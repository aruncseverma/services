<?php
/**
 * service provider class which is reponsible for any locales concerns
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Locale;

use Illuminate\Support\Collection;
use App\Repository\LanguageRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class LocalesServiceProvider extends ServiceProvider
{
    /**
     * locales cache key
     *
     * @const
     */
    const LOCALES_CACHE_KEY = 'locales';

    /**
     * boot services
     *
     * @return void
     */
    public function boot()
    {
        $this->bootLocales();
    }

    /**
     * get settings repository instance
     *
     * @return App\Repository\LanguageRepository
     */
    protected function getRepository() : LanguageRepository
    {
        return $this->app->make(LanguageRepository::class);
        ;
    }

    /**
     * retrieved from database repository
     *
     * @return Illuminate\Support\Collection
     */
    protected function retrievedFromRepository() : Collection
    {
        return $this->getRepository()->findAll(['is_active' => true]);
    }

    /**
     * retrieved from cache
     *
     * @return Illuminate\Support\Collection
     */
    protected function retrievedFromCache() : Collection
    {
        $cache = $this->app->make('cache');

        if (! $cache->has(self::LOCALES_CACHE_KEY)) {
            $cache->rememberForever(self::LOCALES_CACHE_KEY, function () {
                return $this->retrievedFromRepository();
            });
        }

        return $cache->get(self::LOCALES_CACHE_KEY);
    }

    /**
     * boot locales to configuration repository
     *
     * @return void
     */
    protected function bootLocales() : void
    {
        try {
            // check if current database has table of locales
            if (Schema::hasTable($this->getRepository()->getTable())) {
                $locales = $this->getLocales();
                $config = $this->app->make('config');

                foreach ($locales as $locale) {
                    $config->set("app.locales.{$locale->code}", [
                        'name' => $locale->name,
                        'country_code' => $locale->country->code,
                    ]);
                }
            }
        } catch (\Exception $ex) {
            // .. do nothing
        }
    }

    /**
     * get locales list
     *
     * @return Illuminate\Support\Collection
     */
    protected function getLocales() : Collection
    {
        if ($this->app->environment(['local', 'dev'])) {
            return $this->retrievedFromRepository();
        }

        // get from cache
        return $this->retrievedFromCache();
    }
}
