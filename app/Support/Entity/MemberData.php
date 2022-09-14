<?php

/**
 * member user data enttiy class
 *
 */

namespace App\Support\Entity;

class MemberData extends UserData
{
    /**
     * member attribute skype id
     *
     * @var integer
     */
    public $skypeId;

    /**
     * member attribute facebook
     *
     * @var integer
     */
    public $facebook;

    /**
     * member attribute contact platform ids
     *
     * @var array
     */
    public $contactPlatformIds;
}
