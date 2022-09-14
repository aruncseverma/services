<?php
/**
 * custom validation rule for countries
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Validation;

use App\Repository\ContinentRepository;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class ContinentValidator extends Validator
{
    /**
     * continents repository
     *
     * @var App\Repository\ContinentRepository
     */
    protected $continents;

    /**
     * create instance
     *
     * @param App\Repository\ContinentRepository $continents
     */
    public function __construct(ContinentRepository $continents)
    {
        $this->continents = $continents;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string                                    $attribute
     * @param  mixed                                     $value
     * @param  array                                     $parameters
     * @param  Illuminate\Contracts\Validation\Validator $validator
     *
     * @return boolean
     */
    public function validate(string $attribute, $value, array $parameters, ValidatorContract $validator) : bool
    {
        return ($this->continents->find($value)) ? true : false;
    }
}
