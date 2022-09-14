<?php
/**
 * interface class for menu object
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Sidebar\Contracts;

interface Menu
{
    /**
     * checks if menu has children
     *
     * @return boolean
     */
    public function hasChildren() : bool;

    /**
     * checks if current authenticated user has permission to this menu
     *
     * @return boolean
     */
    public function hasPermission() : bool;

    /**
     * checks if current menu has badge support
     *
     * @return boolean
     */
    public function hasBadge() : bool;

    /**
     * checks if current menu has icon
     *
     * @return boolean
     */
    public function hasIcon() : bool;

    /**
     * checks if has children active
     *
     * @return boolean
     */
    public function hasActiveChildren() : bool;

    /**
     * checks if menu is a parent
     *
     * @return boolean
     */
    public function isParent() : bool;

    /**
     * checks if current menu is active
     *
     * @return boolean
     */
    public function isActive() : bool;

    /**
     * get menu children
     */
    public function getChildren() : array;

    /**
     * get menu text
     *
     * @return string
     */
    public function getText() : string;

    /**
     * get menu icon
     *
     * @return string
     */
    public function getIcon() : string;

    /**
     * get menu link
     *
     * @return string
     */
    public function getLink() : string;

    /**
     * get badge key
     *
     * @return string
     */
    public function getBadgeKey() : string;
}
