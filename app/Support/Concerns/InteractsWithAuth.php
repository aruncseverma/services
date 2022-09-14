<?php
/**
 * usable trait class for interacting with laravel auth
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

use App\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;

trait InteractsWithAuth
{
    /**
     * get instance of laravel auth manager
     *
     * @return Illuminate\Auth\AuthManager
     */
    protected function getAuthManager() : AuthManager
    {
        return app('auth');
    }

    /**
     * get auth guard
     *
     * @return Illuminate\Contracts\Auth\Guard
     */
    protected function getAuthGuard() : Guard
    {
        return $this->getAuthManager()->guard($this->getAuthGuardName());
    }

    /**
     * get auth guard name
     *
     * @return string
     */
    protected function getAuthGuardName() : string
    {
        return config('auth.defaults.guard');
    }

    /**
     * get authenticated user model
     *
     * @return App\Models\User|null
     */
    protected function getAuthUser()
    {
        return $this->getAuthGuard()->user();
    }

    /**
     * get active auth guard
     *
     * @return Illuminate\Contracts\Auth\Guard|null
     */
    protected function getActiveAuthGuard():? Guard
    {
        $guardNames = $this->getValidGuardNames();

        foreach ($guardNames as $guardName) {
            $guard = $this->getAuthManager()->guard($guardName);
            if ($guard->check()) {
                return $guard;
            }
        }

        return null;
    }

    /**
     * get first priority authentictated user model
     * 
     * Note:: dont use this in __construct method. because it cannot get user data there.
     * 
     * @return App\Models\User|null
     */
    protected function getAuthUserPriority() :? User
    {
        $activeGuard = $this->getActiveAuthGuard();
        return $activeGuard ? $activeGuard->user() : null;
    }

    /**
     * get allowed guard names
     * 
     * @return array
     */
    protected function getValidGuardNames() : array
    {
        $guards = config('auth.guards');
        unset($guards['web'], $guards['api']);
        $guardNames = array_keys($guards);
        return $guardNames;
    }

    /**
     * Get all active auths
     * 
     * @return array
     */
    protected function getActiveAuths() : array
    {
        $guardNames = $this->getValidGuardNames();
        $auths = [];
        foreach ($guardNames as $guardName) {
            $guard = $this->getAuthManager()->guard($guardName);
            if ($guard->check()) {
                $auths[$guard->user()->getKey()] = $guard->user();
            }
        }
        return $auths;
    }

    /**
     * Check if current auth is super admin
     * @return bool
     */
    protected function isSuperAdmin() : bool
    {
        return ($this->getAuthUser()->getKey() == config('app.super_admin_user_id'));
    }
}
