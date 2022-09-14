<?php
/**
 * usable method for interactive with application objects support
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Objects\Concerns;

use App\Support\Objects\Repository\Contracts\ObjectRepository;

trait InteractsWithObjects
{
    /**
     * get object repository instance
     *
     * @return App\Support\Objects\Contracts\ObjectRepository
     */
    public function getObjectRepository() : ObjectRepository
    {
        return app(ObjectRepository::class);
    }

    /**
     * create object payload to repository
     *
     * @param  array $payload
     *
     * @return mixed
     */
    public function createObject(array $payload)
    {
        return $this->getObjectRepository()->createObject($payload);
    }

    /**
     * fetch object payload using token id
     *
     * @param  mixed $id
     *
     * @return mixed
     */
    public function fetchObject($id)
    {
        return $this->getObjectRepository()->fetchObject($id);
    }

    /**
     * delete object payload using token id
     *
     * @param  mixed $id
     *
     * @return bool
     */
    public function deleteObject($id) : bool
    {
        return $this->getObjectRepository()->deleteObject($id);
    }
}
