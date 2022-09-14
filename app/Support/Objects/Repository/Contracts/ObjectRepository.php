<?php
/**
 *  object repository class interface
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Objects\Repository\Contracts;

interface ObjectRepository
{
    /**
     * fetch object payload and return its parsed information
     *
     * @param  string $id
     *
     * @return mixed
     */
    public function fetchObject(string $id);

    /**
     * creates a new object and returns
     * the token being generated for the object
     *
     * @param  array $payload
     *
     * @return string
     */
    public function createObject(array $payload) : string;

    /**
     * deletes the object using its primary key
     *
     * @param  mixed
     *
     * @return bool
     */
    public function deleteObject(string $id) : bool;
}
