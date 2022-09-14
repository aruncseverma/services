<?php
/**
 * service provider for objects namespace
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Objects;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\ConnectionInterface;
use App\Support\Objects\Repository\ObjectRepository;
use App\Support\Objects\Repository\Contracts\ObjectRepository as ObjectRepositoryContract;

class ObjectsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * register instances
     *
     * @return void
     */
    public function register() : void
    {
        $this->registerObjectRepository();
    }

    /**
     * register instance of the objects repository
     *
     * @return void
     */
    protected function registerObjectRepository() : void
    {
        $this->app->bind(ObjectRepository::class, function ($app) {
            $config = $this->app->make('config');
            $key = $config->get('app.key');
            $table = $config->get('objects.table', 'objects');

            // decode key from base64
            if (Str::startsWith($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            return new ObjectRepository(
                $app->make(ConnectionInterface::class),
                $app->make('hash'),
                $table,
                $key
            );
        });

        $this->app->bind(ObjectRepositoryContract::class, ObjectRepository::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ObjectRepository::class, ObjectRepositoryContract::class];
    }
}
