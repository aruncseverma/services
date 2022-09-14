<?php
/**
 * abstract class for implementing contract of a validator class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 * @abstract
 */

namespace App\Support\Validation;

abstract class Validator implements Contracts\Validator
{
    /**
     * {@inheritDoc}
     */
    public function replacer(string $message, string $attribute, string $rule, array $parameters) : string
    {
        return str_replace(':attribute', $attribute, $message);
    }
}
