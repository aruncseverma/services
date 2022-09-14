<?php
/**
 * permission model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Permissions;

class Permission implements Contracts\Permission
{
    /**
     * permission group name
     *
     * @var string
     */
    protected $group;

    /**
     * permission name
     *
     * @var string
     */
    protected $name;

    /**
     * given user has permission
     *
     * @var bool
     */
    protected $hasPermission;

    /**
     * create instance
     *
     * @param string  $group
     * @param string  $name
     * @param boolean $hasPermission
     */
    public function __construct(string $group, string $name, bool $hasPermission = false)
    {
        $this->group = $group;
        $this->name = $name;
        $this->hasPermission = $hasPermission;
    }

    /**
     * {@inheritDoc}
     *
     * @return boolean
     */
    public function hasPermission() : bool
    {
        return $this->hasPermission;
    }

    /**
     * permission group
     *
     * @return string
     */
    public function getGroup() : string
    {
        return $this->group;
    }

    /**
     * permission name
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
}
