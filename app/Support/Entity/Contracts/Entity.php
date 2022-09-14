<?php
/**
 * contract for entity classes
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Entity\Contracts;

interface Entity
{
    /**
     * populate entity with data
     *
     * @param  array $data
     *
     * @return void
     */
    public function populate(array $data) : void;

    /**
     * convert entity to array
     *
     * @return array
     */
    public function toArray() : array;
}
