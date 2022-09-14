<?php
/**
 * contract class for permission model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Permissions\Contracts;

interface Permission
{
    /**
     * check if given user has a given permission
     *
     * @return boolean
     */
    public function hasPermission() : bool;
}
