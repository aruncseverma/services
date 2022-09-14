<?php
/**
 * interface class for custom validator classes
 *
 * @author Mike Alvarez <mike@hallohallo.ph>
 */

namespace App\Support\Validation\Contracts;

use Illuminate\Contracts\Validation\Validator as ValidatorContract;

interface Validator
{
    /**
     * validate value based on given rule
     *
     * @param  string                                    $attribute
     * @param  mixed                                     $value
     * @param  array                                     $parameters
     * @param  Illuminate\Contracts\Validation\Validator $validator
     *
     * @return bool
     */
    public function validate(string $attribute, $value, array $parameters, ValidatorContract $validator) : bool;

    /**
     * replace validation error message or process it before rendering to output
     *
     * @param  string $message
     * @param  string $attribute
     * @param  string $rule
     * @param  array  $parameters
     *
     * @return string
     */
    public function replacer(string $message, string $attribute, string $rule, array $parameters) : string;
}
