<?php
/**
 * application service provider class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */
namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // check application maitenance
        $this->bootCheckMaintenanceMode();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * checks if current config is defined as maintenance mode
     *
     * @return void
     */
    protected function bootCheckMaintenanceMode() : void
    {
        $isMaintenance = (bool) $this->app->make('config')->get('site.is_maintenance', false);

        if ($isMaintenance === true && ! $this->app->isDownForMaintenance()) {
            // create maintenance file
            Artisan::call('down');
        } elseif ($this->app->isDownForMaintenance() && $isMaintenance === false) {
            // delete maintenance file
            Artisan::call('up');
        }
    }
}
