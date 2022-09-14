<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Support\Concerns\InteractsWithAdminPermissions;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use InteractsWithAdminPermissions;

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // boot admin permissions
        $this->bootAdminGates();
    }

    /**
     * boot admin gates
     *
     * @return void
     */
    protected function bootAdminGates() : void
    {
        foreach ($this->getAdminPermissions() as $group => $commands) {
            foreach ($commands as $command) {
                Gate::define("$group.$command", function ($user) use ($command, $group) {
                    // check if given command and group has permission from the user
                    // and will ignore super admin if possible
                    return ($user->hasPermission($group, $command) || $user->getKey() == 1);
                });
            }
        }
    }
}
