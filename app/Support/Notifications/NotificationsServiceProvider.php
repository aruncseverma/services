<?php
/**
 * notifications service provider class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Notifications;

use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider
{
    /**
     * register services
     *
     * @return void
     */
    public function register()
    {
        $this->registerNotificationsService();
    }

    /**
     * register notify notifications service handler
     *
     * @return void
     */
    protected function registerNotificationsService()
    {
        $this->app->singleton('notify', Handler::class);
        $this->app->singleton(Contracts\Handler::class, Handler::class);
    }
}
