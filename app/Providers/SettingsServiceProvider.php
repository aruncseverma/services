<?php
/**
 * service provider class for adding to config class repository
 * the settings that came from the database
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Providers;

use Illuminate\Support\Collection;
use App\Repository\SettingRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Config\Repository as ConfigRepository;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * settings cache key
     *
     * @const
     */
    const SETTINGS_CACHE_KEY = 'settings';

    /**
     * list of keys which equivalent to
     * laravels configuration keys
     *
     * @return void
     */
    protected $overrideConfigKeys = [
        'site.name' => 'app.name',
        'site.url'  => 'app.url',
    ];

    /**
     * boot services
     *
     * @return void
     */
    public function boot()
    {
        $this->bootSettingsToConfigRepository();
    }

    /**
     * get settings repository instance
     *
     * @return App\Repository\SettingRepository
     */
    protected function getRepository() : SettingRepository
    {
        return $this->app->make(SettingRepository::class);
    }

    /**
     * retrieved from database repository
     *
     * @return Illuminate\Support\Collection
     */
    protected function retrievedFromRepository() : Collection
    {
        return $this->getRepository()->all();
    }

    /**
     * retrieved from cache
     *
     * @return Illuminate\Support\Collection
     */
    protected function retrievedFromCache() : Collection
    {
        $cache = $this->app->make('cache');

        if (! $cache->has(self::SETTINGS_CACHE_KEY)) {
            $cache->rememberForever(self::SETTINGS_CACHE_KEY, function () {
                return $this->retrievedFromRepository();
            });
        }

        return $cache->get(self::SETTINGS_CACHE_KEY);
    }


    /**
     * retrieved settings from cache or database
     *
     * @return Illuminate\Support\Collection
     */
    protected function getSettings() : Collection
    {
        if ($this->app->environment(['local', 'dev'])) {
            return $this->retrievedFromRepository();
        }

        // get from cache
        return $this->retrievedFromCache();
    }

    /**
     * boot defined settings from database to config repository (laravel)
     *
     * @return void
     */
    protected function bootSettingsToConfigRepository() : void
    {
        try {
            // test connection
            $this->app->make('db')->getPdo();
        } catch (\Exception $ex) {
            return;
        }

        $repository = $this->getRepository();
        $config = $this->app->make('config');

        if (Schema::hasTable($repository->getTable())) {
            // get all settings and set it to config() repository
            foreach ($this->getSettings() as $setting) {
                $group = $setting->getAttribute('group');
                $key   = $setting->getAttribute('key');

                // set to config
                $config->set("{$group}.{$key}", $setting->getAttribute('value'));

                // overrides app settings
                $this->overrideConfiguration("{$group}.{$key}", $setting->getAttribute('value'), $config);
            }
        }
    }

    /**
     * overrides configuration from config files
     *
     * @param  string                       $key
     * @param  value                        $value
     * @param  Illuminate\Config\Repository $config
     *
     * @return void
     */
    protected function overrideConfiguration($key, $value, ConfigRepository $config) : void
    {
        if (isset($this->overrideConfigKeys[$key])) {
            $config->set($this->overrideConfigKeys[$key], $value);
        }
    }
}
