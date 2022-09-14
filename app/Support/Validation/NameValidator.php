<?php
/**
 * custom validator rule for validating a person name
 *
 * @author Mike Alvarez <mike@hallohallo.ph>
 */

namespace App\Support\Validation;

use Illuminate\Contracts\Validation\Validator as LaravelValidatorContract;

class NameValidator extends Validator
{
    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, $value, array $parameters, LaravelValidatorContract $validator) : bool
    {
        // @link https://stackoverflow.com/a/2385967
        $chars = 'àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð';

        // process regex checking
        return (bool) preg_match("/^[a-z\,\.\'\-{$chars}]+(?:\s[a-z\,\.\'\-{$chars}]+)*$/iu", $value);
    }
}
