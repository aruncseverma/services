<?php
/**
 * user data entity class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Entity;

use Illuminate\Support\Str;

class UserData implements Contracts\Entity
{
    /**
     * user model instance
     *
     * @var App\Models\User
     */
    public $user;

    /**
     * create instance
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->populate($data);
    }

    /**
     * {@inheritDoc}
     */
    public function populate(array $data) : void
    {
        foreach ($data as $property => $value) {
            $property = Str::camel($property);
            if (property_exists(static::class, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function toArray() : array
    {
        $arr = [];

        // loop through all public properies
        // @todo need to fix should not include protected properties
        foreach (get_object_vars(new static) as $property => $value) {
            $property = Str::snake($property);
            $arr[$property] = $this->{$property};
        }

        return $arr;
    }
}
