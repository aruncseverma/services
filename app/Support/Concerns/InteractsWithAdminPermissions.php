<?php
/**
 * usable methods to interact with admin permissions
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

trait InteractsWithAdminPermissions
{
    /**
     * get defined admin permissions
     *
     * @return array
     */
    protected function getAdminPermissions() : array
    {
        return config('permissions', []);
    }
}
