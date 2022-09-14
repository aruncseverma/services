<?php
/**
 * sidebar menu class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Sidebar;

class Menu implements Contracts\Menu
{
    /**
     * menu text
     *
     * @var string
     */
    protected $text;

    /**
     * menu link
     *
     * @var string
     */
    protected $link;

    /**
     * menu icon
     *
     * @var string
     */
    protected $icon = null;

    /**
     * badge key
     *
     * @var string
     */
    protected $badge = null;

    /**
     * menu children
     *
     * @var array
     */
    protected $children = [];

    /**
     * menu is active
     *
     * @var boolean
     */
    protected $isActive = false;

    /**
     * menu children
     *
     * @var bool
     */
    protected $hasPermission = false;
    
    /**
     * badge counters
     *
     * @var boolean
     */
    protected $hasBadge = false;

    /**
     * create menu instance
     *
     * @param string  $text
     * @param string  $link
     * @param string  $icon
     * @param array   $children
     * @param boolean $hasPermission
     */
    public function __construct(
        string $text,
        string $link,
        string $icon = null,
        string $badge = null,
        array $children = [],
        bool $isActive = false,
        bool $hasBadge = false,
        bool $hasPermission = false
    ) {
        $this->text = $text;
        $this->link = $link;
        $this->icon = $icon;
        $this->badge = $badge;
        $this->children = $children;
        $this->isActive =  $isActive;
        $this->hasBadge = $hasBadge;
        $this->hasPermission = $hasPermission;
    }

    /**
     * checks if menu has children
     *
     * @return boolean
     */
    public function hasChildren() : bool
    {
        return (! empty($this->children));
    }

    /**
     * checks if current authenticated user has permission to this menu
     *
     * @return boolean
     */
    public function hasPermission() : bool
    {
        return $this->hasPermission;
    }

    /**
     * checks if this menu has badge support
     *
     * @return boolean
     */
    public function hasBadge() : bool
    {
        return $this->hasBadge;
    }

    /**
     * checks if current menu has icon
     *
     * @return boolean
     */
    public function hasIcon() : bool
    {
        return (! empty($this->icon));
    }

    /**
     * checks if has children active
     *
     * @return boolean
     */
    public function hasActiveChildren() : bool
    {
        if ($this->isParent()) {
            foreach ($this->getChildren() as $children) {
                if ($children->isActive()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * checks if menu is a parent
     *
     * @return boolean
     */
    public function isParent() : bool
    {
        return $this->hasChildren();
    }

    /**
     * checks if current menu is active
     *
     * @return boolean
     */
    public function isActive() : bool
    {
        return $this->isActive;
    }

    /**
     * get menu children
     */
    public function getChildren() : array
    {
        return $this->children;
    }

    /**
     * get menu text
     *
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * get menu icon
     *
     * @return string
     */
    public function getIcon() : string
    {
        return $this->icon;
    }

    /**
     * get menu link
     *
     * @return string
     */
    public function getLink() : string
    {
        return $this->link;
    }

    /**
     * get menu badge key
     *
     * @return string
     */
    public function getBadgeKey() : string
    {
        return $this->badge;
    }
}
