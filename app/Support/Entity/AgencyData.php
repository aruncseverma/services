<?php
/**
 * agency user data enttiy class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Entity;

use Illuminate\Contracts\Encryption\DecryptException;

class AgencyData extends UserData
{
    /**
     * escort attribute skype id
     *
     * @var integer
     */
    public $skypeId;

    /**
     * escort attribute skype id
     *
     * @var integer
     */
    public $website;

    /**
     * escort attribute contact platform ids
     *
     * @var array
     */
    public $contactPlatformIds;
}
