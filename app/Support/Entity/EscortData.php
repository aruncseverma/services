<?php
/**
 * escort user data enttiy class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Entity;

use App\Models\Country;
use App\Repository\CountryRepository;
use Illuminate\Contracts\Encryption\DecryptException;

class EscortData extends UserData
{
    /**
     * escort country id
     *
     * @var integer
     */
    public $originId;

    /**
     * escort attribute hair color id
     *
     * @var integer
     */
    public $hairColorId;

    /**
     * escort attribute eye color id
     *
     * @var integer
     */
    public $eyeColorId;

    /**
     * escort attribute ethnicity id
     *
     * @var integer
     */
    public $ethnicityId;

    /**
     * escort attribute body type id
     *
     * @var integer
     */
    public $bodyTypeId;

    /**
     * escort attribute cup size id
     *
     * @var integer
     */
    public $cupSizeId;

    /**
     * escort attribute service type
     *
     * @var char
     */
    public $serviceType;

    /**
     * escort attribute social
     *
     * @var char
     */
    public $social;

    /**
     * escort attribute pornstar
     *
     * @var char
     */
    public $pornstar;

    /**
     * escort attribute orientation 2 liner
     *
     * @var char
     */
    public $orientation2Liner;

    /**
     * escort attribute ethnicity id 2
     *
     * @var integer
     */
    public $ethnicityId2;

    /**
     * escort attribute hair length 2 liner id
     *
     * @var integer
     */
    public $hairLength2LinerId;

    /**
     * escort attribute height id
     *
     * @var integer
     */
    public $heightId;

    /**
     * escort attribute weight id
     *
     * @var integer
     */
    public $weightId;

    /**
     * escort attribute blood type id
     *
     * @var integer
     */
    public $bloodTypeId;

    /**
     * escort attribute bust id
     *
     * @var integer
     */
    public $bustId;

    /**
     * escort attribute skype id
     *
     * @var integer
     */
    public $skypeId;

    /**
     * escort attribute contact platform ids
     *
     * @var array
     */
    public $contactPlatformIds;

    /**
     * escort attribute private information
     *
     * @var array
     */
    public $private;

    /**
     * {@inheritDoc}
     *
     * @param  array $data
     *
     * @return void
     */
    public function populate(array $data) : void
    {
        parent::populate($data);

        if (array_key_exists('private', $data)) {
            $this->setPrivateProperty($data['private']);
        }
    }

    /**
     * set escort private property value
     *
     * @param  string|null $data
     *
     * @return void
     */
    public function setPrivateProperty(string $data = null) : void
    {
        // decrypt information value
        try {
            $this->private = json_decode(decrypt($data), true);
        } catch (DecryptException $ex) {
            $this->private = [];
        }
    }
}
