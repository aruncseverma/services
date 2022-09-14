<?php
/**
 * a support object repository class for storing general objects that is used
 * through out the application.
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Objects\Repository;

use Illuminate\Support\Str;
use Illuminate\Database\Query\Builder;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\ConnectionInterface;

class ObjectRepository implements Contracts\ObjectRepository
{
    /**
     * create instance
     *
     * @param Illuminate\Database\ConnectionInterface $connection
     * @param Illuminate\Contracts\Hashing\Hasher     $hasher
     * @param string                                  $table
     * @param string                                  $key
     */
    public function __construct(ConnectionInterface $connection, Hasher $hasher, string $table, string $key)
    {
        $this->connection = $connection;
        $this->hasher     = $hasher;
        $this->table      = $table;
        $this->key        = $key;
    }

    /**
     * fetch object using id and return its parsed payload
     *
     * @param  string $id
     *
     * @return null|array
     */
    public function fetchObject(string $id)
    {
        $result = $this->getBuilder()->where(['id' => $id])->first();

        // if no results was found
        if (! $result) {
            return;
        }

        // unserialize payload and return it
        return $this->unserializePayload($result->payload);
    }

    /**
     * create object information
     *
     * @param  array $payload
     *
     * @return string
     */
    public function createObject(array $payload) : string
    {
        $id = $this->createObjectId();

        $this->getBuilder()->insert([
            'id' => $id,
            'payload' => $this->serializePayload($payload)
        ]);

        return $id;
    }

    /**
     * delete object from the repository
     *
     * @param  string $id
     *
     * @return boolean
     */
    public function deleteObject(string $id) : bool
    {
        return (bool) $this->getBuilder()->where(['id' => $id])->delete();
    }

    /**
     * creates/generates new unique object key
     *
     * @return string
     */
    protected function createObjectId() : string
    {
        return md5($this->hasher->make(Str::random(40) . $this->key));
    }

    /**
     * serialize payload into string
     *
     * @param  array $payload
     *
     * @return string
     */
    protected function serializePayload(array $payload) : string
    {
        return serialize($payload);
    }

    /**
     * unserialize payload string into array
     *
     * @param  string $payload
     *
     * @return array
     */
    protected function unserializePayload(string $payload) : array
    {
        return @unserialize($payload) ?: [];
    }

    /**
     * get repository builder instance
     *
     * @return Illuminate\Database\Query\Builder
     */
    protected function getBuilder() : Builder
    {
        return $this->connection->table($this->table);
    }
}
